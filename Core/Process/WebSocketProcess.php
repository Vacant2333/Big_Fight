<?php
class WebSocketProcess
{
	public $WebSocket;
	public $SM;

	public function __construct($port, $SM)
	{
		$this->SM = $SM;
		$this->WebSocket = new Swoole\WebSocket\Server('0.0.0.0', $port);

		$this->WebSocket->on('Open', function($ws, $request)
		{
			$this->SM->addCommand('addPlayer', [$request->fd]);
		});
		$this->WebSocket->on('Message', function($ws, $frame)
		{
			switch($frame->data)
			{
				case 'update':
					$ws->push($frame->fd, json_encode([
							'name' => 'update',
							'data' => [
								'player' => $this->SM->getData('player'),
								'stuff' => $this->SM->getData('stuff')
							]]
					));
					break;
			}
		});
		$this->WebSocket->on('Close', function($ws, $fd)
		{
			$this->SM->addCommand('delPlayer', [$fd]);
		});
	}

	public function run()
	{
		print("Websocket server initialization complete!\n");
		$this->WebSocket->start();
	}
}