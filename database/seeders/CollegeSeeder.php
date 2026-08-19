<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collegesData = [
            'CS' => 'BU College of Science',
            'CENG' => 'BU College of Engineering',
            'CAL' => 'BU College of Arts and Letters',
        ];

        foreach ($collegesData as $code => $name) {
            College::firstOrCreate(
                ['code' => $code],
                ['name' => $name]
            );
        }
    }
}
