<?php
declare(strict_types = 1);
include_once('Entity.php');

class Stuff extends Entity
{
	public function __construct(int $id)
	{
		$this->id = $id;
		$this->area = rand(...STUFF_AREA);
		$this->setRandCoordinate();
	}
}