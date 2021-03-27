<?php
class WebSocketProcess
{
	public $WebSocket;

	public function __construct($port)
	{
		$this->WebSocket = new Swoole\WebSocket\Server('0.0.0.0', $port);

		$this->WebSocket->on('Open', function($ws, $request)
		{
			$this->PlayerGroup->addPlayer($request->fd);
		});
		$this->WebSocket->on('Message', function($ws, $frame)
		{

			switch($frame->data)
			{
				case 'update':
					//var_dump($this->PlayerGroup->getPlayerGroupData());
					$ws->push($frame->fd, json_encode(['name' => 'update', 'data' => ['player' => $this->PlayerGroup->getPlayerGroupData(), 'stuff' => $this->StuffGroup->getStuffGroupData()]]));
					break;
			}
		});
		$this->WebSocket->on('Close', function($ws, $fd)
		{
			$this->PlayerGroup->delPlayer($fd);
		});
	}

	public function run()
	{
		print("Websocket server initialization complete!\n");
		$this->WebSocket->start();
	}
}