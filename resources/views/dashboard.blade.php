<x-layouts::app :title="__('Dashboard')">
    @php
        $role = session('preview_role', 'iqa-admin');
        $roleLabels = [
            'system-administrator' => 'System Administrator',
            'iqa-admin' => 'IQA Admin',
            'iqa-member' => 'IQA Member',
            'accreditor' => 'Accreditor',
            'university-administrator' => 'BU Admin/Exec',
            'task-force' => 'Task Force',
            'program-chair' => 'Program Chair',
            'faculty-member' => 'Faculty Member'
        ];
    @endphp

    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700 pb-5">
            <div>
                <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Dashboard') }}</flux:heading>
                <flux:text class="text-sm mt-1 text-zinc-500 dark:text-zinc-400">
                    Welcome back, <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ auth()->user()->name }}</span>. You are viewing the <span class="text-orange-500 font-semibold">{{ $roleLabels[$role] ?? $role }}</span> workspace.
                </flux:text>
            </div>
            <div class="flex items-center gap-2">
                <flux:badge color="orange" size="sm" class="font-semibold uppercase tracking-wider">BU IQA OFFICE</flux:badge>
            </div>
        </div>

        <!-- ------------------------------------------------------------- -->
        <!-- SYSTEM ADMINISTRATOR DASHBOARD -->
        <!-- ------------------------------------------------------------- -->
        @if ($role === 'system-administrator')
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Active User Accounts</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">42</div>
                    <flux:text class="text-xs text-green-500 font-medium mt-1">All accounts active</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">System Logs Recorded (Today)</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">189</div>
                    <flux:text class="text-xs text-zinc-400 mt-1">Normal system load</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Database Size & Backups</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">4.8 MB</div>
                    <flux:text class="text-xs text-green-500 font-medium mt-1">Last backup: 2h ago</flux:text>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Audit Events -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs lg:col-span-2">
                    <flux:heading class="font-bold text-base mb-4">Security & System Events</flux:heading>
                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach([
                            ['time' => '10 minutes ago', 'actor' => 'iqa_admin@bu.edu.ph', 'action' => 'Created user account: prof.cruz@bu.edu.ph', 'ip' => '192.168.1.45', 'status' => 'success'],
                            ['time' => '1 hour ago', 'actor' => 'system', 'action' => 'Automatic DB backup completed', 'ip' => 'localhost', 'status' => 'success'],
                            ['time' => '3 hours ago', 'actor' => 'unknown', 'action' => 'Failed login attempt (email: admin@bu.edu.ph)', 'ip' => '222.127.43.12', 'status' => 'failed'],
                            ['time' => '5 hours ago', 'actor' => 'accreditor@bu.edu.ph', 'action' => 'Authenticated via Passkey', 'ip' => '192.168.1.102', 'status' => 'success']
                        ] as $event)
                            <div class="py-3 flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="text-xs font-semibold text-zinc-900 dark:text-white">{{ $event['action'] }}</div>
                                    <div class="text-[11px] text-zinc-400 mt-0.5">By {{ $event['actor'] }} &bull; IP: {{ $event['ip'] }}</div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-zinc-400 block">{{ $event['time'] }}</span>
                                    <span class="inline-flex mt-1 items-center px-1.5 py-0.5 rounded-full text-[9px] font-semibold {{ $event['status'] === 'success' ? 'bg-green-50 text-green-700 dark:bg-green-950/20 dark:text-green-400' : 'bg-red-50 text-red-700 dark:bg-red-950/20 dark:text-red-400' }}">
                                        {{ ucfirst($event['status']) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Admin Actions Panel -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs flex flex-col gap-4">
                    <flux:heading class="font-bold text-base">Quick Maintenance Actions</flux:heading>
                    <flux:button href="{{ route('admin.audit-logs') }}" icon="shield" class="w-full justify-start text-xs">View Full Audit Log</flux:button>
                    <flux:button href="#" icon="cog" class="w-full justify-start text-xs">Manage System Configuration</flux:button>
                    <flux:button href="#" icon="arrow-up-tray" class="w-full justify-start text-xs">Trigger Backup Now</flux:button>
                </div>
            </div>
        @endif

        <!-- ------------------------------------------------------------- -->
        <!-- IQA ADMIN DASHBOARD -->
        <!-- ------------------------------------------------------------- -->
        @if ($role === 'iqa-admin')
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Users</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">87</div>
                    <flux:text class="text-xs text-zinc-400 mt-1">3 pending invitations</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Access Requests</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">4</div>
                    <flux:text class="text-xs text-orange-500 font-medium mt-1">Requires approval</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Active Instruments</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">6</div>
                    <flux:text class="text-xs text-zinc-400 mt-1">BU-wide coverage</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Global Compliance Rate</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">78%</div>
                    <flux:text class="text-xs text-green-500 font-medium mt-1">+3% since last month</flux:text>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Actionable Access Requests -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <flux:heading class="font-bold text-base">Pending Access Requests</flux:heading>
                        <flux:badge color="orange" size="xs">Needs Action</flux:badge>
                    </div>
                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach([
                            ['user' => 'Dr. Maria Santos', 'dept' => 'College of Education', 'doc' => 'BU-IQA-Self-Survey-Report-2025.pdf', 'date' => 'Today'],
                            ['user' => 'Prof. Alan Rivera', 'dept' => 'College of Science', 'doc' => 'IQA-Curriculum-Review-BSCS.pdf', 'date' => 'Yesterday'],
                            ['user' => 'Dr. Jessica Lopez', 'dept' => 'College of Medicine', 'doc' => 'Faculty-Development-Plan-2026.pdf', 'date' => '2 days ago']
                        ] as $request)
                            <div class="py-3.5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="text-xs font-semibold text-zinc-900 dark:text-white">{{ $request['user'] }} <span class="font-normal text-zinc-400">({{ $request['dept'] }})</span></div>
                                    <div class="text-[11px] text-zinc-400 mt-0.5">Requesting: <span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ $request['doc'] }}</span></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <flux:button variant="ghost" size="xs" class="text-red-600 hover:text-red-700">Deny</flux:button>
                                    <flux:button variant="primary" size="xs" class="bg-orange-500 hover:bg-orange-600 border-none text-white text-[10px]">Approve</flux:button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Admin Action Panels -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs flex flex-col gap-4">
                    <flux:heading class="font-bold text-base">Quick Actions</flux:heading>
                    <flux:button href="{{ route('admin.users') }}" icon="users" class="w-full justify-start text-xs">Provision New User Account</flux:button>
                    <flux:button href="{{ route('documents.index') }}" icon="folder" class="w-full justify-start text-xs">Browse Documents Archive</flux:button>
                    <flux:button href="#" icon="clipboard" class="w-full justify-start text-xs">Design Accreditation Instrument</flux:button>
                </div>
            </div>
        @endif

        <!-- ------------------------------------------------------------- -->
        <!-- FACULTY MEMBER DASHBOARD -->
        <!-- ------------------------------------------------------------- -->
        @if ($role === 'faculty-member')
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">My Submissions</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">14</div>
                    <flux:text class="text-xs text-green-500 font-medium mt-1">All processed successfully</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Active Checklists Assigned</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">2</div>
                    <flux:text class="text-xs text-orange-500 font-medium mt-1">1 due in 5 days</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">OCR Extractions Generated</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">14</div>
                    <flux:text class="text-xs text-zinc-400 mt-1">Full-text searchable</flux:text>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Document Upload Area Preview -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs lg:col-span-2">
                    <flux:heading class="font-bold text-base mb-2">Submit Document (OCR Enabled)</flux:heading>
                    <flux:text class="text-xs text-zinc-400 mb-6">Upload program reports, syllabi, and compliance data. We automatically convert scans to searchable text.</flux:text>
                    
                    <a href="{{ route('documents.index') }}" class="group block border-2 border-dashed border-zinc-200 dark:border-zinc-800 hover:border-orange-500 dark:hover:border-orange-500/50 rounded-xl p-8 text-center transition-all bg-zinc-50/50 dark:bg-zinc-950/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto text-zinc-400 group-hover:text-orange-500 transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                        </svg>
                        <div class="text-sm font-semibold mt-3 text-zinc-900 dark:text-white">Click here to go to Document Submission</div>
                        <div class="text-xs text-zinc-400 mt-1">Supports PDF, DOCX, PNG, JPG (Max 20MB)</div>
                    </a>
                </div>

                <!-- Personal Checklists -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs flex flex-col gap-4">
                    <flux:heading class="font-bold text-base">Assigned Checklists</flux:heading>
                    <div class="flex flex-col gap-3">
                        <div class="p-3 border border-zinc-150 dark:border-zinc-800 rounded-lg">
                            <div class="text-xs font-semibold text-zinc-900 dark:text-white">BSCS Level IV Accreditation</div>
                            <div class="text-[10px] text-zinc-400 mt-1">Progress: 8/12 items uploaded</div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 rounded-full mt-2 overflow-hidden">
                                <div class="bg-orange-500 h-full w-[66%]"></div>
                            </div>
                        </div>
                        <div class="p-3 border border-zinc-150 dark:border-zinc-800 rounded-lg">
                            <div class="text-xs font-semibold text-zinc-900 dark:text-white">IQA Syllabus Review 2026</div>
                            <div class="text-[10px] text-zinc-400 mt-1">Progress: 2/5 items uploaded</div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-1.5 rounded-full mt-2 overflow-hidden">
                                <div class="bg-orange-500 h-full w-[40%]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- ------------------------------------------------------------- -->
        <!-- ACCREDITOR DASHBOARD -->
        <!-- ------------------------------------------------------------- -->
        @if ($role === 'accreditor')
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Programs Assigned for Review</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">4</div>
                    <flux:text class="text-xs text-orange-500 font-medium mt-1">2 ready for final review</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Accreditation Submissions</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">16</div>
                    <flux:text class="text-xs text-zinc-400 mt-1">Read-only document access</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Review Audits Logged</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">8</div>
                    <flux:text class="text-xs text-green-500 font-medium mt-1">Logged for integrity</flux:text>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Program Submission Table -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs lg:col-span-2">
                    <flux:heading class="font-bold text-base mb-4">Assigned Programs Submissions</flux:heading>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-zinc-100 dark:border-zinc-800 text-zinc-400 font-semibold uppercase">
                                    <th class="py-2.5">Program</th>
                                    <th class="py-2.5">College</th>
                                    <th class="py-2.5">Status</th>
                                    <th class="py-2.5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                @foreach([
                                    ['program' => 'BS Computer Science', 'college' => 'College of Science', 'status' => 'Ready for Review', 'badge' => 'orange'],
                                    ['program' => 'BS Civil Engineering', 'college' => 'College of Engineering', 'status' => 'Pending Uploads', 'badge' => 'zinc'],
                                    ['program' => 'BS Nursing', 'college' => 'College of Nursing', 'status' => 'Reviewed & Approved', 'badge' => 'green']
                                ] as $prog)
                                    <tr>
                                        <td class="py-3 font-semibold text-zinc-900 dark:text-white">{{ $prog['program'] }}</td>
                                        <td class="py-3 text-zinc-500 dark:text-zinc-400">{{ $prog['college'] }}</td>
                                        <td class="py-3">
                                            <flux:badge color="{{ $prog['badge'] }}" size="xs">{{ $prog['status'] }}</flux:badge>
                                        </td>
                                        <td class="py-3 text-right">
                                            <flux:button size="xs" href="{{ route('documents.index') }}" variant="ghost">View Files</flux:button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Accreditor Guidelines Panel -->
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs flex flex-col gap-4">
                    <flux:heading class="font-bold text-base">Accreditor Notice</flux:heading>
                    <flux:text class="text-xs text-zinc-400">Your account is granted read-only access to compiled program files under the Bicol University Accreditation guidelines. All document review and page access actions are logged in the System Audit Log for compliance.</flux:text>
                    <flux:button href="{{ route('documents.index') }}" icon="folder" class="w-full justify-start text-xs">Browse Documents Archive</flux:button>
                </div>
            </div>
        @endif

        <!-- ------------------------------------------------------------- -->
        <!-- MOCKUP OF OTHER ROLES (FALLBACK GENTLE GRAPHICS) -->
        <!-- ------------------------------------------------------------- -->
        @if (!in_array($role, ['system-administrator', 'iqa-admin', 'faculty-member', 'accreditor']))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Program Files</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">1,420</div>
                    <flux:text class="text-xs text-zinc-400 mt-1">9 Colleges represented</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Compliance Rate</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">78%</div>
                    <flux:text class="text-xs text-green-500 font-medium mt-1">Target: 85% by end of cycle</flux:text>
                </div>
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Accredited Programs</flux:text>
                    <div class="text-3xl font-bold mt-2 text-zinc-900 dark:text-white">24 / 32</div>
                    <flux:text class="text-xs text-zinc-400 mt-1">8 programs in preparation</flux:text>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
                <flux:heading class="font-bold text-base mb-2">Executive Summary: College Compliance Overview</flux:heading>
                <flux:text class="text-xs text-zinc-400 mb-6">A breakdown of compliance and compilation percentage for BU colleges under current QA Cycle.</flux:text>
                
                <div class="space-y-4">
                    @foreach([
                        ['college' => 'College of Science (CS)', 'pct' => 92, 'color' => 'bg-green-500'],
                        ['college' => 'College of Education (CE)', 'pct' => 88, 'color' => 'bg-green-500'],
                        ['college' => 'College of Engineering (CENG)', 'pct' => 74, 'color' => 'bg-orange-500'],
                        ['college' => 'College of Business, Economics and Management (CBEM)', 'pct' => 65, 'color' => 'bg-orange-500'],
                        ['college' => 'College of Nursing (CN)', 'pct' => 98, 'color' => 'bg-green-500']
                    ] as $row)
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                <span>{{ $row['college'] }}</span>
                                <span>{{ $row['pct'] }}%</span>
                            </div>
                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2.5 rounded-full mt-1.5 overflow-hidden">
                                <div class="{{ $row['color'] }} h-full" style="width: {{ $row['pct'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts::app>
