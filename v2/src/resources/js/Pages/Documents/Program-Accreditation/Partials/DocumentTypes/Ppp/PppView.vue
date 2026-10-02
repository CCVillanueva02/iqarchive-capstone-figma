<!--
================================================================================
IQArchive v2 — Program Performance Profile (PPP) Workspace
================================================================================
Role: Searchable overview of the ten AACCUP areas, their live instrument
      requirements, and uploaded PPP documents.
UI Standard: DaisyUI + DESIGN.md semantic tokens.
================================================================================
-->

<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import StatusBadge from '@/Components/StatusBadge.vue';
import {
    ArrowRight,
    BookOpen,
    Building2,
    CheckCircle2,
    ClipboardCheck,
    Download,
    ExternalLink,
    FileText,
    FlaskConical,
    GraduationCap,
    Library,
    Microscope,
    Search,
    Settings,
    UploadCloud,
    Users,
    X,
} from 'lucide-vue-next';

const props = defineProps({
    program: { type: Object, required: true },
    college: { type: Object, required: true },
    documents: { type: Array, default: () => [] },
});

const emit = defineEmits(['openUpload', 'backToHub']);
const page = usePage();
const searchQuery = ref('');
const selectedArea = ref(null);

const areaIcons = [
    BookOpen,
    Users,
    GraduationCap,
    CheckCircle2,
    Microscope,
    ClipboardCheck,
    Library,
    Building2,
    FlaskConical,
    Settings,
];

const pppDocs = computed(() => props.documents.filter((document) => {
    const category = (document.category?.name || '').toLowerCase();
    const title = (document.title || '').toLowerCase();
    return category.includes('ppp') || category.includes('program performance profile') || title.includes('ppp');
}));

const areas = computed(() => (page.props.instrument?.areas || []).map((area, index) => {
    const parameters = area.parameters || [];
    const criteria = parameters.flatMap((parameter) => parameter.criteria || []);

    return {
        ...area,
        icon: areaIcons[index] || ClipboardCheck,
        parameterCount: parameters.length,
        criterionCount: criteria.length,
    };
}));

const filteredAreas = computed(() => {
    const query = searchQuery.value.trim().toLowerCase();
    if (!query) return areas.value;

    return areas.value.filter((area) => [
        area.area_number,
        area.name,
        area.description,
        ...(area.parameters || []).map((parameter) => parameter.name),
    ].join(' ').toLowerCase().includes(query));
});

const totalCriteria = computed(() => areas.value.reduce((total, area) => total + area.criterionCount, 0));
const totalParameters = computed(() => areas.value.reduce((total, area) => total + area.parameterCount, 0));

function areaLabel(areaNumber) {
    const romanNumerals = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];
    return romanNumerals[Number(areaNumber) - 1] || areaNumber;
}

function normalizedStatus(status) {
    if (status === 'iqa_appr') return 'approved';
    if (status === 'dean_appr') return 'submitted';
    return status || 'draft';
}

function openArea(area) {
    selectedArea.value = area;
}

function closeArea() {
    selectedArea.value = null;
}

function uploadForCriterion(criterionId = null) {
    emit('openUpload', criterionId);
}
</script>

