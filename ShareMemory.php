<?php
class ShareMemory
{
	/*
	 * 实现: Swoole\Table
	 * 第一行: 玩家数据
	 * 第二行: 肉坐标数据
	 */

	public $table;

	public function __construct()
	{
		$table = new Swoole\Table(1024);
		$table->column('data', Swoole\Table::TYPE_STRING, 4096);
		$table->create();

		$this->table = $table;

		print("ShareMemory初始化完成,内存占用:[" . (intval($this->table->memorySize / 1024)) . "] KB");
	}

	public function __destruct()
	{

	}
}