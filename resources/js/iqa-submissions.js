window.submissionsWorkspace = function() {
    return {
        searchQuery: '',
        statusFilter: 'all', // 'all', 'timely', 'late', 'due'
        collegeFilter: 'all',
        viewMode: 'grid', // 'grid' or 'list'
        selectedProgram: null,

        // Master list of colleges
        colleges: [
            { id: 'BUCAL', name: 'BU College of Arts & Letters' },
            { id: 'BUCBEM', name: 'BU College of Business, Economics & Management' },
            { id: 'BUCE', name: 'BU College of Education' },
            { id: 'BUCENG', name: 'BU College of Engineering' },
            { id: 'BUCIT', name: 'BU College of Information Technology' },
            { id: 'BUCS', name: 'BU College of Science' },
            { id: 'BUCN', name: 'BU College of Nursing' }
        ],

        // Comprehensive Accreditation Monitoring Data
        monitoringData: [
            // BUCAL
            { id: 'p1', college: 'BUCAL', name: 'Master of Arts in Literature', latestVisit: 'Dec 4-8, 2023', level: 'Level III Re-accredited', rating: '4.08', validFrom: 'Dec 16, 2023', validTo: 'Dec 15, 2024', status: 'Late', remarks: 'Requested for Resched of Visit on Aug 27-29, 2025' },
            { id: 'p2', college: 'BUCAL', name: 'Master in Filipino', latestVisit: 'Dec 4-8, 2023', level: 'Level III Re-accredited', rating: '4.05', validFrom: 'Dec 16, 2023', validTo: 'Dec 15, 2024', status: 'Late', remarks: 'Requested for Resched of Visit on Aug 27-29, 2025' },
            { id: 'p3', college: 'BUCAL', name: 'Ph.D. in Filipino', latestVisit: 'Dec 4-8, 2023', level: 'Level III Re-accredited', rating: '4.17', validFrom: 'Dec 16, 2023', validTo: 'Dec 15, 2024', status: 'Late', remarks: 'Requested for Resched of Visit on Aug 27-29, 2025' },
            { id: 'p4', college: 'BUCAL', name: 'Bachelor of Arts in Speech and Theater Arts', latestVisit: 'Apr 8, 2024', level: 'Level IV Re-accredited', rating: '4.50', validFrom: 'Apr 16, 2024', validTo: 'Apr 15, 2029', status: 'Timely', remarks: 'Passed compliance' },
            { id: 'p5', college: 'BUCAL', name: 'Bachelor of Arts in Audio Visual Communication', latestVisit: 'Jul 19-21, 2023', level: 'Level IV Re-accredited', rating: '4.70', validFrom: 'Aug 1, 2023', validTo: 'Jul 31, 2028', status: 'Timely', remarks: '' },
            { id: 'p6', college: 'BUCAL', name: 'Bachelor of Arts in Literature', latestVisit: 'Aug 19-23, 2024', level: 'Level I Accredited', rating: '3.61', validFrom: 'Sep 1, 2024', validTo: 'Aug 31, 2026', status: 'Timely', remarks: '' },
            { id: 'p7', college: 'BUCAL', name: 'AB in Broadcasting', latestVisit: 'May 6-8, 2024', level: 'Level II Accredited', rating: '4.18', validFrom: 'Jun 1, 2024', validTo: 'May 31, 2025', status: 'Late', remarks: 'To Comply' },
            { id: 'p8', college: 'BUCAL', name: 'AB Journalism', latestVisit: 'Jun 10-13, 2024', level: 'Level II Re-accredited', rating: '4.36', validFrom: 'Jun 16, 2024', validTo: 'Jun 15, 2025', status: 'Late', remarks: 'Revisit Area VI' },
            
            // BUCBEM
            { id: 'p9', college: 'BUCBEM', name: 'Master in Management', latestVisit: 'Aug 21-25, 2023', level: 'Level III Re-accredited', rating: '2.39', validFrom: 'Nov 1, 2018', validTo: 'Aug 31, 2028', status: 'Timely', remarks: 'Revisit ALL' },
            { id: 'p10', college: 'BUCBEM', name: 'Master in Economics', latestVisit: 'Jun 10-12, 2024', level: 'Level III Re-accredited', rating: '4.25', validFrom: 'Jul 1, 2024', validTo: 'Jun 30, 2025', status: 'Due', remarks: 'Deferred' },
            { id: 'p11', college: 'BUCBEM', name: 'BS in Accountancy', latestVisit: 'May 6-8, 2024', level: 'Level III Re-accredited', rating: '4.05', validFrom: 'Jun 1, 2024', validTo: 'May 31, 2026', status: 'Due', remarks: 'Revisit ALL' },
            { id: 'p12', college: 'BUCBEM', name: 'BS in Entrepreneurship', latestVisit: 'May 6-8, 2024', level: 'Level III Accredited', rating: '4.53', validFrom: 'Jun 1, 2024', validTo: 'May 31, 2025', status: 'Late', remarks: 'Comply' },
            { id: 'p13', college: 'BUCBEM', name: 'BS in Business Administration (Management)', latestVisit: 'May 6-8, 2024', level: 'Level III Accredited', rating: '4.52', validFrom: 'Jun 1, 2024', validTo: 'May 31, 2025', status: 'Late', remarks: 'Comply' },

            // BUCE
            { id: 'p14', college: 'BUCE', name: 'Doctoral of Education in Educational Leadership', latestVisit: 'Jun 10-12, 2024', level: 'Level IV Re-accredited', rating: '4.56', validFrom: 'Jul 1, 2024', validTo: 'Jun 30, 2025', status: 'Due', remarks: 'Revisit Community Service on Jun 23-25, 2025' },
            { id: 'p15', college: 'BUCE', name: 'Ph.D. in Mathematics Education', latestVisit: 'Jun 10-13, 2024', level: 'Level IV Re-accredited', rating: '3.83', validFrom: 'Jul 1, 2024', validTo: 'Jun 30, 2026', status: 'Due', remarks: 'Revisit ALL' },
            { id: 'p16', college: 'BUCE', name: 'Ph.D. in Educational Foundations', latestVisit: 'Jun 10-12, 2024', level: 'Level IV Re-accredited', rating: '4.00', validFrom: 'Jul 1, 2024', validTo: 'Jun 30, 2025', status: 'Late', remarks: 'Deferred' },
            { id: 'p17', college: 'BUCE', name: 'Master of Arts in Social Studies Education', latestVisit: 'Aug 19-23, 2024', level: 'Level I Accredited', rating: '3.69', validFrom: 'Sep 1, 2024', validTo: 'Aug 31, 2026', status: 'Timely', remarks: '' },
            { id: 'p18', college: 'BUCE', name: 'Bachelor of Secondary Education', latestVisit: 'Jun 10-13, 2024', level: 'Level IV Re-accredited', rating: '4.55', validFrom: 'Jun 16, 2024', validTo: 'Jun 15, 2025', status: 'Late', remarks: 'Visited Jun 2025, waiting for result' },
            { id: 'p19', college: 'BUCE', name: 'Bachelor of Elementary Education', latestVisit: 'May 6-8, 2024', level: 'Level IV Re-accredited', rating: '4.53', validFrom: 'Jun 1, 2024', validTo: 'May 31, 2025', status: 'Late', remarks: 'Comply' },

            // BUCENG
            { id: 'p20', college: 'BUCENG', name: 'BS in Geodetic Engineering', latestVisit: 'Apr 24-28, 2023', level: 'Level II Accredited', rating: '3.14', validFrom: 'May 1, 2023', validTo: 'Apr 30, 2026', status: 'Due', remarks: '' },
            { id: 'p21', college: 'BUCENG', name: 'BS in Mining Engineering', latestVisit: 'Apr 24-28, 2023', level: 'Level II Accredited', rating: '3.24', validFrom: 'May 1, 2023', validTo: 'Apr 30, 2026', status: 'Timely', remarks: 'Timely by grace period' },
            { id: 'p22', college: 'BUCENG', name: 'BS in Civil Engineering', latestVisit: 'Dec 13-15, 2023', level: 'Level III Accredited', rating: '4.01', validFrom: 'Jan 1, 2024', validTo: 'Dec 31, 2024', status: 'Late', remarks: 'Waiting for result of Jul 2025 revisit' },
            { id: 'p23', college: 'BUCENG', name: 'BS in Electrical Engineering', latestVisit: 'Dec 13-15, 2023', level: 'Level III Accredited', rating: '4.01', validFrom: 'Jan 1, 2024', validTo: 'Dec 31, 2024', status: 'Late', remarks: 'Waiting for result of Jul 2025 revisit' },
            { id: 'p24', college: 'BUCENG', name: 'BS in Mechanical Engineering', latestVisit: 'Dec 13-15, 2023', level: 'Level III Accredited', rating: '3.79', validFrom: 'Jan 1, 2024', validTo: 'Dec 31, 2025', status: 'Due', remarks: 'Survey Visit on Dec 1-3, 2025' },

            // BUCS (From Context)
            { id: 'p25', college: 'BUCS', name: 'BS in Computer Science', latestVisit: 'Dec 9-13, 2024', level: 'Level IV Re-accredited', rating: '4.60', validFrom: 'Jan 1, 2025', validTo: 'Dec 31, 2029', status: 'Timely', remarks: '' },
            { id: 'p26', college: 'BUCS', name: 'BS in Biology', latestVisit: 'Dec 9-13, 2024', level: 'Level III Accredited', rating: '4.20', validFrom: 'Jan 1, 2025', validTo: 'Dec 31, 2028', status: 'Timely', remarks: '' },
            { id: 'p27', college: 'BUCS', name: 'BS in Chemistry', latestVisit: 'Dec 9-13, 2024', level: 'Level II Accredited', rating: '3.80', validFrom: 'Jan 1, 2025', validTo: 'Dec 31, 2027', status: 'Timely', remarks: '' },

            // BUCIT (From Context)
            { id: 'p28', college: 'BUCIT', name: 'BS in Information Technology', latestVisit: 'Oct 2-4, 2024', level: 'Level III Accredited', rating: '4.15', validFrom: 'Nov 1, 2024', validTo: 'Oct 31, 2028', status: 'Timely', remarks: '' },

            // BUCN (From Context)
            { id: 'p29', college: 'BUCN', name: 'BS in Nursing', latestVisit: 'Oct 2-4, 2024', level: 'Level IV Re-accredited', rating: '4.65', validFrom: 'Nov 1, 2024', validTo: 'Oct 31, 2029', status: 'Timely', remarks: '' },
        ],

        get filteredPrograms() {
            return this.monitoringData.filter(program => {
                const matchesSearch = program.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                      program.college.toLowerCase().includes(this.searchQuery.toLowerCase());
                
                const matchesStatus = this.statusFilter === 'all' || 
                                      program.status.toLowerCase() === this.statusFilter.toLowerCase();
                                      
                const matchesCollege = this.collegeFilter === 'all' || 
                                      program.college === this.collegeFilter;
                                      
                return matchesSearch && matchesStatus && matchesCollege;
            });
        },

        get dashboardMetrics() {
            return {
                total: this.monitoringData.length,
                timely: this.monitoringData.filter(p => p.status === 'Timely').length,
                late: this.monitoringData.filter(p => p.status === 'Late').length,
                due: this.monitoringData.filter(p => p.status === 'Due').length
            };
        },

        getStatusBadgeClass(status) {
            switch(status.toLowerCase()) {
                case 'timely': return 'bg-emerald-50 text-emerald-700 border-emerald-100';
                case 'late': return 'bg-rose-50 text-rose-700 border-rose-100';
                case 'due': return 'bg-amber-50 text-amber-700 border-amber-100';
                default: return 'bg-slate-50 text-slate-700 border-slate-100';
            }
        },
        
        getCollegeName(code) {
            const college = this.colleges.find(c => c.id === code);
            return college ? college.name : code;
        }
    }
}
