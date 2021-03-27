<?php
class ServerProcess
{
	public $StuffGroup;
	public $PlayerGroup;
	public $SM;

	public function __construct($SM)
	{
		//初始化
		$this->SM = $SM;
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
			$command_data = $this->SM->getData('command');

			if($command_data != NULL)
			{
				foreach($command_data as $command)
				{
					switch($command['command'])
					{
						case 'addPlayer':
							$this->PlayerGroup->addPlayer(...$command['args']);
							break;

					}
				}
				$this->SM->clearCommand();
			}



			$this->PlayerGroup->update();
			sleep(50 / REFRESH_RATE);
		}
	}
}