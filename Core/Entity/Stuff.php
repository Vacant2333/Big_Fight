<?php
/*
 * Stuff实体
 * 属性: 面积 Int, 坐标 Array(x,y), 类型 type(默认normal)
 */
class Stuff
{
	public $area = 0;
	public $coordinate = ['x' => 0, 'y' => 0];

	//初始化面积
	public function __construct()
	{
		$this->area = rand(25, 45);
		$this->setRandCoordinate();
	}

	//获得坐标
	public function getCoordinate()
	{
		return $this->coordinate;
	}

	//获得半径
	public function getRadius()
	{
		return sqrt($this->area / 3.14);
	}

	//获得面积
	public function getArea()
	{
		return $this->area;
	}

	//设置随机坐标,参数:X 和 Y的最大值
	public function setRandCoordinate()
	{
		$this->coordinate = ['x' => rand(0, MAP_MAX_X), 'y' => rand(0, MAP_MAX_Y)];
	}
}