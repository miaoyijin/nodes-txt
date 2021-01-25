package c

import (
"log"
"runtime"
"strconv"
"strings"
"sync"
"time"
"math/rand"
"golang.org/x/net/context"
"google.golang.org/grpc"
)

var (
	wg sync.WaitGroup
)

const (
	networkType = "tcp"
	server      = "127.0.0.1"
	ports        = "41005"
	parallel    = 50        //连接并行度
	times       = 100000    //每连接请求次数
)

func main1() {
	runtime.GOMAXPROCS(runtime.NumCPU())
	currTime := time.Now()

	//并行请求
	for i := 0; i < int(parallel); i++ {
		wg.Add(1)
		go func() {
			defer wg.Done()
			exe()
		}()
	}
	wg.Wait()

	log.Printf("time taken: %.2f ", time.Now().Sub(currTime).Seconds())
}

func exe() {
	//建立连接
	conn, err := grpc.Dial(server + ":" + ports,  grpc.WithInsecure())
	if err != nil {
		log.Fatalf("did not connect: %v", err)
	}
	defer conn.Close()
	client := xgrpcd.NewDataClient(conn)

	for i := 0; i < int(times); i++ {
		getUser(client)
	}
}

func getUser(client xgrpcd.DataClient) {
	var request xgrpcd.UserRq
	r := rand.Intn(parallel)
	request.Id = int32(r)

	response, _ := client.GetUser(context.Background(), &request) //调用远程方法

	//判断返回结果是否正确
	if id, _ := strconv.Atoi(strings.Split(response.Name, ":")[0]); id != r {
		log.Printf("response error  %#v", response)
	}
}
