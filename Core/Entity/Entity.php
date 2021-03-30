<?php
class Entity
{
	public $id;
	public $area = 0;
	public $coordinate = ['x' => 0, 'y' => 0];

	public function setCoordinate($x, $y)
	{
		$this->coordinate = ['x' => $x, 'y' => $y];
	}

	//判断某个实体是否在本实体内
	public function isInBody($coordinate, $radius)
	{
		$self_radius = $this->getRadius();
		if($self_radius >= $radius)
		{
			$distance = sqrt(pow(($coordinate['x'] - $this->coordinate['x']), 2) + pow(($coordinate['y'] - $this->coordinate['y']), 2));
			if(($distance <= $self_radius) && ($coordinate != $this->coordinate))
			{
				return True;
			}
		}
		return False;
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

	public function addArea($num)
	{
		$this->area += $num;
	}
}