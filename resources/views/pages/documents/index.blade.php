<x-layouts::app :title="__('Documents Archive')">
    @php
        $role = session('preview_role', 'iqa-admin');
        $isFacultyOrTaskForce = in_array($role, ['task-force', 'program-chair', 'faculty-member']);
    @endphp

    <div class="flex h-full w-full flex-1 flex-col gap-6" x-data="{
        searchQuery: '',
        categoryFilter: 'all',
        role: '{{ $role }}',
        showDetailDrawer: false,
        activeDoc: null,
        uploading: false,
        uploadProgress: 0,
        ocrProcessing: false,
        uploadSuccess: false,
        uploadedFile: null,
        
        // Mock OCR results database
        ocrResults: {
            'BU-IQA-Self-Survey-Report-2025.pdf': 'BICOL UNIVERSITY COLLEGE OF SCIENCE\nINTERNAL QUALITY ASSURANCE SELF-SURVEY REPORT\n\nDate of Survey: May 15-20, 2025\nAccreditation Level: Level IV Re-accreditation\n\nExecutive Summary:\nThe Computer Science Department has undergone comprehensive evaluation across nine areas including Vision, Mission, Curriculum, Instruction, Faculty, Student Services, and Research. Recommendations from the previous survey have been 92% implemented...',
            'IQA-Curriculum-Review-BSCS.pdf': 'COLLEGE OF SCIENCE - CURRICULUM REVIEW PANEL MINUTES\n\nReview of BS Computer Science Program Structure\nDate: June 12, 2025\n\nDecisions and Action Items:\n1. Integrate artificial intelligence and machine learning modules into CS 312.\n2. Standardize syllabus layouts for all 1st and 2nd-year programming tracks to comply with IQA guidelines.\n3. Increase laboratory contact hours from 3 to 4 per week.',
            'Faculty-Development-Plan-2026.pdf': 'BICOL UNIVERSITY COLLEGE OF MEDICINE\nFACULTY DEVELOPMENT & TENURE COMPLIANCE PLAN 2026\n\nIQA Objective: Quality enhancement through academic and clinical training upgrades.\n\nTargets:\n1. Sponsor three clinical instructors for medical doctorate specializations.\n2. Conduct semi-annual peer instruction assessment and evaluation workshops.\n3. Implement digital patient-scenario tools for teaching simulations.',
            'BU-CS-Syllabus-WebDev-2026.pdf': 'BICOL UNIVERSITY\nCOURSE SYLLABUS IN WEB DEVELOPMENT (IT 311)\n\nSemester: First Semester, Academic Year 2026-2027\nDepartment: Computer Science\nCourse Description: Introduction to web architectures, full stack JavaScript development, and database integrations.\n\nLearning Outcomes:\n1. Deploy responsive web clients utilizing modern frameworks.\n2. Design scalable RESTful API endpoints.\n3. Build secure session architectures.'
        },

        documents: [
            { id: 1, title: 'BU-IQA-Self-Survey-Report-2025.pdf', category: 'Self-Survey', size: '2.4 MB', college: 'College of Science', program: 'BS Computer Science', status: 'ready', date: 'Jul 10, 2025', uploader: 'Dr. Maria Santos' },
            { id: 2, title: 'IQA-Curriculum-Review-BSCS.pdf', category: 'Curriculum Review', size: '1.1 MB', college: 'College of Science', program: 'BS Computer Science', status: 'ready', date: 'Aug 14, 2025', uploader: 'Prof. Alan Rivera' },
            { id: 3, title: 'Faculty-Development-Plan-2026.pdf', category: 'Faculty Development', size: '3.8 MB', college: 'College of Medicine', program: 'Doctor of Medicine', status: 'ready', date: 'Sep 01, 2025', uploader: 'Dr. Jessica Lopez' },
            { id: 4, title: 'BU-CS-Syllabus-WebDev-2026.pdf', category: 'Course Syllabus', size: '945 KB', college: 'College of Science', program: 'BS Information Technology', status: 'ready', date: 'Oct 12, 2025', uploader: 'Prof. Alan Rivera' }
        ],

        triggerMockUpload(e) {
            const files = e.target.files;
            if (files.length === 0) return;
            const file = files[0];
            this.uploadedFile = file;
            this.uploading = true;
            this.uploadProgress = 0;
            this.uploadSuccess = false;
            this.ocrProcessing = false;
            
            // Step 1: Mock File Upload
            let interval = setInterval(() => {
                this.uploadProgress += 10;
                if (this.uploadProgress >= 100) {
                    clearInterval(interval);
                    this.uploading = false;
                    this.ocrProcessing = true;
                    
                    // Step 2: Mock OCR Text Extraction
                    setTimeout(() => {
                        this.ocrProcessing = false;
                        this.uploadSuccess = true;
                        
                        // Add to documents list
                        const ocrText = 'EXTRACTED OCR TEXT FROM ' + file.name + ':\n\nBicol University IQA Office Upload Portal.\nDocument verified and stored successfully.\nKeywords: Syllabus, Syllabus Alignment, BU Standards.';
                        this.ocrResults[file.name] = ocrText;
                        
                        this.documents.unshift({
                            id: this.documents.length + 1,
                            title: file.name,
                            category: 'Document Submission',
                            size: (file.size / 1024 / 1024).toFixed(1) + ' MB',
                            college: 'College of Science',
                            program: 'BS Computer Science',
                            status: 'ready',
                            date: 'Just now',
                            uploader: 'Dr. Test User'
                        });
                    }, 2000);
                }
            }, 150);
        },

        openDocument(doc) {
            this.activeDoc = doc;
            this.showDetailDrawer = true;
        },

        get filteredDocs() {
            return this.documents.filter(d => {
                const matchesSearch = d.title.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                     d.college.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                     d.program.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                     (this.ocrResults[d.title] && this.ocrResults[d.title].toLowerCase().includes(this.searchQuery.toLowerCase()));
                const matchesCategory = this.categoryFilter === 'all' || d.category === this.categoryFilter;
                return matchesSearch && matchesCategory;
            });
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700 pb-5">
            <div>
                <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-white">
                    {{ $isFacultyOrTaskForce ? __('Document Submission') : __('Documents Archive') }}
                </flux:heading>
                <flux:text class="text-sm mt-1 text-zinc-500 dark:text-zinc-400">
                    {{ $isFacultyOrTaskForce 
                        ? __('Upload scanned and digital compliance documents. Files are OCR-processed automatically.') 
                        : __('Search and review compiled quality assurance and accreditation documents.') }}
                </flux:text>
            </div>
            <div class="flex items-center gap-2">
                <flux:badge color="orange" size="sm" class="font-semibold uppercase tracking-wider">SECURE DATABASE</flux:badge>
            </div>
        </div>

        @if ($isFacultyOrTaskForce)
            <!-- ------------------------------------------------------------- -->
            <!-- FACULTY UPLOAD SECTION -->
            <!-- ------------------------------------------------------------- -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Dropzone Card -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs lg:col-span-2 flex flex-col gap-4">
                    <flux:heading class="font-bold text-base">New Upload</flux:heading>
                    
                    <div class="flex flex-col items-center justify-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 hover:border-orange-500 rounded-xl p-10 text-center transition-all bg-zinc-50/50 dark:bg-zinc-950/20 relative">
                        <input 
                            type="file" 
                            id="file-upload-input" 
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            @change="triggerMockUpload"
                            :disabled="uploading || ocrProcessing"
                        />
                        
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                        </svg>
                        
                        <div class="text-sm font-semibold mt-3 text-zinc-900 dark:text-white">Drag & drop files or click to browse</div>
                        <div class="text-xs text-zinc-400 mt-1">Supports PDF, DOCX, PNG, JPG (Max 20MB)</div>
                    </div>

                    <!-- Progress Indicator -->
                    <div x-show="uploading" class="mt-4 p-4 bg-zinc-50 dark:bg-zinc-950 border border-zinc-150 dark:border-zinc-800 rounded-lg" x-cloak>
                        <div class="flex justify-between items-center text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                            <span class="flex items-center gap-1.5">
                                <span class="animate-spin rounded-full h-3 w-3 border border-orange-500 border-t-transparent"></span>
                                Uploading file...
                            </span>
                            <span x-text="uploadProgress + '%'">0%</span>
                        </div>
                        <div class="w-full bg-zinc-200 dark:bg-zinc-800 h-2 rounded-full mt-2 overflow-hidden">
                            <div class="bg-orange-500 h-full transition-all duration-150" :style="'width: ' + uploadProgress + '%'"></div>
                        </div>
                    </div>

                    <!-- OCR Extraction Indicator -->
                    <div x-show="ocrProcessing" class="mt-4 p-4 bg-orange-50/50 dark:bg-orange-950/10 border border-orange-100 dark:border-orange-900/30 rounded-lg text-center" x-cloak>
                        <div class="flex items-center justify-center gap-2 text-xs font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider animate-pulse">
                            <svg class="animate-spin h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Tesseract OCR: Extracting scanned text...
                        </div>
                        <div class="text-[10px] text-zinc-400 mt-1">Analyzing pages, enhancing contrast, and parsing digital text content.</div>
                    </div>

                    <!-- Success Alert -->
                    <div x-show="uploadSuccess" class="mt-4 p-4 bg-green-50 text-green-700 border border-green-150 rounded-lg flex items-center gap-3" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <div class="text-xs font-bold">Upload and OCR Complete!</div>
                            <div class="text-[10px] text-green-600 mt-0.5">The document has been securely stored. Check the list below to review OCR text.</div>
                        </div>
                        <button @click="uploadSuccess = false" class="text-green-500 hover:text-green-700 text-xs font-bold">&times;</button>
                    </div>
                </div>

                <!-- Guidelines Card -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs flex flex-col gap-4">
                    <flux:heading class="font-bold text-base">OCR Best Practices</flux:heading>
                    <div class="space-y-3 text-xs text-zinc-500 dark:text-zinc-400">
                        <p><strong>1. Document Alignment:</strong> Scans must be upright (no rotations) for optimal optical character recognition.</p>
                        <p><strong>2. Print Quality:</strong> Ensure clean typography. Low contrast, hand-written notes, or smudged copies will decrease OCR accuracy.</p>
                        <p><strong>3. Private Details:</strong> Ensure no personal credit cards, PIN codes, or private credentials are included in compliance materials.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- ------------------------------------------------------------- -->
        <!-- CORE DIRECTORY / LIST VIEW -->
        <!-- ------------------------------------------------------------- -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
            <!-- Search & Filters -->
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
                <!-- Search Input -->
                <div class="relative w-full md:max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        placeholder="Search by filename or content (deep OCR search)..." 
                        x-model="searchQuery"
                        class="w-full pl-9 pr-4 py-1.5 text-sm bg-zinc-50 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 text-zinc-700 dark:text-zinc-300"
                    />
                </div>

                <!-- Filters -->
                <div class="flex gap-2 w-full md:w-auto">
                    <select 
                        x-model="categoryFilter"
                        class="w-full md:w-auto px-3 py-1.5 text-sm bg-zinc-50 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none text-zinc-700 dark:text-zinc-300"
                    >
                        <option value="all">All Categories</option>
                        <option value="Self-Survey">Self-Survey</option>
                        <option value="Curriculum Review">Curriculum Review</option>
                        <option value="Faculty Development">Faculty Development</option>
                        <option value="Course Syllabus">Course Syllabus</option>
                    </select>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-400 font-semibold uppercase">
                            <th class="py-3 px-4">Document Title</th>
                            <th class="py-3 px-4">Category</th>
                            <th class="py-3 px-4">Associated Program</th>
                            <th class="py-3 px-4">College</th>
                            <th class="py-3 px-4">Size</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <template x-for="doc in filteredDocs" :key="doc.id">
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/10">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2">
                                        <!-- PDF icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <div>
                                            <div class="font-bold text-zinc-900 dark:text-white" x-text="doc.title"></div>
                                            <div class="text-[10px] text-zinc-400 mt-0.5" x-text="'Uploaded: ' + doc.date + ' by ' + doc.uploader"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-600 dark:text-zinc-400 font-medium" x-text="doc.category"></td>
                                <td class="py-3.5 px-4 text-zinc-500 dark:text-zinc-400 font-semibold" x-text="doc.program"></td>
                                <td class="py-3.5 px-4 text-zinc-500 dark:text-zinc-400" x-text="doc.college"></td>
                                <td class="py-3.5 px-4 text-zinc-400" x-text="doc.size"></td>
                                <td class="py-3.5 px-4 text-right">
                                    <flux:button variant="ghost" size="xs" @click="openDocument(doc)" icon="eye">
                                        View Details
                                    </flux:button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredDocs.length === 0">
                            <td colspan="6" class="py-8 text-center text-zinc-400">
                                No documents match your search query or selected category.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Slide-over Drawer / Document Details Drawer -->
        <div x-show="showDetailDrawer" class="fixed inset-0 z-50 overflow-hidden" x-cloak>
            <div class="absolute inset-0 overflow-hidden">
                <!-- Overlay background -->
                <div class="absolute inset-0 bg-black/40 backdrop-blur-xs transition-opacity" @click="showDetailDrawer = false"></div>

                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div class="pointer-events-auto w-screen max-w-2xl bg-white dark:bg-zinc-900 border-l border-zinc-200 dark:border-zinc-800 p-6 shadow-xl flex flex-col gap-6" @click.away="showDetailDrawer = false">
                        <div class="flex justify-between items-center border-b border-zinc-150 dark:border-zinc-800 pb-4">
                            <div>
                                <flux:badge color="orange" size="xs">Document Viewer</flux:badge>
                                <h3 class="text-base font-bold text-zinc-900 dark:text-white mt-1" x-text="activeDoc ? activeDoc.title : ''"></h3>
                            </div>
                            <button @click="showDetailDrawer = false" class="text-zinc-400 hover:text-zinc-600 text-lg font-bold">&times;</button>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div class="p-3 bg-zinc-50 dark:bg-zinc-950 rounded-lg">
                                <span class="text-[10px] text-zinc-400 block font-semibold uppercase">Category</span>
                                <span class="font-bold text-zinc-700 dark:text-zinc-300 mt-0.5 block" x-text="activeDoc ? activeDoc.category : ''"></span>
                            </div>
                            <div class="p-3 bg-zinc-50 dark:bg-zinc-950 rounded-lg">
                                <span class="text-[10px] text-zinc-400 block font-semibold uppercase">Associated Program</span>
                                <span class="font-bold text-zinc-700 dark:text-zinc-300 mt-0.5 block" x-text="activeDoc ? activeDoc.program : ''"></span>
                            </div>
                            <div class="p-3 bg-zinc-50 dark:bg-zinc-950 rounded-lg">
                                <span class="text-[10px] text-zinc-400 block font-semibold uppercase">Associated College</span>
                                <span class="font-bold text-zinc-700 dark:text-zinc-300 mt-0.5 block" x-text="activeDoc ? activeDoc.college : ''"></span>
                            </div>
                            <div class="p-3 bg-zinc-50 dark:bg-zinc-950 rounded-lg">
                                <span class="text-[10px] text-zinc-400 block font-semibold uppercase">Uploader</span>
                                <span class="font-bold text-zinc-700 dark:text-zinc-300 mt-0.5 block" x-text="activeDoc ? activeDoc.uploader : ''"></span>
                            </div>
                        </div>

                        <!-- OCR Text Preview -->
                        <div class="flex-1 flex flex-col gap-2 min-h-0">
                            <flux:heading class="font-semibold text-xs text-zinc-500 uppercase tracking-wider">Tesseract OCR Text Extraction</flux:heading>
                            <div class="flex-1 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 overflow-y-auto font-mono text-[11px] leading-[18px] text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap" x-text="activeDoc ? (ocrResults[activeDoc.title] || 'No OCR text extracted for this document.') : ''">
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex gap-2 justify-end border-t border-zinc-150 dark:border-zinc-800 pt-4">
                            <button class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-xs font-semibold rounded-lg flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Download Original
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
