<?php
include_once('Enity.php');

class Stuff extends Enity
{
	public function __construct($id)
	{
		$this->id = $id;
		$this->area = rand(...STUFF_AREA);
		$this->setRandCoordinate();
	}
}