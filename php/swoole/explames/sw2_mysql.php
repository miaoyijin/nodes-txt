<?php
/**
 * Created by PhpStorm.
 * User: mouyj
 * Date: 2020/7/26
 * Time: 19:19
 */
//2.0 swoole 版本高性能HTTP服务器
$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->set([
    'worker_num'      => 1,
]);
$http->on("start", function ($server) {
    swoole_set_process_name("swoole master");
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on('WorkerStart', function ($server, $worker_id){
    swoole_set_process_name("swoole worker");
});
$http->on('managerStart', function ($server){
    swoole_set_process_name("swoole manager");
});

$http->on("request", function ($request, $response) {
    //可以同时处理多个http请求

    //sleep(10);sleep就是正在执行的线程主动让出cpu，【cpu去执行其他线程，swoole 是用一个线程】，
    //在sleep指定的时间过后，cpu才会回到这个线程上继续往下执行
    file_put_contents('log.txt', date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
    mysqldeal($response);
});

$http->start();

function mysqldeal($response)
{
    $db = new swoole_mysql();
    $server = array(
        'host' => 'proverb-mysql-g1-master001.a.2345inc.com',
        'port' => 3306,
        'user' => 'proverb',
        'password' => 'ko5OsiTec2q6',
        'database' => 'proverb_dm',
        'charset' => 'utf8', //指定字符集
        'timeout' => 32,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
    );

    $db->connect($server, function ($db, $r) use ($response) {
        if ($r === false) {
            echo 1111;
            var_export($db->connect_errno, $db->connect_error);
        }
        $sql = 'select sleep(10)';
        $db->query($sql, function(swoole_mysql $db, $r) use ($response) {
            if ($r === false)
            {
                echo 2222;
                var_export($db->error, $db->errno);
            }
            elseif ($r === true )
            {
                echo 3333;
                var_export($db->affected_rows, $db->insert_id);
            }
            echo 4444;
            var_export($r);
            $db->close();
            $response->end();
        });
    });
}