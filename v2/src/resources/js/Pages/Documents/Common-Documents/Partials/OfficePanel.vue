<!--
================================================================================
IQArchive v2 — Common Documents Office Directory Panel
================================================================================
File: resources/js/Pages/Documents/Common-Documents/Partials/OfficePanel.vue
Role: Displays selectable list of BU administrative offices with add office option.
UI Standard: DaisyUI card, badge, input, btn.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { Search } from 'lucide-vue-next';

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
    <div class="card card-border bg-base-100 shadow-xs flex flex-col h-full min-h-0">
        <div class="card-body p-4 flex flex-col h-full min-h-0 space-y-3">
            <div class="flex items-center justify-between shrink-0">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800">Offices</h2>
            </div>

            <div class="shrink-0">
                <label class="input input-sm input-bordered flex items-center gap-2 w-full rounded-lg">
                    <Search class="w-3.5 h-3.5 text-slate-400 shrink-0" />
                    <input
                        v-model="officeSearch"
                        type="text"
                        placeholder="Search offices..."
                        class="grow text-xs"
                    />
                </label>
            </div>

            <div class="flex-1 overflow-y-auto min-h-0 space-y-1.5 pr-0.5">
                <button
                    v-for="office in filteredOffices"
                    :key="office.id"
                    type="button"
                    @click="emit('select', office.id)"
                    class="w-full text-left p-3 rounded-lg border transition-all flex items-center justify-between gap-2 cursor-pointer"
                    :class="[
                        Number(selectedOfficeId) === Number(office.id)
                            ? 'bg-bu-blue-50 border-bu-blue-200 shadow-xs'
                            : 'bg-base-100 hover:bg-slate-50 border-slate-200/80 text-slate-700',
                    ]"
                >
                    <span
                        class="text-xs font-bold leading-tight"
                        :class="Number(selectedOfficeId) === Number(office.id) ? 'text-bu-blue-800' : 'text-slate-800'"
                    >
                        {{ office.name }}
                    </span>
                </button>

                <div v-if="filteredOffices.length === 0" class="py-6 text-center text-slate-400 text-xs">
                    No offices match your search.
                </div>
            </div>
        </div>
    </div>
</template>
