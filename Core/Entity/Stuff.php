<?php
include_once('Enity.php');

class Stuff extends Enity
{
	public function __construct($id)
	{
		$this->id = $id;
		$this->area = rand(25, 45);
		$this->setRandCoordinate();
	}
}