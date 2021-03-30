<?php
class HttpProcess
{
	public $http_server;

	public function __construct($port)
	{
		$this->http_server = new Swoole\Http\Server('0.0.0.0', $port);
		//设置压缩等级(1~9)
		$this->http_server->set(['http_compression_level' => 9]);

		$this->http_server->on('Request', function($request, $response)
		{
			$response->header('Content-Type', 'text/html; charset=utf-8');
			$response->end(file_get_contents('Client/client.html'));
		});
	}

	public function run()
	{
		$this->http_server->start();
	}
}