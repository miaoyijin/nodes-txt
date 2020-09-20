###疑问1:三次握手后假如最后一个ack 丢失，此时客户端已经在发送数据会怎么样
    回答：服务端直接回复RST
###三次握手为什么不等待一段时间


###当半链接队列满了会启用tcp cookie，否则直接丢弃
###backlog 是全连接队列长度
###全链接队列满处理方式：：当 tcp_abort_on_overflow 的值为 0 时，在全连接队列满了以后，服务端会直接丢弃掉客户端传来的 ACK 包。由于服务端将这个 ACK 包丢弃了，那么服务端会认为自己给客户端发送的 SYN+ACK 包一直没有响应，因此服务端会等待一会以后重新发送 SYN+ACK 包给客户端，这个重试次数也有一个上限，可以通过内核参数 tcp_synack_retries 来修改。通过如下命令可以查看 tcp_synack_retries 参数的值。如果服务端在重试期间，客户端由于设置的超时时间较短，TCP 三次握手没有完成，就会出现 connection timeout 异常。
 ####当 tcp_abort_on_overflow 的值为 1 时，在全连接队列满了以后，服务端会直接向客户端发送一个 RST 通知，即 reset 包，表示废除当前的握手过程。此时客户端收到 RST 通知后就会出现 connection reset by peer 异常。