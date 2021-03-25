<?php
include_once('Stuff.php');
/*
 * Stuff组
 * getStuffGroupData 获得所有物资数据 返回二位数组
 * resetStuff($id)   重置一个物资
 */
class StuffGroup
{
	private $stuff_id = [];
	private $stuff_class = [];
	private $stuff_max_num = 50;
	private $max_x = 200;
	private $max_y = 200;

	public function __construct()
	{
		$this->addStuff($this->stuff_max_num);
	}

	//获得所有物资数据
	public function getStuffGroupData()
	{
		$re = [];
		foreach($this->stuff_class as $id => $class)
		{
			$re[] = ['id' => $id, 'area' => $class->getArea(), 'coordinate' => $class->getCoordinate()];
		}
		return $re;
	}

	//重置stuff
	public function resetStuff($id)
	{
		$this->delStuff($id);
		$this->addStuff(1);
	}

	//更新XY最大值
	public function setXYMax($max_x, $max_y)
	{
		$this->max_x = $max_x;
		$this->max_y = $max_y;
	}

	//更新Sutff最大数量
	public function setStuffMaxNum($num)
	{
		$this->addStuff($num - $this->stuff_max_num);
		$this->stuff_max_num = $num;
	}

	//删除stuff
	private function delStuff($id)
	{
		$this->delStuffId($id);
		unset($this->stuff_class[$id]);
	}

	//添加stuff
	private function addStuff($num)
	{
		while($num != 0)
		{
			$stuff = new Stuff();
			$stuff->setRandCoordinate($this->max_x, $this->max_y);
			$this->stuff_class[$this->getARandStuffId()] = $stuff;
			$num--;
		}
	}

	//获得一个随机ID
	private function getARandStuffId()
	{
		while(True)
		{
			$id = rand(1,4096);
			if(!in_array($id, $this->stuff_id))
			{
				$this->stuff_id[] = $id;
				return $id;
			}
		}
	}

	private function delStuffId($id)
	{
		foreach($this->stuff_id as $key => $value)
		{
			if($value == $id)
			{
				unset($this->stuff_id[$key]);
			}
		}
	}
}