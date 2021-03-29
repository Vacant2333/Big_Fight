<?php
include_once('Stuff.php');

class StuffGroup
{
	private $stuff_id = [];
	private $stuff_class = [];
	private $stuff_max_num = 50;

	public function __construct()
	{
		$this->addStuff($this->stuff_max_num);
	}

	//获得所有物资数据
	public function getStuffGroupData($compress = False)
	{
		$re = [];
		foreach($this->stuff_class as $id => $class)
		{
			if($compress)
			{
				$re[] = [
						$class->id,
						$class->getRadius(),
						[$class->getCoordinate()['x'], $class->getCoordinate()['y']]
				];
			}
			else
			{
				$re[] = [
						'id' => $class->id,
						'area' => $class->getArea(),
						'coordinate' => $class->getCoordinate(),
						'radius' => $class->getRadius()
				];
			}
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

	private function addStuff($num)
	{
		while($num != 0)
		{
			$id = $this->getARandStuffId();
			$this->stuff_class[$id] = new Stuff($id);
			$num--;
		}
	}

	//获得一个随机物资ID
	private function getARandStuffId()
	{
		while(True)
		{
			$id = rand(1,1024);
			if(!in_array($id, $this->stuff_id))
			{
				$this->stuff_id[] = $id;
				return $id;
			}
		}
	}
}