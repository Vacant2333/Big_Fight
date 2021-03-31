<?php
declare(strict_types = 1);

class Entity
{
	public int $id;
	public int $area = 0;
	public array $coordinate = ['x' => 0, 'y' => 0];

	//判断某个实体是否在本实体内
	public function isInBody(array $coordinate, float $radius) : bool
	{
		$self_radius = $this->getRadius();
		if($self_radius >= $radius)
		{
			//两个圆心的距离
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

	public function setCoordinate(float $x, float $y)
	{
		$this->coordinate = ['x' => $x, 'y' => $y];
	}

	public function addArea(int $num)
	{
		$this->area += $num;
	}

	public function getCoordinate() : array
	{
		return $this->coordinate;
	}

	//获得半径
	public function getRadius() : float
	{
		return round(sqrt($this->area / 3.14), 2);
	}

	public function getArea() : int
	{
		return $this->area;
	}
}