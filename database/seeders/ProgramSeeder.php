<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds for Bicol University Degree Programs per College & Campus.
     * All programs set to 'Candidate Status' as requested.
     */
    public function run(): void
    {
        $colleges = College::all()->keyBy('code');

        $programsData = [
            // College of Science (CS)
            'CS' => [
                'BSCS' => ['name' => 'BS Computer Science', 'level' => 'Candidate Status'],
                'BSIT' => ['name' => 'BS Information Technology', 'level' => 'Candidate Status'],
                'BSBIO' => ['name' => 'BS Biology', 'level' => 'Candidate Status'],
                'BSCHEM' => ['name' => 'BS Chemistry', 'level' => 'Candidate Status'],
                'BSMET' => ['name' => 'BS Meteorology', 'level' => 'Candidate Status'],
            ],

            // College of Engineering (CENG)
            'CENG' => [
                'BSCE' => ['name' => 'BS Civil Engineering', 'level' => 'Candidate Status'],
                'BSME' => ['name' => 'BS Mechanical Engineering', 'level' => 'Candidate Status'],
                'BSEE' => ['name' => 'BS Electrical Engineering', 'level' => 'Candidate Status'],
                'BSCHE' => ['name' => 'BS Chemical Engineering', 'level' => 'Candidate Status'],
                'BSGE' => ['name' => 'BS Geodetic Engineering', 'level' => 'Candidate Status'],
                'BSCOE' => ['name' => 'BS Computer Engineering', 'level' => 'Candidate Status'],
                'BSMINE' => ['name' => 'BS Mining Engineering', 'level' => 'Candidate Status'],
            ],

            // College of Arts and Letters (CAL)
            'CAL' => [
                'ABCOMM' => ['name' => 'AB Communication', 'level' => 'Candidate Status'],
                'ABJOURN' => ['name' => 'AB Journalism', 'level' => 'Candidate Status'],
                'ABEL' => ['name' => 'AB English Language', 'level' => 'Candidate Status'],
                'BPA' => ['name' => 'Bachelor of Performing Arts', 'level' => 'Candidate Status'],
                'ABHUM' => ['name' => 'AB Humanities', 'level' => 'Candidate Status'],
            ],

            // College of Education (CED)
            'CED' => [
                'BEED' => ['name' => 'Bachelor of Elementary Education', 'level' => 'Candidate Status'],
                'BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Candidate Status'],
                'BECED' => ['name' => 'Bachelor of Early Childhood Education', 'level' => 'Candidate Status'],
                'BSNED' => ['name' => 'Bachelor of Special Needs Education', 'level' => 'Candidate Status'],
                'BCAED' => ['name' => 'Bachelor of Culture and Arts Education', 'level' => 'Candidate Status'],
                'MAED' => ['name' => 'Master of Arts in Education', 'level' => 'Candidate Status'],
                'PHDED' => ['name' => 'Doctor of Philosophy in Education', 'level' => 'Candidate Status'],
            ],

            // College of Business, Economics and Management (CBEM)
            'CBEM' => [
                'BSA' => ['name' => 'BS Accountancy', 'level' => 'Candidate Status'],
                'BSBA' => ['name' => 'BS Business Administration', 'level' => 'Candidate Status'],
                'BSMA' => ['name' => 'BS Management Accounting', 'level' => 'Candidate Status'],
                'BSENT' => ['name' => 'BS Entrepreneurship', 'level' => 'Candidate Status'],
                'BSECON' => ['name' => 'BS Economics', 'level' => 'Candidate Status'],
                'MBA' => ['name' => 'Master in Business Administration', 'level' => 'Candidate Status'],
            ],

            // College of Social Sciences and Philosophy (CSSP)
            'CSSP' => [
                'ABPOLSCI' => ['name' => 'AB Political Science', 'level' => 'Candidate Status'],
                'ABPHIL' => ['name' => 'AB Philosophy', 'level' => 'Candidate Status'],
                'ABSOC' => ['name' => 'AB Sociology', 'level' => 'Candidate Status'],
                'BSSW' => ['name' => 'BS Social Work', 'level' => 'Candidate Status'],
                'BSPSYCH' => ['name' => 'BS Psychology', 'level' => 'Candidate Status'],
            ],

            // College of Nursing (CN)
            'CN' => [
                'BSN' => ['name' => 'BS Nursing', 'level' => 'Candidate Status'],
                'MAN' => ['name' => 'Master of Arts in Nursing', 'level' => 'Candidate Status'],
            ],

            // College of Industrial Technology (CIT)
            'CIT' => [
                'BET' => ['name' => 'Bachelor of Engineering Technology', 'level' => 'Candidate Status'],
                'BSAT' => ['name' => 'BS Automotive Technology', 'level' => 'Candidate Status'],
                'BSET' => ['name' => 'BS Electrical Technology', 'level' => 'Candidate Status'],
                'BSEL' => ['name' => 'BS Electronics Technology', 'level' => 'Candidate Status'],
                'BSFT' => ['name' => 'BS Food Technology', 'level' => 'Candidate Status'],
            ],

            // College of Medicine (CM)
            'CM' => [
                'MD' => ['name' => 'Doctor of Medicine', 'level' => 'Candidate Status'],
            ],

            // College of Law (CL)
            'CL' => [
                'JD' => ['name' => 'Juris Doctor', 'level' => 'Candidate Status'],
            ],

            // Institute of Physical Education and Sports (IPES)
            'IPES' => [
                'BPE' => ['name' => 'Bachelor of Physical Education', 'level' => 'Candidate Status'],
                'BSESS' => ['name' => 'BS Exercise and Sports Sciences', 'level' => 'Candidate Status'],
            ],

            // SATELLITE CAMPUS: BU GUINOBATAN (BUG)
            'BUG' => [
                'BUG-BSAGRI' => ['name' => 'BS Agriculture', 'level' => 'Candidate Status'],
                'BUG-BSABE' => ['name' => 'BS Agricultural and Biosystems Engineering', 'level' => 'Candidate Status'],
                'BUG-BSF' => ['name' => 'BS Forestry', 'level' => 'Candidate Status'],
                'BUG-BSAGRIBUS' => ['name' => 'BS Agribusiness', 'level' => 'Candidate Status'],
            ],

            // SATELLITE CAMPUS: BU POLANGUI (BUP)
            'BUP' => [
                'BUP-BSIT' => ['name' => 'BS Information Technology', 'level' => 'Candidate Status'],
                'BUP-BSCS' => ['name' => 'BS Computer Science', 'level' => 'Candidate Status'],
                'BUP-BSECE' => ['name' => 'BS Electronics Engineering', 'level' => 'Candidate Status'],
                'BUP-BSN' => ['name' => 'BS Nursing', 'level' => 'Candidate Status'],
                'BUP-BEED' => ['name' => 'Bachelor of Elementary Education', 'level' => 'Candidate Status'],
                'BUP-BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Candidate Status'],
                'BUP-BSAT' => ['name' => 'BS Automotive Technology', 'level' => 'Candidate Status'],
                'BUP-BSCOE' => ['name' => 'BS Computer Engineering', 'level' => 'Candidate Status'],
            ],

            // SATELLITE CAMPUS: BU TABACO (BUTC)
            'BUTC' => [
                'BUTC-BSFISH' => ['name' => 'BS Fisheries', 'level' => 'Candidate Status'],
                'BUTC-BSFT' => ['name' => 'BS Food Technology', 'level' => 'Candidate Status'],
                'BUTC-BSN' => ['name' => 'BS Nursing', 'level' => 'Candidate Status'],
                'BUTC-BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Candidate Status'],
                'BUTC-BSBA' => ['name' => 'BS Business Administration', 'level' => 'Candidate Status'],
                'BUTC-BSENT' => ['name' => 'BS Entrepreneurship', 'level' => 'Candidate Status'],
            ],

            // SATELLITE CAMPUS: BU GUBAT (BUGC)
            'BUGC' => [
                'BUGC-BEED' => ['name' => 'Bachelor of Elementary Education', 'level' => 'Candidate Status'],
                'BUGC-BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Candidate Status'],
                'BUGC-BSBA' => ['name' => 'BS Business Administration', 'level' => 'Candidate Status'],
                'BUGC-BSCS' => ['name' => 'BS Computer Science', 'level' => 'Candidate Status'],
                'BUGC-BSAE' => ['name' => 'BS Agricultural Entrepreneurship', 'level' => 'Candidate Status'],
            ],
        ];

        // Gather all valid official program codes
        $validProgramCodes = [];
        foreach ($programsData as $collegePrograms) {
            foreach (array_keys($collegePrograms) as $code) {
                $validProgramCodes[] = $code;
            }
        }

        // Clean up old generated or fake program records (BSP6..80, MSP1..39, PHDP1..7, etc.)
        Program::whereNotIn('code', $validProgramCodes)->forceDelete();

        foreach ($programsData as $collegeCode => $collegePrograms) {
            $college = $colleges->get($collegeCode);
            if (!$college) continue;

            foreach ($collegePrograms as $code => $info) {
                Program::updateOrCreate(
                    ['code' => $code],
                    [
                        'college_id' => $college->id,
                        'name' => $info['name'],
                        'accreditation_level' => $info['level'],
                    ]
                );
            }
        }

        // Also update all existing records in database to Candidate Status
        Program::query()->update(['accreditation_level' => 'Candidate Status']);
    }
}
