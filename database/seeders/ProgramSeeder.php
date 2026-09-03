<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds for Bicol University Degree Programs.
     * All programs match the official user campus/college structure and default to 'Candidate Status'.
     */
    public function run(): void
    {
        $colleges = College::all()->keyBy('code');

        $programsData = [
            // LEGAZPI EAST CAMPUS: Institute of Design and Architecture
            'IDA' => [
                'MSARCH' => 'Master of Science in Architecture',
                'BSARCH' => 'Bachelor of Science in Architecture',
            ],

            // LEGAZPI EAST CAMPUS: College of Industrial Technology
            'CIT' => [
                'MAIE' => 'Master of Arts in Industrial Education',
                'BSFT' => 'Bachelor of Science in Food Technology',
                'BTVTED' => 'Bachelor of Technical Vocational Teacher Education',
                'BSAT' => 'Bachelor of Science in Automotive Technology',
                'BSET' => 'Bachelor of Science in Electronics Technology',
                'BSMT' => 'Bachelor of Science in Mechanical Technology',
                'BSCT' => 'Bachelor of Science in Civil Technology',
                'BSELT' => 'Bachelor of Science in Electrical Technology',
                'BID' => 'Bachelor in Industrial Design',
            ],

            // LEGAZPI EAST CAMPUS: College of Engineering
            'CENG' => [
                'BSME' => 'Bachelor of Science in Mechanical Engineering',
                'BSCHE' => 'Bachelor of Science in Chemical Engineering',
                'BSCE' => 'Bachelor of Science in Civil Engineering',
                'BSEE' => 'Bachelor of Science in Electrical Engineering',
                'BSMINE' => 'Bachelor of Science in Mining Engineering',
                'BSGE' => 'Bachelor of Science in Geodetic Engineering',
            ],

            // LEGAZPI WEST CAMPUS: College of Education
            'CED' => [
                'DED-ELM' => 'Doctor of Education in Educational Leadership and Management',
                'PHD-EF' => 'Doctor of Philosophy in Educational Foundations',
                'PHD-ME' => 'Doctor of Philosophy in Mathematics Education',
                'MAED-READ' => 'Master of Arts in Reading Education',
                'MAED-FIL' => 'Master of Arts in Filipino Education',
                'MAED-ENG' => 'Master of Arts in English Education',
                'MAED-MUS' => 'Master of Arts in Music Education',
                'MAED-MATH' => 'Master of Arts in Mathematics Education',
                'MAED-SOC' => 'Master of Arts in Social Studies Education',
                'MAED-PHYS' => 'Master of Arts in Physics Education',
                'MAED-CHEM' => 'Master of Arts in Chemistry Education',
                'MAED-BIO' => 'Master of Arts in Biology Education',
                'MAED-SCI' => 'Master of Arts in Science Education',
                'MAED-GC' => 'Master of Arts in Guidance and Counseling',
                'MAED-ELM' => 'Master of Arts in Educational Leadership and Management',
                'MAED-ECE' => 'Master of Arts in Early Childhood Education',
                'MAED-CAE' => 'Master of Arts in Culture and Arts Education',
                'BSED' => 'Bachelor of Secondary Education',
                'BEED' => 'Bachelor of Elementary Education',
                'BCAED' => 'Bachelor of Culture and Arts Education',
                'BECED' => 'Bachelor of Early Childhood Education',
            ],

            // LEGAZPI WEST CAMPUS: College of Arts and Letters
            'CAL' => [
                'PHD-FIL' => 'Doctor of Philosophy in Filipino',
                'MA-LIT' => 'Master of Arts in Literature',
                'MA-FIL' => 'Master in Filipino',
                'ABJOURN' => 'Bachelor of Arts in Journalism',
                'BPA' => 'Bachelor of Performing Arts',
                'ABEL' => 'Bachelor of Arts in English Language',
                'ABBROAD' => 'Bachelor of Arts in Broadcasting',
                'ABCOMM' => 'Bachelor of Arts in Communication',
                'ABLIT' => 'Bachelor of Arts in Literature',
            ],

            // LEGAZPI WEST CAMPUS: Institute of Physical Education, Sports and Recreation
            'IPESR' => [
                'MAPEH' => 'Master of Arts in Physical Education',
                'BPE' => 'Bachelor of Physical Education',
                'BSESS' => 'Bachelor of Science in Exercise and Sports Sciences',
            ],

            // LEGAZPI WEST CAMPUS: College of Nursing
            'CN' => [
                'MAN' => 'Master of Arts in Nursing',
                'MNE' => 'Master in Nursing Education',
                'BSN' => 'Bachelor of Science in Nursing',
            ],

            // LEGAZPI WEST CAMPUS: College of Science
            'CS' => [
                'MSBIO' => 'Master of Science in Biology',
                'MIS' => 'Master in Information Systems',
                'BSBIO' => 'Bachelor of Science in Biology',
                'BSCS' => 'Bachelor of Science in Computer Science',
                'BSCHEM' => 'Bachelor of Science in Chemistry',
                'BSIT' => 'Bachelor of Science in Information Technology',
                'BSMET' => 'Bachelor of Science in Meteorology',
            ],

            // LEGAZPI WEST CAMPUS: Jesse M. Robredo Institute of Governance and Development
            'JMRIGD' => [
                'PHD-PA' => 'Doctor of Philosophy in Public Administration',
                'PHD-DM' => 'Doctor of Philosophy in Development Management',
                'BPA-GOV' => 'Bachelor of Public Administration',
                'MPA' => 'Master of Public Administration',
                'MPA-HE' => 'Master in Public Administration major in Health Emergency and Disaster Management',
                'MPA-PP' => 'Master in Public Administration major in Public Procurement',
                'MLGM' => 'Master in Local Government Management',
            ],

            // LEGAZPI WEST CAMPUS: College of Medicine
            'CM' => [
                'MD' => 'Doctor of Medicine',
            ],

            // LEGAZPI WEST CAMPUS: College of Dental Medicine
            'CDM' => [
                'DMD' => 'Doctor of Dental Medicine',
            ],

            // DARAGA CAMPUS: College of Business, Economics and Management
            'CBEM' => [
                'MM' => 'Master in Management',
                'MM-HRM' => 'Master in Management major in Human Resource Management',
                'MSECON' => 'Master in Economics',
                'MCM' => 'Master in Cooperative Management',
                'MSENT' => 'Master in Entrepreneurship',
                'BSBA' => 'Bachelor of Science in Business Administration',
                'BSA' => 'Bachelor of Science in Accountancy',
                'BSECON' => 'Bachelor of Science in Economics',
                'BSENT' => 'Bachelor of Science in Entrepreneurship',
            ],

            // DARAGA CAMPUS: College of Social Sciences, and Philosophy
            'CSSP' => [
                'PHD-PSA' => 'Doctor of Philosophy in Peace and Security Administration',
                'MAPSS' => 'Master of Arts in Peace and Security Studies',
                'ABPHIL' => 'Bachelor of Arts in Philosophy',
                'ABPS' => 'Bachelor of Arts in Peace Studies',
                'ABPOLSCI' => 'Bachelor of Arts in Political Science',
                'BSSW' => 'Bachelor of Science in Social Work',
                'ABSOC' => 'Bachelor of Arts in Sociology',
                'BSPSYCH' => 'Bachelor of Science in Psychology',
            ],

            // SATELLITE CAMPUS: BU GUINOBATAN
            'BUG' => [
                'BUG-MSAGRI' => 'Master of Science in Agriculture',
                'BUG-MRD' => 'Master in Rural Development',
                'BUG-MSBEM' => 'Master of Science in Biodiversity & Environmental Management',
                'BUG-MSSFS' => 'Master of Science in Sustainable Food Systems',
                'BUG-BSF' => 'Bachelor of Science in Forestry',
                'BUG-BSABE' => 'Bachelor of Science in Agricultural and Biosystems Engineering',
                'BUG-BSAGRI' => 'Bachelor of Science in Agriculture',
                'BUG-BSAGRIBUS' => 'Bachelor of Science in Agribusiness',
                'BUG-BAT' => 'Bachelor in Agricultural Technology',
                'BUG-BTVTED' => 'Bachelor of Technical-Vocational Teacher Education',
                'BUG-DVM' => 'Doctor of Veterinary Medicine',
                'BUG-BSFT' => 'Bachelor of Science in Food Technology',
                'BUG-BSDEVCOMM' => 'Bachelor of Science in Development Communication',
            ],

            // SATELLITE CAMPUS: BU POLANGUI
            'BUP' => [
                'BUP-BSET' => 'Bachelor of Science in Electronics Technology',
                'BUP-BSCS' => 'Bachelor of Science in Computer Science',
                'BUP-BSED' => 'Bachelor of Secondary Education',
                'BUP-BSAT' => 'Bachelor of Science in Automotive Technology',
                'BUP-BSCOE' => 'Bachelor of Science in Computer Engineering',
                'BUP-BSECE' => 'Bachelor of Science in Electronics Engineering',
                'BUP-BSIS' => 'Bachelor of Science in Information System',
                'BUP-BSENT' => 'Bachelor of Science in Entrepreneurship',
                'BUP-BSN' => 'Bachelor of Science in Nursing',
                'BUP-BEED' => 'Bachelor of Elementary Education',
                'BUP-BSIT' => 'Bachelor of Science in Information Technology',
                'BUP-BSELT' => 'Bachelor of Science in Electrical Technology',
                'BUP-BSMT' => 'Bachelor of Science in Mechanical Technology',
                'BUP-BSIT-ANI' => 'Bachelor of Science in Information Technology major in Animation',
                'BUP-BTLE' => 'Bachelor of Technology and Livelihood Education',
            ],

            // SATELLITE CAMPUS: BU TABACO
            'BUTC' => [
                'BUTC-MSFISH' => 'Master of Science in Fisheries',
                'BUTC-MSFT' => 'Master of Science in Fisheries Technology',
                'BUTC-BSFISH' => 'Bachelor of Science in Fisheries',
                'BUTC-BSED' => 'Bachelor of Secondary Education',
                'BUTC-BSENT' => 'Bachelor of Science in Entrepreneurship',
                'BUTC-BSN' => 'Bachelor of Science in Nursing',
                'BUTC-BSSW' => 'Bachelor of Science in Social Work',
                'BUTC-BSFT' => 'Bachelor of Science in Food Technology',
            ],

            // SATELLITE CAMPUS: BU GUBAT
            'BUGC' => [
                'BUGC-BEED' => 'Bachelor of Elementary Education',
                'BUGC-BSED' => 'Bachelor of Secondary Education',
                'BUGC-BSENT' => 'Bachelor of Science in Entrepreneurship',
                'BUGC-BSBA' => 'Bachelor of Science in Business Administration major in Microfinance',
                'BUGC-BAT' => 'Bachelor in Agricultural Technology (Ladderized)',
            ],
        ];

        // Gather all valid program codes
        $validProgramCodes = [];
        foreach ($programsData as $collegePrograms) {
            foreach (array_keys($collegePrograms) as $code) {
                $validProgramCodes[] = $code;
            }
        }

        // Force delete any obsolete program records not in the official list
        Program::whereNotIn('code', $validProgramCodes)->forceDelete();

        foreach ($programsData as $collegeCode => $collegePrograms) {
            $college = $colleges->get($collegeCode);
            if (! $college) {
                continue;
            }

            foreach ($collegePrograms as $code => $name) {
                Program::updateOrCreate(
                    ['code' => $code],
                    [
                        'college_id' => $college->id,
                        'name' => $name,
                        'accreditation_level' => 'Candidate Status',
                    ]
                );
            }
        }

        // Ensure all existing programs have Candidate Status
        Program::query()->update(['accreditation_level' => 'Candidate Status']);
    }
}
