<?php
include_once('Stuff.php');

class StuffGroup
{
	public $stuff_id = [];
	public $stuff_class = [];
	public $stuff_max_num = 50;

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
			$re[] = ['id' => $id, 'area' => $class->area, 'coordinate' => $class->coordinate];
		}
		return $re;
	}

	//重置stuff
	public function resetStuff($id)
	{
		$this->delStuff($id);
		$this->addStuff(1);
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
			$stuff->setRandomCoordinate(400, 400);
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