window.documentWorkspace = function() {
    return {
        activeTab: 'common', // 'common' or 'accreditation'
        accredLevel: null, // 'program' or 'institutional'
        accredCategory: null, // 'Self-Survey Documents', 'Compliance Reports', 'Supporting Documents'
        accredActiveAreaId: 'area_i1',
        accredActiveParamId: 'param_i1_a',
        accredActiveSection: 'systems',
        
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
                                            statement: 'The institution has a clearly defined Vision, Mission, Goals, and Objectives.',
                                            documents: [
                                                { name: 'VMGO Approved Resolution s. 2024', type: 'PDF', size: '1.2 MB', date: '2024-03-15', uploader: 'Dr. Albert Santos', office: 'Office of the President', status: 'Verified', ocrText: 'BOARD RESOLUTION NO. 045, SERIES OF 2024\n\nSUBJECT: APPROVAL OF THE UNIVERSITY VISION, MISSION, GOALS AND OBJECTIVES.' }
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
            ocrText: ''
        },

        get activeAccredData() {
            if (!this.accredLevel) return null;
            return this.accredData[this.accredLevel];
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
        categories: [
            {
                id: 'cat_1',
                name: 'Policies & Issuances',
                description: 'Admin orders, office policies, notices',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>`,
                docCount: 4
            },
            {
                id: 'cat_2',
                name: 'Instruments',
                description: 'Per-area accreditation guides, surveys',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zM9 13h6M9 17h3" /></svg>`,
                docCount: 3
            },
            {
                id: 'cat_3',
                name: 'Memoranda',
                description: 'Internal circulars and memos',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>`,
                docCount: 3
            },
            {
                id: 'cat_4',
                name: 'Correspondences',
                description: 'Letters to/from colleges, AACCUP, admin',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>`,
                docCount: 3
            }
        ],
        documents: [
            // Policies & Issuances
            { name: "Administrative Order No. 453, s. of 2024", category: "Policies & Issuances", type: "PDF", size: "1.4 MB", date: "2024-05-10", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "ADMINISTRATIVE ORDER NO. 453, SERIES OF 2024\n\nSUBJECT: CONSTITUTION OF THE TECHNICAL WORKING GROUP (TWG) FOR THE REVIEW AND REVISION OF THE BICOL UNIVERSITY CODE OF 2016." },
            { name: "Office Memorandum No. 153 s. of 2024", category: "Policies & Issuances", type: "PDF", size: "920 KB", date: "2024-06-15", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "OFFICE MEMORANDUM NO. 153, SERIES OF 2024\n\nTO: ALL MEMBERS OF THE CODE REVISION TWG\nSUBJECT: WRITESHOP FOR THE REVIEW AND AMENDMENTS OF THE UNIVERSITY CODE." },
            { name: "BU Code revised 2024", category: "Policies & Issuances", type: "PDF", size: "4.8 MB", date: "2024-11-20", uploader: "Dr. Albert Santos", office: "Office of the President", status: "Verified", ocrText: "REVISED UNIVERSITY CODE OF BICOL UNIVERSITY\n\nApproved by the Board of Regents under Resolution No. 075, s. 2024." },
            { name: "University Circular on Quality Audits", category: "Policies & Issuances", type: "PDF", size: "750 KB", date: "2025-01-10", uploader: "Dr. Albert Santos", office: "IQA Central Office", status: "Pending", ocrText: "UNIVERSITY CIRCULAR NO. 012, SERIES OF 2025\n\nSUBJECT: SCHEDULE OF INTERNAL QUALITY ASSURANCE AUDITS FOR ACADEMIC YEAR 2025-2026." },
            
            // Instruments
            { name: "Self-Survey Instrument Area I", category: "Instruments", type: "Word", size: "680 KB", date: "2026-03-01", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "AACCUP SELF-SURVEY INSTRUMENT\nAREA I: GOVERNANCE AND MANAGEMENT\n\nRating guidelines and evidence checklist for institutional compliance evaluation." },
            { name: "Self-Survey Instrument Area II", category: "Instruments", type: "Word", size: "720 KB", date: "2026-03-05", uploader: "Maria Reyes", office: "IQA Central Office", status: "Verified", ocrText: "AACCUP SELF-SURVEY INSTRUMENT\nAREA II: CURRICULUM AND INSTRUCTION\n\nRating guidelines and syllabus compliance mapping database." },
            { name: "AACCUP Survey Guideline 2026", category: "Instruments", type: "PDF", size: "2.3 MB", date: "2026-02-15", uploader: "Dr. Albert Santos", office: "Office of the President", status: "Verified", ocrText: "AACCUP ACCREDITATION MANUAL 2026\n\nLatest policies, procedures, and institutional survey instrumentation rules for higher education institutions." },
            
            // Memoranda
            { name: "OM No. 214, s. 2015 (Signing Authorities)", category: "Memoranda", type: "PDF", size: "620 KB", date: "2025-06-01", uploader: "Maria Reyes", office: "Office of the President", status: "Verified", ocrText: "BICOL UNIVERSITY\nOFFICE OF THE PRESIDENT\n\nOFFICE MEMORANDUM NO. 214, SERIES OF 2015\n\nTO: ALL ACADEMIC AND ADMINISTRATIVE OFFICIALS\n\nSUBJECT: GUIDELINES ON SIGNING AUTHORITIES FOR REQUISITIONS AND GENERAL OFFICE TRANSACTIONS." },
            { name: "Notice of 1st Regular Academic Council", category: "Memoranda", type: "PDF", size: "410 KB", date: "2026-02-05", uploader: "Maria Reyes", office: "Office of the President", status: "Verified", ocrText: "OFFICE OF THE BOARD SECRETARY\n\nNOTICE OF MEETING\n\nNotice is hereby given that the 1st Regular Academic Council Assembly of Bicol University will be held on February 12, 2026." },
            { name: "Memorandum on Internal Quality Audits s. 2026", category: "Memoranda", type: "PDF", size: "890 KB", date: "2026-04-12", uploader: "Maria Reyes", office: "IQA Central Office", status: "Pending", ocrText: "OFFICE MEMORANDUM NO. 320, SERIES OF 2026\n\nTO: ALL DEANS, DIRECTORS, AND DEPARTMENT CHAIRS\nSUBJECT: CONSTITUTION OF COLLATERAL INTERNAL AUDIT TEAMS." },

            // Correspondences
            { name: "Letter to AACCUP Secretariat (Self-Survey Submission)", category: "Correspondences", type: "PDF", size: "1.1 MB", date: "2026-03-12", uploader: "Dr. Albert Santos", office: "Office of the President", status: "Verified", ocrText: "BICOL UNIVERSITY\nLegazpi City\n\nMarch 12, 2026\n\nTO: THE EXECUTIVE DIRECTOR, AACCUP SECRETARIAT\n\nDear Sir/Madam:\n\nWe have the honor to submit herewith the self-survey documents and supporting files for Bicol University's Institutional Accreditation." },
            { name: "Endorsement Letter from BU President to BOR", category: "Correspondences", type: "PDF", size: "520 KB", date: "2026-03-15", uploader: "Maria Reyes", office: "Office of the President", status: "Verified", ocrText: "OFFICE OF THE UNIVERSITY PRESIDENT\n\nMEMORANDUM FOR THE BOARD OF REGENTS\n\nSUBJECT: ENDORSEMENT OF THE PROPOSED DIGITAL TRANSFORMATION ROADMAP FOR FY 2026." },
            { name: "Query from College of Science Dean on IQA Timeline", category: "Correspondences", type: "PDF", size: "340 KB", date: "2026-04-01", uploader: "Prof. Lilian Diaz", office: "College of Science", status: "Flagged", ocrText: "COLLEGE OF SCIENCE\nOffice of the Dean\n\nApril 1, 2026\n\nTO: THE DIRECTOR, IQA OFFICE\n\nDear Director Santos:\n\nWe would like to request clarification on the timeline for submission of supporting folders for Parameter B." }
        ],
        
        get filteredCategories() {
            if (this.selectedCategory !== null) return [];
            if (!this.searchQuery) return this.categories;
            const query = this.searchQuery.toLowerCase();
            return this.categories.filter(c => 
                c.name.toLowerCase().includes(query) || 
                c.description.toLowerCase().includes(query)
            );
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

        approveDoc() {
            this.selectedDoc.status = 'Verified';
            this.closeDrawer();
        },

        flagDoc() {
            this.selectedDoc.status = 'Flagged';
            this.closeDrawer();
        }
    };
};
