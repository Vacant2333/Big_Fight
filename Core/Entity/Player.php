<?php
class Player
{
	public $id = 0;
	public $area = 0;
	public $coordinate = [];
	public $speed = 0.3;
	public $direction = 24;

	//初始化 设置玩家ID,面积
	public function __construct($id)
	{
		$this->id = $id;
		$this->area = rand(25, 60);
	}

	//更新一帧
	public function update()
	{
		if($this->direction != 0)
		{
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
					$this->coordinate[1] -= $this->speed;
					break;
			}

			//if()
		}
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
		$this->coordinate($x, $y);
	}

	//设置随机坐标
	public function setRandCoordinate()
	{
		$this->setCoordinate(rand(0, MAP_MAX_X), rand(0, MAP_MAX_Y));
	}
}