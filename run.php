<?php
use Swoole\Process;

define('MAP_MAX_X', 800);
define('MAP_MAX_Y', 800);

include_once('Core/Entity/StuffGroup.php');
include_once('Core/Entity/PlayerGroup.php');

//初始化
$StuffGroup = new StuffGroup();
$PlayerGroup = new PlayerGroup();

//Service进程,处理数据
$process_service = new Process(function() use($StuffGroup, $PlayerGroup)
{
	while(True)
	{
		$PlayerGroup->update();
		sleep(0.05);
	}
});

//WebSocket进程,处理数据传输
$process_ws = new Process(function() use($StuffGroup, $PlayerGroup)
{
	$ws = new Swoole\WebSocket\Server('0.0.0.0', 8001);
	$ws->on('Open', function($ws, $request)
	{

	});
	$ws->on('Message', function($ws, $frame) use($StuffGroup, $PlayerGroup)
	{
		switch($frame->data)
		{
			case 'update':
				$ws->push($frame->fd, json_encode([$frame->data, $StuffGroup->getStuffGroupData()]));
				break;
		}
	});
	$ws->on('Close', function($ws, $fd)
	{

	});

	print("Websocket server initialization complete!\n");
	$ws->start();
});

//客户端HTTP服务器
$process_client = new Process(function()
{
	$http = new Swoole\Http\Server('0.0.0.0', 8002);

	$http->on('Request', function($request, $response)
	{
		$response->header('Content-Type', 'text/html; charset=utf-8');
		$response->end(file_get_contents('Client/client.html'));
	});

	print("Client http server initialization complete!\n");
	$http->start();
});

//启动进程
$process_client->start();
$process_service->start();
$process_ws->start();

echo "Main service start up now!\n";
Process::wait(true);