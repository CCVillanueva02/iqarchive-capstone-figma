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
                'logo_image' => 'IDEA.png',
            ],
            'CIT' => [
                'name' => 'College of Industrial Technology',
                'campus' => 'LEGAZPI EAST CAMPUS',
                'logo_image' => 'CIT.png',
            ],
            'CENG' => [
                'name' => 'College of Engineering',
                'campus' => 'LEGAZPI EAST CAMPUS',
                'logo_image' => 'CENG.png',
            ],

            // LEGAZPI WEST CAMPUS
            'CED' => [
                'name' => 'College of Education',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'CE.png',
            ],
            'CAL' => [
                'name' => 'College of Arts and Letters',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'CAL.png',
            ],
            'IPESR' => [
                'name' => 'Institute of Physical Education, Sports and Recreation',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'IPESR.png',
            ],
            'CN' => [
                'name' => 'College of Nursing',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'CN.png',
            ],
            'CS' => [
                'name' => 'College of Science',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'CS.png',
            ],
            'JMRIGD' => [
                'name' => 'Jesse M. Robredo Institute of Governance and Development',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'JMRIGD.png',
            ],
            'CM' => [
                'name' => 'College of Medicine',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'CM.png',
            ],
            'CDM' => [
                'name' => 'College of Dental Medicine',
                'campus' => 'LEGAZPI WEST CAMPUS',
                'logo_image' => 'CDM.png',
            ],

            // DARAGA CAMPUS
            'CBEM' => [
                'name' => 'College of Business, Economics and Management',
                'campus' => 'DARAGA CAMPUS',
                'logo_image' => 'CBEM.png',
            ],
            'CSSP' => [
                'name' => 'College of Social Sciences, and Philosophy',
                'campus' => 'DARAGA CAMPUS',
                'logo_image' => 'CSSP.png',
            ],

            // SATELLITE CAMPUSES
            'BUG' => [
                'name' => 'BU GUINOBATAN',
                'campus' => 'BU GUINOBATAN',
                'logo_image' => 'BUG.png',
            ],
            'BUP' => [
                'name' => 'BU POLANGUI',
                'campus' => 'BU POLANGUI',
                'logo_image' => 'BUPC.png',
            ],
            'BUTC' => [
                'name' => 'BU TABACO',
                'campus' => 'BU TABACO',
                'logo_image' => 'BUTC.png',
            ],
            'BUGC' => [
                'name' => 'BU GUBAT',
                'campus' => 'BU GUBAT',
                'logo_image' => 'BUGC.png',
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
                    'logo_image' => $data['logo_image'],
                ]
            );
        }
    }
}
