<?php
class WebSocketProcess
{
	public $websocket;
	public $SM;

	public function __construct($port, $SM)
	{
		$this->SM = $SM;
		$this->websocket = new Swoole\WebSocket\Server('0.0.0.0', $port);

		$this->websocket->on('Open', function($ws, $request)
		{
			$this->SM->addCommand('addPlayer', [$request->fd]);
		});
		$this->websocket->on('Message', function($ws, $frame)
		{
			if($this->websocket->isEstablished($frame->fd))
			{
				$command = explode(' ', $frame->data)[0];
				$args = array_slice(explode(' ', $frame->data), 1);

				switch($command)
				{
					case 'setPlayerDirection':
						$this->SM->addCommand('setPlayerDirection', [$frame->fd, $args[0]]);
						break;
				}
			}
		});
		$this->websocket->on('Close', function($ws, $fd)
		{
			$this->SM->addCommand('delPlayer', [$fd]);
		});
	}

	public function run()
	{
		//实时推送游戏数据
		Swoole\Timer::tick(round(1000 / REFRESH_RATE), function()
		{
			foreach($this->websocket->connections as $fd)
			{
				if($this->websocket->isEstablished($fd))
				{
					$this->websocket->push($fd, json_encode([
									'name' => 'update',
									'data' => [
											'player' => $this->SM->getData('player'),
											'stuff' => $this->SM->getData('stuff')
									]]));
				}
			}
		});

		$this->websocket->start();
	}
}