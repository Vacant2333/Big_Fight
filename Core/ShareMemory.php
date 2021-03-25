<?php
/*
 * 实现:   Swoole\Table
 * 玩家数据 player
 * 物资数据 stuff
 */
class ShareMemory
{
	public $table;

	public function __construct()
	{
		$table = new Swoole\Table(1024);
		$table->column('data', Swoole\Table::TYPE_STRING, 4096);
		$table->create();

		$this->table = $table;
		print("ShareMemory initialization complete,memory footprint: " . (intval($this->table->memorySize / 1024)) . " KB\n");
	}

	public function saveData($name, $data)
	{
		$this->table->set($name, ['data' => json_encode($data)]);
	}

	public function getData($name)
	{
		return json_decode($this->table->get($name, 'data'));
	}
}