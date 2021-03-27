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
		while(1)
		{
			//处理指令
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
						case 'delPlayer':
							$this->PlayerGroup->delPlayer(...$command['args']);
							break;
						case 'setPlayerDirection':
							$this->PlayerGroup->setPlayerDirection(...$command['args']);
							break;
					}
				}
				$this->SM->clearCommand();
			}

			$this->PlayerGroup->update();
			$this->SM->setData('player', $this->PlayerGroup->getPlayerGroupData());
			$this->SM->setData('stuff', $this->StuffGroup->getStuffGroupData());
			sleep(1 / REFRESH_RATE);
		}
	}
}