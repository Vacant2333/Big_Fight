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
		$this->StuffGroup = new StuffGroup();
	}

	public function run()
	{
		while(1)
		{
			//处理指令
			$command_data = $this->SM->getData('command');
			if($command_data != Null)
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
							if(!$this->PlayerGroup->existsPlayer($command['args'][0]))
							{
								$this->PlayerGroup->addPlayer($command['args'][0]);
							}
							$this->PlayerGroup->setPlayerDirection(...$command['args']);
							break;
					}
				}
				$this->SM->clearCommand();
			}

			if($this->PlayerGroup->getPlayerGroupData() != Null)
			{
				//吃肉
				foreach($this->StuffGroup->getStuffGroupData() as $stuff)
				{
					$player_id = $this->PlayerGroup->isInPlayerGrouBody($stuff['coordinate'], $stuff['radius']);
					if($player_id)
					{
						$this->PlayerGroup->player_class[$player_id]->addArea($stuff['area']);
						$this->StuffGroup->resetStuff($stuff['id']);
					}
				}
				//吃玩家
				foreach($this->PlayerGroup->getPlayerGroupData() as $small_player)
				{
					$big_player_id = $this->PlayerGroup->isInPlayerGrouBody($small_player['coordinate'], $small_player['radius']);
					if($big_player_id)
					{
						$this->PlayerGroup->player_class[$big_player_id]->addArea($small_player['area']);
						$this->PlayerGroup->delPlayer($small_player['id']);
					}
				}

				$this->PlayerGroup->update();
			}

			$this->SM->setData('player', $this->PlayerGroup->getPlayerGroupData(true));
			$this->SM->setData('stuff', $this->StuffGroup->getStuffGroupData(true));
			usleep(round(1000000 / REFRESH_RATE));
		}
	}
}