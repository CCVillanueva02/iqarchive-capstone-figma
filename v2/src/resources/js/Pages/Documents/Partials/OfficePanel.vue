<!--
================================================================================
IQArchive v2 — Common Documents Office Directory Panel
================================================================================
File: resources/js/Pages/Documents/Partials/OfficePanel.vue
Role: Displays selectable list of BU administrative offices with document counts.
UI Standard: DaisyUI card, badge, input.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Building2, Search } from 'lucide-vue-next';

const props = defineProps({
    offices: {
        type: Array,
        required: true,
    },
    selectedOfficeId: {
        type: [Number, String],
        default: null,
    },
});

const emit = defineEmits(['select']);

const officeSearch = ref('');

const filteredOffices = computed(() => {
    if (!officeSearch.value.trim()) {
        return props.offices;
    }
    const q = officeSearch.value.toLowerCase();
    return props.offices.filter(
        (o) => o.name.toLowerCase().includes(q) || (o.description && o.description.toLowerCase().includes(q))
    );
});
</script>

<template>
    <div class="card card-border bg-base-100 shadow-xs flex flex-col h-full">
        <div class="card-body p-4 space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <Building2 class="w-4 h-4 text-bu-navy-700" />
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">Offices & Units</h2>
                </div>
                <span class="badge badge-sm badge-neutral tabular-nums font-mono">
                    {{ offices.length }}
                </span>
            </div>

            <div class="relative">
                <Search class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                <input
                    v-model="officeSearch"
                    type="text"
                    placeholder="Filter offices..."
                    class="input input-sm input-bordered w-full pl-8 text-xs rounded-lg"
                />
            </div>

            <div class="space-y-1.5 overflow-y-auto max-h-[560px] pr-0.5">
                <button
                    v-for="office in filteredOffices"
                    :key="office.id"
                    type="button"
                    @click="emit('select', office.id)"
                    class="w-full text-left p-3 rounded-lg border transition-all flex flex-col gap-1 cursor-pointer"
                    :class="[
                        Number(selectedOfficeId) === Number(office.id)
                            ? 'bg-orange-50/70 border-orange-300 shadow-xs'
                            : 'bg-base-100 hover:bg-slate-50 border-slate-200/80 text-slate-700',
                    ]"
                >
                    <div class="flex items-center justify-between gap-2">
                        <span
                            class="text-xs font-bold leading-tight"
                            :class="Number(selectedOfficeId) === Number(office.id) ? 'text-orange-700' : 'text-slate-800'"
                        >
                            {{ office.name }}
                        </span>
                        <span
                            class="badge badge-xs tabular-nums font-mono"
                            :class="Number(selectedOfficeId) === Number(office.id) ? 'badge-primary text-white bg-orange-600 border-none' : 'badge-ghost text-slate-600'"
                        >
                            {{ office.documents_count ?? 0 }}
                        </span>
                    </div>
                    <p v-if="office.description" class="text-[11px] text-slate-500 line-clamp-1 leading-normal">
                        {{ office.description }}
                    </p>
                </button>

                <div v-if="filteredOffices.length === 0" class="py-6 text-center text-slate-400 text-xs">
                    No offices match your search.
                </div>
            </div>
        </div>
    </div>
</template>
