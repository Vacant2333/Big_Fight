<?php
use Swoole\Process;

define('MAP_MAX_X', 800);
define('MAP_MAX_Y', 800);
define('REFRESH_RATE', 30);
define('HTTP_PORT', 8002);
define('WEBSOCKET_PORT', 8001);

include_once('Core/ShareMemory.php');
include_once('Core/Entity/StuffGroup.php');
include_once('Core/Entity/PlayerGroup.php');
include_once('Core/Process/HttpProcess.php');
include_once('Core/Process/ServerProcess.php');
include_once('Core/Process/WebSocketProcess.php');

$SM = new ShareMemory();
print("ShareMemory initialization complete,memory footprint: " . (intval($SM->table->memorySize / 1024 / 1024)) . " MB!\n");

//Server进程
$process_server = new Process(function() use ($SM)
{
	(new ServerProcess($SM))->run();
});

//WebSocket进程
$process_websocket = new Process(function() use ($SM)
{
	(new WebSocketProcess(WEBSOCKET_PORT, $SM))->run();
});

//客户端HTTP进程
$process_client = new Process(function()
{
	(new HttpProcess(HTTP_PORT))->run();
});

//启动进程
$process_server->start();
$process_websocket->start();
$process_client->start();

sleep(1);
print("Server start up now!\n");
Process::wait(true);