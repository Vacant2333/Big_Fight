<?php
declare(strict_types = 1);
include_once('Player.php');

class PlayerGroup
{
	private array $player_id = [];
	private array $player_class = [];

	public function addPlayer(int $id)
	{
		$this->player_id[] = $id;
		$this->player_class[$id] = new Player($id);
	}

	public function delPlayer(int $id)
	{
		foreach($this->player_id as $key => $value)
		{
			if($value === $id)
			{
				unset($this->player_id[$key]);
			}
		}
		unset($this->player_class[$id]);
	}

	public function setPlayerDirection(int $id, int $direction)
	{
		$this->player_class[$id]->setDirection($direction);
	}

	public function existsPlayer(int $id) : bool
	{
		return in_array($id, $this->player_id);
	}

	//获得玩家组数据
	public function getPlayerGroupData(bool $compress = False) : array
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
	public function isInPlayerGroupBody(array $coordinate, float $radius) : int
	{
		foreach($this->player_class as $id => $class)
		{
			if($class->isInBody($coordinate, $radius) == True)
			{
				return $id;
			}
		}
		return 0;
	}

	public function addPlayerArea(int $id, int $area)
	{
		$this->player_class[$id]->addArea($area);
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