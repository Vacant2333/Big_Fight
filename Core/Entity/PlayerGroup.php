<?php
include_once('Player.php');

class PlayerGroup
{
	public $player_id = [];
	public $player_class = [];

	public function __construct()
	{
		print("PlayerGroup initialization complete,Number: {$this->stuff_max_num}\n");
	}

	//添加玩家
	public function addPlayer($id)
	{
		$this->player_id[] = $id;
		$this->player_class[$id] = new Player($id);
	}

	public function delPlayer($id)
	{
		foreach($this->player_id as $key => $value)
		{
			if($value == $id)
			{
				unset($this->player_id[$key]);
			}
		}
		unset($this->player_class[$id]);
	}


}