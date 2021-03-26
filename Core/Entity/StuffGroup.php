<?php
include_once('Stuff.php');
/*
 * Stuff实体组
 * getStuffGroupData 获得所有物资数据 返回二位数组
 * resetStuff($id)   重置一个物资
 */
class StuffGroup
{
	private $stuff_id = [];
	private $stuff_class = [];
	//MAX 1500?
	private $stuff_max_num = 25;
	private $max_x = 800;
	private $max_y = 800;

	public function __construct()
	{
		$this->addStuff($this->stuff_max_num);
		print("StuffGroup initialization complete,Number: {$this->stuff_max_num}\n");
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

	//重置Stuff
	public function resetStuff($id)
	{
		$this->delStuff($id);
		$this->addStuff(1);
	}

	//获取一个随机 存在的物资ID
	public function getARealRandStuffId()
	{
		return $this->stuff_id[array_rand($this->stuff_id, 1)];
	}

	//更新XY最大值
	public function setXYMax($max_x, $max_y)
	{
		$this->max_x = $max_x;
		$this->max_y = $max_y;
	}

	//更新Stuff最大数量
	public function setStuffMaxNum($num)
	{
		$this->addStuff($num - $this->stuff_max_num);
		$this->stuff_max_num = $num;
	}

	//删除Stuff
	private function delStuff($id)
	{
		$this->delStuffId($id);
		unset($this->stuff_class[$id]);
	}

	//添加Stuff
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

	//获得随机ID
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

	//删除Stuff Id
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