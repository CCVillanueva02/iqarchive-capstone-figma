<!--
================================================================================
IQArchive v2 — Add Administrative Office Modal
================================================================================
File: resources/js/Pages/Documents/Common-Documents/Partials/AddOfficeModal.vue
Role: Modal dialog for registering new institutional administrative offices.
UI Standard: DaisyUI modal, input, textarea, btn, fieldset.
Line count target: < 150 lines.
================================================================================
-->

<script setup>
import { useForm } from '@inertiajs/vue3';
import { Building2, X, AlertCircle } from 'lucide-vue-next';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const form = useForm({
    name: '',
    description: '',
});

function closeModal() {
    form.clearErrors();
    form.reset();
    emit('close');
}

function submit() {
    form.post('/documents/offices', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit('close');
        },
    });
}
</script>

<template>
    <div
        class="modal"
        :class="{ 'modal-open': show }"
        role="dialog"
        aria-modal="true"
        aria-labelledby="add-office-modal-title"
        @keydown.esc="closeModal"
    >
        <div class="modal-box max-w-md p-6 bg-base-100 rounded-xl shadow-xl">
            <!-- Header -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-bu-blue-50 text-bu-blue-700 flex items-center justify-center">
                        <Building2 class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 id="add-office-modal-title" class="text-base font-bold text-slate-800">
                            Add Administrative Office
                        </h3>
                    </div>
                </div>
                <button
                    type="button"
                    class="btn btn-sm btn-ghost btn-circle text-slate-400 hover:text-slate-600"
                    @click="closeModal"
                    aria-label="Close modal"
                >
                    <X class="w-4 h-4" />
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="mt-4 space-y-4">
                <!-- General Error Banner -->
                <div v-if="form.hasErrors && form.errors.error" class="alert alert-error text-xs p-3">
                    <AlertCircle class="w-4 h-4 shrink-0" />
                    <span>{{ form.errors.error }}</span>
                </div>

                <!-- Office Name -->
                <fieldset class="fieldset">
                    <legend class="fieldset-legend font-semibold text-slate-700 text-xs">
                        Office Name
                    </legend>
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="e.g. Office of Student Affairs and Services"
                        class="input input-bordered input-sm w-full"
                        :class="{ 'input-error': form.errors.name }"
                        maxlength="100"
                        required
                        autofocus
                    />
                    <span v-if="form.errors.name" class="text-xs text-error mt-1">
                        {{ form.errors.name }}
                    </span>
                </fieldset>

                <!-- Description / Mandate -->
                <fieldset class="fieldset">
                    <legend class="fieldset-legend font-semibold text-slate-700 text-xs">
                        Description <span class="text-slate-400 font-normal">(Optional)</span>
                    </legend>
                    <textarea
                        v-model="form.description"
                        class="textarea textarea-bordered textarea-sm w-full"
                        :class="{ 'textarea-error': form.errors.description }"
                        rows="3"
                        placeholder="Brief summary of office mandates, university charter functions, or policy purview..."
                        maxlength="1000"
                    ></textarea>
                    <span v-if="form.errors.description" class="text-xs text-error mt-1">
                        {{ form.errors.description }}
                    </span>
                </fieldset>

                <!-- Actions -->
                <div class="modal-action pt-2 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button
                        type="button"
                        class="btn btn-sm btn-ghost text-slate-600"
                        @click="closeModal"
                        :disabled="form.processing"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn btn-sm bg-sidebar-blue hover:bg-sidebar-blue-hover text-white border-none gap-1.5"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing" class="loading loading-spinner loading-xs"></span>
                        <span>Add Office</span>
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button type="button" @click="closeModal">close</button>
        </form>
    </div>
</template>
