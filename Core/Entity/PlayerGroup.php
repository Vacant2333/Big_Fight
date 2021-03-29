<?php
include_once('Player.php');

class PlayerGroup
{
	public $player_id = [];
	public $player_class = [];

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

	public function setPlayerDirection($id, $direction)
	{
		$this->player_class[$id]->setDirection($direction);
	}

	public function existsPlayer($id)
	{
		return in_array($id, $this->player_id);
	}

	//获得玩家组数据
	public function getPlayerGroupData($compress = False)
	{
		$re = [];
		foreach($this->player_class as $id => $class)
		{
			if($compress)
			{
				$re[] = [
						$class->id,
						$class->getRadius(),
						[$class->getCoordinate()['x'], $class->getCoordinate()['y']]
				];
			}
			else
			{
				$re[] = [
						'id' => $class->id,
						'area' => $class->getArea(),
						'speed' => $class->getSpeed(),
						'radius' => $class->getRadius(),
						'direction' => $class->getDirection(),
						'coordinate' => $class->getCoordinate()
				];
			}
		}
		return $re;
	}

	//判断某个实体是否在组内的用户体内
	public function isInPlayerGrouBody($coordinate, $radius)
	{
		foreach($this->player_class as $id => $class)
		{
			if($class->isInBody($coordinate, $radius))
			{
				return $id;
			}
		}
		return False;
	}

	//更新一帧
	public function update()
	{
		foreach($this->player_class as $id => $class)
		{
			$class->update();
		}
	}
}