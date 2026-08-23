<?php

namespace Database\Seeders;

use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentParameter;
use App\Models\InstrumentCriterion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AaccupMasterInstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templateCodes = [
            'INST-PROG-SUPPORTING-DOCS',
            'INST-PROG-SELF-SURVEY',
            'INST-PROG-COMPLIANCE-REPORT',
            'INST-INST-SUPPORTING-DOCS',
            'INST-INST-SELF-SURVEY',
            'INST-INST-COMPLIANCE-REPORT',
        ];

        // Clean up older dummy mock instruments from earlier development seeders
        Instrument::where('is_template', true)
            ->whereNotIn('code', $templateCodes)
            ->delete();

        // ─────────────────────────────────────────────────────────────
        // 1. PROGRAM ACCREDITATION: 10 AREAS MASTER DATA
        // ─────────────────────────────────────────────────────────────
        $programAreasData = [
            [
                'code' => 'Area I',
                'name' => 'Vision, Mission, Goals, and Objectives',
                'order' => 1,
                'weight' => 5.00,
                'description' => 'Statement, clarity, alignment, and dissemination of institutional VMGO.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Statement of VMGO',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The institution has a system of determining its Vision and Mission.', 'tags' => ['#UniversityManual', '#BoardResolution']],
                            ['section' => 'systems', 'code' => 'S.2', 'statement' => 'The Vision clearly reflects what the Institution hopes to become in the future.', 'tags' => ['#VisionStatementAnalysis']],
                            ['section' => 'systems', 'code' => 'S.3', 'statement' => 'The Mission clearly reflects the Institution’s legal and other statutory mandates.', 'tags' => ['#SUC_Charter_RA5521']],
                            ['section' => 'systems', 'code' => 'S.4', 'statement' => 'The Goals of the academic unit/department are clearly stated and are consistent with the Mission of the Institution.', 'tags' => ['#CollegeGoalsAlignmentMatrix']],
                            ['section' => 'systems', 'code' => 'S.5', 'statement' => 'The Objectives have the expected outcomes in terms of student competencies, values, and attributes.', 'tags' => ['#PEO_Matrix', '#GraduateExitSurvey']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'The Institution/Academic Unit conducts a periodic review on the statement of Vision and Mission as well as its goals and program objectives.', 'tags' => ['#CouncilResolution', '#OrientationMinutes']],
                            ['section' => 'implementation', 'code' => 'I.2', 'statement' => 'Faculty, staff, students, and external stakeholders participate in the formulation and review of the VMGO.', 'tags' => ['#StakeholderAssemblyMinutes', '#ConsultationLogs']],
                            ['section' => 'outcomes', 'code' => 'O.1', 'statement' => 'The VMGO are crafted and duly approved by the Board of Regents/Trustees.', 'tags' => ['#BoardResolutionCopy']],
                            ['section' => 'best_practices', 'code' => 'BP.1', 'statement' => 'Interactive digital portals and broadcast media continuously publish VMGO statements.', 'tags' => ['#DigitalSignage', '#PublicPortal']],
                        ]
                    ],
                    [
                        'code' => 'Parameter B',
                        'name' => 'Dissemination and Acceptability',
                        'order' => 2,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The VMGO are available on bulletin boards, in catalogs/manuals, and in other communication media.', 'tags' => ['#StudentHandbook', '#CourseSyllabi', '#PhotoDocumentation']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'A structured system of dissemination and acceptability of the VMGO is enforced across all campuses.', 'tags' => ['#DisseminationPlan', '#FacultyHandbook']],
                            ['section' => 'outcomes', 'code' => 'O.1', 'statement' => 'Stakeholders demonstrate high awareness and understanding of the VMGO based on survey evaluations.', 'tags' => ['#StakeholderSurveyReport', '#AcceptabilitySurvey']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area II',
                'name' => 'Faculty',
                'order' => 2,
                'weight' => 15.00,
                'description' => 'Faculty qualifications, recruitment, professional development, and performance.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Academic Qualifications',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Faculty members teaching in the program possess masteral and doctoral degrees vertically articulated to the discipline.', 'tags' => ['#FacultyProfile', '#TranscriptOfRecords', '#DiplomaCopy']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'PRC professional licenses and board certifications are actively maintained by faculty members.', 'tags' => ['#PRC_License', '#CertificateOfGoodStanding']],
                            ['section' => 'outcomes', 'code' => 'O.1', 'statement' => 'At least 75% of full-time faculty hold relevant post-graduate degrees.', 'tags' => ['#FacultyMasterList', '#CHED_FormE']],
                        ]
                    ],
                    [
                        'code' => 'Parameter B',
                        'name' => 'Recruitment, Selection, and Orientation',
                        'order' => 2,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'A merit selection plan and transparent hiring guidelines govern faculty recruitment.', 'tags' => ['#HiringGuidelines', '#MeritSelectionPlan']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Newly appointed faculty undergo comprehensive institutional orientation and mentoring.', 'tags' => ['#OnboardingLogs', '#FacultyMentoringReport']],
                        ]
                    ],
                    [
                        'code' => 'Parameter C',
                        'name' => 'Faculty Development',
                        'order' => 3,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The institution provides institutional funding and study leaves for continuous faculty development.', 'tags' => ['#FacultyDevPlan', '#ScholarshipPolicy']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Faculty actively participate in national and international conferences, workshops, and research colloquia.', 'tags' => ['#TrainingCertificates', '#TravelOrders']],
                            ['section' => 'best_practices', 'code' => 'BP.1', 'statement' => 'Institutional incentives and deloading are awarded for SCOPUS/WoS peer-reviewed publications.', 'tags' => ['#PublicationIncentivePolicy', '#SCOPUS_Proof']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area III',
                'name' => 'Curriculum and Instruction',
                'order' => 3,
                'weight' => 15.00,
                'description' => 'Curriculum development, CMO compliance, OBE syllabi, and educational technology.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Curriculum Design & CMO Compliance',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The program curriculum adheres strictly to latest CHED Policies, Standards, and Guidelines (PSG/CMO).', 'tags' => ['#CHED_CMO_Compliance', '#ProspectusCopy']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'OBE syllabus is prepared and distributed for every course with mapped student learning outcomes.', 'tags' => ['#OBE_Syllabi', '#CurriculumMap']],
                            ['section' => 'outcomes', 'code' => 'O.1', 'statement' => 'Program graduates demonstrate high passing rates in professional licensure examinations.', 'tags' => ['#PRC_PassingReport', '#BoardAnalytics']],
                        ]
                    ],
                    [
                        'code' => 'Parameter B',
                        'name' => 'Instructional Materials & Educational Technology',
                        'order' => 2,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Faculty-authored instructional modules and courseware undergo formal review and copyrighting.', 'tags' => ['#IM_EvaluationMatrix', '#CopyrightCertificates']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Learning management systems (LMS) and multimedia resources are actively integrated into courses.', 'tags' => ['#LMS_AnalyticsReport', '#CoursewareAccessLogs']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area IV',
                'name' => 'Support to Students',
                'order' => 4,
                'weight' => 10.00,
                'description' => 'Student services, admissions, guidance counseling, career placement, and student bodies.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Student Services Program',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The institution has an active and comprehensive student counseling, guidance, and placement services center.', 'tags' => ['#StudentManual', '#GuidanceServicesLog']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Career counseling, job placement fairs, and alumni tracer tracking services are systematically provided.', 'tags' => ['#CareerFairReport', '#AlumniTracerSurvey']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area V',
                'name' => 'Research',
                'order' => 5,
                'weight' => 10.00,
                'description' => 'Institutional research agenda, faculty publications, student theses, and ethics compliance.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Research Agenda and Outputs',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The program operates under an updated research agenda aligned with institutional priorities.', 'tags' => ['#ResearchAgenda', '#EthicsClearanceGuidelines']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Faculty and students publish researches in indexed journals and present at conferences.', 'tags' => ['#PublishedArticles', '#ConferenceProceedings']],
                            ['section' => 'outcomes', 'code' => 'O.1', 'statement' => 'Research outputs produce commercialized technologies, patents, utility models, or policy briefs.', 'tags' => ['#PatentCopy', '#PolicyBriefs']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area VI',
                'name' => 'Extension and Community Involvement',
                'order' => 6,
                'weight' => 10.00,
                'description' => 'Community outreach, technology transfer, MOA with partner communities, and impact.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Extension Projects and Linkages',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Extension agenda addresses direct needs of adopted communities and industry sectors.', 'tags' => ['#ExtensionAgenda', '#NeedsAssessmentReport']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Partnership agreements (MOA/MOU) are active with local government units and partner organizations.', 'tags' => ['#SignedMOA_Partnership', '#ExtensionActivityReports']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area VII',
                'name' => 'Library',
                'order' => 7,
                'weight' => 10.00,
                'description' => 'Library book holdings, digital databases, reading environments, and automated OPAC.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Collection and Digital Resources',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Core titles, professional references, and peer-reviewed journals meet CHED standard volumes.', 'tags' => ['#LibraryHoldingsInventory', '#E-LibrarySubscriptions']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Integrated library management systems (OPAC/Koha) support patron search and digital access.', 'tags' => ['#OPAC_Report', '#LibraryUtilizationLogs']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area VIII',
                'name' => 'Physical Plant and Facilities',
                'order' => 8,
                'weight' => 5.00,
                'description' => 'Classrooms, accessibility, disaster readiness, ventilation, and safety certificates.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Campus Infrastructure & Safety',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Adequate, well-ventilated, and digitally equipped classrooms are available for all classes.', 'tags' => ['#ClassroomInventory', '#FacilityInspectionReport']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Fire safety certificates, earthquake drills, and PWD ramps comply with national building codes.', 'tags' => ['#FireSafetyCertificate', '#PWD_ComplianceProof']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area IX',
                'name' => 'Laboratories',
                'order' => 9,
                'weight' => 10.00,
                'description' => 'Laboratory apparatus, software licenses, maintenance logs, and safety protocols.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Laboratory Facilities and Equipment',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Laboratory apparatus, workstations, and software licenses satisfy class size requirements.', 'tags' => ['#LabInventoryList', '#SoftwareLicenses']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Safety guidelines, emergency eye-wash, first aid kits, and hazardous waste disposal are maintained.', 'tags' => ['#LabSafetyManual', '#WasteDisposalCertificates']],
                            ['section' => 'outcomes', 'code' => 'O.1', 'statement' => 'Laboratory experiments produce hands-on competency and verified student project deliverables.', 'tags' => ['#StudentLabManuals', '#ProjectExhibits']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area X',
                'name' => 'Administration',
                'order' => 10,
                'weight' => 10.00,
                'description' => 'Organizational leadership, financial stewardship, records management, and QA governance.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Organizational Structure and QA Governance',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The organizational chart clearly outlines operational authority, responsibilities, and accountability.', 'tags' => ['#OrganizationalChart', '#AdministrativeManual']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Internal Quality Assurance (IQA) audits and management reviews are conducted regularly.', 'tags' => ['#IQA_AuditReports', '#ManagementReviewMinutes']],
                            ['section' => 'outcomes', 'code' => 'O.1', 'statement' => 'Budget allocation supports program sustainability and physical development targets.', 'tags' => ['#FinancialAllocationStatement', '#PPMP_Copy']],
                        ]
                    ]
                ]
            ]
        ];

        // Seed 3 Program Master Instruments
        $progSupp = Instrument::updateOrCreate(
            ['code' => 'INST-PROG-SUPPORTING-DOCS'],
            [
                'name' => 'Program Supporting Documents Instrument (AACCUP)',
                'level' => 'Level III',
                'accreditation_type' => 'program',
                'version' => '2026.1',
                'status' => 'active',
                'is_template' => true,
                'description' => 'AACCUP 10-Area Supporting Documents benchmark criteria, parameter checklists, and evidence tag requirements for academic degree programs.',
            ]
        );
        $this->seedInstrumentStructure($progSupp, $programAreasData);

        $progSurvey = Instrument::updateOrCreate(
            ['code' => 'INST-PROG-SELF-SURVEY'],
            [
                'name' => 'Program Self-Survey Instrument (AACCUP)',
                'level' => 'Level III',
                'accreditation_type' => 'program',
                'version' => '2026.1',
                'status' => 'active',
                'is_template' => true,
                'description' => 'Internal QA self-evaluation spreadsheets, numerical rating matrix, and diagnostic compliance evaluations across Areas I–X.',
            ]
        );
        $this->seedInstrumentStructure($progSurvey, $programAreasData);

        $progComp = Instrument::updateOrCreate(
            ['code' => 'INST-PROG-COMPLIANCE-REPORT'],
            [
                'name' => 'Program Compliance Reports Instrument (AACCUP)',
                'level' => 'Level III',
                'accreditation_type' => 'program',
                'version' => '2026.1',
                'status' => 'active',
                'is_template' => true,
                'description' => 'Official compliance monitoring logs, AACCUP team recommendations, corrective action plans, and certificates of accreditation.',
            ]
        );
        $this->seedInstrumentStructure($progComp, $programAreasData);

        // ─────────────────────────────────────────────────────────────
        // 2. INSTITUTIONAL ACCREDITATION: 9 CORE AREAS MASTER DATA
        // ─────────────────────────────────────────────────────────────
        $instAreasData = [
            [
                'code' => 'Area I',
                'name' => 'Governance and Management',
                'order' => 1,
                'weight' => 15.00,
                'description' => 'University charter, BOR resolutions, strategic development plan, and executive management.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Board of Regents & Strategic Direction',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The University operates under an approved 5-year Strategic Development Plan aligned with SUC levelling norms.', 'tags' => ['#StrategicPlan', '#BOR_Approval']],
                            ['section' => 'implementation', 'code' => 'I.1', 'statement' => 'Management committees and academic councils convene regularly with verified minutes and action logs.', 'tags' => ['#CouncilMinutes', '#PolicyResolutions']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area II',
                'name' => 'Teaching, Learning, and Evaluation',
                'order' => 2,
                'weight' => 20.00,
                'description' => 'Institution-wide academic policies, enrollment trends, quality benchmarks, and graduation standards.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Institutional Academic Integrity',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'University-wide grading systems, retention policies, and graduation guidelines are standardized.', 'tags' => ['#AcademicManual', '#RegistrarPolicy']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area III',
                'name' => 'Faculty and Staff Support',
                'order' => 3,
                'weight' => 15.00,
                'description' => 'University-wide HR development, ranking promotions, wellness programs, and compensation systems.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Institutional Human Resource Management',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The University maintains a comprehensive Human Resource Development Master Plan.', 'tags' => ['#HR_MasterPlan', '#StaffingPattern']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area IV',
                'name' => 'Research and Development',
                'order' => 4,
                'weight' => 15.00,
                'description' => 'University research institutes, external grants, patent commercialization, and IP protection.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'University Research Ecosystem',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Central R&D Centers coordinate multidisciplinary projects funded by DOST, CHED, and international partners.', 'tags' => ['#R&D_AnnualReport', '#ExternalGrantsLog']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area V',
                'name' => 'Extension, Consultancy, and Linkages',
                'order' => 5,
                'weight' => 10.00,
                'description' => 'University-wide community engagements, international university consortia, and LGU partnerships.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Institutional Linkages and Global Consortia',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Active bilateral agreements and international consortia memberships expand institutional reach.', 'tags' => ['#International_MOA', '#GlobalConsortiaProof']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area VI',
                'name' => 'Support to Students',
                'order' => 6,
                'weight' => 10.00,
                'description' => 'University scholarship programs, dormitory services, medical-dental clinic, and campus security.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Central Student Affairs & Services',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'University-wide health, scholarship, student housing, and psychological welfare services are operational.', 'tags' => ['#OSAS_AnnualReport', '#HealthClinicCertificates']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area VII',
                'name' => 'Library and Learning Resources',
                'order' => 7,
                'weight' => 5.00,
                'description' => 'University Central Library system, campus digital network, and federated repository access.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'University Library System Network',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The University Library System centralizes electronic resources and automated inter-library loans.', 'tags' => ['#UniversityLibraryMasterPlan', '#DatabaseSubscriptions']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area VIII',
                'name' => 'Infrastructure and Physical Facilities',
                'order' => 8,
                'weight' => 5.00,
                'description' => 'Master campus development plan, disaster resilience, environmental sustainability, and green campus.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'Campus Land Use & Infrastructure Master Plan',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'Approved Land Use Development and Infrastructure Plan (LUDIP) guides physical expansion.', 'tags' => ['#LUDIP_Document', '#GreenCampusPolicy']],
                        ]
                    ]
                ]
            ],
            [
                'code' => 'Area IX',
                'name' => 'Quality Assurance System',
                'order' => 9,
                'weight' => 5.00,
                'description' => 'Institutional Quality Assurance (IQA) governance, ISO 9001 certifications, and SUC level IV maintenance.',
                'parameters' => [
                    [
                        'code' => 'Parameter A',
                        'name' => 'IQA Office Operations & ISO Certification',
                        'order' => 1,
                        'criteria' => [
                            ['section' => 'systems', 'code' => 'S.1', 'statement' => 'The University maintains active ISO 9001:2015 Quality Management System certification across all campuses.', 'tags' => ['#ISO_Certificate', '#InternalAuditSummary']],
                        ]
                    ]
                ]
            ]
        ];

        // Seed 3 Institutional Master Instruments
        $instSupp = Instrument::updateOrCreate(
            ['code' => 'INST-INST-SUPPORTING-DOCS'],
            [
                'name' => 'Institutional Supporting Documents Instrument (AACCUP)',
                'level' => 'Level IV',
                'accreditation_type' => 'institutional',
                'version' => '2026.1',
                'status' => 'active',
                'is_template' => true,
                'description' => 'AACCUP 9-Area Institutional Accreditation Supporting Documents criteria, governance benchmarks, and university-wide evidence tags.',
            ]
        );
        $this->seedInstrumentStructure($instSupp, $instAreasData);

        $instSurvey = Instrument::updateOrCreate(
            ['code' => 'INST-INST-SELF-SURVEY'],
            [
                'name' => 'Institutional Self-Survey Instrument (AACCUP)',
                'level' => 'Level IV',
                'accreditation_type' => 'institutional',
                'version' => '2026.1',
                'status' => 'active',
                'is_template' => true,
                'description' => 'Institutional self-evaluation spreadsheets, university diagnostic checklists, and SUC levelling rubrics.',
            ]
        );
        $this->seedInstrumentStructure($instSurvey, $instAreasData);

        $instComp = Instrument::updateOrCreate(
            ['code' => 'INST-INST-COMPLIANCE-REPORT'],
            [
                'name' => 'Institutional Compliance Reports Instrument (AACCUP)',
                'level' => 'Level IV',
                'accreditation_type' => 'institutional',
                'version' => '2026.1',
                'status' => 'active',
                'is_template' => true,
                'description' => 'University-level compliance monitoring, institutional recommendations tracker, and CHED/AACCUP certificates.',
            ]
        );
        $this->seedInstrumentStructure($instComp, $instAreasData);
    }

    private function seedInstrumentStructure(Instrument $instrument, array $areasData): void
    {
        foreach ($areasData as $aData) {
            $area = InstrumentArea::updateOrCreate(
                ['instrument_id' => $instrument->id, 'code' => $aData['code']],
                [
                    'name' => $aData['name'],
                    'order' => $aData['order'],
                    'weight' => $aData['weight'],
                    'description' => $aData['description'],
                ]
            );

            foreach ($aData['parameters'] as $pData) {
                $param = InstrumentParameter::updateOrCreate(
                    ['instrument_area_id' => $area->id, 'code' => $pData['code']],
                    [
                        'name' => $pData['name'],
                        'order' => $pData['order'],
                        'description' => $pData['name'],
                    ]
                );

                foreach ($pData['criteria'] as $cIdx => $cData) {
                    InstrumentCriterion::updateOrCreate(
                        ['instrument_parameter_id' => $param->id, 'code' => $cData['code'], 'section' => $cData['section']],
                        [
                            'statement' => $cData['statement'],
                            'required_tags' => $cData['tags'] ?? [],
                            'order' => $cIdx + 1,
                        ]
                    );
                }
            }
        }
    }
}