<template>
    <div class="space-y-4">
        <section class="card card-border overflow-hidden rounded-box border-bu-blue-100 bg-base-100 shadow-xs">
            <div class="flex flex-col gap-4 bg-bu-blue-50 p-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 items-start gap-3">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-field border border-bu-blue-200 bg-base-100 text-bu-blue-700">
                        <ClipboardCheck class="size-5" />
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-heading-md font-bold text-slate-900">Program Performance Profile</h2>
                            <span class="badge badge-info badge-soft badge-sm">{{ program.current_level }}</span>
                        </div>
                        <p class="mt-1 text-body-sm text-slate-600">
                            Review the official AACCUP instrument and prepare profile evidence across all ten accreditation areas.
                        </p>
                    </div>
                </div>

                <div class="flex shrink-0 flex-wrap items-center gap-2">
                    <a
                        class="btn btn-sm btn-outline border-bu-blue-700 text-bu-blue-700 hover:border-bu-blue-700 hover:bg-bu-blue-700 hover:text-white"
                        href="https://docs.google.com/document/d/1Pwv8MBYmYrrh8aVwEJ8uwdlQp8B4emrw/edit?usp=sharing&ouid=109544054632104586601&rtpof=true&sd=true"
                        target="_blank"
                        rel="noreferrer"
                    >
                        <FileText class="size-4" />
                        PPP template
                        <ExternalLink class="size-3.5" />
                    </a>
                    <button type="button" class="btn btn-sm border-none bg-sidebar-blue text-white hover:bg-sidebar-blue-hover" @click="uploadForCriterion()">
                        <UploadCloud class="size-4" />
                        Upload PPP
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 divide-x divide-slate-200 border-t border-bu-blue-100 sm:grid-cols-4">
                <div class="p-4">
                    <p class="text-caption font-semibold text-slate-500">Survey areas</p>
                    <p class="mt-1 text-heading-lg font-bold tabular-nums text-slate-900">{{ areas.length }}</p>
                </div>
                <div class="p-4">
                    <p class="text-caption font-semibold text-slate-500">Parameters</p>
                    <p class="mt-1 text-heading-lg font-bold tabular-nums text-slate-900">{{ totalParameters }}</p>
                </div>
                <div class="border-t border-slate-200 p-4 sm:border-t-0">
                    <p class="text-caption font-semibold text-slate-500">Benchmarks</p>
                    <p class="mt-1 text-heading-lg font-bold tabular-nums text-slate-900">{{ totalCriteria }}</p>
                </div>
                <div class="border-t border-slate-200 p-4 sm:border-t-0">
                    <p class="text-caption font-semibold text-slate-500">PPP files</p>
                    <p class="mt-1 text-heading-lg font-bold tabular-nums text-bu-blue-700">{{ pppDocs.length }}</p>
                </div>
            </div>
        </section>

        <section>
            <div class="mb-3 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-heading-md font-bold text-slate-900">Accreditation areas</h2>
                    <p class="mt-1 text-caption text-slate-500">Open an area to inspect parameters, benchmarks, and upload criterion evidence.</p>
                </div>
                <label class="input input-sm input-bordered flex w-full items-center gap-2 rounded-field bg-base-100 shadow-xs focus-within:border-bu-blue-500 sm:w-72">
                    <Search class="size-4 shrink-0 text-slate-400" />
                    <input v-model="searchQuery" type="search" class="grow" placeholder="Search areas or parameters" />
                </label>
            </div>

            <div v-if="filteredAreas.length" class="grid grid-cols-1 gap-3 xl:grid-cols-2">
                <article
                    v-for="area in filteredAreas"
                    :key="area.id"
                    class="card card-border rounded-box border-slate-200 bg-base-100 shadow-xs transition-colors hover:border-bu-blue-200"
                >
                    <div class="card-body gap-3 p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex size-10 shrink-0 items-center justify-center rounded-field border border-bu-blue-100 bg-bu-blue-50 text-bu-blue-700">
                                <component :is="area.icon" class="size-5" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-micro font-bold uppercase tracking-wider text-bu-blue-600">Area {{ areaLabel(area.area_number) }}</p>
                                <h3 class="mt-0.5 text-heading-sm font-bold text-slate-900">{{ area.name }}</h3>
                            </div>
                            <span class="badge badge-neutral badge-soft badge-sm shrink-0">{{ area.criterionCount }} benchmarks</span>
                        </div>

                        <p class="line-clamp-2 min-h-10 text-body-sm leading-relaxed text-slate-600">{{ area.description }}</p>

                        <div class="flex items-center justify-between border-t border-slate-100 pt-3">
                            <div class="flex items-center gap-3 text-caption text-slate-500">
                                <span><strong class="text-slate-700">{{ area.parameterCount }}</strong> parameters</span>
                                <span><strong class="text-slate-700">{{ area.criterionCount }}</strong> criteria</span>
                            </div>
                            <button type="button" class="btn btn-xs border-none bg-sidebar-blue text-white hover:bg-sidebar-blue-hover" @click="openArea(area)">
                                Open area
                                <ArrowRight class="size-3.5" />
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            <div v-else class="card card-border rounded-box border-slate-200 bg-base-100 p-10 text-center">
                <Search class="mx-auto size-9 text-slate-300" />
                <h3 class="mt-3 text-heading-sm font-bold text-slate-800">No accreditation areas found</h3>
                <p class="mt-1 text-caption text-slate-500">Clear the search or use a broader area or parameter name.</p>
            </div>
        </section>

        <section class="card card-border overflow-hidden rounded-box border-slate-200 bg-base-100 shadow-xs">
            <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
                <div>
                    <h2 class="text-heading-sm font-bold text-slate-900">Uploaded PPP documents</h2>
                    <p class="mt-0.5 text-caption text-slate-500">Files attached to {{ program.name }}.</p>
                </div>
                <span class="badge badge-neutral badge-soft badge-sm">{{ pppDocs.length }} files</span>
            </div>

            <div v-if="pppDocs.length" class="overflow-x-auto">
                <table class="table table-sm w-full text-body-sm">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-caption text-slate-600">
                            <th>Document</th>
                            <th>Uploader</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="document in pppDocs" :key="document.id" class="hover:bg-slate-50/80">
                            <td>
                                <p class="font-semibold text-slate-900">{{ document.title }}</p>
                                <p class="mt-0.5 text-caption text-slate-500">{{ document.original_filename }}</p>
                            </td>
                            <td class="text-slate-600">{{ document.uploader?.name || 'System' }}</td>
                            <td><StatusBadge :status="normalizedStatus(document.status)" size="sm" /></td>
                            <td class="text-right">
                                <a :href="`/documents/${document.id}/download`" class="btn btn-xs btn-ghost text-sidebar-blue hover:bg-bu-blue-50">
                                    <Download class="size-3.5" />
                                    Download
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="p-8 text-center">
                <FileText class="mx-auto size-9 text-slate-300" />
                <p class="mt-3 text-heading-sm font-bold text-slate-700">No PPP documents uploaded</p>
                <p class="mt-1 text-caption text-slate-500">Upload the official profile or add evidence from an accreditation area.</p>
                <button type="button" class="btn btn-sm mt-4 border-none bg-sidebar-blue text-white hover:bg-sidebar-blue-hover" @click="uploadForCriterion()">
                    <UploadCloud class="size-4" />
                    Upload first document
                </button>
            </div>
        </section>

        <div v-if="selectedArea" class="fixed inset-0 z-50 flex justify-end bg-slate-900/40 backdrop-blur-[2px]" role="presentation" @mousedown.self="closeArea">
            <aside class="flex h-full w-full max-w-lg flex-col border-l border-slate-200 bg-base-100 shadow-2xl" role="dialog" aria-modal="true" :aria-label="`Area ${areaLabel(selectedArea.area_number)} details`">
                <div class="flex items-start gap-3 border-b border-slate-200 p-5">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-field border border-bu-blue-100 bg-bu-blue-50 text-bu-blue-700">
                        <component :is="selectedArea.icon" class="size-5" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-micro font-bold uppercase tracking-wider text-bu-blue-600">Area {{ areaLabel(selectedArea.area_number) }}</p>
                        <h2 class="mt-0.5 text-heading-md font-bold text-slate-900">{{ selectedArea.name }}</h2>
                        <p class="mt-1 text-caption leading-relaxed text-slate-500">{{ selectedArea.description }}</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-circle btn-ghost text-slate-500" aria-label="Close area details" @click="closeArea">
                        <X class="size-4" />
                    </button>
                </div>

                <div class="flex-1 space-y-3 overflow-y-auto p-5">
                    <section v-for="parameter in selectedArea.parameters" :key="parameter.id" class="card card-border rounded-box border-slate-200 bg-base-100">
                        <div class="card-body gap-3 p-4">
                            <div>
                                <p class="text-micro font-bold uppercase tracking-wider text-slate-400">Parameter {{ parameter.parameter_letter }}</p>
                                <h3 class="mt-0.5 text-heading-sm font-bold text-slate-900">{{ parameter.name }}</h3>
                            </div>

                            <div class="divide-y divide-slate-100 border-t border-slate-100">
                                <div v-for="criterion in parameter.criteria" :key="criterion.id" class="flex items-start gap-3 py-3">
                                    <span class="badge badge-neutral badge-soft badge-sm shrink-0 font-mono">{{ criterion.benchmark_code }}</span>
                                    <p class="flex-1 text-caption leading-relaxed text-slate-700">{{ criterion.title }}</p>
                                    <button type="button" class="btn btn-xs btn-ghost shrink-0 text-sidebar-blue hover:bg-bu-blue-50" title="Upload evidence" @click="uploadForCriterion(criterion.id)">
                                        <UploadCloud class="size-3.5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="flex items-center justify-between border-t border-slate-200 p-4">
                    <p class="text-caption text-slate-500">{{ selectedArea.criterionCount }} benchmarks in this area</p>
                    <button type="button" class="btn btn-sm border-none bg-sidebar-blue text-white hover:bg-sidebar-blue-hover" @click="uploadForCriterion()">
                        <UploadCloud class="size-4" />
                        Upload area file
                    </button>
                </div>
            </aside>
        </div>
    </div>
</template>
