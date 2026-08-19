<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = College::all()->keyBy('code');

        $programsData = [
            'CS' => [
                'BSCS' => ['name' => 'BS Computer Science', 'level' => 'Level IV Re-accredited'],
                'BSIT' => ['name' => 'BS Information Technology', 'level' => 'Level III Accredited'],
                'BSBIO' => ['name' => 'BS Biology', 'level' => 'Level III Accredited'],
            ],
            'CENG' => [
                'BSCE' => ['name' => 'BS Civil Engineering', 'level' => 'Level III Accredited'],
                'BSME' => ['name' => 'BS Mechanical Engineering', 'level' => 'Level II Accredited'],
            ],
        ];

        foreach ($programsData as $collegeCode => $collegePrograms) {
            $college = $colleges->get($collegeCode);
            if (!$college) continue;

            foreach ($collegePrograms as $code => $info) {
                Program::firstOrCreate(
                    ['code' => $code],
                    [
                        'college_id' => $college->id,
                        'name' => $info['name'],
                        'accreditation_level' => $info['level'],
                    ]
                );
            }
        }

        // Seed remaining programs programmatically to reach 126 (matches the Welcome Page)
        $colIds = $colleges->values();

        if ($colIds->isEmpty()) return;

        // 75 more Baccalaureate (to reach 80 total)
        for ($i = 6; $i <= 80; $i++) {
            $college = $colIds[$i % count($colIds)];
            Program::firstOrCreate(
                ['code' => "BSP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "BS Program " . $i,
                ]
            );
        }

        // 39 Master's programs
        for ($i = 1; $i <= 39; $i++) {
            $college = $colIds[$i % count($colIds)];
            Program::firstOrCreate(
                ['code' => "MSP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "MS Program " . $i,
                ]
            );
        }

        // 7 Doctoral programs
        for ($i = 1; $i <= 7; $i++) {
            $college = $colIds[$i % count($colIds)];
            Program::firstOrCreate(
                ['code' => "PHDP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "PhD Program " . $i,
                ]
            );
        }

        // 2 Post Bacc programs
        for ($i = 1; $i <= 2; $i++) {
            $college = $colIds[$i % count($colIds)];
            Program::firstOrCreate(
                ['code' => "PBP" . $i],
                [
                    'college_id' => $college->id,
                    'name' => "Post Bacc Program " . $i,
                ]
            );
        }
    }
}
