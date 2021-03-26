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
	private $stuff_max_num = 30;

	public function __construct()
	{
		$this->addStuff($this->stuff_max_num);
		print("StuffGroup initialization complete!\n");
	}

	//获得所有物资数据
	public function getStuffGroupData()
	{
		$re = [];
		foreach($this->stuff_class as $id => $class)
		{
			$re[] = [
				'id' => $id,
				'area' => $class->getArea(),
				'coordinate' => $class->getCoordinate(),
				'radius' => $class->getRadius()
			];
		}
		return $re;
	}

	//重置一个Stuff
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

	//更新Stuff最大数量
	public function setStuffMaxNum($num)
	{
		$this->addStuff($num - $this->stuff_max_num);
		$this->stuff_max_num = $num;
	}

	//删除Stuff
	private function delStuff($id)
	{
		foreach($this->stuff_id as $key => $value)
		{
			if($value == $id)
			{
				unset($this->stuff_id[$key]);
			}
		}
		unset($this->stuff_class[$id]);
	}

	//添加Stuff
	private function addStuff($num)
	{
		while($num != 0)
		{
			$this->stuff_class[$this->getARandStuffId()] = new Stuff();
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
}