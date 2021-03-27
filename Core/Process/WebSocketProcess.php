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
			$command = explode(' ', $frame->data)[0];
			$args = array_slice(explode(' ', $frame->data), 1);
			switch($command)
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
				case 'setPlayerDirection':
					$this->SM->addCommand('setPlayerDirection', [$frame->fd, $args[0]]);
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