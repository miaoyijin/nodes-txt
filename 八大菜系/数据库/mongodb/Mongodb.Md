###为什么使用mongodb数据库
1：松散性数据结构Bjson，结构简单，读写快。
2：分片模式易水平扩展，支持大量数据，mysql较难需要做数据迁移。
3：mmap技术零拷贝，读写快(占内存)。
4：mongodb map reduce可以对文章数据进行分析，适合做一些分析比如做给文章做ES索引。
5：mysql 资源宝贵更适合做存储事务型数据。

####再稍微讲讲 mmap 和 sendFile 的区别。

mmap 适合小数据量读写，sendFile 适合大文件传输。
mmap 需要 4 次上下文切换，3 次数据拷贝；sendFile 需要 3 次上下文切换，最少 2 次数据拷贝。
sendFile 可以利用 DMA 方式，减少 CPU 拷贝，mmap 则不能（必须从内核拷贝到 Socket 缓冲区）。
在这个选择上：rocketMQ 在消费消息时，使用了 mmap。kafka 使用了 sendFile。


###mysql buffer size
4.1 Buffer Pool预热
MySQL在重启后，Buffer Pool里面没有什么数据，这个时候业务上对数据库的数据操作，
MySQL就只能从磁盘中读取数据到内存中，这个过程可能需要很久才能是内存中的数据是业务频繁使用的。
Buffer Pool中数据从无到业务频繁使用热数据的过程称之为预热。所以在预热这个过程中，
MySQL数据库的性能不会特别好，并且Buffer Pool越大，预热过程越长。

为了减短这个预热过程，在MySQL关闭前，把Buffer Pool中的页面信息保存到磁盘，等到MySQL启动时，
再根据之前保存的信息把磁盘中的数据加载到Buffer Pool中即可


###mongodo 和mysql 数据的选择