<!--
================================================================================
IQArchive v2 — Audit Detail Drawer Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditDetailDrawer.vue
Role: Slide-over drawer displaying metadata, cryptographic hash, diffs, and JSON.
UI Standard: DaisyUI modal/panel, badge, btn; Lucide icons.
Line count target: < 195 lines.
================================================================================
-->

<script setup>
import { ref, computed } from 'vue';
import { X, Copy, Check, ShieldCheck, FileCode, Layers, User, Globe } from 'lucide-vue-next';

const props = defineProps({
    isOpen: {
        type: Boolean,
        default: false,
    },
    log: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);
const copiedHash = ref(false);
const copiedJson = ref(false);

const fileHash = computed(() => {
    return props.log?.details?.file_hash || null;
});

const previousState = computed(() => {
    return props.log?.details?.previous || props.log?.details?.before || null;
});

const updatedState = computed(() => {
    return props.log?.details?.updated || props.log?.details?.after || null;
});

async function copyToClipboard(text, isHash = false) {
    if (!text) return;
    const payload = typeof text === 'object' ? JSON.stringify(text, null, 2) : String(text);
    try {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            await navigator.clipboard.writeText(payload);
        } else {
            // Fallback for non-secure / restricted environments
            const textArea = document.createElement('textarea');
            textArea.value = payload;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
        }
        if (isHash) {
            copiedHash.value = true;
            setTimeout(() => (copiedHash.value = false), 2000);
        } else {
            copiedJson.value = true;
            setTimeout(() => (copiedJson.value = false), 2000);
        }
    } catch (err) {
        console.warn('Clipboard copy failed:', err);
    }
}
</script>

