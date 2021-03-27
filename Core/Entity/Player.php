<?php
class Player
{
	public $id = 0;
	public $area = 300;
	public $coordinate = ['x' => 0, 'y' => 0];
	public $speed = 0.13 / REFRESH_RATE;
	public $direction = 24;

	//初始化 设置玩家ID,面积
	public function __construct($id)
	{
		$this->id = $id;
	}

	//更新一帧
	public function update()
	{
		if($this->getDirection() != 0)
		{
			$x = $this->coordinate['x'];
			$y = $this->coordinate['y'];
			switch($this->getDirection())
			{
				case 3:
					//右上

					break;
				case 6:
					//右
					$x += $this->speed;
					break;
				case 9:
					//右下

					break;
				case 12:
					//下
					$y += $this->speed;
					break;
				case 15:
					//左下

					break;
				case 18:
					//左
					$x -= $this->speed;
					break;
				case 21:
					//左上

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

	public function getSpeed()
	{
		return $this->speed;
	}

	public function getArea()
	{
		return $this->area;
	}

	//获得半径
	public function getRadius()
	{
		return sqrt($this->area / 3.14);
	}

	//设置方向
	public function setDirection($direction)
	{
		$this->direction = $direction;
	}

	//获取方向
	public function getDirection()
	{
		return $this->direction;
	}

	//获得坐标
	public function getCoordinate()
	{
		return $this->coordinate;
	}

	//设置坐标
	public function setCoordinate($x, $y)
	{
		$this->coordinate = ['x' => $x, 'y' => $y];
	}

	//设置随机坐标
	public function setRandCoordinate()
	{
		$this->setCoordinate(rand(0, MAP_MAX_X), rand(0, MAP_MAX_Y));
	}
}