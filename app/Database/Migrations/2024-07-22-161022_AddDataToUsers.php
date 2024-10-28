<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class AddMobileNumberToUsers extends Migration
{
    /**
     * @var string[]
     */
    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up()
    {
        $fields = [
            'name' => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true],
            'lastname' => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true],
            'phone' => ['type' => 'VARCHAR', 'constraint' => '9', 'null' => true],
            'sex' => ['type' => 'ENUM', 'constraint' => ['M','F','O'], 'null' => true],
            'birthday' => ['type' => 'DATE', 'null' => true],
        ];
        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $fields = [
            'name',
            'lastname',
            'phone',
            'sex',
            'birthday',
        ];
        $this->forge->dropColumn($this->tables['users'], $fields);
    }
}
