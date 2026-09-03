{{--
    IQArchive Feature: Clean Document Repository Master
    Unified feature view for managing common, program, and institutional accreditation evidence.
--}}
<div class="w-full px-6 lg:px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen">
    <!-- 1. Unified Page Header -->
    <x-ui.page-header
        title="Document Repository"
        subtitle="Access institutional accreditation evidence, supporting documents, and compliance records."
        :breadcrumbs="[
            ['label' => 'Evidence Archive', 'url' => '#'],
            ['label' => 'Document Repository']
        ]"
    >
        <x-slot:actions>
            <x-ui.button
                type="button"
                variant="brand"
                size="sm"
                @click="openUploadModal ? openUploadModal() : null"
            >
                <x-slot:icon>
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                </x-slot:icon>
                Upload Document
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <!-- 2. Category Tab Strip & Search Filter Bar -->
    <div class="bg-white border border-zinc-200/80 rounded-2xl shadow-3xs p-4 flex flex-col gap-4">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-zinc-100 pb-3">
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    @click="activeTab = 'common-documents'"
                    :class="activeTab === 'common-documents' ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:text-primary hover:bg-zinc-100'"
                    class="px-3.5 py-1.5 rounded-xl text-body-sm font-bold transition cursor-pointer"
                >
                    Common Documents
                </button>
                <button
                    type="button"
                    @click="activeTab = 'program-accreditation'"
                    :class="activeTab === 'program-accreditation' ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:text-primary hover:bg-zinc-100'"
                    class="px-3.5 py-1.5 rounded-xl text-body-sm font-bold transition cursor-pointer"
                >
                    Program Evidence
                </button>
                <button
                    type="button"
                    @click="activeTab = 'institutional-accreditation'"
                    :class="activeTab === 'institutional-accreditation' ? 'bg-primary text-white shadow-xs' : 'text-zinc-600 hover:text-primary hover:bg-zinc-100'"
                    class="px-3.5 py-1.5 rounded-xl text-body-sm font-bold transition cursor-pointer"
                >
                    Institutional Survey
                </button>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="w-full sm:w-80">
                <flux:input
                    x-model="searchQuery"
                    placeholder="Search documents by title, tag, or code..."
                    icon="magnifying-glass"
                    size="sm"
                />
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-zinc-400 font-semibold">Filter:</span>
                <select
                    x-model="statusFilter"
                    class="text-xs font-bold border border-zinc-200 rounded-xl px-3 py-1.5 bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-primary/20 text-zinc-700 cursor-pointer"
                >
                    <option value="">All Statuses</option>
                    <option value="verified">Verified</option>
                    <option value="pending">Pending Review</option>
                    <option value="needs_revision">Needs Revision</option>
                </select>
            </div>
        </div>
    </div>

    <!-- 3. Standard Document Evidence Table using <x-ui.table> and <x-ui.document-chip> -->
    <x-ui.table>
        <x-slot:head>
            <th class="py-3 px-4 pl-6">Evidence Document</th>
            <th class="py-3 px-4">Category / Criterion</th>
            <th class="py-3 px-4">Uploaded By</th>
            <th class="py-3 px-4 text-center">Status</th>
            <th class="py-3 px-4">Upload Date</th>
            <th class="py-3 px-4 pr-6 text-right">Actions</th>
        </x-slot:head>

        <x-slot:body>
            <template x-for="doc in (filteredDocuments || [])" :key="doc.id">
                <tr class="hover:bg-zinc-50/70 transition-colors group">
                    <!-- File & Chip -->
                    <td class="py-3 px-4 pl-6">
                        <div class="flex items-center gap-3">
                            <x-ui.document-chip
                                ::title="doc.title"
                                ::file-name="doc.file_name || doc.title"
                                ::file-size="doc.file_size || 'PDF'"
                            />
                        </div>
                    </td>

                    <!-- Category / Criterion -->
                    <td class="py-3 px-4">
                        <span class="font-semibold text-zinc-800 block text-xs" x-text="doc.category || doc.criterion_code || 'General'"></span>
                        <span class="text-label-xs text-zinc-400 block mt-0.5" x-text="doc.area_name || 'Accreditation Archive'"></span>
                    </td>

                    <!-- Uploader -->
                    <td class="py-3 px-4">
                        <span class="text-xs font-medium text-zinc-700" x-text="doc.uploader_name || 'Institutional Staff'"></span>
                    </td>

                    <!-- Status -->
                    <td class="py-3 px-4 text-center">
                        <span
                            :class="{
                                'bg-emerald-50 text-emerald-700 border-emerald-200': doc.status === 'verified',
                                'bg-rose-50 text-rose-700 border-rose-200': doc.status === 'needs_revision',
                                'bg-amber-50 text-amber-700 border-amber-200': doc.status !== 'verified' && doc.status !== 'needs_revision'
                            }"
                            class="px-2.5 py-1 rounded-lg text-label-xs font-bold border inline-flex items-center gap-1.5"
                        >
                            <span
                                :class="{
                                    'bg-emerald-500': doc.status === 'verified',
                                    'bg-rose-500': doc.status === 'needs_revision',
                                    'bg-amber-500': doc.status !== 'verified' && doc.status !== 'needs_revision'
                                }"
                                class="w-1.5 h-1.5 rounded-full"
                            ></span>
                            <span x-text="doc.status ? doc.status.replace('_', ' ').toUpperCase() : 'PENDING'"></span>
                        </span>
                    </td>

                    <!-- Date -->
                    <td class="py-3 px-4">
                        <span class="text-xs text-zinc-500 font-mono" x-text="doc.created_at || 'Recent'"></span>
                    </td>

                    <!-- Actions -->
                    <td class="py-3 px-4 pr-6 text-right">
                        <div class="inline-flex items-center gap-2">
                            <a
                                :href="doc.view_url || '#'"
                                target="_blank"
                                class="p-1.5 rounded-lg text-zinc-500 hover:text-primary hover:bg-zinc-100 transition cursor-pointer"
                                title="View Document"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a
                                :href="doc.download_url || '#'"
                                class="p-1.5 rounded-lg text-zinc-500 hover:text-primary hover:bg-zinc-100 transition cursor-pointer"
                                title="Download Document"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            </template>
        </x-slot:body>
    </x-ui.table>
</div>
