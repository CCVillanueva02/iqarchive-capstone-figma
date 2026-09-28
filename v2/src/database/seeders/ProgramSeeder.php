<?php

/**
 * ============================================================================
 * IQArchive v2 — Program Seeder
 * ============================================================================
 * File: database/seeders/ProgramSeeder.php
 * Responsibility: Seeds official Bicol University degree programs mapped to colleges.
 * Schema Alignment: Zone 1 (programs table: college_id, code, name, current_level)
 * ============================================================================
 */

namespace Database\Seeders;

use App\Models\College;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds for Bicol University Degree Programs.
     */
    public function run(): void
    {
        $colleges = College::all()->keyBy('code');

        $programsData = [
            // LEGAZPI EAST CAMPUS: Institute of Design and Architecture
            'IDA' => [
                'MSARCH' => ['name' => 'Master of Science in Architecture', 'level' => 'Candidate Status'],
                'BSARCH' => ['name' => 'Bachelor of Science in Architecture', 'level' => 'Level 1'],
            ],

            // LEGAZPI EAST CAMPUS: College of Industrial Technology
            'CIT' => [
                'MAIE' => ['name' => 'Master of Arts in Industrial Education', 'level' => 'Level 2'],
                'BSFT' => ['name' => 'Bachelor of Science in Food Technology', 'level' => 'Level 1'],
                'BTVTED' => ['name' => 'Bachelor of Technical Vocational Teacher Education', 'level' => 'Candidate Status'],
                'BSAT' => ['name' => 'Bachelor of Science in Automotive Technology', 'level' => 'Level 2'],
                'BSET' => ['name' => 'Bachelor of Science in Electronics Technology', 'level' => 'Level 3'],
                'BSMT' => ['name' => 'Bachelor of Science in Mechanical Technology', 'level' => 'Level 2'],
                'BSCT' => ['name' => 'Bachelor of Science in Civil Technology', 'level' => 'Level 1'],
                'BSELT' => ['name' => 'Bachelor of Science in Electrical Technology', 'level' => 'Level 2'],
                'BID' => ['name' => 'Bachelor in Industrial Design', 'level' => 'Candidate Status'],
            ],

            // LEGAZPI EAST CAMPUS: College of Engineering
            'CENG' => [
                'BSME' => ['name' => 'Bachelor of Science in Mechanical Engineering', 'level' => 'Level 3'],
                'BSCHE' => ['name' => 'Bachelor of Science in Chemical Engineering', 'level' => 'Level 2'],
                'BSCE' => ['name' => 'Bachelor of Science in Civil Engineering', 'level' => 'Level 4'],
                'BSEE' => ['name' => 'Bachelor of Science in Electrical Engineering', 'level' => 'Level 3'],
                'BSMINE' => ['name' => 'Bachelor of Science in Mining Engineering', 'level' => 'Level 1'],
                'BSGE' => ['name' => 'Bachelor of Science in Geodetic Engineering', 'level' => 'Candidate Status'],
            ],

            // LEGAZPI WEST CAMPUS: College of Education
            'CED' => [
                'DED-ELM' => ['name' => 'Doctor of Education in Educational Leadership and Management', 'level' => 'Level 4'],
                'PHD-EF' => ['name' => 'Doctor of Philosophy in Educational Foundations', 'level' => 'Level 3'],
                'PHD-ME' => ['name' => 'Doctor of Philosophy in Mathematics Education', 'level' => 'Level 3'],
                'MAED-READ' => ['name' => 'Master of Arts in Reading Education', 'level' => 'Level 2'],
                'MAED-FIL' => ['name' => 'Master of Arts in Filipino Education', 'level' => 'Level 2'],
                'MAED-ENG' => ['name' => 'Master of Arts in English Education', 'level' => 'Level 3'],
                'MAED-MUS' => ['name' => 'Master of Arts in Music Education', 'level' => 'Candidate Status'],
                'MAED-MATH' => ['name' => 'Master of Arts in Mathematics Education', 'level' => 'Level 2'],
                'MAED-SOC' => ['name' => 'Master of Arts in Social Studies Education', 'level' => 'Level 2'],
                'MAED-PHYS' => ['name' => 'Master of Arts in Physics Education', 'level' => 'Level 1'],
                'MAED-CHEM' => ['name' => 'Master of Arts in Chemistry Education', 'level' => 'Level 1'],
                'MAED-BIO' => ['name' => 'Master of Arts in Biology Education', 'level' => 'Level 2'],
                'MAED-SCI' => ['name' => 'Master of Arts in Science Education', 'level' => 'Level 1'],
                'MAED-GC' => ['name' => 'Master of Arts in Guidance and Counseling', 'level' => 'Level 2'],
                'MAED-ELM' => ['name' => 'Master of Arts in Educational Leadership and Management', 'level' => 'Level 3'],
                'MAED-ECE' => ['name' => 'Master of Arts in Early Childhood Education', 'level' => 'Candidate Status'],
                'MAED-CAE' => ['name' => 'Master of Arts in Culture and Arts Education', 'level' => 'Candidate Status'],
                'BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Level 4'],
                'BEED' => ['name' => 'Bachelor of Elementary Education', 'level' => 'Level 4'],
                'BCAED' => ['name' => 'Bachelor of Culture and Arts Education', 'level' => 'Level 1'],
                'BECED' => ['name' => 'Bachelor of Early Childhood Education', 'level' => 'Level 1'],
            ],

            // LEGAZPI WEST CAMPUS: College of Arts and Letters
            'CAL' => [
                'PHD-FIL' => ['name' => 'Doctor of Philosophy in Filipino', 'level' => 'Level 2'],
                'MA-LIT' => ['name' => 'Master of Arts in Literature', 'level' => 'Level 2'],
                'MA-FIL' => ['name' => 'Master in Filipino', 'level' => 'Level 2'],
                'ABJOURN' => ['name' => 'Bachelor of Arts in Journalism', 'level' => 'Level 3'],
                'BPA' => ['name' => 'Bachelor of Performing Arts', 'level' => 'Candidate Status'],
                'ABEL' => ['name' => 'Bachelor of Arts in English Language', 'level' => 'Level 3'],
                'ABBROAD' => ['name' => 'Bachelor of Arts in Broadcasting', 'level' => 'Level 3'],
                'ABCOMM' => ['name' => 'Bachelor of Arts in Communication', 'level' => 'Level 4'],
                'ABLIT' => ['name' => 'Bachelor of Arts in Literature', 'level' => 'Level 2'],
            ],

            // LEGAZPI WEST CAMPUS: Institute of Physical Education, Sports and Recreation
            'IPESR' => [
                'MAPEH' => ['name' => 'Master of Arts in Physical Education', 'level' => 'Level 2'],
                'BPE' => ['name' => 'Bachelor of Physical Education', 'level' => 'Level 1'],
                'BSESS' => ['name' => 'Bachelor of Science in Exercise and Sports Sciences', 'level' => 'Candidate Status'],
            ],

            // LEGAZPI WEST CAMPUS: College of Nursing
            'CN' => [
                'MAN' => ['name' => 'Master of Arts in Nursing', 'level' => 'Level 3'],
                'MNE' => ['name' => 'Master in Nursing Education', 'level' => 'Level 2'],
                'BSN' => ['name' => 'Bachelor of Science in Nursing', 'level' => 'Level 4'],
            ],

            // LEGAZPI WEST CAMPUS: College of Science
            'CS' => [
                'MSBIO' => ['name' => 'Master of Science in Biology', 'level' => 'Level 2'],
                'MIS' => ['name' => 'Master in Information Systems', 'level' => 'Level 1'],
                'BSBIO' => ['name' => 'Bachelor of Science in Biology', 'level' => 'Level 3'],
                'BSCS' => ['name' => 'Bachelor of Science in Computer Science', 'level' => 'Level 3'],
                'BSCHEM' => ['name' => 'Bachelor of Science in Chemistry', 'level' => 'Level 4'],
                'BSIT' => ['name' => 'Bachelor of Science in Information Technology', 'level' => 'Level 3'],
                'BSMET' => ['name' => 'Bachelor of Science in Meteorology', 'level' => 'Candidate Status'],
            ],

            // LEGAZPI WEST CAMPUS: Jesse M. Robredo Institute of Governance and Development
            'JMRIGD' => [
                'PHD-PA' => ['name' => 'Doctor of Philosophy in Public Administration', 'level' => 'Level 3'],
                'PHD-DM' => ['name' => 'Doctor of Philosophy in Development Management', 'level' => 'Level 2'],
                'BPA-GOV' => ['name' => 'Bachelor of Public Administration', 'level' => 'Level 2'],
                'MPA' => ['name' => 'Master of Public Administration', 'level' => 'Level 3'],
                'MPA-HE' => ['name' => 'Master in Public Administration major in Health Emergency and Disaster Management', 'level' => 'Candidate Status'],
                'MPA-PP' => ['name' => 'Master in Public Administration major in Public Procurement', 'level' => 'Candidate Status'],
                'MLGM' => ['name' => 'Master in Local Government Management', 'level' => 'Level 1'],
            ],

            // LEGAZPI WEST CAMPUS: College of Medicine
            'CM' => [
                'MD' => ['name' => 'Doctor of Medicine', 'level' => 'Level 2'],
            ],

            // LEGAZPI WEST CAMPUS: College of Dental Medicine
            'CDM' => [
                'DMD' => ['name' => 'Doctor of Dental Medicine', 'level' => 'Candidate Status'],
            ],

            // DARAGA CAMPUS: College of Business, Economics and Management
            'CBEM' => [
                'MM' => ['name' => 'Master in Management', 'level' => 'Level 3'],
                'MM-HRM' => ['name' => 'Master in Management major in Human Resource Management', 'level' => 'Level 2'],
                'MSECON' => ['name' => 'Master in Economics', 'level' => 'Level 2'],
                'MCM' => ['name' => 'Master in Cooperative Management', 'level' => 'Level 1'],
                'MSENT' => ['name' => 'Master in Entrepreneurship', 'level' => 'Level 1'],
                'BSBA' => ['name' => 'Bachelor of Science in Business Administration', 'level' => 'Level 4'],
                'BSA' => ['name' => 'Bachelor of Science in Accountancy', 'level' => 'Level 4'],
                'BSECON' => ['name' => 'Bachelor of Science in Economics', 'level' => 'Level 3'],
                'BSENT' => ['name' => 'Bachelor of Science in Entrepreneurship', 'level' => 'Level 2'],
            ],

            // DARAGA CAMPUS: College of Social Sciences, and Philosophy
            'CSSP' => [
                'PHD-PSA' => ['name' => 'Doctor of Philosophy in Peace and Security Administration', 'level' => 'Level 2'],
                'MAPSS' => ['name' => 'Master of Arts in Peace and Security Studies', 'level' => 'Level 2'],
                'ABPHIL' => ['name' => 'Bachelor of Arts in Philosophy', 'level' => 'Level 2'],
                'ABPS' => ['name' => 'Bachelor of Arts in Peace Studies', 'level' => 'Level 1'],
                'ABPOLSCI' => ['name' => 'Bachelor of Arts in Political Science', 'level' => 'Level 3'],
                'BSSW' => ['name' => 'Bachelor of Science in Social Work', 'level' => 'Level 3'],
                'ABSOC' => ['name' => 'Bachelor of Arts in Sociology', 'level' => 'Level 2'],
                'BSPSYCH' => ['name' => 'Bachelor of Science in Psychology', 'level' => 'Level 3'],
            ],

            // SATELLITE CAMPUS: BU GUINOBATAN
            'BUG' => [
                'BUG-MSAGRI' => ['name' => 'Master of Science in Agriculture', 'level' => 'Level 2'],
                'BUG-MRD' => ['name' => 'Master in Rural Development', 'level' => 'Level 2'],
                'BUG-MSBEM' => ['name' => 'Master of Science in Biodiversity & Environmental Management', 'level' => 'Level 1'],
                'BUG-MSSFS' => ['name' => 'Master of Science in Sustainable Food Systems', 'level' => 'Candidate Status'],
                'BUG-BSF' => ['name' => 'Bachelor of Science in Forestry', 'level' => 'Level 3'],
                'BUG-BSABE' => ['name' => 'Bachelor of Science in Agricultural and Biosystems Engineering', 'level' => 'Level 2'],
                'BUG-BSAGRI' => ['name' => 'Bachelor of Science in Agriculture', 'level' => 'Level 4'],
                'BUG-BSAGRIBUS' => ['name' => 'Bachelor of Science in Agribusiness', 'level' => 'Level 3'],
                'BUG-BAT' => ['name' => 'Bachelor in Agricultural Technology', 'level' => 'Level 2'],
                'BUG-BTVTED' => ['name' => 'Bachelor of Technical-Vocational Teacher Education', 'level' => 'Candidate Status'],
                'BUG-DVM' => ['name' => 'Doctor of Veterinary Medicine', 'level' => 'Level 1'],
                'BUG-BSFT' => ['name' => 'Bachelor of Science in Food Technology', 'level' => 'Level 1'],
                'BUG-BSDEVCOMM' => ['name' => 'Bachelor of Science in Development Communication', 'level' => 'Candidate Status'],
            ],

            // SATELLITE CAMPUS: BU POLANGUI
            'BUP' => [
                'BUP-BSET' => ['name' => 'Bachelor of Science in Electronics Technology', 'level' => 'Level 2'],
                'BUP-BSCS' => ['name' => 'Bachelor of Science in Computer Science', 'level' => 'Level 3'],
                'BUP-BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Level 3'],
                'BUP-BSAT' => ['name' => 'Bachelor of Science in Automotive Technology', 'level' => 'Level 2'],
                'BUP-BSCOE' => ['name' => 'Bachelor of Science in Computer Engineering', 'level' => 'Level 2'],
                'BUP-BSECE' => ['name' => 'Bachelor of Science in Electronics Engineering', 'level' => 'Level 2'],
                'BUP-BSIS' => ['name' => 'Bachelor of Science in Information System', 'level' => 'Level 3'],
                'BUP-BSENT' => ['name' => 'Bachelor of Science in Entrepreneurship', 'level' => 'Level 2'],
                'BUP-BSN' => ['name' => 'Bachelor of Science in Nursing', 'level' => 'Level 3'],
                'BUP-BEED' => ['name' => 'Bachelor of Elementary Education', 'level' => 'Level 3'],
                'BUP-BSIT' => ['name' => 'Bachelor of Science in Information Technology', 'level' => 'Level 3'],
                'BUP-BSELT' => ['name' => 'Bachelor of Science in Electrical Technology', 'level' => 'Level 1'],
                'BUP-BSMT' => ['name' => 'Bachelor of Science in Mechanical Technology', 'level' => 'Level 1'],
                'BUP-BSIT-ANI' => ['name' => 'Bachelor of Science in Information Technology major in Animation', 'level' => 'Candidate Status'],
                'BUP-BTLE' => ['name' => 'Bachelor of Technology and Livelihood Education', 'level' => 'Candidate Status'],
            ],

            // SATELLITE CAMPUS: BU TABACO
            'BUTC' => [
                'BUTC-MSFISH' => ['name' => 'Master of Science in Fisheries', 'level' => 'Level 2'],
                'BUTC-MSFT' => ['name' => 'Master of Science in Fisheries Technology', 'level' => 'Candidate Status'],
                'BUTC-BSFISH' => ['name' => 'Bachelor of Science in Fisheries', 'level' => 'Level 3'],
                'BUTC-BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Level 3'],
                'BUTC-BSENT' => ['name' => 'Bachelor of Science in Entrepreneurship', 'level' => 'Level 2'],
                'BUTC-BSN' => ['name' => 'Bachelor of Science in Nursing', 'level' => 'Level 2'],
                'BUTC-BSSW' => ['name' => 'Bachelor of Science in Social Work', 'level' => 'Level 2'],
                'BUTC-BSFT' => ['name' => 'Bachelor of Science in Food Technology', 'level' => 'Level 1'],
            ],

            // SATELLITE CAMPUS: BU GUBAT
            'BUGC' => [
                'BUGC-BEED' => ['name' => 'Bachelor of Elementary Education', 'level' => 'Level 3'],
                'BUGC-BSED' => ['name' => 'Bachelor of Secondary Education', 'level' => 'Level 2'],
                'BUGC-BSENT' => ['name' => 'Bachelor of Science in Entrepreneurship', 'level' => 'Level 1'],
                'BUGC-BSBA' => ['name' => 'Bachelor of Science in Business Administration major in Microfinance', 'level' => 'Candidate Status'],
                'BUGC-BAT' => ['name' => 'Bachelor in Agricultural Technology ', 'level' => 'Candidate Status'],
            ],
        ];

        foreach ($programsData as $collegeCode => $collegePrograms) {
            $college = $colleges->get($collegeCode);
            if (! $college) {
                continue;
            }

            foreach ($collegePrograms as $code => $data) {
                Program::updateOrCreate(
                    ['code' => $code],
                    [
                        'college_id' => $college->id,
                        'name' => $data['name'],
                        'current_level' => $data['level'],
                    ]
                );
            }
        }
    }
}
