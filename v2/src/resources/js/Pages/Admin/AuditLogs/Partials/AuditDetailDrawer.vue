<!--
================================================================================
IQArchive v2 — Audit Detail Drawer Partial
================================================================================
File: resources/js/Pages/Admin/AuditLogs/Partials/AuditDetailDrawer.vue
Role: Slide-over drawer with metadata, cryptographic hash, before/after diffs & JSON.
UI Standard: DaisyUI / Institutional BU Blue (#0038A8). Line count < 195.
================================================================================
-->

<script setup>
import { ref, computed, watch } from 'vue';
import {
    X,
    Copy,
    Check,
    Building2,
    Layers,
    FileCode,
    ChevronDown,
    ShieldCheck,
} from 'lucide-vue-next';
import {
    humanAction,
    deriveSeverity,
    initials,
    getActionIcon,
    SEV_BADGE,
    SEV_LABEL,
} from '../auditData.js';

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

const hashCopied = ref(false);
const jsonCopied = ref(false);

watch(() => props.log?.id, () => {
    hashCopied.value = false;
    jsonCopied.value = false;
});

const beforeState = computed(() => {
    return props.log?.details?.before ?? props.log?.details?.previous ?? null;
});

const afterState = computed(() => {
    return props.log?.details?.after ?? props.log?.details?.updated ?? null;
});

const fileHash = computed(() => {
    return props.log?.details?.file_hash || null;
});

function formatTimestamp(ts) {
    if (!ts) return { date: '—', time: '—' };
    const d = new Date(ts);
    return {
        date: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
        time: d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' }),
    };
}

async function copyText(text, isHash = false) {
    if (!text) return;
    const str = typeof text === 'object' ? JSON.stringify(text, null, 2) : String(text);
    try {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            await navigator.clipboard.writeText(str);
        } else {
            const ta = document.createElement('textarea');
            ta.value = str;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
        }
        if (isHash) {
            hashCopied.value = true;
            setTimeout(() => (hashCopied.value = false), 2000);
        } else {
            jsonCopied.value = true;
            setTimeout(() => (jsonCopied.value = false), 2000);
        }
    } catch (e) {
        console.warn('Copy failed:', e);
    }
}
</script>

