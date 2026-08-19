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
            // LEGAZPI EAST CAMPUS
            'IDA' => [
                'name' => 'Institute of Design and Architecture',
                'campus' => 'LEGAZPI EAST CAMPUS',
            ],
            'CIT' => [
                'name' => 'College of Industrial Technology',
                'campus' => 'LEGAZPI EAST CAMPUS',
            ],
            'CENG' => [
                'name' => 'College of Engineering',
                'campus' => 'LEGAZPI EAST CAMPUS',
            ],

            // LEGAZPI WEST CAMPUS
            'CED' => [
                'name' => 'College of Education',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],
            'CAL' => [
                'name' => 'College of Arts and Letters',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],
            'IPESR' => [
                'name' => 'Institute of Physical Education, Sports and Recreation',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],
            'CN' => [
                'name' => 'College of Nursing',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],
            'CS' => [
                'name' => 'College of Science',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],
            'JMRIGD' => [
                'name' => 'Jesse M. Robredo Institute of Governance and Development',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],
            'CM' => [
                'name' => 'College of Medicine',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],
            'CDM' => [
                'name' => 'College of Dental Medicine',
                'campus' => 'LEGAZPI WEST CAMPUS',
            ],

            // DARAGA CAMPUS
            'CBEM' => [
                'name' => 'College of Business, Economics and Management',
                'campus' => 'DARAGA CAMPUS',
            ],
            'CSSP' => [
                'name' => 'College of Social Sciences, and Philosophy',
                'campus' => 'DARAGA CAMPUS',
            ],

            // SATELLITE CAMPUSES
            'BUG' => [
                'name' => 'BU GUINOBATAN',
                'campus' => 'BU GUINOBATAN',
            ],
            'BUP' => [
                'name' => 'BU POLANGUI',
                'campus' => 'BU POLANGUI',
            ],
            'BUTC' => [
                'name' => 'BU TABACO',
                'campus' => 'BU TABACO',
            ],
            'BUGC' => [
                'name' => 'BU GUBAT',
                'campus' => 'BU GUBAT',
            ],
        ];

        // Force delete any obsolete colleges not in the official user list
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
