window.documentWorkspace = function (initialState = {}) {
    const userRole = initialState.userRole || '';
    const canSeeCommonDocs = ['iqa-staff', 'iqa-admin', 'iqa-member', 'task-force-member', 'college-head', 'system-administrator'].includes(userRole);
    const canSeeInstitutionalDocs = ['iqa-staff', 'iqa-admin', 'iqa-member', 'system-administrator'].includes(userRole);
    let defaultTab = initialState.activeTab || (canSeeCommonDocs ? 'common-documents' : 'program-accreditation');
    if (!canSeeCommonDocs && defaultTab === 'common-documents') {
        defaultTab = 'program-accreditation';
    }
    if (!canSeeInstitutionalDocs && defaultTab === 'institutional-accreditation') {
        defaultTab = 'program-accreditation';
    }
    let initialAccredLevel = initialState.accredLevel || null;
    if (defaultTab === 'program-accreditation') {
        initialAccredLevel = 'program';
    } else if (defaultTab === 'institutional-accreditation') {
        initialAccredLevel = 'institutional';
    }

    return {
        currentUserId: initialState.userId || null,
        currentUserRole: initialState.userRole || '',
        activeTab: defaultTab, // 'common-documents', 'program-accreditation', 'institutional-accreditation'
        accredLevel: initialAccredLevel, // 'program' or 'institutional'
        accredCollege: null, // selected college object
        accredProgram: null, // selected program object
        collegeSearchQuery: '',
        programSearchQuery: '',
        programCollegeFilter: 'all',
        accredCategory: null, // 'Self-Survey Documents', 'Compliance Reports', 'Supporting Documents', 'Narrative Profile', 'PPP'
        accredActiveAreaId: 'area_i1',
        accredActiveParamId: 'param_i1_a',
        accredActiveSection: 'systems',

        // === Self-Survey State ===
        selfSurveyActiveAreaId: 'ss_area_i1', // default to Area I; string = viewing that area's table
        selfSurveyRatings: {},             // { indicatorKey: 1-5 | null }
        selfSurveyBestPractices: {},       // { paramKey: 'text...' }
        selfSurveyPreparedBy: '',          // prepared by name
        selfSurveySaving: false,           // debounce guard

        // === Narrative Profile State ===
        npAreas: [
            { id: 'np_area_1',  code: 'Area I',   title: 'Vision, Mission, Goals, and Objectives' },
            { id: 'np_area_2',  code: 'Area II',  title: 'Faculty' },
            { id: 'np_area_3',  code: 'Area III', title: 'Curriculum and Instruction' },
            { id: 'np_area_4',  code: 'Area IV',  title: 'Support to Students' },
            { id: 'np_area_5',  code: 'Area V',   title: 'Research' },
            { id: 'np_area_6',  code: 'Area VI',  title: 'Extension and Community Involvement' },
            { id: 'np_area_7',  code: 'Area VII', title: 'Library' },
            { id: 'np_area_8',  code: 'Area VIII','title': 'Physical Plant and Facilities' },
            { id: 'np_area_9',  code: 'Area IX',  title: 'Laboratories' },
            { id: 'np_area_10', code: 'Area X',   title: 'Administration' },
        ],
        npActiveAreaId: 'np_area_1',
        npDocContents: {},           // { areaId: { content: '<html>', lastSaved: Date | null } }
        npDocGoogleUrls: {},         // { areaId: 'https://docs.google.com/...' }
        npActiveViewMode: 'in-app',  // 'in-app' | 'google-doc'
        npEditorOpen: false,
        npEditorAreaId: null,
        npEditorSaved: false,

        // === PPP (Program Performance Portfolio) State ===
        pppAreas: [
            { id: 'ppp_area_1',  code: 'Area I',   title: 'Vision, Mission, Goals, and Objectives' },
            { id: 'ppp_area_2',  code: 'Area II',  title: 'Faculty' },
            { id: 'ppp_area_3',  code: 'Area III', title: 'Curriculum and Instruction' },
            { id: 'ppp_area_4',  code: 'Area IV',  title: 'Support to Students' },
            { id: 'ppp_area_5',  code: 'Area V',   title: 'Research' },
            { id: 'ppp_area_6',  code: 'Area VI',  title: 'Extension and Community Involvement' },
            { id: 'ppp_area_7',  code: 'Area VII', title: 'Library' },
            { id: 'ppp_area_8',  code: 'Area VIII','title': 'Physical Plant and Facilities' },
            { id: 'ppp_area_9',  code: 'Area IX',  title: 'Laboratories' },
            { id: 'ppp_area_10', code: 'Area X',   title: 'Administration' },
        ],
        pppActiveAreaId: 'ppp_area_1',
        pppDocContents: {},          // { areaId: { content: '<html>', lastSaved: Date | null } }
        pppDocGoogleUrls: {},        // { areaId: 'https://docs.google.com/...' }
        pppActiveViewMode: 'in-app', // 'in-app' | 'google-doc'
        pppEditorOpen: false,
        pppEditorAreaId: null,
        pppEditorSaved: false,

        // Shared Document Editor UX State
        editorIsFullscreen: false,
        autoSaveStatus: 'saved',     // 'saved' | 'saving'
        lastSavedTime: 'Just now',
        autoSaveTimer: null,

        // List of academic programs for Program Accreditation selection UI
        programsList: [],

        // Accreditation mock data
        accredData: {
            program: {
                title: 'Program Accreditation',
                areas: [
                    {
                        id: 'area_p1',
                        code: 'Area I',
                        title: 'Vision, Mission, Goals, and Objectives',
                        progress: 100,
                        parameters: [
                            {
                                id: 'param_p1_a',
                                code: 'Parameter A',
                                title: 'Statement of VMGO',
                                progress: 100,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The institution has a system of determining its Vision and Mission.',
                                            documents: [
                                                { name: 'VMGO Formulation System Policy', type: 'PDF', size: '1.4 MB', date: '2024-01-10', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'POLICY ON FORMULATION AND REVISION OF VMGO...' }
                                            ]
                                        },
                                        {
                                            id: 'S.2',
                                            statement: 'The Vision clearly reflects what the Institution hopes to become in the future.',
                                            documents: [
                                                { name: 'Bicol University Vision Statement & Analysis', type: 'PDF', size: '0.8 MB', date: '2024-02-15', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'VISION STATEMENT OF BICOL UNIVERSITY...' }
                                            ]
                                        },
                                        {
                                            id: 'S.3',
                                            statement: 'The Mission clearly reflects the Institution’s legal and other statutory mandates.',
                                            documents: [
                                                { name: 'SUC Charter (Republic Act 5521) copy', type: 'PDF', size: '2.1 MB', date: '2024-02-28', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'REPUBLIC ACT NO. 5521: CHARTER OF BICOL UNIVERSITY...' }
                                            ]
                                        },
                                        {
                                            id: 'S.4',
                                            statement: 'The Goals of the academic unit/department are clearly stated and are consistent with the Mission of the Institution.',
                                            documents: [
                                                { name: 'College of Science Goals and Alignment Matrix', type: 'PDF', size: '1.1 MB', date: '2024-03-12', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'GOALS OF THE COLLEGE OF SCIENCE...' }
                                            ]
                                        },
                                        {
                                            id: 'S.5',
                                            statement: 'The Objectives have the expected outcomes in terms of competencies (skills and knowledge), values and other attributes of the graduates which include the development of:',
                                            documents: []
                                        },
                                        {
                                            id: 'S.5.1',
                                            statement: 'technical/pedagogical skills;',
                                            documents: [
                                                { name: 'BSCS Program Educational Objectives (PEO) Matrix', type: 'PDF', size: '1.5 MB', date: '2024-04-05', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'TECHNICAL COMPETENCIES AND STUDENT OUTCOMES...' }
                                            ]
                                        },
                                        {
                                            id: 'S.5.2',
                                            statement: 'research and extension capabilities;',
                                            documents: []
                                        },
                                        {
                                            id: 'S.5.3',
                                            statement: 'students’ own ideas, desirable attitudes and personal discipline;',
                                            documents: []
                                        },
                                        {
                                            id: 'S.5.4',
                                            statement: 'moral character;',
                                            documents: []
                                        },
                                        {
                                            id: 'S.5.5',
                                            statement: 'critical thinking skills; problem solving and other higher order thinking skills; and',
                                            documents: []
                                        },
                                        {
                                            id: 'S.5.6',
                                            statement: 'aesthetic and cultural values.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [
                                        {
                                            id: 'I.1',
                                            statement: 'The Institution/Academic Unit conducts a review on the statement of the Vision and Mission as well as its goals and program objectives for the approval of authorities concerned.',
                                            documents: [
                                                { name: 'BU Academic Council Resolution Approving CS VMGO', type: 'PDF', size: '1.3 MB', date: '2024-03-20', uploader: 'Dr. Roger Cruz', office: 'Office of the President', status: 'Verified', ocrText: 'COUNCIL RESOLUTION NO. 012 APPROVING REVISED VMGO...' }
                                            ]
                                        },
                                        {
                                            id: 'I.2',
                                            statement: 'The College/Academic Unit follows a system in formulating goals and the objectives of the program.',
                                            documents: []
                                        },
                                        {
                                            id: 'I.3',
                                            statement: 'The College’s/Academic Unit’s faculty, staff, personnel, students and other stakeholders (cooperating agencies, linkages, alumni, industry sector and other concerned groups) participate in the formulation, review and/or revision of the VMGO.',
                                            documents: [
                                                { name: 'Minutes of Stakeholder Consultation Assembly', type: 'PDF', size: '1.9 MB', date: '2025-04-18', uploader: 'Prof. Amelia Vega', office: 'College of Science', status: 'Verified', ocrText: 'STAKEHOLDERS VMGO ASSEMBLY MINUTES...' }
                                            ]
                                        }
                                    ],
                                    outcomes: [
                                        {
                                            id: 'O.1',
                                            statement: 'The VMGO are crafted and duly approved by the BOR/BOT.',
                                            documents: [
                                                { name: 'Board of Regents Resolution s. 2024 Approval', type: 'PDF', size: '1.2 MB', date: '2024-03-15', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'BOARD RESOLUTION NO. 045, SERIES OF 2024\n\nSUBJECT: APPROVAL OF THE UNIVERSITY VISION, MISSION, GOALS AND OBJECTIVES.' }
                                            ]
                                        }
                                    ],
                                    bestpractices: []
                                }
                            },
                            {
                                id: 'param_p1_b',
                                code: 'Parameter B',
                                title: 'Dissemination and Acceptability',
                                progress: 100,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The VMGO are available on bulletin boards, in catalogs/manuals and are available in other forms of communication media.',
                                            documents: [
                                                { name: 'BU Student Catalog and Website VMGO Screen', type: 'PDF', size: '2.5 MB', date: '2025-06-12', uploader: 'Prof. Evelyn Diaz', office: 'Student Affairs Office', status: 'Verified', ocrText: 'STUDENT CATALOG s. 2025-2026...' }
                                            ]
                                        }
                                    ],
                                    implementation: [
                                        {
                                            id: 'I.1',
                                            statement: 'A system of dissemination and acceptability of the VMGO is enforced.',
                                            documents: []
                                        },
                                        {
                                            id: 'I.2',
                                            statement: 'The administrators/faculty attend in in-service seminars and training on the awareness and acceptability of the:',
                                            documents: []
                                        },
                                        {
                                            id: 'I.2.1',
                                            statement: 'Vision and Mission of the Institution;',
                                            documents: []
                                        },
                                        {
                                            id: 'I.2.2',
                                            statement: 'Goals of the Academic Unit; and',
                                            documents: []
                                        },
                                        {
                                            id: 'I.2.3',
                                            statement: 'Objectives of the Program.',
                                            documents: []
                                        },
                                        {
                                            id: 'I.3',
                                            statement: 'The formulation/review/revision of the VMGO is participated in by the following:',
                                            documents: []
                                        },
                                        {
                                            id: 'I.3.1',
                                            statement: 'administrators;',
                                            documents: []
                                        },
                                        {
                                            id: 'I.3.2',
                                            statement: 'faculty;',
                                            documents: []
                                        },
                                        {
                                            id: 'I.3.3',
                                            statement: 'staff;',
                                            documents: []
                                        },
                                        {
                                            id: 'I.3.4',
                                            statement: 'students; and',
                                            documents: []
                                        },
                                        {
                                            id: 'I.3.5',
                                            statement: 'other stakeholders.',
                                            documents: []
                                        },
                                        {
                                            id: 'I.4',
                                            statement: 'The faculty and staff perform their jobs/functions in consonance with the VMGO.',
                                            documents: []
                                        },
                                        {
                                            id: 'I.5',
                                            statement: 'The VMGO are widely disseminated to the different agencies, institutions, industry sector and the community.',
                                            documents: [
                                                { name: 'BU VMGO External Dissemination Activity Report', type: 'PDF', size: '3.4 MB', date: '2025-10-15', uploader: 'Dr. Roger Cruz', office: 'Extension Services Office', status: 'Verified', ocrText: 'BU VMGO PUBLIC DISSEMINATION CAMPAIGN...' }
                                            ]
                                        }
                                    ],
                                    outcomes: [
                                        {
                                            id: 'O.1',
                                            statement: 'There is full awareness and acceptance of the VMGO by all the administrators, faculty, staff, students, and other stakeholders.',
                                            documents: []
                                        },
                                        {
                                            id: 'O.2',
                                            statement: 'There is congruency between actual educational practices and activities with the following:',
                                            documents: []
                                        },
                                        {
                                            id: 'O.2.1',
                                            statement: 'Vision and mission of the SUC;',
                                            documents: [
                                                { name: 'VMGO Congruency and Integration Audit Report', type: 'PDF', size: '1.7 MB', date: '2026-02-12', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'CONGRUENCY REPORT ON EDUCATIONAL PRACTICES WITH VMGO...' }
                                            ]
                                        },
                                        {
                                            id: 'O.2.2',
                                            statement: 'Goals of the College/Academic Unit; and',
                                            documents: []
                                        },
                                        {
                                            id: 'O.2.3',
                                            statement: 'Objectives of the Program.',
                                            documents: []
                                        },
                                        {
                                            id: 'O.3',
                                            statement: 'The goals and objectives are fully achieved.',
                                            documents: []
                                        }
                                    ],
                                    bestpractices: []
                                }
                            },
                            {
                                id: 'param_p1_c',
                                code: 'Parameter C',
                                title: 'Relationship of the Goals and Objectives to the Vision and Mission',
                                progress: 100,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'There is congruence between the objectives of the program and the goals of the college.',
                                            documents: [
                                                { name: 'BU CS PEO to College Goals Alignment Matrix', type: 'PDF', size: '1.2 MB', date: '2025-02-14', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'ALIGNMENT MATRIX BETWEEN BSCS PEOs AND COLLEGE OF SCIENCE GOALS...' }
                                            ]
                                        }
                                    ],
                                    implementation: [
                                        {
                                            id: 'I.1',
                                            statement: 'The program objectives are regularly reviewed for compatibility with the mission statement.',
                                            documents: []
                                        },
                                        {
                                            id: 'I.2',
                                            statement: 'Activities and instructions are designed to implement the program objectives.',
                                            documents: [
                                                { name: 'Syllabus Sample showing VMGO Alignment Integration', type: 'PDF', size: '2.4 MB', date: '2025-09-10', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'COURSE SYLLABUS INTEGRATING VMGO...' }
                                            ]
                                        }
                                    ],
                                    outcomes: [
                                        {
                                            id: 'O.1',
                                            statement: 'The graduates demonstrate the competencies expected of them in line with the program objectives.',
                                            documents: [
                                                { name: 'Tracer Study Report of BSCS Graduates s. 2025', type: 'PDF', size: '3.8 MB', date: '2025-12-05', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'GRADUATE TRACER AND PLACEMENT SUCCESS STUDY...' }
                                            ]
                                        }
                                    ],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p2',
                        code: 'Area II',
                        title: 'Faculty',
                        progress: 64,
                        parameters: [
                            {
                                id: 'param_p2_a',
                                code: 'Parameter A',
                                title: 'Academic Qualifications',
                                progress: 64,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'Faculty members possess the appropriate educational background and degrees for their assignments.',
                                            documents: [
                                                { name: 'Faculty Roster & Qualifications Database', type: 'Excel', size: '2.1 MB', date: '2025-10-15', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'FACULTY ROSTER & ACADEMIC CREDENTIALS\n\nTotal Faculty: 45. Doctorates: 15. Masters: 28. Baccalaureate: 2.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p3',
                        code: 'Area III',
                        title: 'Curriculum and Instruction',
                        progress: 88,
                        parameters: [
                            {
                                id: 'param_p3_a',
                                code: 'Parameter A',
                                title: 'Curriculum Development',
                                progress: 88,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The curriculum is regularly reviewed and updated in consultation with stakeholders.',
                                            documents: [
                                                { name: 'Minutes of Curriculum Review Committee s. 2025', type: 'PDF', size: '1.6 MB', date: '2025-08-12', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'MINUTES OF THE JOINT CURRICULUM REVIEW ASSEMBLY\n\nDiscussed alignment of BSCS and BSIT program outcomes with AACCUP and CHED standards.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p4',
                        code: 'Area IV',
                        title: 'Support to Students',
                        progress: 92,
                        parameters: [
                            {
                                id: 'param_p4_a',
                                code: 'Parameter A',
                                title: 'Student Services Program',
                                progress: 92,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The institution has an active and comprehensive student counseling, guidance, and placement services center.',
                                            documents: [
                                                { name: 'Guidance & Counseling Manual of Operations s. 2025', type: 'PDF', size: '1.4 MB', date: '2025-05-18', uploader: 'Prof. Evelyn Diaz', office: 'Student Affairs Office', status: 'Verified', ocrText: 'STUDENT AFFAIRS & GUIDANCE COUNSELING MANUAL\n\nOutline of intake interviews, psychological testing, and placement counseling guides.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p5',
                        code: 'Area V',
                        title: 'Research',
                        progress: 75,
                        parameters: [
                            {
                                id: 'param_p5_a',
                                code: 'Parameter A',
                                title: 'Research Agenda and Outputs',
                                progress: 75,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The faculty is engaged in research activities aligned with the university research agenda.',
                                            documents: [
                                                { name: 'Faculty Publications & Citations Report 2025', type: 'PDF', size: '3.1 MB', date: '2025-11-20', uploader: 'Dr. Roger Cruz', office: 'Research and Development Office', status: 'Verified', ocrText: 'ANNUAL RESEARCH PRODUCTION REPORT\n\nLists of index-journal publications, citations, and registered patents of faculty members.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p6',
                        code: 'Area VI',
                        title: 'Extension and Community Involvement',
                        progress: 80,
                        parameters: [
                            {
                                id: 'param_p6_a',
                                code: 'Parameter A',
                                title: 'Extension Service Projects',
                                progress: 80,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The department implements extension and community service projects aligned with local community needs.',
                                            documents: [
                                                { name: 'Barangay Livelihood Training Extension Program Portfolio', type: 'PDF', size: '4.2 MB', date: '2026-01-10', uploader: 'Engr. Sarah Gomez', office: 'Extension Services Division', status: 'Verified', ocrText: 'COMMUNITY LIVELIHOOD SKILLS DEVELOPMENT PORTFOLIO\n\nDetails of IT literacy and computer assembly trainings conducted for local youth groups.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p7',
                        code: 'Area VII',
                        title: 'Library',
                        progress: 85,
                        parameters: [
                            {
                                id: 'param_p7_a',
                                code: 'Parameter A',
                                title: 'Library Resources and Holdings',
                                progress: 85,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The library has sufficient and up-to-date book, journal, and e-resource holdings for the program.',
                                            documents: [
                                                { name: 'Bicol University Library Holdings Catalog s. 2026', type: 'Excel', size: '1.9 MB', date: '2026-03-02', uploader: 'Librarian Delia Santos', office: 'University Library', status: 'Verified', ocrText: 'LIBRARY ACQUISITIONS & HOLDINGS IN COMPUTER SCIENCE\n\nList of textbooks, electronic subscriptions (IEEE, ACM), and research materials.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p8',
                        code: 'Area VIII',
                        title: 'Physical Plant and Facilities',
                        progress: 90,
                        parameters: [
                            {
                                id: 'param_p8_a',
                                code: 'Parameter A',
                                title: 'Classrooms and Buildings',
                                progress: 90,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The physical classrooms, buildings, and building layouts are safe, spacious, and well-maintained.',
                                            documents: [
                                                { name: 'CS Building Occupancy & Safety Inspection Report', type: 'PDF', size: '2.8 MB', date: '2025-08-30', uploader: 'Arch. Leo Alba', office: 'Physical Plant Office', status: 'Verified', ocrText: 'CERTIFICATE OF BUILDING SAFETY & OCCUPANCY\n\nCS main building structural clearance, fire safety indicators, and classroom sizes report.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p9',
                        code: 'Area IX',
                        title: 'Laboratories',
                        progress: 95,
                        parameters: [
                            {
                                id: 'param_p9_a',
                                code: 'Parameter A',
                                title: 'Laboratory Equipment and Software',
                                progress: 95,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The computer and science laboratories are equipped with industry-standard hardware and software licenses.',
                                            documents: [
                                                { name: 'CS Advanced Labs Network & Software Inventory s. 2026', type: 'PDF', size: '1.5 MB', date: '2026-04-12', uploader: 'Maria Reyes', office: 'College of Science', status: 'Verified', ocrText: 'COMPUTER LABORATORY SPECIFICATIONS & INVENTORY\n\nTotal PCs: 120. Intel Core i7, 16GB RAM. Licensed IDEs, MATLAB, and specialized CS compilers.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_p10',
                        code: 'Area X',
                        title: 'Administration',
                        progress: 88,
                        parameters: [
                            {
                                id: 'param_p10_a',
                                code: 'Parameter A',
                                title: 'Administrative Staff and Efficiency',
                                progress: 88,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The administrative services and supporting personnel perform operations efficiently.',
                                            documents: [
                                                { name: 'CS Administration Operations Performance Rating s. 2025', type: 'PDF', size: '1.1 MB', date: '2025-12-15', uploader: 'Prof. Amelia Vega', office: 'IQA Central Office', status: 'Verified', ocrText: 'ANNUAL PERFORMANCE EVALUATION SUMMARY\n\nAdministrative staff operational ratings, client feedback results, and processing time efficiency metrics.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    }
                ]
            },
            institutional: {
                title: 'Institutional Accreditation',
                areas: [
                    {
                        id: 'area_i1',
                        code: 'Area I',
                        title: 'Governance and Management',
                        progress: 85,
                        parameters: [
                            {
                                id: 'param_i1_a',
                                code: 'Parameter A',
                                title: 'Governance',
                                progress: 85,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The governing board operates under established charter and functions efficiently.',
                                            documents: [
                                                { name: 'Board of Regents Charter & Bylaws', type: 'PDF', size: '2.5 MB', date: '2024-02-10', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'CHARTER OF THE BOARD OF REGENTS\n\nPowers, duties, and responsibilities of Board members and executive committees.' }
                                            ]
                                        },
                                        {
                                            id: 'S.2',
                                            statement: 'The organizational chart is clearly defined, approved, and disseminated to stakeholders.',
                                            documents: [
                                                { name: 'BU Approved Organizational Chart 2024', type: 'PDF', size: '1.1 MB', date: '2024-05-18', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'REVISED BICOL UNIVERSITY ORGANIZATIONAL STRUCTURE\n\nApproved per Board Resolution No. 120, series of 2024.' }
                                            ]
                                        }
                                    ],
                                    implementation: [
                                        {
                                            id: 'I.1',
                                            statement: 'Decisions are documented via board resolutions and administrative issuances.',
                                            documents: [
                                                { name: 'Administrative Order No. 453, s. of 2024', type: 'PDF', size: '1.4 MB', date: '2024-05-10', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'ADMINISTRATIVE ORDER NO. 453, SERIES OF 2024\n\nSUBJECT: CONSTITUTION OF THE TECHNICAL WORKING GROUP.' }
                                            ]
                                        }
                                    ],
                                    outcomes: [
                                        {
                                            id: 'O.1',
                                            statement: 'Governing board reviews and updates institutional plans regularly.',
                                            documents: []
                                        }
                                    ],
                                    bestpractices: [
                                        {
                                            id: 'BP.1',
                                            statement: 'Conduct of annual strategic planning workshops with all unit heads.',
                                            description: 'Aligns institutional budgets and plans directly with BOR targets.'
                                        }
                                    ]
                                }
                            },
                            {
                                id: 'param_i1_b',
                                code: 'Parameter B',
                                title: 'Probity',
                                progress: 35,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'Administrative decisions are governed by established civil service rules and laws.',
                                            documents: [
                                                { name: 'BU Code revised 2024', type: 'PDF', size: '4.8 MB', date: '2024-11-20', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'REVISED UNIVERSITY CODE OF BICOL UNIVERSITY\n\nTitle Two: Academic Policies and Administrative Regulations.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i2',
                        code: 'Area II',
                        title: 'Administration',
                        progress: 42,
                        parameters: [
                            {
                                id: 'param_i2_a',
                                code: 'Parameter A',
                                title: 'Administrative Staffing',
                                progress: 42,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'Administrative offices are staffed with qualified personnel matching civil service requirements.',
                                            documents: [
                                                { name: 'Administrative Staff Profile 2025', type: 'PDF', size: '1.8 MB', date: '2025-09-12', uploader: 'Maria Reyes', office: 'IQA Central Office', status: 'Verified', ocrText: 'ADMINISTRATIVE AND SUPPORT STAFF ROSTER\n\nQualifications, civil service eligibility status, and office distribution summaries.' }
                                            ]
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i3',
                        code: 'Area III',
                        title: 'Curriculum and Instruction',
                        progress: 90,
                        parameters: [
                            {
                                id: 'param_i3_a',
                                code: 'Parameter A',
                                title: 'Curriculum Design & Approval',
                                progress: 90,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'The institution has clearly defined instructional objectives aligned with standard compliance mandates.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i4',
                        code: 'Area IV',
                        title: 'Support to Students',
                        progress: 75,
                        parameters: [
                            {
                                id: 'param_i4_a',
                                code: 'Parameter A',
                                title: 'Student Services Guidance',
                                progress: 75,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'A comprehensive student handbook is published and disseminated annualy.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i5',
                        code: 'Area V',
                        title: 'Research',
                        progress: 50,
                        parameters: [
                            {
                                id: 'param_i5_a',
                                code: 'Parameter A',
                                title: 'Research Program Agenda',
                                progress: 50,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'Research priorities are aligned with regional and national development goals.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i6',
                        code: 'Area VI',
                        title: 'Extension and Community Involvement',
                        progress: 60,
                        parameters: [
                            {
                                id: 'param_i6_a',
                                code: 'Parameter A',
                                title: 'Extension Projects',
                                progress: 60,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'Community extension programs are designed and implemented based on community needs assessment.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i7',
                        code: 'Area VII',
                        title: 'Library',
                        progress: 80,
                        parameters: [
                            {
                                id: 'param_i7_a',
                                code: 'Parameter A',
                                title: 'Library Holdings & Databases',
                                progress: 80,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'Adequate physical and digital academic reference holdings are available for university programs.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i8',
                        code: 'Area VIII',
                        title: 'Physical Plant and Facilities',
                        progress: 45,
                        parameters: [
                            {
                                id: 'param_i8_a',
                                code: 'Parameter A',
                                title: 'Building Safety & Maintenance',
                                progress: 45,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'University buildings are fully compliant with environmental, safety, and fire protection codes.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    },
                    {
                        id: 'area_i9',
                        code: 'Area IX',
                        title: 'Laboratories',
                        progress: 30,
                        parameters: [
                            {
                                id: 'param_i9_a',
                                code: 'Parameter A',
                                title: 'Laboratory Facilities & Safety',
                                progress: 30,
                                sections: {
                                    systems: [
                                        {
                                            id: 'S.1',
                                            statement: 'Specialized lab rooms are fully equipped with working research apparatuses.',
                                            documents: []
                                        }
                                    ],
                                    implementation: [],
                                    outcomes: [],
                                    bestpractices: []
                                }
                            }
                        ]
                    }
                ]
            }
        },

        // ================================================================
        // COMPLIANCE REPORTS – Institutional Accreditation
        // Recommendations, Actions Taken, Supporting Documents, Remarks
        // ================================================================
        complianceActiveAreaId: 'comp_area_1',
        complianceReports: [
            {
                id: 'comp_area_1',
                code: 'AREA I',
                title: 'Governance & Management',
                progress: 60,
                recommendations: [
                    {
                        id: 1,
                        text: 'The university charter is obsolete and needs updating through IRR (University Code) to better articulate current mandate and CHED/DBM/COA/CSC policy guidelines.',
                        status: 'Fully complied',
                        actions: [
                            'TWG constituted to review and revise the BU Code of 2016',
                            'Administrative and Academic Councils endorsed the proposed revision',
                            'Presented to BU Administrative Clearing House and Academic Council',
                            'Presentation of the Proposed Revised BU Code to the Board of Regents'
                        ],
                        documents: [
                            { name: 'AO No. 453, s. 2024', type: 'PDF', size: '1.4 MB', date: '2024-05-10', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'ADMINISTRATIVE ORDER NO. 453, SERIES OF 2024' },
                            { name: 'BU Code 2024 (revised)', type: 'PDF', size: '4.8 MB', date: '2024-11-20', status: 'Verified', uploader: 'Dr. Albert Santos', office: 'Office of the President', ocrText: 'REVISED UNIVERSITY CODE OF BICOL UNIVERSITY' },
                            { name: 'Office Memorandum No. 153 s. 2024', type: 'PDF', size: '980 KB', date: '2024-06-15', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'OFFICE MEMORANDUM - TWG REVIEW OF BU CODE' },
                            { name: 'Notice of Administrative Council Meeting', type: 'PDF', size: '520 KB', date: '2024-07-20', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'NOTICE OF MEETING - ADMINISTRATIVE COUNCIL' },
                            { name: 'BOR Resolution on University Code Revision', type: 'PDF', size: '1.1 MB', date: '2024-09-05', status: 'Pending', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'BOARD OF REGENTS RESOLUTION' }
                        ],
                        remarks: 'The revised BU Code has been presented and endorsed. Final BOR approval is pending for the updated University Code reflecting current policy guidelines.'
                    },
                    {
                        id: 2,
                        text: 'Strengthen disaster preparedness and risk mitigation given the university\'s hazard-prone location.',
                        status: 'Partial',
                        actions: [
                            'Issuance of Administrative Order No. 750, s. of 2023 constituting the DRRM Council',
                            'Conducted annual earthquake and fire drills across all campuses',
                            'Developed campus-level contingency and evacuation plans'
                        ],
                        documents: [
                            { name: 'DRRM Protocol 2024', type: 'PDF', size: '2.1 MB', date: '2024-03-15', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'DISASTER RISK REDUCTION AND MANAGEMENT PROTOCOL' },
                            { name: 'AO No. 750, s. 2023', type: 'PDF', size: '890 KB', date: '2023-11-08', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'ADMINISTRATIVE ORDER 750 - DRRM COUNCIL CONSTITUTION' }
                        ],
                        remarks: 'DRRM Council constituted and protocols established. Full implementation of campus-level contingency plans is still in progress for satellite campuses.'
                    },
                    {
                        id: 3,
                        text: 'Improve transparency mechanisms and public access to institutional financial information.',
                        status: 'Fully complied',
                        actions: [
                            'Digital Transparency Seal published on university website',
                            'Quarterly financial reports posted publicly',
                            'Annual COA audit compliance maintained'
                        ],
                        documents: [
                            { name: 'Transparency Seal Compliance Certificate 2025', type: 'PDF', size: '980 KB', date: '2025-08-15', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'NATIONAL TRANSPARENCY SEAL COMPLIANCE' }
                        ],
                        remarks: 'Full compliance achieved. Transparency Seal is published and financial documents are accessible to the public through the official university website.'
                    },
                    {
                        id: 4,
                        text: 'Strengthen internal audit mechanisms and financial controls across satellite campuses.',
                        status: 'Not started',
                        actions: [],
                        documents: [],
                        remarks: 'No action has been initiated yet. Awaiting appointment of additional internal audit staff for satellite campus coverage.'
                    },
                    {
                        id: 5,
                        text: 'Institutionalize regular bi-monthly EXECOM meetings with documentation of action items and follow-up.',
                        status: 'Fully complied',
                        actions: [
                            'Regular bi-monthly EXECOM meetings conducted since 2023',
                            'Minutes and action items documented and distributed',
                            'Follow-up tracking system implemented'
                        ],
                        documents: [
                            { name: 'EXECOM Minutes Compilation 2024-2025', type: 'PDF', size: '3.2 MB', date: '2025-06-20', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'EXECUTIVE COMMITTEE MEETING MINUTES COMPILATION' }
                        ],
                        remarks: 'Fully complied. Regular bi-monthly EXECOM meetings are conducted with documented minutes and tracked action items.'
                    }
                ]
            },
            {
                id: 'comp_area_2',
                code: 'AREA II',
                title: 'Teaching, Learning and Evaluation',
                progress: 45,
                recommendations: [
                    {
                        id: 1,
                        text: 'Review and update OBE syllabi across all degree programs to align with current CHED memoranda and industry standards.',
                        status: 'Partial',
                        actions: [
                            'Curriculum review committees established per college',
                            'OBE syllabi audit initiated for priority programs',
                            'Industry consultations conducted for selected programs'
                        ],
                        documents: [
                            { name: 'OBE Syllabi Audit Report 2025', type: 'PDF', size: '3.1 MB', date: '2025-07-22', status: 'Verified', uploader: 'Maria Reyes', office: 'Office of Academic Affairs', ocrText: 'OUTCOMES-BASED EDUCATION SYLLABI AUDIT REPORT' }
                        ],
                        remarks: 'OBE syllabi audit is ongoing. Priority programs have completed alignment review. Remaining programs scheduled for completion by end of AY 2025-2026.'
                    },
                    {
                        id: 2,
                        text: 'Enhance faculty development programs on modern pedagogical approaches including blended and flexible learning.',
                        status: 'Fully complied',
                        actions: [
                            'Series of faculty training workshops on blended learning conducted',
                            'LMS training for all faculty members completed',
                            'Flexible learning policy framework adopted'
                        ],
                        documents: [
                            { name: 'Faculty Development Program Report 2025', type: 'PDF', size: '2.4 MB', date: '2025-09-10', status: 'Verified', uploader: 'Maria Reyes', office: 'Office of Academic Affairs', ocrText: 'FACULTY DEVELOPMENT AND PEDAGOGICAL TRAINING REPORT' }
                        ],
                        remarks: 'All faculty members have undergone training on blended learning modalities and LMS usage. Continuing education units credited for participants.'
                    },
                    {
                        id: 3,
                        text: 'Establish a standardized student evaluation system across all colleges.',
                        status: 'Not started',
                        actions: [],
                        documents: [],
                        remarks: 'Awaiting development of a unified online Student Evaluation of Teaching (SET) platform. Currently, colleges use varied formats.'
                    }
                ]
            },
            {
                id: 'comp_area_3',
                code: 'AREA III',
                title: 'Faculty & Staff',
                progress: 55,
                recommendations: [
                    {
                        id: 1,
                        text: 'Address faculty-to-student ratio deficiencies particularly in high-enrollment programs.',
                        status: 'Partial',
                        actions: [
                            'Requests for new faculty plantilla positions submitted to DBM',
                            'Adjunct faculty hiring policy updated',
                            'Part-time faculty engagement guidelines established'
                        ],
                        documents: [
                            { name: 'Faculty Plantilla Request FY 2025', type: 'PDF', size: '1.5 MB', date: '2025-03-10', status: 'Verified', uploader: 'Maria Reyes', office: 'HRMO', ocrText: 'FACULTY PLANTILLA POSITION REQUESTS' }
                        ],
                        remarks: 'DBM requests filed. Adjunct faculty hiring initiated for critical programs. Full plantilla filling subject to national budget approval.'
                    },
                    {
                        id: 2,
                        text: 'Strengthen faculty research competency through structured capacity building programs.',
                        status: 'Fully complied',
                        actions: [
                            'Research methodology training series conducted quarterly',
                            'Research writing workshops with journal editors organized',
                            'Faculty research incentive program established'
                        ],
                        documents: [
                            { name: 'Research Capacity Building Report 2025', type: 'PDF', size: '2.8 MB', date: '2025-08-20', status: 'Verified', uploader: 'Maria Reyes', office: 'RDC Office', ocrText: 'FACULTY RESEARCH CAPACITY BUILDING SUMMARY' },
                            { name: 'Research Incentive Guidelines', type: 'PDF', size: '1.2 MB', date: '2025-01-15', status: 'Verified', uploader: 'Maria Reyes', office: 'RDC Office', ocrText: 'RESEARCH INCENTIVE AND CITATION BONUS SCHEME GUIDELINES' }
                        ],
                        remarks: 'Quarterly training conducted. Faculty research publications increased by 35% compared to previous year.'
                    },
                    {
                        id: 3,
                        text: 'Implement a comprehensive faculty and staff performance management system aligned with CSC guidelines.',
                        status: 'Partial',
                        actions: [
                            'SPMS orientation conducted for all units',
                            'IPCR templates standardized across university'
                        ],
                        documents: [
                            { name: 'SPMS Implementation Report', type: 'PDF', size: '1.8 MB', date: '2025-06-30', status: 'Pending', uploader: 'Maria Reyes', office: 'HRMO', ocrText: 'STRATEGIC PERFORMANCE MANAGEMENT SYSTEM REPORT' }
                        ],
                        remarks: 'SPMS partially implemented. Automated IPCR submission system under development for full digital compliance.'
                    }
                ]
            },
            {
                id: 'comp_area_4',
                code: 'AREA IV',
                title: 'Research',
                progress: 40,
                recommendations: [
                    {
                        id: 1,
                        text: 'Update the institutional research agenda to reflect emerging national priorities and regional development needs.',
                        status: 'Fully complied',
                        actions: [
                            'Research agenda reviewed and updated in consultation with DOST and CHED',
                            'Multi-stakeholder validation workshops conducted',
                            'Updated research agenda approved by the Academic Council'
                        ],
                        documents: [
                            { name: 'BU Institutional Research Agenda 2024-2028', type: 'PDF', size: '2.8 MB', date: '2024-03-12', status: 'Verified', uploader: 'Maria Reyes', office: 'RDC Office', ocrText: 'UNIVERSITY RESEARCH PRIORITIES AND GUIDELINES 2024-2028' }
                        ],
                        remarks: 'Research agenda fully updated and aligned with Harmonized National Research and Development Agenda.'
                    },
                    {
                        id: 2,
                        text: 'Increase research publication output in Scopus/WoS indexed journals.',
                        status: 'Partial',
                        actions: [
                            'Research publication incentive scheme implemented',
                            'Partnership with journal editors for manuscript mentoring',
                            'Writing clinics and manuscript bootcamps conducted'
                        ],
                        documents: [
                            { name: 'Faculty Research Grant Awards Summary 2025', type: 'PDF', size: '1.6 MB', date: '2025-08-20', status: 'Verified', uploader: 'Maria Reyes', office: 'RDC Office', ocrText: 'SUMMARY OF APPROVED INTERNAL RESEARCH GRANTS AND PUBLICATION INCENTIVES' }
                        ],
                        remarks: 'Research output increased but target of 50 Scopus publications per year has not yet been met. Currently at 32 publications.'
                    },
                    {
                        id: 3,
                        text: 'Establish a functional Technology Transfer Office for IP protection and commercialization.',
                        status: 'Not started',
                        actions: [],
                        documents: [],
                        remarks: 'Awaiting organizational restructuring approval. TTO establishment is included in the university development plan for 2026.'
                    }
                ]
            },
            {
                id: 'comp_area_5',
                code: 'AREA V',
                title: 'Extension, Occupancy and Linkages',
                progress: 50,
                recommendations: [
                    {
                        id: 1,
                        text: 'Develop a comprehensive community engagement framework that integrates extension services with research and instruction.',
                        status: 'Partial',
                        actions: [
                            'Community needs assessment conducted in partner barangays',
                            'Extension manual drafted with integration guidelines',
                            'Pilot community engagement projects initiated in 3 municipalities'
                        ],
                        documents: [
                            { name: 'Community Engagement Framework Draft', type: 'PDF', size: '2.5 MB', date: '2025-04-15', status: 'Pending', uploader: 'Maria Reyes', office: 'Extension Office', ocrText: 'COMMUNITY ENGAGEMENT FRAMEWORK AND INTEGRATION GUIDELINES' }
                        ],
                        remarks: 'Framework drafted and undergoing stakeholder consultations. Final version expected by Q1 2026.'
                    },
                    {
                        id: 2,
                        text: 'Strengthen institutional linkages with industry, government agencies, and international partners.',
                        status: 'Fully complied',
                        actions: [
                            'MOAs signed with 15 new industry partners',
                            'International academic exchange agreements with 3 ASEAN universities',
                            'Regular industry-academe roundtable discussions institutionalized'
                        ],
                        documents: [
                            { name: 'MOA Compilation 2024-2025', type: 'PDF', size: '5.2 MB', date: '2025-10-01', status: 'Verified', uploader: 'Maria Reyes', office: 'Extension Office', ocrText: 'MEMORANDA OF AGREEMENT AND INSTITUTIONAL PARTNERSHIPS COMPILATION' },
                            { name: 'International Linkages Report', type: 'PDF', size: '1.8 MB', date: '2025-09-20', status: 'Verified', uploader: 'Maria Reyes', office: 'International Affairs', ocrText: 'INTERNATIONAL ACADEMIC EXCHANGE AND PARTNERSHIP REPORT' }
                        ],
                        remarks: 'Active partnerships established and maintained. Number of institutional linkages increased by 40% from the previous evaluation period.'
                    }
                ]
            },
            {
                id: 'comp_area_6',
                code: 'AREA VI',
                title: 'Support to Students',
                progress: 70,
                recommendations: [
                    {
                        id: 1,
                        text: 'Expand scholarship and financial assistance programs to cover more marginalized students.',
                        status: 'Fully complied',
                        actions: [
                            'Expanded TES and institutional scholarship programs',
                            'Emergency financial assistance fund established',
                            'Student assistantship program broadened to cover more slots'
                        ],
                        documents: [
                            { name: 'Scholarship Recipients & Fund Allocation Summary', type: 'PDF', size: '1.7 MB', date: '2025-09-15', status: 'Verified', uploader: 'Maria Reyes', office: 'OSAS', ocrText: 'FINANCIAL ASSISTANCE AND SCHOLARSHIP SUMMARY' }
                        ],
                        remarks: 'Scholarship coverage increased by 25%. Emergency financial assistance accessed by 150+ students since establishment.'
                    },
                    {
                        id: 2,
                        text: 'Strengthen mental health support services and guidance counseling across all campuses.',
                        status: 'Partial',
                        actions: [
                            'Licensed guidance counselors assigned to main campus',
                            'Mental health awareness programs conducted per semester',
                            'Online counseling platform being developed'
                        ],
                        documents: [
                            { name: 'Guidance & Counseling Annual Report 2025', type: 'PDF', size: '2.0 MB', date: '2025-11-10', status: 'Verified', uploader: 'Maria Reyes', office: 'OSAS', ocrText: 'GUIDANCE AND COUNSELING SERVICES ANNUAL REPORT' }
                        ],
                        remarks: 'Main campus fully covered. Satellite campus counselor deployment still below the ideal ratio. Online counseling platform under development.'
                    },
                    {
                        id: 3,
                        text: 'Establish a comprehensive career services and job placement tracking system.',
                        status: 'Not started',
                        actions: [],
                        documents: [],
                        remarks: 'Career services office restructuring planned. Graduate employment tracking system to be developed as part of the alumni management project.'
                    }
                ]
            },
            {
                id: 'comp_area_7',
                code: 'AREA VII',
                title: 'Library',
                progress: 65,
                recommendations: [
                    {
                        id: 1,
                        text: 'Upgrade digital library infrastructure and expand access to online databases and e-journals.',
                        status: 'Fully complied',
                        actions: [
                            'Subscription to 5 major academic databases renewed and expanded',
                            'E-library portal redesigned with improved search capabilities',
                            'Remote access enabled for all enrolled students and faculty'
                        ],
                        documents: [
                            { name: 'Digital Library Infrastructure Report 2025', type: 'PDF', size: '2.3 MB', date: '2025-07-15', status: 'Verified', uploader: 'Maria Reyes', office: 'University Library', ocrText: 'DIGITAL LIBRARY INFRASTRUCTURE AND E-RESOURCES REPORT' }
                        ],
                        remarks: 'Digital library fully upgraded. Access to major databases like Scopus, JSTOR, and ProQuest available institution-wide.'
                    },
                    {
                        id: 2,
                        text: 'Update physical library collections and ensure adequate book-to-student ratios per program.',
                        status: 'Partial',
                        actions: [
                            'Book acquisition budget increased by 30%',
                            'Priority acquisitions list submitted by all colleges',
                            'Weeding of outdated materials conducted'
                        ],
                        documents: [
                            { name: 'Library Collection Development Report', type: 'PDF', size: '1.5 MB', date: '2025-08-30', status: 'Pending', uploader: 'Maria Reyes', office: 'University Library', ocrText: 'LIBRARY COLLECTION DEVELOPMENT AND ACQUISITION REPORT' }
                        ],
                        remarks: 'Book acquisition ongoing. Some programs still below the recommended book-to-student ratio. Procurement expected to be completed by Q2 2026.'
                    }
                ]
            },
            {
                id: 'comp_area_8',
                code: 'AREA VIII',
                title: 'Infrastructure and Other Learning Sources',
                progress: 35,
                recommendations: [
                    {
                        id: 1,
                        text: 'Modernize classroom facilities and integrate smart classroom technologies across all colleges.',
                        status: 'Partial',
                        actions: [
                            'Smart classroom pilot implemented in 10 rooms',
                            'ICT equipment inventory and assessment completed',
                            'Procurement of additional multimedia equipment initiated'
                        ],
                        documents: [
                            { name: 'Smart Classroom Implementation Report', type: 'PDF', size: '2.6 MB', date: '2025-05-20', status: 'Verified', uploader: 'Maria Reyes', office: 'ICT Office', ocrText: 'SMART CLASSROOM PILOT IMPLEMENTATION AND ASSESSMENT REPORT' }
                        ],
                        remarks: 'Pilot phase completed in 10 classrooms. Full rollout to 50+ rooms planned for 2026 pending budget allocation.'
                    },
                    {
                        id: 2,
                        text: 'Ensure all university buildings comply with updated fire safety, accessibility, and environmental codes.',
                        status: 'Not started',
                        actions: [],
                        documents: [],
                        remarks: 'Building assessment scheduled. Budget for safety compliance upgrades to be included in the next fiscal year capital outlay.'
                    },
                    {
                        id: 3,
                        text: 'Develop additional laboratory and workshop spaces for STEM and technical-vocational programs.',
                        status: 'Partial',
                        actions: [
                            'Feasibility study for new laboratory building completed',
                            'Site identified and approved by the Board of Regents'
                        ],
                        documents: [
                            { name: 'Laboratory Building Feasibility Study', type: 'PDF', size: '3.5 MB', date: '2025-02-28', status: 'Verified', uploader: 'Maria Reyes', office: 'Planning Office', ocrText: 'FEASIBILITY STUDY FOR NEW STEM LABORATORY BUILDING' }
                        ],
                        remarks: 'Feasibility study approved. Construction pending procurement and budget appropriation.'
                    }
                ]
            },
            {
                id: 'comp_area_9',
                code: 'AREA IX',
                title: 'Quality Assurance Culture',
                progress: 75,
                recommendations: [
                    {
                        id: 1,
                        text: 'Institutionalize quality assurance mechanisms across all academic and administrative units.',
                        status: 'Fully complied',
                        actions: [
                            'IQA Office established as a permanent institutional unit',
                            'Quality assurance manual developed and disseminated',
                            'QA orientation conducted for all unit heads and faculty'
                        ],
                        documents: [
                            { name: 'Quality Assurance Manual 2024', type: 'PDF', size: '4.5 MB', date: '2024-08-10', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'INSTITUTIONAL QUALITY ASSURANCE MANUAL AND OPERATIONAL GUIDELINES' },
                            { name: 'IQA Office Establishment Order', type: 'PDF', size: '890 KB', date: '2024-01-15', status: 'Verified', uploader: 'Maria Reyes', office: 'Office of the President', ocrText: 'ADMINISTRATIVE ORDER ESTABLISHING THE IQA OFFICE' }
                        ],
                        remarks: 'IQA Office fully operational. Quality assurance culture embedded in institutional planning and operations.'
                    },
                    {
                        id: 2,
                        text: 'Develop a continuous quality improvement (CQI) framework with measurable KPIs for all programs.',
                        status: 'Partial',
                        actions: [
                            'CQI framework draft completed with stakeholder input',
                            'KPI identification workshops conducted per college',
                            'Pilot CQI implementation in 5 programs'
                        ],
                        documents: [
                            { name: 'CQI Framework Draft Report', type: 'PDF', size: '2.2 MB', date: '2025-10-05', status: 'Pending', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'CONTINUOUS QUALITY IMPROVEMENT FRAMEWORK AND KPI METRICS' }
                        ],
                        remarks: 'CQI framework piloted in 5 programs. Full institutional rollout scheduled for AY 2026-2027.'
                    },
                    {
                        id: 3,
                        text: 'Train faculty and staff on quality assurance standards and self-assessment procedures.',
                        status: 'Fully complied',
                        actions: [
                            'QA training series conducted for all colleges and units',
                            'Self-assessment workshop toolkit developed and distributed',
                            'Online QA resource portal launched on university website'
                        ],
                        documents: [
                            { name: 'QA Training Completion Report', type: 'PDF', size: '1.6 MB', date: '2025-11-15', status: 'Verified', uploader: 'Maria Reyes', office: 'IQA Central Office', ocrText: 'QUALITY ASSURANCE TRAINING COMPLETION AND IMPACT ASSESSMENT' }
                        ],
                        remarks: 'All faculty and staff trained. Self-assessment toolkit accessible through the online QA portal.'
                    }
                ]
            }
        ],

        // ================================================================
        // INSTITUTIONAL SELF-SURVEY – Static Pre-Population Data
        // Used for visual reference when DB has no seeded records.
        // ================================================================
        institutionalSurveyAreas: [
            {
                id: 'ss_area_i1',
                code: 'Area I',
                title: 'Governance and Management',
                color: 'bg-blue-600',
                lightColor: 'bg-blue-50',
                textColor: 'text-blue-700',
                borderColor: 'border-blue-200',
                parameters: [
                    {
                        id: 'ss_param_i1_a',
                        code: 'A',
                        title: 'GOVERNANCE – ORGANIZATIONAL STRUCTURE',
                        sections: {
                            system: [
                                { id: 'ss_s_i1a_1', code: 'S.1', statement: 'The governance of the institution is clearly defined in the organizational structure.' },
                                { id: 'ss_s_i1a_2', code: 'S.2', statement: 'The powers, functions/duties and responsibilities of key officials are clearly delineated.' },
                                { id: 'ss_s_i1a_3', code: 'S.3', statement: 'Administrative and academic councils/bodies exist to assist in decision-making as defined in the organizational structure.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i1a_1', code: 'I.1', statement: 'The policy-making body demonstrates strong leadership and supports the institution\'s programs and operations.' },
                                { id: 'ss_i_i1a_2', code: 'I.2', statement: 'The key officials follow the functional relationship structure in decision-making.' },
                                { id: 'ss_i_i1a_3', code: 'I.3', statement: 'The organizational structure is used in defining the lines of communication and coordination.' },
                                { id: 'ss_i_i1a_4', code: 'I.4', statement: 'The Administrative and Academic Councils function effectively.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i1a_1', code: 'O.1', statement: 'Functions of various units and implementation of programs and projects are well-coordinated.' },
                                { id: 'ss_o_i1a_2', code: 'O.2', statement: 'Conflict in administrative jurisdictions and official relationships are minimal.' },
                                { id: 'ss_o_i1a_3', code: 'O.3', statement: 'Stakeholders feel satisfied in the management of the institution.' },
                                { id: 'ss_o_i1a_4', code: 'O.4', statement: 'Stronger cooperation and coordination among individuals and units are observable.' },
                                { id: 'ss_o_i1a_5', code: 'O.5', statement: 'The governing body demonstrates integrity and objectivity in all transactions in the pursuit of the mission of the institution.' },
                                { id: 'ss_o_i1a_6', code: 'O.6', statement: 'Various stakeholders express satisfaction with openness and transparency in the dissemination of the Governing Body\'s decisions.' }
                            ]
                        }
                    },
                    {
                        id: 'ss_param_i1_b',
                        code: 'B',
                        title: 'PROBITY',
                        sections: {
                            system: [
                                { id: 'ss_s_i1b_1', code: 'S.1', statement: 'Guidelines and protocols are in place.' },
                                { id: 'ss_s_i1b_2', code: 'S.2', statement: 'Major policies and decisions are available.' },
                                { id: 'ss_s_i1b_3', code: 'S.3', statement: 'Policies and decisions are in accordance with existing laws, rules and regulations.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i1b_1', code: 'I.1', statement: 'Key officials exercise sound judgment and prudent decision-making.' },
                                { id: 'ss_i_i1b_2', code: 'I.2', statement: 'Officials are accountable and transparent in all transactions.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i1b_1', code: 'O.1', statement: 'The institution demonstrates integrity and probity in governance.' },
                                { id: 'ss_o_i1b_2', code: 'O.2', statement: 'Stakeholders express confidence in the institution\'s leadership.' }
                            ]
                        }
                    },
                    {
                        id: 'ss_param_i1_c',
                        code: 'C',
                        title: 'PLANNING',
                        sections: {
                            system: [
                                { id: 'ss_s_i1c_1', code: 'S.1', statement: 'A system of planning exists and is operational.' },
                                { id: 'ss_s_i1c_2', code: 'S.2', statement: 'All units participate in the planning process.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i1c_1', code: 'I.1', statement: 'The institutional plan is implemented, monitored, and evaluated.' },
                                { id: 'ss_i_i1c_2', code: 'I.2', statement: 'Resources are allocated according to the institutional plan.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i1c_1', code: 'O.1', statement: 'Goals and targets in the institutional plan are achieved.' },
                                { id: 'ss_o_i1c_2', code: 'O.2', statement: 'The institution is responsive to changes in its external environment.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i2',
                code: 'Area II',
                title: 'Administration',
                color: 'bg-indigo-600',
                lightColor: 'bg-indigo-50',
                textColor: 'text-indigo-700',
                borderColor: 'border-indigo-200',
                parameters: [
                    {
                        id: 'ss_param_i2_a',
                        code: 'A',
                        title: 'ADMINISTRATIVE STAFFING AND PERSONNEL MANAGEMENT',
                        sections: {
                            system: [
                                { id: 'ss_s_i2a_1', code: 'S.1', statement: 'Administrative offices are staffed with qualified personnel meeting civil service requirements.' },
                                { id: 'ss_s_i2a_2', code: 'S.2', statement: 'A merit-based promotion and appointment system exists.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i2a_1', code: 'I.1', statement: 'Personnel policies are implemented fairly and consistently.' },
                                { id: 'ss_i_i2a_2', code: 'I.2', statement: 'Staff development programs are regularly conducted.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i2a_1', code: 'O.1', statement: 'Administrative offices operate efficiently and effectively.' },
                                { id: 'ss_o_i2a_2', code: 'O.2', statement: 'Staff demonstrate competence and professionalism.' }
                            ]
                        }
                    },
                    {
                        id: 'ss_param_i2_b',
                        code: 'B',
                        title: 'FISCAL MANAGEMENT',
                        sections: {
                            system: [
                                { id: 'ss_s_i2b_1', code: 'S.1', statement: 'A budgeting system is established and operational.' },
                                { id: 'ss_s_i2b_2', code: 'S.2', statement: 'Financial reports are regularly prepared and disseminated.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i2b_1', code: 'I.1', statement: 'Budget allocations are in accordance with institutional priorities.' },
                                { id: 'ss_i_i2b_2', code: 'I.2', statement: 'Financial transactions are properly documented and audited.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i2b_1', code: 'O.1', statement: 'The institution demonstrates sound fiscal management.' },
                                { id: 'ss_o_i2b_2', code: 'O.2', statement: 'Resources are utilized efficiently and judiciously.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i3',
                code: 'Area III',
                title: 'Curriculum and Instruction',
                color: 'bg-violet-600',
                lightColor: 'bg-violet-50',
                textColor: 'text-violet-700',
                borderColor: 'border-violet-200',
                parameters: [
                    {
                        id: 'ss_param_i3_a',
                        code: 'A',
                        title: 'CURRICULUM DEVELOPMENT AND IMPLEMENTATION',
                        sections: {
                            system: [
                                { id: 'ss_s_i3a_1', code: 'S.1', statement: 'The institution has clearly defined instructional objectives aligned with its VMGO.' },
                                { id: 'ss_s_i3a_2', code: 'S.2', statement: 'Curricula are regularly reviewed and updated in consultation with stakeholders.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i3a_1', code: 'I.1', statement: 'Faculty implement the approved curriculum effectively.' },
                                { id: 'ss_i_i3a_2', code: 'I.2', statement: 'Innovative pedagogical approaches are employed in instruction.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i3a_1', code: 'O.1', statement: 'Graduates demonstrate competencies expected by industry and society.' },
                                { id: 'ss_o_i3a_2', code: 'O.2', statement: 'Board examination passing rates meet or exceed national averages.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i4',
                code: 'Area IV',
                title: 'Support to Students',
                color: 'bg-emerald-600',
                lightColor: 'bg-emerald-50',
                textColor: 'text-emerald-700',
                borderColor: 'border-emerald-200',
                parameters: [
                    {
                        id: 'ss_param_i4_a',
                        code: 'A',
                        title: 'STUDENT SERVICES AND WELFARE',
                        sections: {
                            system: [
                                { id: 'ss_s_i4a_1', code: 'S.1', statement: 'A comprehensive student handbook is published and disseminated annually.' },
                                { id: 'ss_s_i4a_2', code: 'S.2', statement: 'Guidance and counseling services are available to all students.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i4a_1', code: 'I.1', statement: 'Student organizations are active and duly recognized.' },
                                { id: 'ss_i_i4a_2', code: 'I.2', statement: 'Scholarship and financial assistance programs are operational.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i4a_1', code: 'O.1', statement: 'Students feel adequately supported in their academic journey.' },
                                { id: 'ss_o_i4a_2', code: 'O.2', statement: 'Retention and graduation rates are satisfactory.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i5',
                code: 'Area V',
                title: 'Research',
                color: 'bg-amber-600',
                lightColor: 'bg-amber-50',
                textColor: 'text-amber-700',
                borderColor: 'border-amber-200',
                parameters: [
                    {
                        id: 'ss_param_i5_a',
                        code: 'A',
                        title: 'RESEARCH AGENDA AND PRODUCTION',
                        sections: {
                            system: [
                                { id: 'ss_s_i5a_1', code: 'S.1', statement: 'Research priorities are aligned with regional and national development goals.' },
                                { id: 'ss_s_i5a_2', code: 'S.2', statement: 'A research agenda is formulated and approved.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i5a_1', code: 'I.1', statement: 'Faculty engage in research activities aligned with the university research agenda.' },
                                { id: 'ss_i_i5a_2', code: 'I.2', statement: 'Research outputs are published in reputable journals.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i5a_1', code: 'O.1', statement: 'Research outputs contribute to knowledge and community development.' },
                                { id: 'ss_o_i5a_2', code: 'O.2', statement: 'The institution receives research recognition and awards.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i6',
                code: 'Area VI',
                title: 'Extension and Community Involvement',
                color: 'bg-orange-600',
                lightColor: 'bg-orange-50',
                textColor: 'text-orange-700',
                borderColor: 'border-orange-200',
                parameters: [
                    {
                        id: 'ss_param_i6_a',
                        code: 'A',
                        title: 'EXTENSION PROGRAMS AND SERVICES',
                        sections: {
                            system: [
                                { id: 'ss_s_i6a_1', code: 'S.1', statement: 'Community extension programs are designed based on community needs assessment.' },
                                { id: 'ss_s_i6a_2', code: 'S.2', statement: 'Extension activities are aligned with the institutional VMGO.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i6a_1', code: 'I.1', statement: 'Faculty and students actively participate in extension activities.' },
                                { id: 'ss_i_i6a_2', code: 'I.2', statement: 'Community partners are engaged in co-implementing programs.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i6a_1', code: 'O.1', statement: 'Extension programs create measurable positive impact on communities.' },
                                { id: 'ss_o_i6a_2', code: 'O.2', statement: 'The institution is recognized as a partner in community development.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i7',
                code: 'Area VII',
                title: 'Library',
                color: 'bg-teal-600',
                lightColor: 'bg-teal-50',
                textColor: 'text-teal-700',
                borderColor: 'border-teal-200',
                parameters: [
                    {
                        id: 'ss_param_i7_a',
                        code: 'A',
                        title: 'LIBRARY HOLDINGS AND RESOURCES',
                        sections: {
                            system: [
                                { id: 'ss_s_i7a_1', code: 'S.1', statement: 'Adequate physical and digital academic reference holdings are available for university programs.' },
                                { id: 'ss_s_i7a_2', code: 'S.2', statement: 'The library has a system for acquisition, cataloging, and circulation.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i7a_1', code: 'I.1', statement: 'Library resources are regularly updated and maintained.' },
                                { id: 'ss_i_i7a_2', code: 'I.2', statement: 'Electronic databases and e-resources are accessible to students and faculty.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i7a_1', code: 'O.1', statement: 'Students and faculty make effective use of library resources.' },
                                { id: 'ss_o_i7a_2', code: 'O.2', statement: 'Library holdings meet accreditation standards.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i8',
                code: 'Area VIII',
                title: 'Physical Plant and Facilities',
                color: 'bg-rose-600',
                lightColor: 'bg-rose-50',
                textColor: 'text-rose-700',
                borderColor: 'border-rose-200',
                parameters: [
                    {
                        id: 'ss_param_i8_a',
                        code: 'A',
                        title: 'BUILDINGS AND CAMPUS FACILITIES',
                        sections: {
                            system: [
                                { id: 'ss_s_i8a_1', code: 'S.1', statement: 'University buildings comply with environmental, safety, and fire protection codes.' },
                                { id: 'ss_s_i8a_2', code: 'S.2', statement: 'Facilities are adequate, well-maintained, and safe for use.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i8a_1', code: 'I.1', statement: 'Regular inspection and maintenance of facilities are conducted.' },
                                { id: 'ss_i_i8a_2', code: 'I.2', statement: 'Facility improvement plans are implemented systematically.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i8a_1', code: 'O.1', statement: 'The campus environment is conducive to learning and working.' },
                                { id: 'ss_o_i8a_2', code: 'O.2', statement: 'All buildings and facilities meet safety standards.' }
                            ]
                        }
                    }
                ]
            },
            {
                id: 'ss_area_i9',
                code: 'Area IX',
                title: 'Laboratories',
                color: 'bg-cyan-600',
                lightColor: 'bg-cyan-50',
                textColor: 'text-cyan-700',
                borderColor: 'border-cyan-200',
                parameters: [
                    {
                        id: 'ss_param_i9_a',
                        code: 'A',
                        title: 'LABORATORY FACILITIES AND EQUIPMENT',
                        sections: {
                            system: [
                                { id: 'ss_s_i9a_1', code: 'S.1', statement: 'Specialized laboratory rooms are fully equipped with working research apparatuses.' },
                                { id: 'ss_s_i9a_2', code: 'S.2', statement: 'Safety protocols and equipment are in place in all laboratories.' }
                            ],
                            implementation: [
                                { id: 'ss_i_i9a_1', code: 'I.1', statement: 'Laboratory equipment is regularly calibrated and maintained.' },
                                { id: 'ss_i_i9a_2', code: 'I.2', statement: 'Students follow laboratory safety rules and procedures.' }
                            ],
                            outcome: [
                                { id: 'ss_o_i9a_1', code: 'O.1', statement: 'Laboratory facilities support quality research and learning.' },
                                { id: 'ss_o_i9a_2', code: 'O.2', statement: 'Students demonstrate practical competencies through laboratory work.' }
                            ]
                        }
                    }
                ]
            }
        ],

        selectedCategory: null,
        searchQuery: '',
        filterType: 'all',
        filterOffice: 'all',
        filterDate: 'all',
        filterStatus: 'all',
        showDrawer: false,
        selectedDoc: {
            name: '',
            size: '',
            date: '',
            uploader: '',
            office: '',
            type: '',
            status: '',
            ocrText: '',
            fileUrl: ''
        },

        get activeAccredData() {
            if (!this.accredLevel) return null;
            return this.accredData[this.accredLevel];
        },

        get availableColleges() {
            const defaultCollegeMeta = {
                'CS': { code: 'CS', name: 'BU College of Science', iconBg: 'bg-blue-50 text-[#1b355a]', description: 'Computer Science, Information Technology, Biology, Chemistry' },
                'CENG': { code: 'CENG', name: 'BU College of Engineering', iconBg: 'bg-amber-50 text-amber-700', description: 'Civil, Mechanical, and Electrical Engineering' },
                'CAL': { code: 'CAL', name: 'BU College of Arts & Letters', iconBg: 'bg-rose-50 text-rose-700', description: 'Communication, Languages, Humanities' },
                'CED': { code: 'CED', name: 'BU College of Education', iconBg: 'bg-purple-50 text-purple-700', description: 'Elementary and Secondary Teacher Education' },
                'CN': { code: 'CN', name: 'BU College of Nursing', iconBg: 'bg-teal-50 text-teal-700', description: 'Nursing and Health Sciences' },
                'CBEM': { code: 'CBEM', name: 'BU College of Business, Economics & Management', iconBg: 'bg-emerald-50 text-emerald-700', description: 'Business Administration, Accountancy, Economics' }
            };

            let list = [];

            if (this.collegesList && this.collegesList.length > 0) {
                list = this.collegesList.map(c => {
                    const code = c.code || (c.name ? c.name.split(' ').pop() : 'COL');
                    const meta = defaultCollegeMeta[code] || { code, name: c.name, iconBg: 'bg-slate-100 text-[#1b355a]', description: 'Academic College Unit' };
                    const count = this.programsList.filter(p => p.college_id === c.id || p.collegeCode === code || (p.college && p.college.toLowerCase().includes(c.name.toLowerCase()))).length;
                    return {
                        id: c.id || code,
                        code: code,
                        name: c.name || meta.name,
                        description: meta.description,
                        iconBg: meta.iconBg,
                        programCount: count
                    };
                });
            } else {
                const codes = ['CS', 'CENG', 'CAL', 'CED', 'CN', 'CBEM'];
                list = codes.map(code => {
                    const meta = defaultCollegeMeta[code];
                    const count = this.programsList.filter(p => p.collegeCode === code || (p.college && p.college.includes(meta.name))).length;
                    return {
                        id: code.toLowerCase(),
                        code: code,
                        name: meta.name,
                        description: meta.description,
                        iconBg: meta.iconBg,
                        programCount: count
                    };
                });
            }

            if (this.collegeSearchQuery) {
                const q = this.collegeSearchQuery.toLowerCase().trim();
                list = list.filter(c => c.name.toLowerCase().includes(q) || c.code.toLowerCase().includes(q) || (c.description && c.description.toLowerCase().includes(q)));
            }

            return list;
        },

        selectCollege(college) {
            this.accredCollege = college;
            this.accredProgram = null;
            this.accredCategory = null;
            this.programSearchQuery = '';
        },

        clearCollege() {
            this.accredCollege = null;
            this.accredProgram = null;
            this.accredCategory = null;
            this.collegeSearchQuery = '';
        },

        get filteredPrograms() {
            return this.programsList.filter(prog => {
                if (this.accredCollege) {
                    const selectedCode = this.accredCollege.code;
                    const selectedId = this.accredCollege.id;
                    const matchCollege = (prog.collegeCode && prog.collegeCode === selectedCode) ||
                        (prog.college_id && prog.college_id === selectedId) ||
                        (prog.college && this.accredCollege.name && prog.college.toLowerCase().includes(this.accredCollege.name.toLowerCase()));
                    if (!matchCollege) return false;
                } else if (this.programCollegeFilter !== 'all' && prog.collegeCode !== this.programCollegeFilter) {
                    return false;
                }
                if (this.programSearchQuery) {
                    const query = this.programSearchQuery.toLowerCase().trim();
                    const match = prog.name.toLowerCase().includes(query) ||
                        prog.code.toLowerCase().includes(query) ||
                        (prog.college && prog.college.toLowerCase().includes(query)) ||
                        (prog.level && prog.level.toLowerCase().includes(query));
                    if (!match) return false;
                }
                return true;
            });
        },

        selectProgram(prog) {
            this.accredProgram = prog;
            this.accredCategory = null;
        },

        clearProgram() {
            this.accredProgram = null;
            this.accredCategory = null;
        },

        get activeArea() {
            const data = this.activeAccredData;
            if (!data) return null;
            return data.areas.find(a => a.id === this.accredActiveAreaId) || data.areas[0];
        },

        get activeParam() {
            const area = this.activeArea;
            if (!area) return null;
            return area.parameters.find(p => p.id === this.accredActiveParamId) || area.parameters[0];
        },

        get activeChecklistItems() {
            const param = this.activeParam;
            if (!param) return [];
            return param.sections[this.accredActiveSection] || [];
        },

        selectArea(areaId) {
            this.accredActiveAreaId = areaId;
            const area = this.activeAccredData.areas.find(a => a.id === areaId);
            if (area && area.parameters.length > 0) {
                this.accredActiveParamId = area.parameters[0].id;
            } else {
                this.accredActiveParamId = null;
            }
            this.accredActiveSection = 'systems';
        },

        // ── Compliance Report helpers ────────────────────────────────

        get activeComplianceArea() {
            return this.complianceReports.find(a => a.id === this.complianceActiveAreaId) || this.complianceReports[0];
        },

        selectComplianceArea(areaId) {
            this.complianceActiveAreaId = areaId;
        },

        complianceStats(area) {
            if (!area || !area.recommendations) return { total: 0, complied: 0, partial: 0, notStarted: 0 };
            const recs = area.recommendations;
            return {
                total: recs.length,
                complied: recs.filter(r => r.status === 'Fully complied').length,
                partial: recs.filter(r => r.status === 'Partial').length,
                notStarted: recs.filter(r => r.status === 'Not started').length
            };
        },

        // ── Self-Survey helpers ──────────────────────────────────────

        /** Open a survey area table; load saved ratings from DB */
        selectSurveyArea(areaId) {
            this.selfSurveyActiveAreaId = areaId;
            this.loadSurveyRatings(areaId);
        },

        /** Fetch saved ratings for this area from the server */
        loadSurveyRatings(areaId) {
            const area = this.institutionalSurveyAreas.find(a => a.id === areaId);
            if (!area) return;
            // Collect all indicator IDs for this area to initialise the map
            area.parameters.forEach(param => {
                Object.values(param.sections).forEach(indicators => {
                    indicators.forEach(ind => {
                        if (!(ind.id in this.selfSurveyRatings)) {
                            this.selfSurveyRatings[ind.id] = null;
                        }
                    });
                });
            });
            // No DB seeded yet – ratings stay as null until user sets them
        },

        /** Compute the mean of IR values for a given array of indicators */
        sectionMean(indicators) {
            if (!indicators.length) return null;
            
            // Filter out NA so they are completely excluded from calculations
            const validIndicators = indicators.filter(ind => this.selfSurveyRatings[ind.id] !== 'NA');
            if (!validIndicators.length) return null;

            const rated = validIndicators
                .map(ind => this.selfSurveyRatings[ind.id])
                .filter(v => v !== null && v !== undefined && v !== '');
                
            if (!rated.length) return null;
            
            // Divide by total valid indicators (not just rated) so partial completion shows partial progress
            return (rated.reduce((s, v) => s + Number(v), 0) / validIndicators.length).toFixed(2);
        },

        /** Compute PM: average of non-null section means for a parameter */
        paramMean(param) {
            const means = ['system', 'implementation', 'outcome']
                .map(sec => this.sectionMean(param.sections[sec] || []))
                .filter(v => v !== null);
            if (!means.length) return null;
            return (means.reduce((s, v) => s + Number(v), 0) / means.length).toFixed(2);
        },

        /** Compute area completion as 0-100 percentage (for the tab strip progress bar).
         *  Counts how many indicators have ANY rating (including 0) out of the total. */
        areaMeanPct(area) {
            if (!area || !area.parameters || !area.parameters.length) return 0;
            let total = 0;
            let rated = 0;
            for (const param of area.parameters) {
                const allIndicators = [
                    ...(param.sections.system || []),
                    ...(param.sections.implementation || []),
                    ...(param.sections.outcome || []),
                ];
                total += allIndicators.length;
                rated += allIndicators.filter(ind => {
                    const v = this.selfSurveyRatings[ind.id];
                    return v !== null && v !== undefined && v !== '';
                }).length;
            }
            if (!total) return 0;
            return Math.round((rated / total) * 100);
        },

        /** Returns true when every mandatory indicator (system, implementation, outcome)
         *  in the given area has a rating selected (not empty). Best Practices are optional. */
        isAreaComplete(areaId) {
            if (!areaId) return false;
            const area = this.institutionalSurveyAreas.find(a => a.id === areaId);
            if (!area) return false;
            for (const param of area.parameters) {
                const mandatoryIndicators = [
                    ...(param.sections.system || []),
                    ...(param.sections.implementation || []),
                    ...(param.sections.outcome || []),
                ];
                for (const ind of mandatoryIndicators) {
                    const val = this.selfSurveyRatings[ind.id];
                    if (val === null || val === undefined || val === '') return false;
                }
            }
            return true;
        },

        /** Save a single IR rating to the server (debounced) */
        saveRating(indicatorId, value) {
            const finalValue = value === '' ? null : (value === 'NA' ? 'NA' : Number(value));
            this.selfSurveyRatings[indicatorId] = finalValue;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch('/api/self-survey/ratings', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ indicator_id: indicatorId, rating: finalValue })
            }).catch(err => console.warn('Rating save failed (offline mode):', err));
        },

        saveBestPractice(paramId, value) {
            this.selfSurveyBestPractices[paramId] = value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch('/api/self-survey/best-practices', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ param_id: paramId, best_practice: value })
            }).catch(err => console.warn('Best practice save failed (offline mode):', err));
        },

        submitSelfSurvey() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Self-Survey Submitted',
                    text: 'The self-survey for this area has been successfully submitted.',
                    confirmButtonColor: '#059669', // emerald-600
                });
            } else {
                alert('Self-survey has been submitted.');
            }
        },
        categories: [],
        documents: [],
        offices: [],
        selectedOffice: null,

        get filteredOffices() {
            let filterOffices = this.offices;
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filterOffices = filterOffices.filter(o =>
                    o.name.toLowerCase().includes(query) ||
                    (o.description && o.description.toLowerCase().includes(query))
                );
            }
            return filterOffices;
        },

        get filteredCategories() {
            if (this.selectedOffice === null || this.selectedCategory !== null) return [];
            let cats = this.categories;
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                cats = cats.filter(c =>
                    c.name.toLowerCase().includes(query) ||
                    c.description.toLowerCase().includes(query)
                );
            }
            return [...cats].sort((a, b) => {
                const aIsUncat = a.name.toLowerCase().includes('uncategorized');
                const bIsUncat = b.name.toLowerCase().includes('uncategorized');
                if (aIsUncat && !bIsUncat) return 1;
                if (!aIsUncat && bIsUncat) return -1;
                return 0;
            });
        },

        get filteredDocuments() {
            if (!this.selectedCategory) return [];
            return this.documents.filter(doc => {
                if (doc.category !== this.selectedCategory) return false;

                // Search filter
                if (this.searchQuery) {
                    const query = this.searchQuery.toLowerCase();
                    const matchesSearch = doc.name.toLowerCase().includes(query) ||
                        doc.uploader.toLowerCase().includes(query) ||
                        doc.ocrText.toLowerCase().includes(query);
                    if (!matchesSearch) return false;
                }

                // Type filter
                if (this.filterType !== 'all' && doc.type !== this.filterType) return false;

                // Office filter
                if (this.filterOffice !== 'all' && doc.office !== this.filterOffice) return false;

                // Date filter
                if (this.filterDate !== 'all' && !doc.date.startsWith(this.filterDate)) return false;

                // Status filter
                if (this.filterStatus !== 'all' && doc.status !== this.filterStatus) return false;

                return true;
            });
        },

        selectOffice(officeId) {
            this.selectedOffice = officeId;
            this.selectedCategory = null;
            this.searchQuery = '';
            this.initCategories(officeId);
        },

        selectCategory(catName) {
            this.selectedCategory = catName;
            this.searchQuery = ''; // Reset search query when switching views
            this.filterType = 'all';
            this.filterOffice = 'all';
            this.filterDate = 'all';
            this.filterStatus = 'all';
        },

        openDoc(doc) {
            this.selectedDoc = doc;
            this.showDrawer = true;
        },

        closeDrawer() {
            this.showDrawer = false;
        },

        async updateDocStatus(doc, newStatus) {
            if (!doc) return;
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const response = await fetch(`/api/common-documents/${doc.id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || data.error || 'Failed to update document status.');
                }

                doc.status = newStatus;
                if (this.selectedDoc && this.selectedDoc.id === doc.id) {
                    this.selectedDoc.status = newStatus;
                }

                Swal.fire({
                    title: 'Status Updated!',
                    text: data.message || `Document marked as ${newStatus}.`,
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                this.initCategories(this.selectedOffice);
            } catch (error) {
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'An error occurred while updating status.',
                    icon: 'error',
                    confirmButtonColor: '#F47920'
                });
            }
        },

        approveDoc() {
            if (this.selectedDoc) {
                this.updateDocStatus(this.selectedDoc, 'Verified');
                this.closeDrawer();
            }
        },

        rejectDoc() {
            if (this.selectedDoc) {
                this.updateDocStatus(this.selectedDoc, 'Rejected');
                this.closeDrawer();
            }
        },

        async deleteDoc(doc) {
            if (!doc) return;

            const result = await Swal.fire({
                title: 'Delete Document?',
                text: `Are you sure you want to permanently delete "${doc.name}"? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#3b82f6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-2xl border border-slate-200/60 shadow-lg font-sans',
                    title: 'text-[#1b355a] font-bold text-xl',
                    confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white',
                    cancelButton: 'px-6 py-2.5 rounded-xl font-semibold text-zinc-700 bg-slate-100 hover:bg-slate-200'
                }
            });

            if (result.isConfirmed) {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    const response = await fetch(`/api/common-documents/${doc.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Failed to delete document');
                    }

                    Swal.fire({
                        title: 'Deleted!',
                        text: data.message || 'Your document has been deleted.',
                        icon: 'success',
                        confirmButtonColor: '#F47920',
                        customClass: {
                            popup: 'rounded-2xl border border-slate-200/60 shadow-lg font-sans',
                            title: 'text-[#1b355a] font-bold text-xl',
                            confirmButton: 'px-6 py-2.5 rounded-xl font-semibold text-white'
                        }
                    });

                    this.documents = this.documents.filter(d => d.id !== doc.id);

                    if (this.selectedDoc && this.selectedDoc.id === doc.id) {
                        this.closeDrawer();
                    }

                    this.initCategories(this.selectedOffice);

                } catch (error) {
                    Swal.fire({
                        title: 'Error',
                        text: error.message || 'An error occurred while deleting the document.',
                        icon: 'error',
                        confirmButtonColor: '#F47920'
                    });
                }
            }
        },

        showCollegeModal: false,
        collegeForm: { id: null, name: '', code: '' },

        showProgramModal: false,
        programForm: { id: null, name: '', code: '', college_id: '', accreditation_level: 'Candidate' },
        collegesList: [],

        openCreateCollegeModal() {
            this.collegeForm = { id: null, name: '', code: '' };
            this.showCollegeModal = true;
        },
        openEditCollegeModal(college) {
            this.collegeForm = { id: college.id, name: college.name, code: college.code };
            this.showCollegeModal = true;
        },
        closeCollegeModal() {
            this.showCollegeModal = false;
        },
        async saveCollege() {
            if (!this.collegeForm.name || !this.collegeForm.code) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Name and Code are required.', confirmButtonColor: '#1b355a' });
                return;
            }
            const isEdit = !!this.collegeForm.id;
            const url = isEdit ? `/api/colleges/${this.collegeForm.id}` : '/api/colleges';
            const method = isEdit ? 'PUT' : 'POST';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                const res = await fetch(url, {
                    method,
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(this.collegeForm)
                });
                if (!res.ok) throw await res.json();
                Swal.fire({ icon: 'success', title: 'Success', text: 'College saved successfully.', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                this.closeCollegeModal();
                this.initBackendData();
            } catch (err) {
                let errorMsg = err.message || 'Failed to save college.';
                if (err.errors) {
                    errorMsg = Object.values(err.errors).flat().join('<br>');
                }
                Swal.fire({ icon: 'error', title: 'Error', html: errorMsg, confirmButtonColor: '#1b355a' });
            }
        },
        async confirmDeleteCollege(college) {
            const result = await Swal.fire({
                title: 'Delete College?',
                text: `Are you sure you want to delete ${college.name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!'
            });
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                try {
                    const res = await fetch(`/api/colleges/${college.id}`, {
                        method: 'DELETE',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                    });
                    if (!res.ok) throw await res.json();
                    Swal.fire({ icon: 'success', title: 'Deleted', text: 'College deleted.', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                    this.initBackendData();
                    if (this.accredCollege && this.accredCollege.id === college.id) {
                        this.clearCollege();
                    }
                } catch (err) {
                    Swal.fire({ icon: 'error', title: 'Error', text: err.error || 'Failed to delete college.', confirmButtonColor: '#1b355a' });
                }
            }
        },

        openAddProgramModal() {
            this.programForm = { id: null, name: '', code: '', college_id: this.accredCollege?.id || (this.collegesList[0]?.id || ''), accreditation_level: 'Candidate' };
            this.showProgramModal = true;
        },
        openEditProgramModal(program) {
            this.programForm = { id: program.id, name: program.name, code: program.code, college_id: program.college_id, accreditation_level: program.level || 'Candidate' };
            this.showProgramModal = true;
        },
        closeProgramModal() {
            this.showProgramModal = false;
        },
        async saveProgram() {
            if (!this.programForm.name || !this.programForm.code || !this.programForm.college_id) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Name, Code, and College are required.', confirmButtonColor: '#1b355a' });
                return;
            }
            const isEdit = !!this.programForm.id;
            const url = isEdit ? `/api/programs/${this.programForm.id}` : '/api/programs';
            const method = isEdit ? 'PUT' : 'POST';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                const res = await fetch(url, {
                    method,
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(this.programForm)
                });
                if (!res.ok) throw await res.json();
                Swal.fire({ icon: 'success', title: 'Success', text: 'Program saved successfully.', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                this.closeProgramModal();
                this.initBackendData();
            } catch (err) {
                let errorMsg = err.message || 'Failed to save program.';
                if (err.errors) {
                    errorMsg = Object.values(err.errors).flat().join('<br>');
                }
                Swal.fire({ icon: 'error', title: 'Error', html: errorMsg, confirmButtonColor: '#1b355a' });
            }
        },
        async confirmDeleteProgram(program) {
            const result = await Swal.fire({
                title: 'Delete Program?',
                text: `Are you sure you want to delete ${program.name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!'
            });
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                try {
                    const res = await fetch(`/api/programs/${program.id}`, {
                        method: 'DELETE',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                    });
                    if (!res.ok) throw await res.json();
                    Swal.fire({ icon: 'success', title: 'Deleted', text: 'Program deleted.', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                    this.initBackendData();
                    if (this.accredProgram && this.accredProgram.id === program.id) {
                        this.clearProgram();
                    }
                } catch (err) {
                    Swal.fire({ icon: 'error', title: 'Error', text: err.error || 'Failed to delete program.', confirmButtonColor: '#1b355a' });
                }
            }
        },

        init() {
            this.initBackendData();

            // Sync accredLevel on initial load
            if (this.activeTab === 'institutional-accreditation') {
                this.accredLevel = 'institutional';
                if (!this.accredActiveAreaId || this.accredActiveAreaId.startsWith('area_p')) {
                    this.accredActiveAreaId = 'area_i1';
                    this.accredActiveParamId = 'param_i1_a';
                }
            } else if (this.activeTab === 'program-accreditation') {
                this.accredLevel = 'program';
                if (!this.accredActiveAreaId || this.accredActiveAreaId.startsWith('area_i')) {
                    this.accredActiveAreaId = 'area_p1';
                    this.accredActiveParamId = 'param_p1_a';
                }
            }

            // Sync accredLevel whenever activeTab changes
            this.$watch('activeTab', (newTab) => {
                if (newTab === 'institutional-accreditation') {
                    this.accredLevel = 'institutional';
                    this.accredCategory = null;
                    if (!this.accredActiveAreaId || this.accredActiveAreaId.startsWith('area_p')) {
                        this.accredActiveAreaId = 'area_i1';
                        this.accredActiveParamId = 'param_i1_a';
                    }
                } else if (newTab === 'program-accreditation') {
                    this.accredLevel = 'program';
                    this.accredCategory = null;
                    if (!this.accredActiveAreaId || this.accredActiveAreaId.startsWith('area_i')) {
                        this.accredActiveAreaId = 'area_p1';
                        this.accredActiveParamId = 'param_p1_a';
                    }
                }
            });

            // Check URL parameters for status filter or category
            const urlParams = new URLSearchParams(window.location.search);
            const statusParam = urlParams.get('status');
            const categoryParam = urlParams.get('category');

            if (statusParam) {
                this.filterStatus = statusParam;
            }
            if (categoryParam) {
                this.selectedCategory = categoryParam;
            }
        },

        initBackendData() {
            fetch('/api/programs')
                .then(res => res.json())
                .then(data => {
                    if (Array.isArray(data) && data.length > 0) {
                        this.programsList = data;
                    }
                })
                .catch(err => console.error('Error fetching programs from backend:', err));

            fetch('/api/colleges')
                .then(res => res.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        this.collegesList = data;
                        if (data.length > 0 && !this.newProgram.college_id) {
                            this.newProgram.college_id = data[0].id;
                        }
                    }
                })
                .catch(err => console.error('Error fetching colleges:', err));

            fetch('/api/offices')
                .then(res => res.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        this.offices = data;
                    }
                })
                .catch(err => console.error('Error fetching offices:', err));
        },

        initCategories(officeId = null) {
            if (!officeId) {
                this.categories = [];
                this.documents = [];
                return;
            }
            // Fetch categories from backend
            fetch(`/api/categories?office_id=${officeId}`)
                .then(res => res.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        this.categories = data.map(dbCat => ({
                            id: 'cat_' + dbCat.id,
                            name: dbCat.name,
                            description: dbCat.description || ('Common document category for ' + dbCat.name),
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>`,
                            docCount: dbCat.docCount || 0
                        }));
                    }
                })
                .catch(err => console.error('Error fetching categories from backend:', err));

            // Fetch common documents from backend
            fetch(`/api/common-documents?office_id=${officeId}`)
                .then(res => res.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        this.documents = data;
                    }
                })
                .catch(err => console.error('Error fetching common documents:', err));
        },

        // Category Creation Modal state & methods (IQA Admin & System Admin only)
        showCreateCategoryModal: false,
        createCategoryLoading: false,
        createCategoryError: '',
        createCategorySuccess: '',
        newCategoryForm: {
            name: '',
            description: ''
        },

        openCreateCategoryModal() {
            this.createCategoryError = '';
            this.createCategorySuccess = '';
            this.showCreateCategoryModal = true;
            this.newCategoryForm = { name: '', description: '' };
        },

        closeCreateCategoryModal() {
            this.showCreateCategoryModal = false;
        },

        submitNewCategory() {
            this.createCategoryError = '';
            this.createCategorySuccess = '';

            if (!this.newCategoryForm.name.trim()) {
                this.createCategoryError = 'Category name is required.';
                return;
            }

            this.createCategoryLoading = true;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            fetch('/api/categories', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(this.newCategoryForm)
            })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) throw new Error(data.message || data.error || 'Failed to create Document Category.');
                    return data;
                })
                .then(data => {
                    this.createCategoryLoading = false;
                    this.createCategorySuccess = 'Document Category card created successfully!';

                    if (data.category) {
                        this.categories.push({
                            id: 'cat_' + data.category.id,
                            name: data.category.name,
                            description: data.category.description || 'Common document category',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>`,
                            docCount: 0
                        });
                    }

                    setTimeout(() => {
                        this.closeCreateCategoryModal();
                        this.createCategorySuccess = '';
                    }, 1000);
                })
                .catch(err => {
                    this.createCategoryLoading = false;
                    this.createCategoryError = err.message || 'An error occurred while creating the category.';
                });
        },

        // Upload Document Modal state & methods
        showUploadModal: false,
        uploadLoading: false,
        uploadError: '',
        uploadSuccess: '',
        uploadForm: {
            title: '',
            category_name: '',
            file: null
        },

        openUploadModal() {
            this.uploadError = '';
            this.uploadSuccess = '';
            this.showUploadModal = true;
            this.uploadForm.category_name = this.selectedCategory || '';
            this.uploadForm.file = null;
        },

        closeUploadModal() {
            this.showUploadModal = false;
        },

        submitUploadDocument() {
            this.uploadError = '';
            this.uploadSuccess = '';

            if (!this.uploadForm.title.trim()) {
                this.uploadError = 'Document title is required.';
                return;
            }

            this.uploadLoading = true;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const targetCategory = this.uploadForm.category_name || 'Uncategorized Documents';

            const formData = new FormData();
            formData.append('title', this.uploadForm.title);
            if (this.uploadForm.category_name) {
                formData.append('category_name', this.uploadForm.category_name);
            }
            if (this.uploadForm.file) {
                formData.append('file', this.uploadForm.file);
            }
            if (this.selectedOffice) {
                formData.append('office_id', this.selectedOffice);
            }

            fetch('/api/common-documents', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) throw new Error(data.message || data.error || 'Failed to upload document.');
                    return data;
                })
                .then(data => {
                    this.uploadLoading = false;
                    this.uploadSuccess = 'Document uploaded successfully!';

                    if (data.document) {
                        this.documents.unshift(data.document);
                    }

                    const catObj = this.categories.find(c => c.name.toLowerCase() === targetCategory.toLowerCase());
                    if (catObj) {
                        catObj.docCount = (catObj.docCount || 0) + 1;
                    }

                    setTimeout(() => {
                        this.closeUploadModal();
                        this.uploadForm = { title: '', category_name: '', file: null };
                        this.uploadSuccess = '';
                    }, 1000);
                })
                .catch(err => {
                    this.uploadLoading = false;
                    this.uploadError = err.message || 'An error occurred while uploading.';
                });
        },

        // ================================================================
        // NARRATIVE PROFILE — Methods
        // ================================================================

        initNarrativeProfile() {
            this.npActiveAreaId = this.npAreas[0].id;
        },

        getDefaultNPTemplate(areaId) {
            const area = this.npAreas.find(a => a.id === areaId);
            if (!area) return '';
            const programName = this.accredProgram ? this.accredProgram.name : '___________________________';
            return `
                <p style="font-size:14pt; font-weight:bold; text-align:center; margin-bottom: 20px; color:#1b355a;">B. AACCUP Template for Level 3 Narrative Profile</p>
                <table style="width:100%; border:none; margin-bottom:24px; font-size:12pt;">
                    <tbody>
                        <tr style="border:none;">
                            <td style="width:180px; padding:6px 0; font-weight:bold; border:none;">Program:</td>
                            <td style="border-bottom:1px solid #1a1a1a; padding:6px 8px; border-top:none; border-left:none; border-right:none; font-weight:600; color:#1b355a;">${programName}</td>
                        </tr>
                        <tr style="border:none;">
                            <td style="padding:6px 0; font-weight:bold; border:none;">Area (Mandatory):</td>
                            <td style="border-bottom:1px solid #1a1a1a; padding:6px 8px; border-top:none; border-left:none; border-right:none; font-weight:600; color:#1b355a;">${area.code} &ndash; ${area.title}</td>
                        </tr>
                    </tbody>
                </table>
                <ol style="font-size:12pt; line-height:2.2; padding-left:28px; margin:0;">
                    <li style="margin-bottom:14px;"><strong>Well-defined Objectives</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Enter narrative description of well-defined objectives and strategic intent here...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Adequate and Relevant Projects/Activities to Achieve Objectives</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Enter relevant projects, academic activities, and implementation strategies here...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Systematic and Effective Procedures</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Describe operational workflows, monitoring systems, and evaluation procedures here...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Reasonable Budget</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Detail budget allocations, fund utilization, and financial sustainability here...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Provision of Materials and Other Resources</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[List learning resources, facilities, equipment, and laboratory provisions here...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Participation of Significant Number of Faculty/Staff/Students/Community in Major Projects/Activities</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Document stakeholder engagement, faculty involvement, and community outreach data here...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Awards of Distinction and Achievement and Grants of this Program. &ldquo;Best Practices&rdquo; adopted.</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Highlight recognitions, accreditations, research grants, and institutional best practices here...]</p></li>
                </ol>
            `;
        },

        openNPEditor(areaId) {
            this.npEditorAreaId = areaId;
            this.npEditorSaved = false;
            this.autoSaveStatus = 'saved';
            this.npEditorOpen = true;

            const initialContent = this.npDocContents[areaId] && this.npDocContents[areaId].content
                ? this.npDocContents[areaId].content
                : this.getDefaultNPTemplate(areaId);

            this.$nextTick(() => {
                const el = document.getElementById('np-editor-sheet');
                if (el) {
                    el.innerHTML = initialContent;
                    setTimeout(() => {
                        el.focus();
                    }, 50);
                }
            });
        },

        saveNPEditor() {
            if (!this.npEditorAreaId) return;
            const el = document.getElementById('np-editor-sheet');
            const content = el ? el.innerHTML : '';

            if (!this.npDocContents[this.npEditorAreaId]) {
                this.npDocContents[this.npEditorAreaId] = {};
            }
            this.npDocContents[this.npEditorAreaId].content = content;
            this.npDocContents[this.npEditorAreaId].lastSaved = new Date();
            this.npEditorSaved = true;
            this.autoSaveStatus = 'saved';
            const now = new Date();
            this.lastSavedTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            setTimeout(() => { this.npEditorSaved = false; }, 3000);
        },

        closeNPEditor() {
            this.saveNPEditor();
            this.editorIsFullscreen = false;
            this.npEditorOpen = false;
            this.npEditorAreaId = null;
        },

        // ================================================================
        // PPP — Methods
        // ================================================================

        initPPP() {
            this.pppActiveAreaId = this.pppAreas[0].id;
        },

        getDefaultPPPTemplate(areaId) {
            const area = this.pppAreas.find(a => a.id === areaId);
            if (!area) return '';
            const programName = this.accredProgram ? this.accredProgram.name : '___________________________';
            return `
                <p style="font-size:14pt; font-weight:bold; text-align:center; margin-bottom: 20px; color:#0f766e;">Program Performance Portfolio (PPP)</p>
                <table style="width:100%; border:none; margin-bottom:24px; font-size:12pt;">
                    <tbody>
                        <tr style="border:none;">
                            <td style="width:180px; padding:6px 0; font-weight:bold; border:none;">Program:</td>
                            <td style="border-bottom:1px solid #1a1a1a; padding:6px 8px; border-top:none; border-left:none; border-right:none; font-weight:600; color:#0f766e;">${programName}</td>
                        </tr>
                        <tr style="border:none;">
                            <td style="padding:6px 0; font-weight:bold; border:none;">Area (Mandatory):</td>
                            <td style="border-bottom:1px solid #1a1a1a; padding:6px 8px; border-top:none; border-left:none; border-right:none; font-weight:600; color:#0f766e;">${area.code} &ndash; ${area.title}</td>
                        </tr>
                    </tbody>
                </table>
                <ol style="font-size:12pt; line-height:2.2; padding-left:28px; margin:0;">
                    <li style="margin-bottom:14px;"><strong>Well-defined Objectives</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Provide portfolio evidence of program performance metrics and benchmarks...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Adequate and Relevant Projects/Activities to Achieve Objectives</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Document ongoing projects, milestones achieved, and compliance activities...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Systematic and Effective Procedures</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Provide flowcharts, quality procedures, and internal verification mechanisms...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Reasonable Budget</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Provide budgetary allocations, financial statements, and expenditure logs...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Provision of Materials and Other Resources</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[List physical, digital, and academic holdings supporting the area...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Participation of Significant Number of Faculty/Staff/Students/Community in Major Projects/Activities</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Include participant rosters, attendance sheets, and survey outputs...]</p></li>
                    <li style="margin-bottom:14px;"><strong>Awards of Distinction and Achievement and Grants of this Program. &ldquo;Best Practices&rdquo; adopted.</strong><p style="margin:4px 0 16px 0; color:#555; font-style:italic;">[Document awards, grants received, and proven institutional best practices...]</p></li>
                </ol>
            `;
        },

        openPPPEditor(areaId) {
            this.pppEditorAreaId = areaId;
            this.pppEditorSaved = false;
            this.autoSaveStatus = 'saved';
            this.pppEditorOpen = true;

            const initialContent = this.pppDocContents[areaId] && this.pppDocContents[areaId].content
                ? this.pppDocContents[areaId].content
                : this.getDefaultPPPTemplate(areaId);

            this.$nextTick(() => {
                const el = document.getElementById('ppp-editor-sheet');
                if (el) {
                    el.innerHTML = initialContent;
                    setTimeout(() => {
                        el.focus();
                    }, 50);
                }
            });
        },

        savePPPEditor() {
            if (!this.pppEditorAreaId) return;
            const el = document.getElementById('ppp-editor-sheet');
            const content = el ? el.innerHTML : '';

            if (!this.pppDocContents[this.pppEditorAreaId]) {
                this.pppDocContents[this.pppEditorAreaId] = {};
            }
            this.pppDocContents[this.pppEditorAreaId].content = content;
            this.pppDocContents[this.pppEditorAreaId].lastSaved = new Date();
            this.pppEditorSaved = true;
            this.autoSaveStatus = 'saved';
            const now = new Date();
            this.lastSavedTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            setTimeout(() => { this.pppEditorSaved = false; }, 3000);
        },

        closePPPEditor() {
            this.savePPPEditor();
            this.editorIsFullscreen = false;
            this.pppEditorOpen = false;
            this.pppEditorAreaId = null;
        },

        // ================================================================
        // AUTO-SAVE ENGINE & FULLSCREEN CONTROLS
        // ================================================================

        triggerAutoSave(docType = 'np') {
            this.autoSaveStatus = 'saving';
            if (this.autoSaveTimer) clearTimeout(this.autoSaveTimer);
            this.autoSaveTimer = setTimeout(() => {
                if (docType === 'np') {
                    this.saveNPEditor();
                } else {
                    this.savePPPEditor();
                }
            }, 600);
        },

        toggleEditorFullscreen() {
            this.editorIsFullscreen = !this.editorIsFullscreen;
        },

        getGoogleEmbedUrl(url) {
            if (!url) return '';
            if (url.includes('docs.google.com/document/d/')) {
                const match = url.match(/docs\.google\.com\/document\/d\/([a-zA-Z0-9_-]+)/);
                if (match && match[1]) {
                    return `https://docs.google.com/document/d/${match[1]}/edit?embedded=true`;
                }
            }
            return url;
        },

        // ================================================================
        // ADVANCED TABLE MANAGEMENT METHODS
        // ================================================================

        getTableTarget(containerId) {
            const sel = window.getSelection();
            if (!sel || !sel.rangeCount) return null;
            let node = sel.anchorNode;
            while (node && node.id !== containerId) {
                if (node.tagName === 'TD' || node.tagName === 'TH') {
                    const tr = node.closest('tr');
                    const table = node.closest('table');
                    return { cell: node, row: tr, table: table };
                }
                node = node.parentNode;
            }
            return null;
        },

        insertTableRow(containerId, position = 'below') {
            const target = this.getTableTarget(containerId);
            if (!target) {
                this.insertDocumentTable(containerId);
                return;
            }
            const cols = target.row.children.length;
            const newRow = document.createElement('tr');
            for (let i = 0; i < cols; i++) {
                const td = document.createElement('td');
                td.style.border = '1px solid #cbd5e1';
                td.style.padding = '8px 12px';
                td.innerHTML = '&nbsp;';
                newRow.appendChild(td);
            }
            if (position === 'above') {
                target.row.parentNode.insertBefore(newRow, target.row);
            } else {
                target.row.parentNode.insertBefore(newRow, target.row.nextSibling);
            }
            const docType = containerId.startsWith('np') ? 'np' : 'ppp';
            this.triggerAutoSave(docType);
        },

        deleteTableRow(containerId) {
            const target = this.getTableTarget(containerId);
            if (!target) return;
            if (target.table.rows.length <= 1) {
                target.table.remove();
            } else {
                target.row.remove();
            }
            const docType = containerId.startsWith('np') ? 'np' : 'ppp';
            this.triggerAutoSave(docType);
        },

        insertTableColumn(containerId, position = 'right') {
            const target = this.getTableTarget(containerId);
            if (!target) return;
            const colIndex = Array.from(target.row.children).indexOf(target.cell);
            const rows = target.table.rows;
            for (let r = 0; r < rows.length; r++) {
                const cellType = rows[r].children[colIndex]?.tagName === 'TH' ? 'th' : 'td';
                const newCell = document.createElement(cellType);
                newCell.style.border = '1px solid #cbd5e1';
                newCell.style.padding = '8px 12px';
                if (cellType === 'th') {
                    newCell.style.background = '#f8fafc';
                    newCell.style.fontWeight = 'bold';
                    newCell.innerHTML = 'Header';
                } else {
                    newCell.innerHTML = '&nbsp;';
                }
                if (position === 'left') {
                    rows[r].insertBefore(newCell, rows[r].children[colIndex]);
                } else {
                    rows[r].insertBefore(newCell, rows[r].children[colIndex]?.nextSibling);
                }
            }
            const docType = containerId.startsWith('np') ? 'np' : 'ppp';
            this.triggerAutoSave(docType);
        },

        deleteTableColumn(containerId) {
            const target = this.getTableTarget(containerId);
            if (!target) return;
            const colIndex = Array.from(target.row.children).indexOf(target.cell);
            const rows = target.table.rows;
            if (target.row.children.length <= 1) {
                target.table.remove();
            } else {
                for (let r = 0; r < rows.length; r++) {
                    if (rows[r].children[colIndex]) {
                        rows[r].children[colIndex].remove();
                    }
                }
            }
            const docType = containerId.startsWith('np') ? 'np' : 'ppp';
            this.triggerAutoSave(docType);
        },

        deleteCurrentTable(containerId) {
            const target = this.getTableTarget(containerId);
            if (target && target.table) {
                target.table.remove();
                const docType = containerId.startsWith('np') ? 'np' : 'ppp';
                this.triggerAutoSave(docType);
            }
        },

        // ================================================================
        // SHARED DOCUMENT FORMATTING & PRINT UTILITIES
        // ================================================================

        execDocCmd(command, value = null) {
            document.execCommand(command, false, value);
        },

        insertDocumentTable(containerId) {
            const el = document.getElementById(containerId);
            if (el) el.focus();
            const tableHtml = `
                <table style="width:100%; border-collapse:collapse; margin:16px 0; border:1px solid #cbd5e1;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="border:1px solid #cbd5e1; padding:8px 12px; text-align:left; font-weight:bold;">Item / Indicator</th>
                            <th style="border:1px solid #cbd5e1; padding:8px 12px; text-align:left; font-weight:bold;">Status / Details</th>
                            <th style="border:1px solid #cbd5e1; padding:8px 12px; text-align:left; font-weight:bold;">Remarks / Evidence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border:1px solid #cbd5e1; padding:8px 12px;">&nbsp;</td>
                            <td style="border:1px solid #cbd5e1; padding:8px 12px;">&nbsp;</td>
                            <td style="border:1px solid #cbd5e1; padding:8px 12px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #cbd5e1; padding:8px 12px;">&nbsp;</td>
                            <td style="border:1px solid #cbd5e1; padding:8px 12px;">&nbsp;</td>
                            <td style="border:1px solid #cbd5e1; padding:8px 12px;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <p><br></p>
            `;
            document.execCommand('insertHTML', false, tableHtml);
        },

        insertDocumentImage(event, containerId) {
            const file = event.target.files[0];
            if (!file) return;
            const el = document.getElementById(containerId);
            if (el) el.focus();
            const reader = new FileReader();
            reader.onload = (e) => {
                const imgHtml = `<p><img src="${e.target.result}" style="max-width:100%; height:auto; display:block; margin:14px 0; border-radius:6px; box-shadow:0 1px 3px rgba(0,0,0,0.1);" alt="Uploaded Picture"></p><p><br></p>`;
                document.execCommand('insertHTML', false, imgHtml);
                const docType = containerId.startsWith('np') ? 'np' : 'ppp';
                this.triggerAutoSave(docType);
            };
            reader.readAsDataURL(file);
            event.target.value = '';
        },

        printCurrentEditor(sheetId, docTitle = 'Accreditation Document') {
            const el = document.getElementById(sheetId);
            const content = el ? el.innerHTML : '';
            this.printDocument(content, docTitle);
        },

        printDocument(htmlContent, docTitle = 'Accreditation Document') {
            const printWindow = window.open('', '_blank', 'width=900,height=700');
            if (!printWindow) {
                alert('Please allow popups to print documents.');
                return;
            }
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${docTitle}</title>
                    <style>
                        @page { size: letter; margin: 1in; }
                        body {
                            font-family: 'Times New Roman', Times, serif;
                            font-size: 12pt;
                            line-height: 1.8;
                            color: #1a1a1a;
                            margin: 0;
                            padding: 0;
                        }
                        table { border-collapse: collapse; width: 100%; margin: 16px 0; }
                        table, th, td { border: 1px solid #000; }
                        th, td { padding: 8px 12px; }
                        th { background: #f1f5f9; font-weight: bold; }
                        img { max-width: 100%; height: auto; display: block; margin: 12px 0; }
                        ol, ul { padding-left: 28px; }
                        li { margin-bottom: 8px; }
                        h1, h2, h3 { color: #002b61; }
                    </style>
                </head>
                <body>
                    ${htmlContent}
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 400);
        }
    };
};