<template>
    <div v-if="isOpen && log" class="fixed inset-0 z-50 flex justify-end">
        <!-- Backdrop -->
        <div
            @click="emit('close')"
            class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] transition-opacity cursor-pointer"
        />

        <!-- Slide-over Drawer Panel -->
        <div class="relative w-full max-w-lg bg-white border-l border-slate-200 shadow-2xl flex flex-col h-full z-10 animate-in slide-in-from-right duration-200">
            <!-- Header -->
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/60 shrink-0 flex items-start justify-between gap-3">
                <div class="flex items-start gap-3 min-w-0">
                    <div
                        class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-white"
                        style="background-color: #0038A8;"
                    >
                        <component :is="getActionIcon(log.action)" :size="16" />
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-900 leading-snug">
                            {{ humanAction(log.action) }}
                        </p>
                        <span
                            :class="[
                                'inline-flex items-center text-[10px] font-semibold px-2 py-0.5 rounded-full mt-1.5',
                                SEV_BADGE[deriveSeverity(log.action)]
                            ]"
                        >
                            {{ SEV_LABEL[deriveSeverity(log.action)] }}
                        </span>
                    </div>
                </div>
                <button
                    type="button"
                    @click="emit('close')"
                    class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-200 rounded-lg transition-colors shrink-0 cursor-pointer"
                    aria-label="Close drawer"
                >
                    <X :size="14" />
                </button>
            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto px-5 py-5 space-y-5 text-xs">
                <!-- Date & IP -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl px-3.5 py-3">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Date &amp; Time</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ formatTimestamp(log.created_at).date }}</p>
                        <p class="font-mono text-slate-500 text-[11px]">{{ formatTimestamp(log.created_at).time }}</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl px-3.5 py-3">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">IP Address</p>
                        <p class="font-mono font-semibold text-slate-800 mt-1">{{ log.ip_address || 'N/A' }}</p>
                    </div>
                </div>

                <!-- Performed By -->
                <section class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Performed By</p>
                    <div v-if="log.user" class="flex items-center gap-3 border border-slate-100 rounded-xl p-3 bg-slate-50/50">
                        <div
                            class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 text-white text-xs font-extrabold"
                            style="background-color: #0038A8;"
                        >
                            {{ initials(log.user.name) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-slate-800 text-sm">{{ log.user.name }}</p>
                            <p class="text-slate-400 truncate font-mono">{{ log.user.email }}</p>
                            <p v-if="log.college" class="text-slate-500 flex items-center gap-1 mt-0.5">
                                <Building2 :size="10" class="text-slate-400" />
                                <span>{{ log.college.name }}</span>
                            </p>
                        </div>
                    </div>
                    <div v-else class="border border-slate-100 rounded-xl p-3 bg-slate-50/50 text-slate-500 italic">
                        Performed automatically by the system.
                    </div>
                </section>

                <!-- What Was Affected -->
                <section class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <Layers :size="10" />
                        <span>What Was Affected</span>
                    </p>
                    <div class="border border-slate-100 rounded-xl p-3 bg-slate-50/50 space-y-1.5">
                        <p v-if="log.details?.title" class="font-semibold text-slate-800">
                            "{{ log.details.title }}"
                        </p>
                        <p v-if="log.details?.area" class="text-slate-700">
                            Accreditation Area: <span class="font-semibold">{{ log.details.area }}</span>
                            <span v-if="log.details.missing_benchmarks != null" class="text-red-600 ml-1">
                                · {{ log.details.missing_benchmarks }} missing benchmarks
                            </span>
                        </p>
                        <p v-if="log.details?.email" class="text-slate-700">
                            Blocked email: <span class="font-mono">{{ log.details.email }}</span>
                        </p>
                        <p v-if="log.college" class="text-slate-500">
                            College: {{ log.college.name }}
                        </p>
                        <p v-if="!log.details?.title && !log.details?.area && !log.details?.email" class="text-slate-500">
                            {{ (log.target_type || 'Entity').split('\\').pop() }} #{{ log.target_id || 'N/A' }}
                        </p>
                    </div>
                </section>

                <!-- File Integrity Hash -->
                <section v-if="fileHash" class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">File Integrity Hash</p>
                        <button
                            type="button"
                            @click="copyText(fileHash, true)"
                            class="flex items-center gap-1 text-[10px] text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                        >
                            <Check v-if="hashCopied" :size="10" class="text-emerald-500" />
                            <Copy v-else :size="10" />
                            <span>{{ hashCopied ? 'Copied' : 'Copy' }}</span>
                        </button>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-3 font-mono text-[11px] text-slate-700 break-all leading-relaxed select-all">
                        {{ fileHash }}
                    </div>
                </section>

                <!-- What Changed (State diff) -->
                <section v-if="beforeState || afterState" class="space-y-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">What Changed</p>
                    <div class="grid grid-cols-2 gap-2 font-mono text-[11px]">
                        <div v-if="beforeState" class="bg-red-50 border border-red-100 rounded-xl p-3">
                            <p class="text-[9px] font-extrabold text-red-400 uppercase tracking-widest mb-1.5">Before</p>
                            <pre class="text-red-900 whitespace-pre-wrap">{{ JSON.stringify(beforeState, null, 2) }}</pre>
                        </div>
                        <div v-if="afterState" class="bg-emerald-50 border border-emerald-100 rounded-xl p-3">
                            <p class="text-[9px] font-extrabold text-emerald-500 uppercase tracking-widest mb-1.5">After</p>
                            <pre class="text-emerald-900 whitespace-pre-wrap">{{ JSON.stringify(afterState, null, 2) }}</pre>
                        </div>
                    </div>
                </section>

                <!-- Technical Details (JSON) -->
                <details v-if="log.details" class="group">
                    <summary class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider cursor-pointer list-none select-none hover:text-slate-600 transition-colors">
                        <FileCode :size="10" />
                        <span>Technical Details</span>
                        <ChevronDown :size="10" class="ml-auto group-open:rotate-180 transition-transform text-slate-300" />
                    </summary>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-end">
                            <button
                                type="button"
                                @click="copyText(log.details, false)"
                                class="flex items-center gap-1 text-[10px] text-slate-400 hover:text-slate-700 transition-colors cursor-pointer"
                            >
                                <Check v-if="jsonCopied" :size="9" class="text-emerald-500" />
                                <Copy v-else :size="9" />
                                <span>{{ jsonCopied ? 'Copied' : 'Copy JSON' }}</span>
                            </button>
                        </div>
                        <pre class="bg-slate-900 text-slate-300 p-3.5 rounded-xl text-[10px] font-mono overflow-x-auto leading-relaxed max-h-52">{{ JSON.stringify(log.details, null, 2) }}</pre>
                    </div>
                </details>
            </div>

            <!-- Footer -->
            <div class="px-5 py-2.5 border-t border-slate-100 bg-slate-50/60 shrink-0 flex items-center gap-2 text-[10px] text-slate-400">
                <ShieldCheck :size="11" class="text-emerald-500" />
                <span>Immutable record — cannot be edited</span>
                <span class="ml-auto font-mono text-slate-300">#{{ log.id }}</span>
            </div>
        </div>
    </div>
</template>
