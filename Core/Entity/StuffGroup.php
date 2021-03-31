<?php
declare(strict_types = 1);
include_once('Stuff.php');

class StuffGroup
{
	private array $stuff_id = [];
	private array $stuff_class = [];
	private int $stuff_max_num = 50;

	public function __construct()
	{
		$this->addStuff($this->stuff_max_num);
	}

	//获得所有物资数据
	public function getStuffGroupData(bool $compress = False) : array
	{
		$re = [];
		foreach($this->stuff_class as $id => $class)
		{
			if($compress == True)
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
	public function resetStuff(int $id)
	{
		$this->delStuff($id);
		$this->addStuff(1);
	}

	private function delStuff(int $id)
	{
		foreach($this->stuff_id as $key => $value)
		{
			if($value === $id)
			{
				unset($this->stuff_id[$key]);
			}
		}
		unset($this->stuff_class[$id]);
	}

	private function addStuff(int $num)
	{
		while($num !== 0)
		{
			$id = $this->getARandStuffId();
			$this->stuff_class[$id] = new Stuff($id);
			$num--;
		}
	}

	//获得一个随机物资ID
	private function getARandStuffId() : int
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