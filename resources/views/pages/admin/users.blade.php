<x-layouts::app :title="__('User Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-6" x-data="{
        searchQuery: '',
        roleFilter: 'all',
        showAddModal: false,
        showDeleteModal: false,
        deletingUser: null,
        newUser: { name: '', email: '', role: 'faculty-member', college: '' },
        users: [
            { id: 1, name: 'Dr. Maria Santos', email: 'maria.santos@bu.edu.ph', role: 'iqa-admin', college: 'Office of the President', status: 'active', date: 'Jul 10, 2025', initials: 'MS' },
            { id: 2, name: 'Prof. Alan Rivera', email: 'alan.rivera@bu.edu.ph', role: 'iqa-member', college: 'College of Science', status: 'active', date: 'Aug 14, 2025', initials: 'AR' },
            { id: 3, name: 'Dr. Jessica Lopez', email: 'jessica.lopez@bu.edu.ph', role: 'program-chair', college: 'College of Education', status: 'active', date: 'Sep 01, 2025', initials: 'JL' },
            { id: 4, name: 'Engr. David Tecson', email: 'david.tecson@bu.edu.ph', role: 'task-force', college: 'College of Engineering', status: 'active', date: 'Oct 12, 2025', initials: 'DT' },
            { id: 5, name: 'Dr. Evelyn Castro', email: 'evelyn.castro@bu.edu.ph', role: 'accreditor', college: 'AACCUP Board', status: 'active', date: 'Nov 05, 2025', initials: 'EC' },
            { id: 6, name: 'Prof. Michael Cruz', email: 'michael.cruz@bu.edu.ph', role: 'faculty-member', college: 'College of Science', status: 'pending', date: 'Today', initials: 'MC' },
            { id: 7, name: 'Dr. Roberto Diaz', email: 'roberto.diaz@bu.edu.ph', role: 'university-administrator', college: 'Office of Academic Affairs', status: 'active', date: 'Jan 15, 2026', initials: 'RD' }
        ],
        roleLabels: {
            'system-administrator': 'System Admin',
            'iqa-admin': 'IQA Admin',
            'iqa-member': 'IQA Member',
            'accreditor': 'Accreditor',
            'university-administrator': 'BU Admin/Exec',
            'task-force': 'Task Force',
            'program-chair': 'Program Chair',
            'faculty-member': 'Faculty Member'
        },
        roleBadges: {
            'system-administrator': 'zinc',
            'iqa-admin': 'orange',
            'iqa-member': 'blue',
            'accreditor': 'purple',
            'university-administrator': 'green',
            'task-force': 'teal',
            'program-chair': 'indigo',
            'faculty-member': 'zinc'
        },
        addUser() {
            if (!this.newUser.name || !this.newUser.email) return;
            const initials = this.newUser.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
            this.users.unshift({
                id: this.users.length + 1,
                name: this.newUser.name,
                email: this.newUser.email,
                role: this.newUser.role,
                college: this.newUser.college || 'Bicol University',
                status: 'pending',
                date: 'Today',
                initials: initials
            });
            this.showAddModal = false;
            this.newUser = { name: '', email: '', role: 'faculty-member', college: '' };
        },
        confirmDelete(user) {
            this.deletingUser = user;
            this.showDeleteModal = true;
        },
        deleteUser() {
            this.users = this.users.filter(u => u.id !== this.deletingUser.id);
            this.showDeleteModal = false;
            this.deletingUser = null;
        },
        get filteredUsers() {
            return this.users.filter(u => {
                const matchesSearch = u.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                     u.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                     u.college.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesRole = this.roleFilter === 'all' || u.role === this.roleFilter;
                return matchesSearch && matchesRole;
            });
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700 pb-5">
            <div>
                <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-white">{{ __('User Accounts') }}</flux:heading>
                <flux:text class="text-sm mt-1 text-zinc-500 dark:text-zinc-400">
                    Create, manage, and assign roles to Bicol University internal and external users.
                </flux:text>
            </div>
            <div class="flex items-center gap-2">
                <flux:button @click="showAddModal = true" class="bg-[#f27224] hover:bg-[#d65f1a] text-white border-none shadow-xs text-xs font-semibold px-4 py-2 rounded-lg flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0zM3 19.235v-.11a6 6 0 0 1 12 0v.11" />
                    </svg>
                    Add User Account
                </flux:button>
            </div>
        </div>

        <!-- Role Count Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-2xs">
                <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Total Accounts</div>
                <div class="text-xl font-bold mt-1 text-zinc-800 dark:text-white" x-text="users.length">7</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-2xs">
                <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Active Admins</div>
                <div class="text-xl font-bold mt-1 text-zinc-800 dark:text-white" x-text="users.filter(u => u.role === 'iqa-admin').length">1</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-2xs">
                <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Accreditors</div>
                <div class="text-xl font-bold mt-1 text-zinc-800 dark:text-white" x-text="users.filter(u => u.role === 'accreditor').length">1</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 shadow-2xs">
                <div class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider">Pending Invite</div>
                <div class="text-xl font-bold mt-1 text-zinc-800 dark:text-white text-orange-500" x-text="users.filter(u => u.status === 'pending').length">1</div>
            </div>
        </div>

        <!-- Directory Directory -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 shadow-2xs">
            <!-- Search & Filters -->
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-6 w-full">
                <!-- Search Input -->
                <div class="relative w-full md:max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        placeholder="Search by name, email, or department..." 
                        x-model="searchQuery"
                        class="w-full pl-9 pr-4 py-1.5 text-sm bg-zinc-50 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 text-zinc-700 dark:text-zinc-300"
                    />
                </div>

                <!-- Filters -->
                <div class="flex gap-2 w-full md:w-auto">
                    <select 
                        x-model="roleFilter"
                        class="w-full md:w-auto px-3 py-1.5 text-sm bg-zinc-50 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none text-zinc-700 dark:text-zinc-300"
                    >
                        <option value="all">All Roles</option>
                        <option value="system-administrator">System Admin</option>
                        <option value="iqa-admin">IQA Admin</option>
                        <option value="iqa-member">IQA Member</option>
                        <option value="accreditor">Accreditor</option>
                        <option value="university-administrator">BU Admin/Exec</option>
                        <option value="task-force">Task Force</option>
                        <option value="program-chair">Program Chair</option>
                        <option value="faculty-member">Faculty Member</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800 text-zinc-400 font-semibold uppercase">
                            <th class="py-3 px-4">User</th>
                            <th class="py-3 px-4">College / Office</th>
                            <th class="py-3 px-4">Role</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Date Created</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <template x-for="user in filteredUsers" :key="user.id">
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/10">
                                <td class="py-3.5 px-4 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-400 font-semibold flex items-center justify-center text-[11px]" x-text="user.initials"></div>
                                    <div>
                                        <div class="font-bold text-zinc-900 dark:text-white" x-text="user.name"></div>
                                        <div class="text-[10px] text-zinc-400" x-text="user.email"></div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-500 dark:text-zinc-400" x-text="user.college"></td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium" 
                                          :class="{
                                              'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300': roleBadges[user.role] === 'zinc',
                                              'bg-orange-50 text-orange-700 dark:bg-orange-950/20 dark:text-orange-400': roleBadges[user.role] === 'orange',
                                              'bg-blue-50 text-blue-700 dark:bg-blue-950/20 dark:text-blue-400': roleBadges[user.role] === 'blue',
                                              'bg-purple-50 text-purple-700 dark:bg-purple-950/20 dark:text-purple-400': roleBadges[user.role] === 'purple',
                                              'bg-green-50 text-green-700 dark:bg-green-950/20 dark:text-green-400': roleBadges[user.role] === 'green',
                                              'bg-teal-50 text-teal-700 dark:bg-teal-950/20 dark:text-teal-400': roleBadges[user.role] === 'teal',
                                              'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/20 dark:text-indigo-400': roleBadges[user.role] === 'indigo'
                                          }"
                                          x-text="roleLabels[user.role]">
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold"
                                          :class="user.status === 'active' ? 'bg-green-50 text-green-700 dark:bg-green-950/20 dark:text-green-400' : 'bg-orange-50 text-orange-700 dark:bg-orange-950/20 dark:text-orange-400'">
                                        <span class="w-1 h-1 rounded-full" :class="user.status === 'active' ? 'bg-green-500' : 'bg-orange-500'"></span>
                                        <span x-text="user.status"></span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-zinc-400" x-text="user.date"></td>
                                <td class="py-3.5 px-4 text-right">
                                    <flux:button variant="ghost" size="xs" @click="confirmDelete(user)" class="text-red-500 hover:text-red-700" icon="trash">
                                        Revoke
                                    </flux:button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredUsers.length === 0">
                            <td colspan="6" class="py-8 text-center text-zinc-400">
                                No users found matching your search or filters.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add User Modal -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4" x-cloak>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl max-w-md w-full p-6 shadow-xl flex flex-col gap-5" @click.away="showAddModal = false">
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">Provision New User Account</h3>
                    <p class="text-xs text-zinc-400 mt-1">This user will receive an email containing account credentials and a secure sign-in link.</p>
                </div>

                <div class="flex flex-col gap-4">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 mb-1">Full Name</label>
                        <input type="text" x-model="newUser.name" placeholder="Dr. Juan Dela Cruz" class="w-full px-3 py-2 text-xs border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 text-zinc-800 dark:text-white" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 mb-1">Email Address</label>
                        <input type="email" x-model="newUser.email" placeholder="juan.delacruz@bu.edu.ph" class="w-full px-3 py-2 text-xs border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 text-zinc-800 dark:text-white" />
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 mb-1">System Role</label>
                        <select x-model="newUser.role" class="w-full px-3 py-2 text-xs border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none text-zinc-800 dark:text-white">
                            <option value="system-administrator">System Administrator</option>
                            <option value="iqa-admin">IQA Admin</option>
                            <option value="iqa-member">IQA Member</option>
                            <option value="accreditor">Accreditor</option>
                            <option value="university-administrator">BU Admin/Executive</option>
                            <option value="task-force">Task Force</option>
                            <option value="program-chair">Program Chair</option>
                            <option value="faculty-member">Faculty Member</option>
                        </select>
                    </div>

                    <!-- College / Department -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500 mb-1">College / Office Association</label>
                        <input type="text" x-model="newUser.college" placeholder="College of Science" class="w-full px-3 py-2 text-xs border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500 text-zinc-800 dark:text-white" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-2">
                    <button @click="showAddModal = false" class="px-4 py-2 text-xs font-semibold text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg">Cancel</button>
                    <button @click="addUser" class="px-4 py-2 text-xs font-semibold bg-[#f27224] hover:bg-[#d65f1a] text-white rounded-lg">Provision Account</button>
                </div>
            </div>
        </div>

        <!-- Revoke Confirmation Modal -->
        <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4" x-cloak>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl max-w-sm w-full p-6 shadow-xl flex flex-col gap-4" @click.away="showDeleteModal = false">
                <div>
                    <h3 class="text-sm font-bold text-red-600">Revoke User Access</h3>
                    <p class="text-xs text-zinc-400 mt-1" x-text="'Are you sure you want to revoke system access for ' + (deletingUser ? deletingUser.name : '') + '? They will be logged out and cannot log back in.'"></p>
                </div>

                <div class="flex justify-end gap-2 mt-2">
                    <button @click="showDeleteModal = false" class="px-4 py-2 text-xs font-semibold text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg">Cancel</button>
                    <button @click="deleteUser" class="px-4 py-2 text-xs font-semibold bg-red-600 hover:bg-red-700 text-white rounded-lg">Revoke Access</button>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
