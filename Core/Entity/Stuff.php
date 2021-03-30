<?php
include_once('Entity.php');

class Stuff extends Entity
{
	public function __construct($id)
	{
		$this->id = $id;
		$this->area = rand(...STUFF_AREA);
		$this->setRandCoordinate();
	}
}