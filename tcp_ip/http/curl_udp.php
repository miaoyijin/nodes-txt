<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
//udp无序号，不保证先发先到,且不管是否存在服务

//2:udp 在游戏中的应用如何确保数据连续
//解答：队列发送



//3: 当我们发送的UDP数据大于1472的时候会怎样呢？
//这也就是说IP数据报大于1500字节，大于MTU，这个时候发送方IP层就需要分片(fragmentation)。把数据报分成若干片，使每一片都小于MTU，而接收方IP层则需要进行数据报的重组。这样就会多做许多事情，而更严重的是，由于UDP的特性，当某一片数据传送中丢失时，接收方无法重组数据报，将导致丢弃整个UDP数据报。
//
//因此，在普通的局域网环境下，我建议将UDP的数据控制在1472字节以下为好。


//4:每个UDP socket都有一个接收缓冲区，没有发送缓冲区，从概念上来说就是只要有数据就发，
//不管对方是否可以正确接收，所以不缓冲，不需要发送缓冲区。
//UDP：当套接口接收缓冲区满时，新来的数据报无法进入接收缓冲区，此数据报就被丢弃。
//UDP是没有流量控制的；快的发送者可以很容易地就淹没慢的接收者，导致接收方的UDP丢弃数据报。【所以udp不能一次发送太多数据数据】
//udp 在发送的数据较大时，会发生IP数据分片，简称分包[udp不会粘包]


//5:在发送数据时，是从用户态数据到内核态

//6:tcpdump查看的是TCP ,UDP数据包的传输，其实在ip层UDP,TCp也会分片传输，当UDP，TCP数据包大于MTU时即会IP分片
function udpGet($sendMsg = '', $ip = '115.238.192.243', $port = '9998'){
    $handle = stream_socket_client("udp://{$ip}:{$port}", $errno, $errstr);
    if( !$handle ){
        die("ERROR: {$errno} - {$errstr}\n");
    }
    $ret = fwrite($handle, $sendMsg."\n");//一次不能发太多数据会导致buffer塞满
    var_dump($ret);exit;
    $result = fread($handle, 1024);
    fclose($handle);
    return $result;
}

$result = udpGet(file_get_contents('D:/www/wpimages/www/github/nodes-txt/tcp_ip/http/udp_file_test'));
echo $result;