<!--
================================================================================
IQArchive v2 — Unified Landing & Google Workspace SSO Portal
================================================================================
File: resources/js/Pages/Auth/Login.vue
Security Context: Restricts authentication strictly to verified Bicol University
                  accounts ending in @bicol-u.edu.ph.
================================================================================
-->

<script setup>
import { Head } from '@inertiajs/vue3';
import MobileUnsupported from '@/Components/MobileUnsupported.vue';
import {
    AlertCircle,
    CheckCircle2,
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
});
</script>

<template>
    <Head title="IQArchive — Bicol University Document Management & Monitoring System" />

    <!-- Desktop Viewport Guard (≥1024px required) -->
    <MobileUnsupported />

    <div class="min-h-screen bg-slate-50 text-slate-800 font-sans flex flex-col justify-center relative overflow-hidden selection:bg-orange-500/20 selection:text-orange-900">
        
        <!-- Subtle Ambient Lighting Accents (Clean, premium, zero-clutter) -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- ================================================================== -->
        <!-- MAIN CONTENT AREA                                                  -->
        <!-- ================================================================== -->
        <main class="w-full max-w-7xl mx-auto px-8 lg:px-12 py-16 relative z-10">
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- Left Column: Institutional Value Proposition -->
                <div class="lg:col-span-7 flex flex-col items-start text-left gap-5">
                    <!-- Main Hero Headline -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0a192f] tracking-tight leading-[1.15]">
                        A Document Management &amp; Monitoring System for Quality Assurance
                    </h1>

                    <!-- Descriptive Subtitle -->
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
                        Centralize accreditation documents, track compliance in real time, and simplify quality assurance workflows across Bicol University's colleges and programs.
                    </p>
                </div>

                <!-- Right Column: Institutional Google SSO Card -->
                <div id="auth-card" class="lg:col-span-5 w-full flex justify-center">
                    <div class="card card-border bg-base-100 shadow-xl w-full max-w-md transition-all duration-300 hover:shadow-2xl">
                        <div class="card-body p-8 sm:p-10 gap-6">

                            <!-- Brand Seal & Office Title -->
                            <div class="text-center flex flex-col items-center">
                                <!-- Bicol University Seal -->
                                <div class="flex items-center justify-center w-20 h-20 rounded-full bg-base-200 border border-base-300 mb-4 p-2 shadow-2xs transition-transform duration-300 hover:scale-105">
                                    <img src="/bulogo.png" alt="Bicol University Seal" class="w-full h-full object-contain" />
                                </div>

                                <h2 class="text-2xl font-bold text-base-content tracking-tight">
                                    IQArchive
                                </h2>
                                <p class="text-sm text-base-content/60 font-medium mt-0.5">
                                    Internal Quality Assurance Office
                                </p>
                            </div>

                            <!-- Status & Error Alert Banners (DaisyUI alert) -->
                            <div v-if="error" role="alert" class="alert alert-error alert-soft text-xs shadow-2xs">
                                <AlertCircle class="w-4 h-4 shrink-0" />
                                <span class="leading-relaxed font-medium">{{ error }}</span>
                            </div>

                            <div v-if="success" role="alert" class="alert alert-success alert-soft text-xs shadow-2xs">
                                <CheckCircle2 class="w-4 h-4 shrink-0" />
                                <span class="leading-relaxed font-medium">{{ success }}</span>
                            </div>

                            <!-- Primary Google SSO Action (DaisyUI btn) -->
                            <div class="card-actions">
                                <a
                                    href="/auth/google/redirect"
                                    class="btn bg-white text-slate-800 hover:bg-slate-50 border-slate-300 w-full h-auto py-3 text-sm font-semibold shadow-xs gap-3 transition-all duration-200 active:scale-[0.99]"
                                >
                                    <!-- Official Google Multicolor Icon -->
                                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
                                    </svg>
                                    <span>Sign in with Google</span>
                                </a>
                            </div>

                            <!-- Direct 1-Line Support Link -->
                            <div class="text-center mt-4">
                                <p class="text-xs text-base-content/60">
                                    <a
                                        href="mailto:bu-iqao@bicol-u.edu.ph"
                                        class="link link-hover font-semibold hover:text-orange-600 transition-colors"
                                    >
                                        Don't have an account?
                                    </a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </main>

    </div>
</template>
