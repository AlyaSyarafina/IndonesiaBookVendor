<?php

namespace PNDevworks\AdminPanel\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up()
	{
		// checks if table has been created or not.
		// If there's table on the DB, then skip this migration :D
		// Since this migration contains user creation as well, we'll just skip this thing.
		$db = \Config\Database::connect();
		if ($db->tableExists('users')) {
			return;
		}

		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '128',
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users');

		$builder = $db->table('users');
		$builder->insert([
			'first_name' => 'Admin',
			'last_name' => 'admin',
			'email' => 'admin@localhost',
			'password' => password_hash('admin', config("Authentication")->passwordAlgorithm)
		]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
