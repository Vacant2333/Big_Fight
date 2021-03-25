<?php
class Player
{
	public id;
	public coordinate;
	public direction = 0;

	public function __construct($id)
	{
		$this->id = $id;
	}

	public function setDirection($direction)
	{
		$this->direction = $direction;
	}

	public function setCoordinate($x, $y)
	{
		$this->coordinate($x, $y);
	}

	public function setRandCoordinate($max_x, $max_y)
	{
		$this->coordinate = [rand(1, $x_max), rand(1, $y_max)];
	}
}