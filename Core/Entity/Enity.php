<?php
class Enity
{
	public $id;
	public $area = 0;
	public $coordinate = ['x' => 0, 'y' => 0];

	public function setCoordinate($x, $y)
	{
		$this->coordinate = ['x' => $x, 'y' => $y];
	}

	//设置随机坐标
	public function setRandCoordinate()
	{
		$this->setCoordinate(rand(0, MAP_MAX_X), rand(0, MAP_MAX_Y));
	}

	public function getCoordinate()
	{
		return $this->coordinate;
	}

	//获得半径
	public function getRadius()
	{
		return sqrt($this->area / 3.14);
	}

	public function getArea()
	{
		return $this->area;
	}
}