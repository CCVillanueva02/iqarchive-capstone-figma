<?php

/**
 * ============================================================================
 * IQArchive v2 — AACCUP Master Instrument Seeder
 * ============================================================================
 * File: database/seeders/AaccupMasterInstrumentSeeder.php
 * Responsibility: Seeds the official 10-Area AACCUP Survey Instrument hierarchy.
 * Schema Alignment: Zone 2 (instruments -> instrument_areas -> instrument_parameters -> instrument_criteria)
 * ============================================================================
 */

namespace Database\Seeders;

use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentCriterion;
use App\Models\InstrumentParameter;
use Illuminate\Database\Seeder;

class AaccupMasterInstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrument = Instrument::updateOrCreate(
            ['code' => 'INST-AACCUP-UG'],
            [
                'name' => 'AACCUP Undergraduate Master Survey Instrument',
                'type' => 'ug',
                'version' => '2026.1',
                'is_active' => true,
            ]
        );

        $areasData = [
            [
                'area_number' => 1,
                'name' => 'Vision, Mission, Goals, and Objectives',
                'description' => 'Statement, clarity, alignment, and dissemination of institutional VMGO.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Statement of VMGO',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The institution has a system of determining its Vision and Mission.', 'type' => 'system'],
                            ['code' => 'S.2', 'title' => 'The Vision clearly reflects what the Institution hopes to become in the future.', 'type' => 'system'],
                            ['code' => 'S.3', 'title' => 'The Mission clearly reflects the Institution’s legal and other statutory mandates.', 'type' => 'system'],
                            ['code' => 'S.4', 'title' => 'The Goals of the academic unit/department are clearly stated and are consistent with the Mission.', 'type' => 'system'],
                            ['code' => 'S.5', 'title' => 'The Objectives have the expected outcomes in terms of student competencies, values, and attributes.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'The Institution/Academic Unit conducts a periodic review on the statement of Vision and Mission.', 'type' => 'impl'],
                            ['code' => 'I.2', 'title' => 'Faculty, staff, students, and external stakeholders participate in the formulation and review of VMGO.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'The VMGO are crafted and duly approved by the Board of Regents/Trustees.', 'type' => 'outcome'],
                            ['code' => 'BP.1', 'title' => 'Interactive digital portals and broadcast media continuously publish VMGO statements.', 'type' => 'best_practice'],
                        ],
                    ],
                    [
                        'letter' => 'B',
                        'name' => 'Dissemination and Acceptability',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The VMGO are available on bulletin boards, in catalogs/manuals, and in other communication media.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'A structured system of dissemination and acceptability of the VMGO is enforced across all campuses.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'Stakeholders demonstrate high awareness and understanding of the VMGO based on survey evaluations.', 'type' => 'outcome'],
                        ],
                    ],
                    [
                        'letter' => 'C',
                        'name' => 'Relationship of the Goals and Objectives to the Vision and Mission',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The institutional plan is aligned with the vision, mission, and national development goals.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'The institutional plan is implemented, monitored, and evaluated.', 'type' => 'impl'],
                            ['code' => 'I.2', 'title' => 'Resources are allocated according to the institutional plan.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'Goals and targets in the institutional plan are achieved.', 'type' => 'outcome'],
                            ['code' => 'O.2', 'title' => 'The institution is responsive to changes in its external environment.', 'type' => 'outcome'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 2,
                'name' => 'Faculty',
                'description' => 'Faculty qualifications, recruitment, professional development, and performance.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Academic Qualifications',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'Faculty members teaching in the program possess vertically articulated masteral and doctoral degrees.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'PRC professional licenses and board certifications are actively maintained by faculty members.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'At least 75% of full-time faculty hold relevant post-graduate degrees.', 'type' => 'outcome'],
                        ],
                    ],
                    [
                        'letter' => 'B',
                        'name' => 'Recruitment, Selection, and Orientation',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'A merit selection plan and transparent hiring guidelines govern faculty recruitment.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Newly appointed faculty undergo comprehensive institutional orientation and mentoring.', 'type' => 'impl'],
                        ],
                    ],
                    [
                        'letter' => 'C',
                        'name' => 'Faculty Development',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The institution provides funding and study leaves for continuous faculty development.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Faculty actively participate in national and international conferences and research colloquia.', 'type' => 'impl'],
                            ['code' => 'BP.1', 'title' => 'Institutional incentives and deloading are awarded for peer-reviewed publications.', 'type' => 'best_practice'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 3,
                'name' => 'Curriculum and Instruction',
                'description' => 'Curriculum development, CMO compliance, OBE syllabi, and educational technology.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Curriculum Design & CMO Compliance',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The program curriculum adheres strictly to latest CHED Policies, Standards, and Guidelines (CMO).', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'OBE syllabus is prepared and distributed for every course with mapped student learning outcomes.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'Program graduates demonstrate high passing rates in professional licensure examinations.', 'type' => 'outcome'],
                        ],
                    ],
                    [
                        'letter' => 'B',
                        'name' => 'Instructional Materials & Educational Technology',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'Faculty-authored instructional modules and courseware undergo formal review and copyrighting.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Learning management systems (LMS) and multimedia resources are actively integrated into courses.', 'type' => 'impl'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 4,
                'name' => 'Support to Students',
                'description' => 'Student services, admissions, guidance counseling, career placement, and student bodies.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Student Services Program',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The institution has an active and comprehensive student counseling, guidance, and placement center.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Career counseling, job placement fairs, and alumni tracer tracking are systematically provided.', 'type' => 'impl'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 5,
                'name' => 'Research',
                'description' => 'Institutional research agenda, faculty publications, student theses, and ethics compliance.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Research Agenda and Outputs',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The program operates under an updated research agenda aligned with institutional priorities.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Faculty and students publish researches in indexed journals and present at conferences.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'Research outputs produce commercialized technologies, patents, utility models, or policy briefs.', 'type' => 'outcome'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 6,
                'name' => 'Extension and Community Involvement',
                'description' => 'Community outreach, technology transfer, MOA with partner communities, and impact.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Extension Projects and Linkages',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'Extension agenda addresses direct needs of adopted communities and industry sectors.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Partnership agreements (MOA/MOU) are active with local government units and partner organizations.', 'type' => 'impl'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 7,
                'name' => 'Library',
                'description' => 'Library book holdings, digital databases, reading environments, and automated OPAC.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Collection and Digital Resources',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'Core titles, professional references, and peer-reviewed journals meet CHED standard volumes.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Integrated library management systems (OPAC/Koha) support patron search and digital access.', 'type' => 'impl'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 8,
                'name' => 'Physical Plant and Facilities',
                'description' => 'Classrooms, accessibility, disaster readiness, ventilation, and safety certificates.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Campus Infrastructure & Safety',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'Adequate, well-ventilated, and digitally equipped classrooms are available for all classes.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Fire safety certificates, earthquake drills, and PWD ramps comply with national building codes.', 'type' => 'impl'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 9,
                'name' => 'Laboratories',
                'description' => 'Laboratory apparatus, software licenses, maintenance logs, and safety protocols.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Laboratory Facilities and Equipment',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'Laboratory apparatus, workstations, and software licenses satisfy class size requirements.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Safety guidelines, emergency eye-wash, first aid kits, and waste disposal are maintained.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'Laboratory experiments produce hands-on competency and verified student project deliverables.', 'type' => 'outcome'],
                        ],
                    ],
                ],
            ],
            [
                'area_number' => 10,
                'name' => 'Administration',
                'description' => 'Organizational leadership, financial stewardship, records management, and QA governance.',
                'parameters' => [
                    [
                        'letter' => 'A',
                        'name' => 'Organizational Structure and QA Governance',
                        'criteria' => [
                            ['code' => 'S.1', 'title' => 'The organizational chart clearly outlines operational authority, responsibilities, and accountability.', 'type' => 'system'],
                            ['code' => 'I.1', 'title' => 'Internal Quality Assurance (IQA) audits and management reviews are conducted regularly.', 'type' => 'impl'],
                            ['code' => 'O.1', 'title' => 'Budget allocation supports program sustainability and physical development targets.', 'type' => 'outcome'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($areasData as $areaItem) {
            $area = InstrumentArea::updateOrCreate(
                [
                    'instrument_id' => $instrument->id,
                    'area_number' => $areaItem['area_number'],
                ],
                [
                    'name' => $areaItem['name'],
                    'description' => $areaItem['description'],
                ]
            );

            foreach ($areaItem['parameters'] as $paramItem) {
                $parameter = InstrumentParameter::updateOrCreate(
                    [
                        'instrument_area_id' => $area->id,
                        'parameter_letter' => $paramItem['letter'],
                    ],
                    [
                        'name' => $paramItem['name'],
                        'description' => "Parameter {$paramItem['letter']} - {$paramItem['name']}",
                    ]
                );

                foreach ($paramItem['criteria'] as $critItem) {
                    InstrumentCriterion::updateOrCreate(
                        [
                            'instrument_parameter_id' => $parameter->id,
                            'benchmark_code' => $critItem['code'],
                        ],
                        [
                            'title' => $critItem['title'],
                            'type' => $critItem['type'],
                        ]
                    );
                }
            }
        }
    }
}
