<?php
/*
 * 实现:   Swoole\Table
 * 玩家数据 player
 * 物资数据 stuff
 * 指令数据 command
 */
class ShareMemory
{
	public $table;

	public function __construct()
	{
		$table = new Swoole\Table(64);
		$table->column('data', Swoole\Table::TYPE_STRING, 64*1024*16);
		$table->create();

		$this->table = $table;
	}

	public function setData($name, $data)
	{
		$this->table->set($name, ['data' => json_encode($data)]);
	}

	public function getData($name)
	{
		return  json_decode($this->table->get($name, 'data'), True);
	}

	public function addCommand($command, $args)
	{
		$command_data = $this->getData('command');
		$command_data[] = [
				'command' => $command,
				'args' => $args
		];
		$this->setData('command', $command_data);
	}

	public function clearCommand()
	{
		$this->setData('command', []);
	}
}