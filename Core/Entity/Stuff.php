<?php
/*
 * Stuff实体
 * 属性: 面积 Int, 坐标 Array(x,y), 类型 type(默认normal)
 */
class Stuff
{
	public $area;
	public $coordinate;
	public $type = 'normal';

	//初始化面积
	public function __construct()
	{
		$this->area = rand(10, 25);
	}

	//获得坐标
	public function getCoordinate()
	{
		return $this->coordinate ? $this->coordinate : False;
	}

	//获得面积
	public function getArea()
	{
		return $this->area;
	}

	//设置随机坐标,参数:X 和 Y的最大值
	public function setRandCoordinate($x_max, $y_max)
	{
		$this->coordinate = [rand(1, $x_max), rand(1, $y_max)];
	}
}