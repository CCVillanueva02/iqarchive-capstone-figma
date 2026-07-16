<x-layouts::app :title="__('Audit Logs')">
    <div class="flex h-full w-full flex-1 flex-col gap-6" x-data="{
        searchQuery: '',
        statusFilter: 'all',
        categoryFilter: 'all',
        showPayloadModal: false,
        activeLog: null,
        logs: [
            { id: 1, timestamp: '2026-07-16 22:58:12', actor: 'iqa_admin@bu.edu.ph', action: 'CREATE_USER', category: 'USER_MGMT', target: 'prof.cruz@bu.edu.ph', ip: '192.168.1.45', status: 'success', ua: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...', payload: '{\n  \'name\': \'Prof. Michael Cruz\',\n  \'email\': \'prof.cruz@bu.edu.ph\',\n  \'role\': \'faculty-member\',\n  \'college\': \'College of Science\'\n}' },
            { id: 2, timestamp: '2026-07-16 22:04:15', actor: 'system', action: 'DATABASE_BACKUP', category: 'SYSTEM', target: 'backup_20260716.sql.gz', ip: 'localhost', status: 'success', ua: 'Laravel Scheduled Tasks CLI', payload: '{\n  \'file\': \'backup_20260716.sql.gz\',\n  \'size_bytes\': 5033164,\n  \'driver\': \'local\',\n  \'time_taken_seconds\': 1.8\n}' },
            { id: 3, timestamp: '2026-07-16 21:12:44', actor: 'unknown', action: 'LOGIN_FAILED', category: 'AUTH', target: 'admin@bu.edu.ph', ip: '222.127.43.12', status: 'failed', ua: 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36...', payload: '{\n  \'email\': \'admin@bu.edu.ph\',\n  \'reason\': \'invalid_password\',\n  \'attempts\': 3\n}' },
            { id: 4, timestamp: '2026-07-16 19:40:02', actor: 'accreditor@bu.edu.ph', action: 'USER_LOGIN', category: 'AUTH', target: 'accreditor@bu.edu.ph', ip: '192.168.1.102', status: 'success', ua: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)...', payload: '{\n  \'auth_type\': \'passkey\',\n  \'credential_id\': \'pk_61048b2e\',\n  \'session_lifetime\': 120\n}' },
            { id: 5, timestamp: '2026-07-16 18:22:51', actor: 'prof.rivera@bu.edu.ph', action: 'DOCUMENT_UPLOAD', category: 'DOCUMENT', target: 'IQA-Curriculum-Review-BSCS.pdf', ip: '192.168.2.14', status: 'success', ua: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)...', payload: '{\n  \'filename\': \'IQA-Curriculum-Review-BSCS.pdf\',\n  \'file_size_bytes\': 1153433,\n  \'ocr_extracted\': true,\n  \'category\': \'Curriculum Review\'\n}' },
            { id: 6, timestamp: '2026-07-16 17:15:30', actor: 'maria.santos@bu.edu.ph', action: 'ACCESS_REQUEST_APPROVED', category: 'DOCUMENT', target: 'Request #14 (IQA-Syllabus-2025)', ip: '192.168.1.45', status: 'success', ua: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)...', payload: '{\n  \'request_id\': 14,\n  \'approved_for\': \'prof.cruz@bu.edu.ph\',\n  \'document_id\': 8,\n  \'access_expiry\': \'2026-07-23 17:15:30\'\n}' },
            { id: 7, timestamp: '2026-07-16 15:02:11', actor: 'system', action: 'ENFORCE_HTTPS_REWRITE', category: 'SYSTEM', target: 'Middleware Engine', ip: 'internal', status: 'success', ua: 'Laravel Framework Base', payload: '{\n  \'enforce_https\': true,\n  \'hsts_preload\': true,\n  \'max_age\': 31536000\n}' }
        ],
        categoryLabels: {
            'AUTH': 'Authentication',
            'USER_MGMT': 'User Management',
            'DOCUMENT': 'Document & OCR',
            'SYSTEM': 'System Ops'
        },
        viewPayload(log) {
            this.activeLog = log;
            this.showPayloadModal = true;
        },
        get filteredLogs() {
            return this.logs.filter(l => {
                const matchesSearch = l.actor.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                     l.action.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                     l.target.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                     l.ip.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesStatus = this.statusFilter === 'all' || l.status === this.statusFilter;
                const matchesCategory = this.categoryFilter === 'all' || l.category === this.categoryFilter;
                return matchesSearch && matchesStatus && matchesCategory;
            });
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700 pb-5">
            <div>
                <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('Audit Logs') }}</flux:heading>
                <flux:text class="text-sm mt-1 text-zinc-500 dark:text-zinc-400">
                    Track system actions, user logins, and administrative actions for security auditing and compliance review.
                </flux:text>
            </div>
            <div class="flex items-center gap-2">
                <flux:badge color="orange" size="sm" class="font-semibold uppercase tracking-wider">SYSTEM LOGS</flux:badge>
            </div>
        </div>

        <!-- Directory Board -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
            <!-- Search & Filters -->
            <div class="flex flex-col lg:flex-row gap-4 justify-between items-center mb-6">
                <!-- Search Input -->
                <div class="relative w-full lg:max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        placeholder="Search by actor, action, target, or IP address..." 
                        x-model="searchQuery"
                        class="w-full pl-9 pr-4 py-1.5 text-sm bg-zinc-50 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 text-zinc-700 dark:text-zinc-300"
                    />
                </div>

                <!-- Filters -->
                <div class="flex gap-2 w-full lg:w-auto">
                    <select 
                        x-model="categoryFilter"
                        class="w-full lg:w-auto px-3 py-1.5 text-sm bg-zinc-50 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none text-zinc-700 dark:text-zinc-300"
                    >
                        <option value="all">All Event Types</option>
                        <option value="AUTH">Authentication</option>
                        <option value="USER_MGMT">User Management</option>
                        <option value="DOCUMENT">Document & OCR</option>
                        <option value="SYSTEM">System Ops</option>
                    </select>

                    <select 
                        x-model="statusFilter"
                        class="w-full lg:w-auto px-3 py-1.5 text-sm bg-zinc-50 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none text-zinc-700 dark:text-zinc-300"
                    >
                        <option value="all">All Statuses</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-400 font-semibold uppercase">
                            <th class="py-3 px-4">Timestamp</th>
                            <th class="py-3 px-4">Actor</th>
                            <th class="py-3 px-4">Action</th>
                            <th class="py-3 px-4">Target Entity</th>
                            <th class="py-3 px-4">IP Address</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <template x-for="log in filteredLogs" :key="log.id">
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/10">
                                <td class="py-3.5 px-4 text-zinc-400" x-text="log.timestamp"></td>
                                <td class="py-3.5 px-4 font-semibold text-zinc-900 dark:text-white" x-text="log.actor"></td>
                                <td class="py-3.5 px-4 font-mono text-[10px]">
                                    <span class="px-1.5 py-0.5 rounded-sm bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300" x-text="log.action"></span>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-600 dark:text-zinc-300 font-medium" x-text="log.target"></td>
                                <td class="py-3.5 px-4 text-zinc-500 dark:text-zinc-400" x-text="log.ip"></td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-semibold"
                                          :class="log.status === 'success' ? 'bg-green-50 text-green-700 dark:bg-green-950/20 dark:text-green-400' : 'bg-red-50 text-red-700 dark:bg-red-950/20 dark:text-red-400'">
                                        <span x-text="log.status === 'success' ? 'Success' : 'Failed'"></span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <flux:button variant="ghost" size="xs" @click="viewPayload(log)" icon="code-bracket">
                                        Payload
                                    </flux:button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredLogs.length === 0">
                            <td colspan="7" class="py-8 text-center text-zinc-400">
                                No audit events found matching your filter criteria.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payload Modal -->
        <div x-show="showPayloadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4" x-cloak>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl max-w-lg w-full p-6 shadow-xl flex flex-col gap-4" @click.away="showPayloadModal = false">
                <div>
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-white">Audit Event Details</h3>
                    <p class="text-[10px] text-zinc-400 mt-0.5" x-text="'ID: ' + (activeLog ? activeLog.id : '') + ' &bull; Logged: ' + (activeLog ? activeLog.timestamp : '')"></p>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="block text-[10px] text-zinc-400 font-bold uppercase">Browser User Agent</span>
                        <span class="block text-zinc-700 dark:text-zinc-300 font-medium break-all border border-zinc-100 dark:border-zinc-800 p-2 rounded bg-zinc-50 dark:bg-zinc-950 text-[10px] mt-1" x-text="activeLog ? activeLog.ua : ''"></span>
                    </div>

                    <div>
                        <span class="block text-[10px] text-zinc-400 font-bold uppercase">Metadata Payload (JSON)</span>
                        <pre class="bg-zinc-50 dark:bg-zinc-950 border border-zinc-150 dark:border-zinc-800 rounded p-3 font-mono text-[10px] text-zinc-700 dark:text-zinc-300 overflow-x-auto mt-1" x-text="activeLog ? activeLog.payload : ''"></pre>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-2">
                    <button @click="showPayloadModal = false" class="px-4 py-2 text-xs font-semibold bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700 rounded-lg">Close Details</button>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
