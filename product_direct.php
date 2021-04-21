<?php
require_once'/opt/case/php_test/rabbitmq/vendor/autoload.php';

$routeKey = $queue = 'simple_queue';
$exchange = 'feature_test';
$routeKey = '';
//direct和topic模式很类似
$hosts = [
    [
        'host' => 'answer-ramq-c1-node001.a.2345inc.com',
        'port' => '5672',
        'user' => 'cloud_union_mq',
        'password' => 'S5DspseecrDmjiFsj77m',
        'vhost' => 'cloud_union'
    ]
];


    /** @var \PhpAmqpLib\Connection\AMQPStreamConnection $connect */
    $connect = \PhpAmqpLib\Connection\AMQPStreamConnection::create_connection($hosts);

    $channel = $connect->channel();
    $channel->queue_declare($queue, false, true, false, false);
    /*$channel->exchange_declare($exchange, AMQP_EX_TYPE_DIRECT);//如果交换机不存在则需要申明,存在则不需要申明
    $channel->queue_bind($queue, $exchange, $routeKey);//并且绑定queue和exchange
    */
    $string = '{"businessData":{"taskTag":11001,"taskId":110010002,"taskType":2,"taskDesc":"\u6253\u5f00\u8f6f\u4ef6\u8d5a\u94b1\u5b9d\u7bb1","orderId":"syh_20210104100216_143516187_110010002_977905","orderTime":1609725736,"rewardType":"gold","rewardValue":22,"isShow":1,"refLabel":"","project":"2345lahuo","customerId":"","extraData":""},"device":{"imei":"868014039032638","oaid":"","deviceType":1,"brand":"HONOR","model":"BND-AL10","oem":"HUAWEI","os":"Android","osv":"9","osvCode":28,"osid":"c48dfe0ca3bb3181","network":1,"operator":0,"imsi":"","ip":"172.17.96.80","lon":"0","lat":"0","width":1080,"height":2038,"orientation":"1","userAgent":"Mozilla\/5.0 (Linux; Android 9; BND-AL10 Build\/HONORBND-AL10; wv) AppleWebKit\/537.36 (KHTML, like Gecko) Version\/4.0 Chrome\/79.0.3945.116 Mobile Safari\/537.36","macAddress":"10:44:00:e7:38:0f","macAddr":"10:44:00:e7:38:0f","romOsName":"EMUI","romOsVersion":"9.1.0"},"app":{"packageName":"com.planet.light2345","appName":"\u661f\u7403\u5e84\u56ed","channel":"UMENG_CHANNEL_VALUE","versionName":"7.2.2","versionCode":"70201","appChannel":"UMENG_CHANNEL_VALUE","sdkVersion":"2.31.0.6","sdkJarChannel":"xq_guanfang","sdkJarVersion":83600,"appid":49},"user":{"uid":"104400e7380f","passid":"143516187","tourist":0,"wuid":"868014039032638"},"originData":{"order_id":"syh_20210104100216_143516187_110010002_977905","task_id":1023,"task_gold":22,"passid":"143516187","is_finish":0,"task_type":2,"order_time":1609725736,"max_times":5,"project":"2345lahuo","package_name":"com.planet.light2345"}}';
    $dataArr = json_decode($string, true);

    for ($i = 0; $i < 5; $i++) {
        $dataArr['businessData']['orderTime'] = time();
        $dataArr['originData']['order_time'] = time();
        $dataArr['app']['packageName'] = 'com.browser2345';
        $dataArr['originData']['package_name'] = 'com.browser2345';
        $dataArr['originData']['project'] = 'sl-2345lahuo';
        $dataArr['businessData']['project'] = 'sl-2345lahuo';
        $dataArr['businessData']['orderId'] = substr($dataArr['businessData']['orderId'], 0, 40) . rand(1, 999999) . $i;

        $channel->basic_publish(new \PhpAmqpLib\Message\AMQPMessage(json_encode($dataArr), ['delivery_mode' => \PhpAmqpLib\Message\AMQPMessage:: DELIVERY_MODE_NON_PERSISTENT]), $exchange, $routeKey);//默认交换机

    }

echo 'done' . PHP_EOL;
