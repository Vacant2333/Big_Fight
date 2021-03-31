<?php
declare(strict_types = 1);

class WebSocketProcess
{
	public Swoole\WebSocket\Server $websocket;
	public ShareMemory $SM;

	public function __construct($port, $SM)
	{
		$this->SM = $SM;
		$this->websocket = new Swoole\WebSocket\Server('0.0.0.0', $port);
		//启用压缩
		$this->websocket->set(['websocket_compression' => True]);

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
						$this->SM->addCommand('setPlayerDirection', [$frame->fd, intval($args[0])]);
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
		Swoole\Timer::tick(intval(1000 / REFRESH_RATE), function()
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
									]]), SWOOLE_WEBSOCKET_OPCODE_TEXT, SWOOLE_WEBSOCKET_FLAG_FIN | SWOOLE_WEBSOCKET_FLAG_COMPRESS);
				}
			}
		});

		$this->websocket->start();
	}
}