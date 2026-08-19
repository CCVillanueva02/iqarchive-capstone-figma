<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds for Bicol University Colleges and Satellite Campuses.
     */
    public function run(): void
    {
        $collegesData = [
            // Main & Specialized Campuses (Legazpi, Daraga, East Campus)
            'CS' => [
                'name' => 'BU College of Science',
                'campus' => 'Main Campus (Legazpi)',
            ],
            'CENG' => [
                'name' => 'BU College of Engineering',
                'campus' => 'Main Campus (Legazpi)',
            ],
            'CAL' => [
                'name' => 'BU College of Arts and Letters',
                'campus' => 'Main Campus (Legazpi)',
            ],
            'CED' => [
                'name' => 'BU College of Education',
                'campus' => 'Main Campus (Legazpi)',
            ],
            'CBEM' => [
                'name' => 'BU College of Business, Economics and Management',
                'campus' => 'Daraga Campus',
            ],
            'CSSP' => [
                'name' => 'BU College of Social Sciences and Philosophy',
                'campus' => 'Daraga Campus',
            ],
            'CN' => [
                'name' => 'BU College of Nursing',
                'campus' => 'Main Campus (Legazpi)',
            ],
            'CIT' => [
                'name' => 'BU College of Industrial Technology',
                'campus' => 'East Campus (Legazpi)',
            ],
            'CM' => [
                'name' => 'BU College of Medicine',
                'campus' => 'Main Campus (Legazpi)',
            ],
            'CL' => [
                'name' => 'BU College of Law',
                'campus' => 'Main Campus (Legazpi)',
            ],
            'IPES' => [
                'name' => 'BU Institute of Physical Education and Sports',
                'campus' => 'Main Campus (Legazpi)',
            ],

            // Satellite Campuses (treated directly as Colleges)
            'BUG' => [
                'name' => 'BU Guinobatan',
                'campus' => 'BU Guinobatan',
            ],
            'BUP' => [
                'name' => 'BU Polangui',
                'campus' => 'BU Polangui',
            ],
            'BUTC' => [
                'name' => 'BU Tabaco',
                'campus' => 'BU Tabaco',
            ],
            'BUGC' => [
                'name' => 'BU Gubat',
                'campus' => 'BU Gubat',
            ],
        ];

        // Clean up old or obsolete college records not in the official list
        College::whereNotIn('code', array_keys($collegesData))->forceDelete();

        foreach ($collegesData as $code => $data) {
            College::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $data['name'],
                    'campus' => $data['campus'],
                ]
            );
        }
    }
}
