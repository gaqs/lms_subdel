<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Tecnología y Ciencia',
                'color' => '#22C55E',
                'created_at' => '2023-06-27 12:00:00',
                'updated_at' => '2023-06-27 12:00:00'
            ],
            [
                'id' => 2,
                'name' => 'Salud y Bienestar',
                'color' => '#F97316',
                'created_at' => '2023-06-28 12:00:00',
                'updated_at' => '2023-06-28 12:00:00'
            ],
            [
                'id' => 3,
                'name' => 'Negocios y Finanzas',
                'color' => '#525252',
                'created_at' => '2023-06-29 12:00:00',
                'updated_at' => '2023-06-29 12:00:00'
            ],
            [
                'id' => 4,
                'name' => 'Estilo de Vida',
                'color' => '#EAB308',
                'created_at' => '2023-06-30 12:00:00',
                'updated_at' => '2023-06-30 12:00:00'
            ],
            [
                'id' => 5,
                'name' => 'Educación y Aprendizaje',
                'color' => '#71717A',
                'created_at' => '2023-07-01 12:00:00',
                'updated_at' => '2023-07-01 12:00:00'
            ],
            [
                'id' => 6,
                'name' => 'Viajes y Aventuras',
                'color' => '#FDE047',
                'created_at' => '2023-07-02 12:00:00',
                'updated_at' => '2023-07-02 12:00:00'
            ],
            [
                'id' => 7,
                'name' => 'Arte y Cultura',
                'color' => '#84CC16',
                'created_at' => '2023-07-03 12:00:00',
                'updated_at' => '2023-07-03 12:00:00'
            ],
            [
                'id' => 8,
                'name' => 'Cocina y Gastronomía',
                'color' => '#4F46E5',
                'created_at' => '2023-07-04 12:00:00',
                'updated_at' => '2023-07-04 12:00:00'
            ],
            [
                'id' => 9,
                'name' => 'Opinión y Análisis',
                'color' => '#059669',
                'created_at' => '2023-07-05 12:00:00',
                'updated_at' => '2023-07-05 12:00:00'
            ],
            [
                'id' => 10,
                'name' => 'Desarrollo Personal',
                'color' => '#0D9488',
                'created_at' => '2023-07-06 12:00:00',
                'updated_at' => '2023-07-06 12:00:00'
            ]
        ];

        $this->db->table('categories')->insertBatch($data);

    }

}
