<!--
================================================================================
IQArchive v2 — Unified Landing & Google Workspace SSO Portal
================================================================================
File: resources/js/Pages/Auth/Login.vue
Security Context: Restricts authentication strictly to verified Bicol University
                  accounts ending in @bicol-u.edu.ph.
UI Standard: Adheres to DaisyUI component standards (card, btn, alert) with
             split-screen institutional branding.
================================================================================
-->

<script setup>
import { Head } from '@inertiajs/vue3';
import MobileUnsupported from '@/Components/MobileUnsupported.vue';
import {
    AlertCircle,
    CheckCircle2,
    Info,
} from 'lucide-vue-next';

defineProps({
    error: {
        type: String,
        default: null,
    },
    success: {
        type: String,
        default: null,
    },
    info: {
        type: String,
        default: null,
    },
    isLocal: {
        type: Boolean,
        default: false,
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <Head title="Sign In — IQArchive" />

    <!-- Desktop Viewport Guard (≥1024px required) -->
    <MobileUnsupported />

    <div class="min-h-screen w-full flex flex-col lg:flex-row font-sans bg-slate-50 text-slate-800 selection:bg-orange-500/20 selection:text-orange-900">
        
        <!-- ================================================================== -->
        <!-- LEFT COLUMN: Institutional Monument Hero Banner                     -->
        <!-- ================================================================== -->
        <section 
            class="relative lg:w-[58%] min-h-[42vh] lg:min-h-screen bg-cover bg-center flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-16 lg:py-24 overflow-hidden"
            style="background-image: url('/images/bu-monument.jpg');"
            aria-label="Bicol University Quality Assurance Welcome"
        >
            <!-- Deep Navy Gradient Overlay for High Contrast Text (Left to Right) -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#0B1B3D]/95 via-[#0B1B3D]/85 to-[#0B1B3D]/60 pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl flex flex-col items-start text-left">
                <!-- Workspace Category Kicker with BU Orange Accent Line -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-1 bg-[#F26522] rounded-full inline-block"></span>
                    <span class="text-xs font-bold tracking-widest uppercase text-slate-200">
                        Internal Quality Assurance Workspace
                    </span>
                </div>

                <!-- Main Hero Headline with BU Orange Highlight -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-[1.15]">
                    A Document Management<br class="hidden sm:inline" />
                    &amp; Monitoring System<br class="hidden sm:inline" />
                    for <span class="text-[#F26522]">Quality Assurance</span>
                </h1>

                <!-- Descriptive Subtitle -->
                <p class="mt-6 text-base sm:text-lg text-slate-300 leading-relaxed max-w-xl">
                    Centralize accreditation documents, track compliance in real time, and simplify quality assurance workflows across Bicol University's colleges and programs.
                </p>
            </div>
        </section>

        <!-- ================================================================== -->
        <!-- RIGHT COLUMN: Authentication Card Panel                            -->
        <!-- ================================================================== -->
        <main class="lg:w-[42%] min-h-[58vh] lg:min-h-screen bg-white flex items-center justify-center p-6 sm:p-10 lg:p-14">
            <div class="card card-border bg-white shadow-xl border-slate-100 w-full max-w-md rounded-2xl transition-all duration-300 hover:shadow-2xl">
                <div class="card-body p-8 sm:p-10 gap-6">

                    <!-- Brand Seal & Office Title -->
                    <div class="text-center flex flex-col items-center">
                        <img 
                            src="/bulogo.png" 
                            alt="Bicol University Seal" 
                            class="w-20 h-20 object-contain transition-transform duration-300 hover:scale-105" 
                        />

                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">
                            IQArchive
                        </h2>
                        <p class="text-sm font-medium text-slate-500 mt-1">
                            Internal Quality Assurance Office
                        </p>
                    </div>

                    <!-- Status, Info & Error Alert Banners (DaisyUI alert) -->
                    <div v-if="error" role="alert" class="alert alert-error alert-soft text-xs shadow-2xs">
                        <AlertCircle class="w-4 h-4 shrink-0" />
                        <span class="leading-relaxed font-medium">{{ error }}</span>
                    </div>

                    <div v-if="info" role="alert" class="alert alert-info alert-soft text-xs shadow-2xs">
                        <Info class="w-4 h-4 shrink-0" />
                        <span class="leading-relaxed font-medium">{{ info }}</span>
                    </div>

                    <div v-if="success" role="alert" class="alert alert-success alert-soft text-xs shadow-2xs">
                        <CheckCircle2 class="w-4 h-4 shrink-0" />
                        <span class="leading-relaxed font-medium">{{ success }}</span>
                    </div>

                    <!-- Primary Google SSO Action (DaisyUI btn) -->
                    <div class="card-actions">
                        <a
                            id="google-sso-btn"
                            href="/auth/google/redirect"
                            class="btn bg-white hover:bg-slate-50 text-slate-700 border-slate-200 hover:border-slate-300 w-full h-auto py-3 text-sm font-semibold rounded-xl shadow-xs gap-3 transition-all duration-200 active:scale-[0.99]"
                        >
                            <!-- Official Google Multicolor SVG Icon -->
                            <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                            </svg>
                            <span>Sign in with Google</span>
                        </a>
                    </div>

                    <!-- Direct Support Link -->
                    <div class="text-center mt-1">
                        <a
                            href="mailto:bu-iqao@bicol-u.edu.ph"
                            class="text-xs text-slate-500 hover:text-[#F26522] transition-colors"
                        >
                            Don't have an account?
                        </a>
                    </div>
                </div>
            </div>
        </main>

    </div>
</template>
