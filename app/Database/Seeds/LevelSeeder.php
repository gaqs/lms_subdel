<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'level' => 'Novato',
                'created_at' => '2024-09-12 12:00:00',
                'updated_at' => '2024-09-12 12:00:00'
            ],
            [
                'id' => 2,
                'level' => 'Intermedio',
                'created_at' => '2024-09-12 12:00:00',
                'updated_at' => '2024-09-12 12:00:00'
            ],
            [
                'id' => 3,
                'level' => 'Avanzado',
                'created_at' => '2024-09-12 12:00:00',
                'updated_at' => '2024-09-12 12:00:00'
            ],
        ];

        $this->db->table('levels')->insertBatch($data);


    }
}
