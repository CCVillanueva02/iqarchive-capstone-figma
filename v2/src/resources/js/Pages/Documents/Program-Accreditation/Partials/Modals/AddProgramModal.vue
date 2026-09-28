<!--
================================================================================
IQArchive v2 — Add Degree Program Modal
================================================================================
File: resources/js/Pages/Documents/Program-Accreditation/Partials/Modals/AddProgramModal.vue
Role: Modal dialog for IQA staff to register a new academic degree program.
UI Standard: DaisyUI modal-box, input-bordered, select-bordered, btn (< 160 lines).
================================================================================
-->

<script setup>
import { useForm } from '@inertiajs/vue3';
import { X, Plus, GraduationCap } from 'lucide-vue-next';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    college: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);

const form = useForm({
    college_id: '',
    code: '',
    name: '',
    current_level: 'Candidate Status',
});

function handleClose() {
    form.reset();
    form.clearErrors();
    emit('close');
}

function submit() {
    if (props.college) {
        form.college_id = props.college.id;
    }
    form.post('/documents/program-accreditation/programs', {
        preserveScroll: true,
        onSuccess: () => {
            handleClose();
        },
    });
}
</script>

<template>
    <dialog v-if="show" class="modal modal-open bg-slate-900/60 backdrop-blur-xs z-50">
        <div class="modal-box max-w-lg bg-base-100 p-6 rounded-2xl shadow-2xl border border-slate-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-orange-50 border border-orange-200 flex items-center justify-center text-bu-orange-500">
                        <GraduationCap class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Add Academic Degree Program</h3>
                        <p class="text-xs text-slate-500">{{ college?.name }} ({{ college?.code }})</p>
                    </div>
                </div>
                <button
                    type="button"
                    @click="handleClose"
                    class="btn btn-ghost btn-sm btn-circle text-slate-400 hover:text-slate-700"
                >
                    <X class="w-5 h-5" />
                </button>
            </div>

            <!-- Modal Form -->
            <form @submit.prevent="submit" class="space-y-4 pt-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Program Code <span class="text-error">*</span>
                    </label>
                    <input
                        v-model="form.code"
                        type="text"
                        placeholder="e.g. BSIT, BSCE, BSN"
                        class="input input-bordered w-full input-sm text-sm"
                        :class="{ 'input-error': form.errors.code }"
                        required
                    />
                    <p v-if="form.errors.code" class="text-error text-xs mt-1">{{ form.errors.code }}</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Full Degree Program Title <span class="text-error">*</span>
                    </label>
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="e.g. Bachelor of Science in Information Technology"
                        class="input input-bordered w-full input-sm text-sm"
                        :class="{ 'input-error': form.errors.name }"
                        required
                    />
                    <p v-if="form.errors.name" class="text-error text-xs mt-1">{{ form.errors.name }}</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Current Accreditation Level <span class="text-error">*</span>
                    </label>
                    <select
                        v-model="form.current_level"
                        class="select select-bordered w-full select-sm text-sm"
                        :class="{ 'select-error': form.errors.current_level }"
                        required
                    >
                        <option value="Candidate Status">Candidate Status</option>
                        <option value="Level 1">Level 1</option>
                        <option value="Level 2">Level 2</option>
                        <option value="Level 3">Level 3</option>
                        <option value="Level 4">Level 4</option>
                    </select>
                    <p v-if="form.errors.current_level" class="text-error text-xs mt-1">{{ form.errors.current_level }}</p>
                </div>

                <!-- Modal Actions -->
                <div class="modal-action pt-2 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button
                        type="button"
                        @click="handleClose"
                        class="btn btn-sm btn-ghost text-slate-600 hover:bg-slate-100"
                        :disabled="form.processing"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn btn-sm bg-bu-orange-500 hover:bg-bu-orange-600 text-white border-none gap-1.5"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing" class="loading loading-spinner loading-xs"></span>
                        <Plus v-else class="w-4 h-4" />
                        <span>Save Program</span>
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</template>
