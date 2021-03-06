<?php
declare(strict_types = 1);
include_once('Entity.php');

class Player extends Entity
{
	private int $direction = 0;
	private float $speed = PLAYER_SPEED / REFRESH_RATE;

	//初始化 设置玩家ID,面积
	public function __construct(int $id)
	{
		$this->id = $id;
		$this->area = PLAYER_AREA;
		$this->setRandCoordinate();
	}

	public function getSpeed() : float
	{
		return $this->speed;
	}

	public function setDirection(int $direction)
	{
		$this->direction = $direction;
	}

	public function getDirection() : int
	{
		return $this->direction;
	}

	//更新一帧
	public function update()
	{
		if($this->getDirection() != 0)
		{
			$x = $this->coordinate['x'];
			$y = $this->coordinate['y'];
			//斜走的速度
			$bevel_speed = round($this->speed / sqrt(2), 2);
			switch($this->getDirection())
			{
				case 3:
					//右上
					$x += $bevel_speed;
					$y -= $bevel_speed;
					break;
				case 6:
					//右
					$x += $this->speed;
					break;
				case 9:
					//右下
					$x += $bevel_speed;
					$y += $bevel_speed;
					break;
				case 12:
					//下
					$y += $this->speed;
					break;
				case 15:
					//左下
					$x -= $bevel_speed;
					$y += $bevel_speed;
					break;
				case 18:
					//左
					$x -= $this->speed;
					break;
				case 21:
					//左上
					$x -= $bevel_speed;
					$y -= $bevel_speed;
					break;
				case 24:
					//上
					$y -= $this->speed;
					break;
			}
			//处理出界
			$this->coordinate = [
					'x' => ($x < 0 or $x > MAP_MAX_X) ? (($x < 0) ? 0 : MAP_MAX_X) : $x,
					'y' => ($y < 0 or $y > MAP_MAX_Y) ? (($y < 0) ? 0 : MAP_MAX_Y) : $y
			];
		}
	}
}