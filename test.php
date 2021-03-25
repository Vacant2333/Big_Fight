<?php
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\WebSocket\CloseFrame;
use Swoole\Coroutine\Http\Server;
use Swoole\Coroutine;
use function Swoole\Coroutine\run;

run(function(){
	go(function(){
	$serv = new Swoole\Server("127.0.0.1", 9502);

//监听连接进入事件
$serv->on('Connect', function ($serv, $fd) {
    $redis = new Redis();
    $redis->connect("127.0.0.1",6379);//此处OnConnect的协程会挂起
    Co::sleep(5);//此处sleep模拟connect比较慢的情况
    $redis->set($fd,"fd $fd connected");
});

//监听数据接收事件
$serv->on('Receive', function ($serv, $fd, $reactor_id, $data) {
    $redis = new Redis();
    $redis->connect("127.0.0.1",6379);//此处onReceive的协程会挂起
    var_dump($redis->get($fd));//有可能onReceive的协程的redis连接先建立好了，上面的set还没有执行，此处get会是false，产生逻辑错误
});

//监听连接关闭事件
$serv->on('Close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();
	});
	go(function(){
		while(1)
		{
		echo 3;
		sleep(3);
		}
	});
});