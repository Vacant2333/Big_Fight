<?php
class ServerProcess
{
	public $StuffGroup;
	public $PlayerGroup;

	public function __construct()
	{
		//初始化
		$this->PlayerGroup = new PlayerGroup();
		print("PlayerGroup initialization complete!\n");
		$this->StuffGroup = new StuffGroup();
		print("StuffGroup initialization complete!\n");

	}

	public function run()
	{
		$this->PlayerGroup->addPlayer(111);

		while(1)
		{
			$this->PlayerGroup->update();
			sleep(1 / REFRESH_RATE);
		}
		/*
		Swoole\Timer::tick(((1 * 1000) / REFRESH_RATE), function()
		{
			$this->PlayerGroup->update();
			sleep(0.01);
		});
		*/
	}
}