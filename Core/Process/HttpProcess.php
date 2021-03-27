<?php
class HttpProcess
{
	public $http_server;

	public function __construct($port)
	{
		$this->http_server = new Swoole\Http\Server('0.0.0.0', $port);

		$this->http_server->on('Request', function($request, $response)
		{
			$response->header('Content-Type', 'text/html; charset=utf-8');
			$response->end(file_get_contents('Client/client.html'));
		});
	}

	public function run()
	{
		print("Client http server initialization complete!\n");
		$this->http_server->start();
	}
}