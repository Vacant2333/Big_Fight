<?php
use Swoole\Process;

include_once('Core/ShareMemory.php');
include_once('Core/Entity/StuffGroup.php');

//初始化共享内存
$SM = new ShareMemory();

//Service进程,处理数据
$process_service = new Process(function() use($SM)
{
	$StuffGroup = new StuffGroup();

	while(True)
	{




		$SM->saveData('stuff', $StuffGroup->getStuffGroupData());
		sleep(0.02);
	}
});

//WebSocket进程,处理数据传输
$process_ws = new Process(function() use($SM)
{
	$ws = new Swoole\WebSocket\Server('0.0.0.0', 8001);
	$ws->on('Open', function($ws, $request)
	{
		$ws->push($request->fd, "hello, welcome\n");
	});
	$ws->on('Message', function($ws, $frame) use($SM)
	{
		$ws->push($frame->fd, json_encode($SM->getData('stuff')));
	});
	$ws->on('Close', function($ws, $fd)
	{
		echo "client-{$fd} is closed\n";
	});
	$ws->start();
});

//启动进程
$process_service->start();
$process_ws->start();
sleep(1);
print("Service start up now!\n");

Process::wait(true);