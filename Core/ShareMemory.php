<?php
declare(strict_types = 1);
/*
 * 进程间共享数据
 * 实现: Swoole\Table
 * 玩家数据 player
 * 物资数据 stuff
 * 指令数据 command
 */
class ShareMemory
{
	public Swoole\Table $table;

	public function __construct()
	{
		$table = new Swoole\Table(64);
		$table->column('data', Swoole\Table::TYPE_STRING, 32*1024*8);
		$table->create();

		$this->table = $table;
	}

	public function setData(string $name, array $data)
	{
		$this->table->set($name, ['data' => json_encode($data)]);
	}

	public function getData(string $name) : array
	{
		$data = $this->table->get($name, 'data');
		if($data)
		{
			return  json_decode($this->table->get($name, 'data'), True);
		}
		else
		{
			return [];
		}
	}

	public function addCommand(string $command, array $args)
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