<template>
    <div v-if="isOpen && log" class="fixed inset-0 z-50 flex justify-end">
        <!-- Backdrop -->
        <div
            @click="emit('close')"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-[2px] transition-opacity"
            aria-hidden="true"
        />

        <!-- Slide-over Content Drawer -->
        <div class="relative w-full max-w-lg bg-base-100 shadow-2xl border-l border-slate-200 flex flex-col h-full z-10 animate-in slide-in-from-right duration-200">
            <!-- Header -->
            <div class="p-4 border-b border-slate-100 flex items-center justify-between shrink-0 bg-slate-50/50">
                <div class="space-y-0.5">
                    <div class="flex items-center gap-2">
                        <ShieldCheck class="w-4 h-4 text-primary" />
                        <h2 class="text-sm font-bold text-slate-800">
                            Audit Record #{{ log.id }}
                        </h2>
                        <span class="badge badge-xs font-mono font-semibold bg-slate-100 border border-slate-200 text-slate-700">
                            {{ log.action }}
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-400 font-mono">
                        {{ new Date(log.created_at).toLocaleString() }}
                    </p>
                </div>
                <button
                    type="button"
                    @click="emit('close')"
                    class="btn btn-sm btn-circle btn-ghost text-slate-400 hover:text-slate-700"
                    aria-label="Close drawer"
                >
                    <X class="w-4 h-4" />
                </button>
            </div>

            <!-- Scrollable Drawer Body -->
            <div class="p-5 overflow-y-auto flex-1 space-y-5 text-xs">
                <!-- 1. Actor & Origin Card -->
                <div class="card card-border bg-base-100 shadow-xs p-3.5 space-y-2.5">
                    <div class="flex items-center gap-1.5 font-bold text-slate-700 text-xs uppercase tracking-wide">
                        <User class="w-3.5 h-3.5 text-primary" />
                        <span>Actor & Origin Context</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-[11px]">
                        <div>
                            <span class="text-slate-400">Initiated By:</span>
                            <div class="font-semibold text-slate-800">{{ log.user?.name || 'System Process' }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">Email:</span>
                            <div class="font-mono text-slate-600 truncate">{{ log.user?.email || 'N/A' }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">College Scope:</span>
                            <div class="font-semibold text-slate-800">{{ log.college?.name || 'University-Wide' }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400">IP Address:</span>
                            <div class="font-mono text-slate-600">{{ log.ip_address || '127.0.0.1' }}</div>
                        </div>
                    </div>
                </div>

                <!-- 2. Target Entity Card -->
                <div class="card card-border bg-base-100 shadow-xs p-3.5 space-y-2.5">
                    <div class="flex items-center gap-1.5 font-bold text-slate-700 text-xs uppercase tracking-wide">
                        <Layers class="w-3.5 h-3.5 text-info" />
                        <span>Target Entity Reference</span>
                    </div>
                    <div class="space-y-1 text-[11px]">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Entity Model:</span>
                            <span class="font-mono font-medium text-slate-700">{{ log.target_type }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Record ID:</span>
                            <span class="font-mono font-bold text-slate-800">#{{ log.target_id || 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Cryptographic Non-Repudiation (SHA-256) -->
                <div v-if="fileHash" class="card card-border bg-base-100 shadow-xs p-3.5 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-700 text-xs uppercase tracking-wide">Cryptographic File Hash</span>
                        <button
                            type="button"
                            @click="copyToClipboard(fileHash, true)"
                            class="btn btn-xs btn-ghost gap-1 text-slate-500 hover:text-primary"
                        >
                            <Check v-if="copiedHash" class="w-3 h-3 text-success" />
                            <Copy v-else class="w-3 h-3" />
                            <span>{{ copiedHash ? 'Copied' : 'Copy Hash' }}</span>
                        </button>
                    </div>
                    <div class="font-mono text-[11px] bg-slate-50 border border-slate-200 p-2 rounded break-all text-slate-700 select-all">
                        {{ fileHash }}
                    </div>
                </div>

                <!-- 4. State Comparison Diff (Before vs After) -->
                <div v-if="previousState || updatedState" class="space-y-2">
                    <span class="font-bold text-slate-700 text-xs uppercase tracking-wide">State Comparison Diff</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px] font-mono">
                        <div class="bg-rose-50/70 border border-rose-200 text-rose-900 rounded-lg p-2.5 space-y-1">
                            <div class="font-bold text-[10px] text-rose-700 uppercase tracking-wider">Previous State</div>
                            <pre class="overflow-x-auto whitespace-pre-wrap">{{ JSON.stringify(previousState, null, 2) }}</pre>
                        </div>
                        <div class="bg-emerald-50/70 border border-emerald-200 text-emerald-900 rounded-lg p-2.5 space-y-1">
                            <div class="font-bold text-[10px] text-emerald-700 uppercase tracking-wider">Updated State</div>
                            <pre class="overflow-x-auto whitespace-pre-wrap">{{ JSON.stringify(updatedState, null, 2) }}</pre>
                        </div>
                    </div>
                </div>

                <!-- 5. Complete Raw Payload Accordion -->
                <details class="collapse collapse-arrow bg-slate-50 border border-slate-200 rounded-lg">
                    <summary class="collapse-title text-xs font-semibold text-slate-700 flex items-center gap-1.5 py-2.5 min-h-0">
                        <FileCode class="w-3.5 h-3.5 text-slate-500" />
                        <span>Inspect Raw JSON Payload</span>
                    </summary>
                    <div class="collapse-content pt-1 text-[11px] space-y-2">
                        <div class="flex justify-end">
                            <button
                                type="button"
                                @click="copyToClipboard(log.details)"
                                class="btn btn-xs btn-outline border-slate-300 text-slate-600 gap-1"
                            >
                                <Check v-if="copiedJson" class="w-3 h-3 text-success" />
                                <Copy v-else class="w-3 h-3" />
                                <span>{{ copiedJson ? 'Copied' : 'Copy JSON' }}</span>
                            </button>
                        </div>
                        <pre class="bg-slate-900 text-slate-200 p-3 rounded-lg overflow-x-auto font-mono text-[10px] max-h-56 leading-relaxed">
{{ JSON.stringify(log.details, null, 2) }}</pre>
                    </div>
                </details>
            </div>

            <!-- Drawer Footer -->
            <div class="p-3 border-t border-slate-100 flex items-center justify-between bg-slate-50/50 shrink-0 text-slate-400 text-[11px]">
                <div class="flex items-center gap-1.5">
                    <ShieldCheck class="w-3.5 h-3.5 text-success" />
                    <span>Immutable Audit Record</span>
                </div>
                <button
                    type="button"
                    @click="emit('close')"
                    class="btn btn-xs btn-ghost text-slate-600 hover:text-slate-900"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</template>
