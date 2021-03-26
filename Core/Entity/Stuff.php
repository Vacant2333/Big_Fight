<?php
/*
 * Stuff实体
 * 属性: 面积 Int, 坐标 Array(x,y), 类型 type(默认normal)
 */
class Stuff
{
	public $area = 0;
	public $coordinate = [];

	//初始化面积
	public function __construct()
	{
		$this->area = rand(15, 33);
		$this->setRandCoordinate();
	}

	//获得坐标
	public function getCoordinate()
	{
		return $this->coordinate ? $this->coordinate : False;
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
		$this->coordinate = [rand(0, MAP_MAX_X), rand(0, MAP_MAX_Y)];
	}
}