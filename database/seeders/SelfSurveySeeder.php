<?php

namespace Database\Seeders;

use App\Models\SelfSurveyArea;
use App\Models\SelfSurveyIndicator;
use App\Models\SelfSurveyParameter;
use Illuminate\Database\Seeder;

class SelfSurveySeeder extends Seeder
{
    /**
     * Seeds the standard AACCUP Institutional Self-Survey areas, parameters, and indicators.
     */
    public function run(): void
    {
        $areasData = [
            [
                'code' => 'area_i1',
                'label' => 'Area I',
                'title' => 'Governance and Management',
                'sort_order' => 1,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'GOVERNANCE – ORGANIZATIONAL STRUCTURE',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'The governance of the institution is clearly defined in the organizational structure.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'The powers, functions/duties and responsibilities of key officials are clearly delineated.', 'sort_order' => 2],
                            ['section' => 'system', 'code' => 'S.3', 'statement' => 'Administrative and academic councils/bodies exist to assist in decision-making as defined in the organizational structure.', 'sort_order' => 3],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => "The policy-making body demonstrates strong leadership and supports the institution's programs and operations.", 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'The key officials follow the functional relationship structure in decision-making.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.3', 'statement' => 'The organizational structure is used in defining the lines of communication and coordination.', 'sort_order' => 3],
                            ['section' => 'implementation', 'code' => 'I.4', 'statement' => 'The Administrative and Academic Councils function effectively.', 'sort_order' => 4],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Functions of various units and implementation of programs and projects are well-coordinated.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'Conflict in administrative jurisdictions and official relationships are minimal.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.3', 'statement' => 'Stakeholders feel satisfied in the management of the institution.', 'sort_order' => 3],
                            ['section' => 'outcome', 'code' => 'O.4', 'statement' => 'Stronger cooperation and coordination among individuals and units are observable.', 'sort_order' => 4],
                            ['section' => 'outcome', 'code' => 'O.5', 'statement' => 'The governing body demonstrates integrity and objectivity in all transactions in the pursuit of the mission of the institution.', 'sort_order' => 5],
                            ['section' => 'outcome', 'code' => 'O.6', 'statement' => "Various stakeholders express satisfaction with openness and transparency in the dissemination of the Governing Body's decisions.", 'sort_order' => 6],
                        ],
                    ],
                    [
                        'code' => 'B',
                        'title' => 'PROBITY',
                        'sort_order' => 2,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'Guidelines and protocols are in place.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'Major policies and decisions are available.', 'sort_order' => 2],
                            ['section' => 'system', 'code' => 'S.3', 'statement' => 'Policies and decisions are in accordance with existing laws, rules and regulations.', 'sort_order' => 3],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Key officials exercise sound judgment and prudent decision-making.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Officials are accountable and transparent in all transactions.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'The institution demonstrates integrity and probity in governance.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => "Stakeholders express confidence in the institution's leadership.", 'sort_order' => 2],
                        ],
                    ],
                    [
                        'code' => 'C',
                        'title' => 'PLANNING',
                        'sort_order' => 3,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'A system of planning exists and is operational.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'All units participate in the planning process.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'The institutional plan is implemented, monitored, and evaluated.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Resources are allocated according to the institutional plan.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Goals and targets in the institutional plan are achieved.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'The institution is responsive to changes in its external environment.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i2',
                'label' => 'Area II',
                'title' => 'Administration',
                'sort_order' => 2,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'ADMINISTRATIVE STAFFING AND PERSONNEL MANAGEMENT',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'Administrative offices are staffed with qualified personnel meeting civil service requirements.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'A merit-based promotion and appointment system exists.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Personnel policies are implemented fairly and consistently.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Staff development programs are regularly conducted.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Administrative offices operate efficiently and effectively.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'Staff demonstrate competence and professionalism.', 'sort_order' => 2],
                        ],
                    ],
                    [
                        'code' => 'B',
                        'title' => 'FISCAL MANAGEMENT',
                        'sort_order' => 2,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'A budgeting system is established and operational.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'Financial reports are regularly prepared and disseminated.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Budget allocations are in accordance with institutional priorities.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Financial transactions are properly documented and audited.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'The institution demonstrates sound fiscal management.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'Resources are utilized efficiently and judiciously.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i3',
                'label' => 'Area III',
                'title' => 'Curriculum and Instruction',
                'sort_order' => 3,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'CURRICULUM DEVELOPMENT AND IMPLEMENTATION',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'The institution has clearly defined instructional objectives aligned with its VMGO.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'Curricula are regularly reviewed and updated in consultation with stakeholders.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Faculty implement the approved curriculum effectively.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Innovative pedagogical approaches are employed in instruction.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Graduates demonstrate competencies expected by industry and society.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'Board examination passing rates meet or exceed national averages.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i4',
                'label' => 'Area IV',
                'title' => 'Support to Students',
                'sort_order' => 4,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'STUDENT SERVICES AND WELFARE',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'A comprehensive student handbook is published and disseminated annually.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'Guidance and counseling services are available to all students.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Student organizations are active and duly recognized.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Scholarship and financial assistance programs are operational.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Students feel adequately supported in their academic journey.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'Retention and graduation rates are satisfactory.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i5',
                'label' => 'Area V',
                'title' => 'Research',
                'sort_order' => 5,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'RESEARCH AGENDA AND PRODUCTION',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'Research priorities are aligned with regional and national development goals.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'A research agenda is formulated and approved.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Faculty engage in research activities aligned with the university research agenda.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Research outputs are published in reputable journals.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Research outputs contribute to knowledge and community development.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'The institution receives research recognition and awards.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i6',
                'label' => 'Area VI',
                'title' => 'Extension and Community Involvement',
                'sort_order' => 6,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'EXTENSION PROGRAMS AND SERVICES',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'Community extension programs are designed based on community needs assessment.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'Extension activities are aligned with the institutional VMGO.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Faculty and students actively participate in extension activities.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Community partners are engaged in co-implementing programs.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Extension programs create measurable positive impact on communities.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'The institution is recognized as a partner in community development.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i7',
                'label' => 'Area VII',
                'title' => 'Library',
                'sort_order' => 7,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'LIBRARY HOLDINGS AND RESOURCES',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'Adequate physical and digital academic reference holdings are available for university programs.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'The library has a system for acquisition, cataloging, and circulation.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Library resources are regularly updated and maintained.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Electronic databases and e-resources are accessible to students and faculty.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Students and faculty make effective use of library resources.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'Library holdings meet accreditation standards.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i8',
                'label' => 'Area VIII',
                'title' => 'Physical Plant and Facilities',
                'sort_order' => 8,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'BUILDINGS AND CAMPUS FACILITIES',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'University buildings comply with environmental, safety, and fire protection codes.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'Facilities are adequate, well-maintained, and safe for use.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Regular inspection and maintenance of facilities are conducted.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Facility improvement plans are implemented systematically.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'The campus environment is conducive to learning and working.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'All buildings and facilities meet safety standards.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
            [
                'code' => 'area_i9',
                'label' => 'Area IX',
                'title' => 'Laboratories',
                'sort_order' => 9,
                'parameters' => [
                    [
                        'code' => 'A',
                        'title' => 'LABORATORY FACILITIES AND EQUIPMENT',
                        'sort_order' => 1,
                        'indicators' => [
                            ['section' => 'system', 'code' => 'S.1', 'statement' => 'Specialized laboratory rooms are fully equipped with working research apparatuses.', 'sort_order' => 1],
                            ['section' => 'system', 'code' => 'S.2', 'statement' => 'Safety protocols and equipment are in place in all laboratories.', 'sort_order' => 2],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Laboratory equipment is regularly calibrated and maintained.', 'sort_order' => 1],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Students follow laboratory safety rules and procedures.', 'sort_order' => 2],
                            ['section' => 'outcome', 'code' => 'O.1', 'statement' => 'Laboratory facilities support quality research and learning.', 'sort_order' => 1],
                            ['section' => 'outcome', 'code' => 'O.2', 'statement' => 'Students demonstrate practical competencies through laboratory work.', 'sort_order' => 2],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($areasData as $aData) {
            $area = SelfSurveyArea::updateOrCreate(
                ['code' => $aData['code']],
                [
                    'label' => $aData['label'],
                    'title' => $aData['title'],
                    'type' => 'institutional',
                    'sort_order' => $aData['sort_order'],
                ]
            );

            foreach ($aData['parameters'] as $pData) {
                $param = SelfSurveyParameter::updateOrCreate(
                    [
                        'area_id' => $area->id,
                        'code' => $pData['code'],
                    ],
                    [
                        'title' => $pData['title'],
                        'sort_order' => $pData['sort_order'],
                    ]
                );

                foreach ($pData['indicators'] as $iData) {
                    SelfSurveyIndicator::updateOrCreate(
                        [
                            'parameter_id' => $param->id,
                            'code' => $iData['code'],
                            'section' => $iData['section'],
                        ],
                        [
                            'statement' => $iData['statement'],
                            'sort_order' => $iData['sort_order'],
                        ]
                    );
                }
            }
        }
    }
}
