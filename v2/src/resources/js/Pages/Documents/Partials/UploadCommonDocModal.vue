<!--
================================================================================
IQArchive v2 — Upload Common Document Modal
================================================================================
File: resources/js/Pages/Documents/Partials/UploadCommonDocModal.vue
Role: DaisyUI modal for uploading university-wide common documents.
UI Standard: DaisyUI modal, file-input, input, select, textarea, btn.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { UploadCloud, X, AlertCircle } from 'lucide-vue-next';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    offices: {
        type: Array,
        required: true,
    },
    initialOfficeId: {
        type: [Number, String],
        default: null,
    },
});

const emit = defineEmits(['close']);

const form = useForm({
    title: '',
    office_id: props.initialOfficeId || (props.offices[0]?.id ?? ''),
    file: null,
    description: '',
});

watch(
    () => props.initialOfficeId,
    (newVal) => {
        if (newVal) form.office_id = newVal;
    }
);

function handleFileChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.file = file;
    }
}

function submit() {
    form.post('/documents/common', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit('close');
        },
    });
}
</script>

<template>
    <dialog class="modal" :class="{ 'modal-open': show }">
        <div class="modal-box max-w-lg bg-base-100 p-6 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="p-2 rounded-lg bg-orange-50 text-orange-600">
                        <UploadCloud class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-slate-800">Upload Common Document</h3>
                        <p class="text-xs text-slate-500">Add an institutional policy to the university vault.</p>
                    </div>
                </div>
                <button type="button" @click="emit('close')" class="btn btn-sm btn-ghost btn-circle">
                    <X class="w-4 h-4" />
                </button>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="label pb-1">
                        <span class="label-text text-xs font-semibold text-slate-700">Originating Office *</span>
                    </label>
                    <select v-model="form.office_id" class="select select-sm select-bordered w-full text-xs">
                        <option v-for="off in offices" :key="off.id" :value="off.id">
                            {{ off.name }}
                        </option>
                    </select>
                    <span v-if="form.errors.office_id" class="text-xs text-error mt-1 flex items-center gap-1">
                        <AlertCircle class="w-3.5 h-3.5" /> {{ form.errors.office_id }}
                    </span>
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text text-xs font-semibold text-slate-700">Document Title *</span>
                    </label>
                    <input
                        v-model="form.title"
                        type="text"
                        placeholder="e.g. BU Faculty Merit Promotion System 2024"
                        class="input input-sm input-bordered w-full text-xs"
                    />
                    <span v-if="form.errors.title" class="text-xs text-error mt-1 flex items-center gap-1">
                        <AlertCircle class="w-3.5 h-3.5" /> {{ form.errors.title }}
                    </span>
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text text-xs font-semibold text-slate-700">PDF File Attachment * (max 20MB)</span>
                    </label>
                    <input
                        type="file"
                        accept="application/pdf"
                        @change="handleFileChange"
                        class="file-input file-input-sm file-input-bordered w-full text-xs"
                    />
                    <span v-if="form.errors.file" class="text-xs text-error mt-1 flex items-center gap-1">
                        <AlertCircle class="w-3.5 h-3.5" /> {{ form.errors.file }}
                    </span>
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text text-xs font-semibold text-slate-700">Notes / Remarks (Optional)</span>
                    </label>
                    <textarea
                        v-model="form.description"
                        rows="2"
                        placeholder="Add context or applicability details..."
                        class="textarea textarea-bordered textarea-sm w-full text-xs"
                    ></textarea>
                </div>

                <div class="modal-action pt-2 flex items-center justify-end gap-2 border-t border-slate-100">
                    <button type="button" @click="emit('close')" class="btn btn-sm btn-ghost text-slate-600">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="btn btn-sm bg-orange-600 hover:bg-orange-700 text-white border-none gap-2"
                    >
                        <span v-if="form.processing" class="loading loading-spinner loading-xs"></span>
                        <span>Upload File</span>
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button @click="emit('close')">close</button>
        </form>
    </dialog>
</template>
