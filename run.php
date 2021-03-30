<?php
use Swoole\Process;

define('REFRESH_RATE', 30);

define('PLAYER_AREA', 400);
define('PLAYER_SPEED', 80);
define('STUFF_AREA', [25,125]);

define('MAP_MAX_X', 800);
define('MAP_MAX_Y', 800);
define('HTTP_PORT', 8002);
define('WEBSOCKET_PORT', 8001);

include_once('Core/ShareMemory.php');
include_once('Core/Entity/StuffGroup.php');
include_once('Core/Entity/PlayerGroup.php');
include_once('Core/Process/HttpProcess.php');
include_once('Core/Process/ServerProcess.php');
include_once('Core/Process/WebSocketProcess.php');

$SM = new ShareMemory();

$process_server = new Process(function() use ($SM)
{
	(new ServerProcess($SM))->run();
});

$process_websocket = new Process(function() use ($SM)
{
	(new WebSocketProcess(WEBSOCKET_PORT, $SM))->run();
});

$process_client = new Process(function()
{
	(new HttpProcess(HTTP_PORT))->run();
});

$process_server->start();
$process_websocket->start();
$process_client->start();

print("Server start up now!\n");
Process::wait(true);