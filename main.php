<?php
use Swoole\Process;

include_once('ShareMemory.php');

$SM = new ShareMemory();

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
		$ws->push($frame->fd, "server: {$table->get('1', 'data')}");
	});
	$ws->on('Close', function($ws, $fd)
	{
		echo "client-{$fd} is closed\n";
	});
	$ws->start();
});

$process_ws->start();



Process::wait(true);