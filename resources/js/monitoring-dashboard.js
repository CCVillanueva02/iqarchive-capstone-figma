window.documentsWorkspace = function() {
    return {
        accredLevel: null, // null, 'program', or 'institutional'
        documentsSearchQuery: '',
        documentsOfficeFilter: 'all',
        documentsStatusFilter: 'all',
        selectedProgram: null,
        expandedItem: null,

        // Documents mock data
        documentsData: {
            institutional: {
                title: "Institutional Accreditation",
                areas: [
                    { id: "sub_inst_1", name: "Area I: Governance and Management", office: "Office of the President", progress: 85, deadline: "Oct 15, 2026", status: "in_progress" },
                    { id: "sub_inst_2", name: "Area II: Administration", office: "Office of VPAF", progress: 42, deadline: "Jan 20, 2027", status: "overdue" },
                    { id: "sub_inst_3", name: "Area III: Curriculum and Instruction", office: "Office of VPAA", progress: 90, deadline: "Mar 10, 2024", status: "compliant" },
                    { id: "sub_inst_4", name: "Area IV: Support to Students", office: "Office of Student Affairs", progress: 75, deadline: "Dec 5, 2024", status: "in_progress" },
                    { id: "sub_inst_5", name: "Area V: Research", office: "Research and Development Office", progress: 100, deadline: "Jun 30, 2024", status: "compliant" },
                    { id: "sub_inst_6", name: "Area VI: Extension and Community Involvement", office: "Extension Services Division", progress: 30, deadline: "Aug 15, 2026", status: "overdue" },
                    { id: "sub_inst_7", name: "Area VII: Library", office: "University Library", progress: 15, deadline: "Nov 30, 2026", status: "overdue" },
                    { id: "sub_inst_8", name: "Area VIII: Physical Plant and Facilities", office: "Physical Plant Office", progress: 90, deadline: "Dec 15, 2026", status: "compliant" },
                    { id: "sub_inst_9", name: "Area IX: Laboratories", office: "College of Science", progress: 95, deadline: "Dec 15, 2026", status: "compliant" }
                ],
                deadlines: [
                    { id: "dl_inst_1", title: "Governance Area Submission", subtitle: "Compliance Submission", days: 5, date: "June 30, 2024", type: "danger" },
                    { id: "dl_inst_2", title: "University-wide Self-Study", subtitle: "University-wide Self-Study", days: 20, date: "July 15, 2024", type: "warning" },
                    { id: "dl_inst_3", title: "Physical Plant Checklist Liaison", subtitle: "Liaison Documentation", days: 45, date: "August 15, 2024", type: "safe" }
                ],
                activity: [
                    { id: "act_inst_1", user: "Admin User", action: "uploaded Q2 University Report.", time: "2 hours ago", initials: "AU" },
                    { id: "act_inst_2", user: "Dr. Lee", action: "changed status of Research Area to In Progress.", time: "Yesterday at 9:00 AM", initials: "DL" },
                    { id: "act_inst_3", user: "Dr. Lee", action: "changed status of University Area to Overdue.", time: "Yesterday at 9:00 AM", initials: "DL" }
                ]
            },
            program: {
                title: "Program Accreditation",
                areas: [
                    { id: "sub_prog_1", name: "BS Computer Science", office: "College of Science", progress: 95, deadline: "Oct 15, 2026", status: "compliant" },
                    { id: "sub_prog_2", name: "BS Information Technology", office: "College of Science", progress: 70, deadline: "Jan 20, 2027", status: "in_progress" },
                    { id: "sub_prog_3", name: "BS Electrical Engineering", office: "College of Engineering", progress: 40, deadline: "Mar 10, 2024", status: "overdue" },
                    { id: "sub_prog_4", name: "BS Food Technology", office: "College of Agriculture", progress: 80, deadline: "Dec 5, 2024", status: "in_progress" },
                    { id: "sub_prog_5", name: "BS Civil Engineering", office: "College of Engineering", progress: 100, deadline: "Jun 30, 2024", status: "compliant" },
                    { id: "sub_prog_6", name: "BS Biology", office: "College of Science", progress: 50, deadline: "Sep 12, 2026", status: "in_progress" }
                ],
                deadlines: [
                    { id: "dl_prog_1", title: "BSEE Area II Faculty Profiles", subtitle: "Faculty Portfolio Submission", days: 3, date: "June 28, 2024", type: "danger" },
                    { id: "dl_prog_2", title: "BSCS Self-Survey Endorsement", subtitle: "Program Self-Study", days: 12, date: "July 7, 2024", type: "warning" },
                    { id: "dl_prog_3", title: "BSIT Area III Curriculum Matrix", subtitle: "Curriculum Map", days: 28, date: "July 23, 2024", type: "safe" }
                ],
                activity: [
                    { id: "act_prog_1", user: "Prof. Diaz", action: "linked Board Resolutions to BSCS Area I.", time: "3 hours ago", initials: "PD" },
                    { id: "act_prog_2", user: "Dr. Santos", action: "verified Faculty Profiles for BS Civil Engineering.", time: "Yesterday at 11:30 AM", initials: "DS" },
                    { id: "act_prog_3", user: "Maria Reyes", action: "flagged Syllabus Matrix for BS Electrical Engineering.", time: "2 days ago", initials: "MR" }
                ]
            }
        },
        
        // Mock specific details for a selected item (Program or Institutional Area)
        getDetails(item, type) {
            if (!item) return null;
            
            const mockDocs1 = [
                { id: "d1", name: "Board Resolution No. 45", type: "PDF", size: "1.2 MB", uploader: "Maria Reyes", date: "Oct 12, 2025" },
                { id: "d2", name: "Strategic Plan Matrix", type: "Excel", size: "3.4 MB", uploader: "Dr. Santos", date: "Oct 15, 2025" }
            ];
            const mockDocs2 = [
                { id: "d3", name: "Policy Implementation Memo", type: "Word", size: "800 KB", uploader: "Prof. Cruz", date: "Nov 02, 2025" }
            ];

            const generateProgramChecklist = (prog) => [
                { id: "c1", title: "Parameter A", complied: prog >= 30, documents: prog >= 30 ? mockDocs1 : [] },
                { id: "c2", title: "Parameter B", complied: prog >= 60, documents: prog >= 60 ? mockDocs2 : [] },
                { id: "c3", title: "Parameter C", complied: prog >= 90, documents: prog >= 90 ? [...mockDocs1, ...mockDocs2] : [] }
            ];

            const generateInstChecklist = (prog) => [
                { id: "s1", title: "S.1 Institutional systems established.", complied: prog >= 25, documents: prog >= 25 ? mockDocs1 : [] },
                { id: "s2", title: "S.2 Documents properly reviewed.", complied: prog >= 50, documents: prog >= 50 ? mockDocs2 : [] },
                { id: "i1", title: "I.1 Implementation reflects policy.", complied: prog >= 75, documents: prog >= 75 ? mockDocs1 : [] },
                { id: "o1", title: "O.1 Outcomes meet targeted goals.", complied: prog >= 95, documents: prog >= 95 ? [...mockDocs1, ...mockDocs2] : [] }
            ];

            if (type === 'program') {
                return {
                    ...item,
                    overallScore: item.progress,
                    pendingDocs: Math.max(0, 100 - item.progress),
                    subItemsTitle: 'Area Breakdown',
                    subItems: [
                        { id: "a1", name: "Area I: Vision, Mission, Goals, and Objectives", leader: "Dr. A. Santos", status: item.progress > 90 ? "compliant" : "in_progress", progress: Math.min(100, item.progress + 10), checklist: generateProgramChecklist(Math.min(100, item.progress + 10)) },
                        { id: "a2", name: "Area II: Faculty", leader: "Prof. B. Reyes", status: item.progress > 80 ? "compliant" : "in_progress", progress: Math.min(100, item.progress + 15), checklist: generateProgramChecklist(Math.min(100, item.progress + 15)) },
                        { id: "a3", name: "Area III: Curriculum and Instruction", leader: "Dr. C. Cruz", status: item.progress > 70 ? "compliant" : "in_progress", progress: Math.min(100, item.progress + 5), checklist: generateProgramChecklist(Math.min(100, item.progress + 5)) },
                        { id: "a4", name: "Area IV: Support to Students", leader: "Prof. D. Garcia", status: item.progress > 60 ? "compliant" : "in_progress", progress: Math.min(100, item.progress + 20), checklist: generateProgramChecklist(Math.min(100, item.progress + 20)) },
                        { id: "a5", name: "Area V: Research", leader: "Dr. E. Mendoza", status: "in_progress", progress: Math.max(0, item.progress - 10), checklist: generateProgramChecklist(Math.max(0, item.progress - 10)) },
                        { id: "a6", name: "Area VI: Extension and Community Involvement", leader: "Prof. F. Torres", status: item.progress > 50 ? "compliant" : "overdue", progress: Math.max(0, item.progress - 5), checklist: generateProgramChecklist(Math.max(0, item.progress - 5)) },
                        { id: "a7", name: "Area VII: Library", leader: "Ms. G. Bautista", status: item.progress > 40 ? "compliant" : "in_progress", progress: Math.min(100, item.progress + 8), checklist: generateProgramChecklist(Math.min(100, item.progress + 8)) },
                        { id: "a8", name: "Area VIII: Physical Plant and Facilities", leader: "Engr. H. Villanueva", status: item.progress > 30 ? "compliant" : "overdue", progress: Math.max(0, item.progress - 15), checklist: generateProgramChecklist(Math.max(0, item.progress - 15)) },
                        { id: "a9", name: "Area IX: Laboratories", leader: "Mr. I. Ramos", status: item.progress > 20 ? "compliant" : "in_progress", progress: Math.min(100, item.progress + 12), checklist: generateProgramChecklist(Math.min(100, item.progress + 12)) },
                        { id: "a10", name: "Area X: Administration", leader: "Dr. J. Castro", status: "in_progress", progress: Math.max(0, item.progress - 2), checklist: generateProgramChecklist(Math.max(0, item.progress - 2)) }
                    ]
                };
            } else if (type === 'institutional') {
                return {
                    ...item,
                    overallScore: item.progress,
                    pendingDocs: Math.max(0, 100 - item.progress),
                    subItemsTitle: 'Parameter Breakdown',
                    subItems: [
                        { id: "p1", name: "Parameter A", leader: "Dr. A. Santos", status: item.progress > 80 ? "compliant" : "in_progress", progress: Math.min(100, item.progress + 10), checklist: generateInstChecklist(Math.min(100, item.progress + 10)) },
                        { id: "p2", name: "Parameter B", leader: "Prof. B. Reyes", status: item.progress > 60 ? "compliant" : "in_progress", progress: Math.max(0, item.progress - 5), checklist: generateInstChecklist(Math.max(0, item.progress - 5)) },
                        { id: "p3", name: "Parameter C", leader: "Dr. C. Cruz", status: item.progress > 40 ? "compliant" : "overdue", progress: Math.max(0, item.progress - 15), checklist: generateInstChecklist(Math.max(0, item.progress - 15)) },
                        { id: "p4", name: "Parameter D", leader: "Prof. D. Garcia", status: "in_progress", progress: Math.min(100, item.progress + 5), checklist: generateInstChecklist(Math.min(100, item.progress + 5)) }
                    ]
                };
            }
            return null;
        },

        get activeDocumentsData() {
            if (!this.accredLevel) return null;
            return this.documentsData[this.accredLevel];
        },

        get filteredAreas() {
            if (!this.activeDocumentsData) return [];
            
            return this.activeDocumentsData.areas.filter(area => {
                const matchesSearch = area.name.toLowerCase().includes(this.documentsSearchQuery.toLowerCase()) || 
                                      area.office.toLowerCase().includes(this.documentsSearchQuery.toLowerCase());
                
                const matchesOffice = this.documentsOfficeFilter === 'all' || 
                                      area.office === this.documentsOfficeFilter;
                                      
                const matchesStatus = this.documentsStatusFilter === 'all' || 
                                      area.status === this.documentsStatusFilter;
                                      
                return matchesSearch && matchesOffice && matchesStatus;
            });
        },

        get officeOptions() {
            if (!this.activeDocumentsData) return [];
            const offices = new Set(this.activeDocumentsData.areas.map(a => a.office));
            return Array.from(offices);
        },
        
        get metrics() {
            if (!this.activeDocumentsData) return { total: 0, compliant: 0, inProgress: 0, overdue: 0 };
            
            const areas = this.activeDocumentsData.areas;
            return {
                total: areas.length,
                compliant: areas.filter(a => a.status === 'compliant').length,
                inProgress: areas.filter(a => a.status === 'in_progress').length,
                overdue: areas.filter(a => a.status === 'overdue').length
            };
        },
        
        getStatusBadgeClass(status) {
            switch(status) {
                case 'compliant': return 'bg-emerald-50 text-emerald-700 border-emerald-100';
                case 'in_progress': return 'bg-amber-50 text-amber-700 border-amber-100';
                case 'overdue': return 'bg-rose-50 text-rose-700 border-rose-100';
                default: return 'bg-slate-50 text-slate-700 border-slate-100';
            }
        },
        
        getStatusLabel(status) {
            switch(status) {
                case 'compliant': return 'Compliant';
                case 'in_progress': return 'In Progress';
                case 'overdue': return 'Overdue';
                default: return status;
            }
        }
    }
}
