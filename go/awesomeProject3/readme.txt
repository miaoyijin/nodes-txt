前提条件
yum install libtool -y
yum install automake

export GO111MODULE=on
export GOPROXY=https://goproxy.cn
go mod vendor


1: Protocol buffer compiler 安装
git clone https://github.com/google/protobuf
./autogen.sh
./configure
./make && make install

2：protoc的golang插件

    go get google.golang.org/protobuf/cmd/protoc-gen-go google.golang.org/grpc/cmd/protoc-gen-go-grpc

3:安装代码依赖包go get -u google.golang.org/grpc

4：protoc  --go_out=. --go_opt=paths=source_relative
 --go-grpc_out=. --go-grpc_opt=paths=source_relative
 helloworld/helloworld/helloworld.proto