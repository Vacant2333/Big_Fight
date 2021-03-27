<?php
class Player
{
	public $id = 0;
	public $area = 150;
	public $coordinate = ['x' => 0, 'y' => 0];
	public $speed = 20 / REFRESH_RATE;
	public $direction = 24;

	//初始化 设置玩家ID,面积
	public function __construct($id)
	{
		$this->id = $id;
	}

	//更新一帧
	public function update()
	{
		if($this->direction != 0)
		{
			//TOOD:方向
			switch($this->direction)
			{
				case 3:
					//
					break;
				case 6:

					break;
				case 9:

					break;
				case 12:

					break;
				case 15:

					break;
				case 18:

					break;
				case 21:

					break;
				case 24:
					//上
					$this->coordinate['y'] -= $this->speed;
					break;
			}

			//if()
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