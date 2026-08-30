{{--
    IQArchive Desktop-Only Screen Guard Component
    -------------------------------------------------------------------------
    SECURITY & ARCHITECTURAL NOTE:
    IQArchive is strictly an institutional desktop workstation application
    designed for complex accreditation matrices, multi-document evidence
    inspections, and high-density compliance analytics.
    
    Mobile viewports (< 1024px / lg) are intentionally unsupported to prevent
    data misrepresentation, accidental submission errors, and impaired document
    review. This component renders a full-viewport blocking experience on mobile
    devices instructing users to switch to a desktop environment.
--}}
<div x-data="{ currentWidth: window.innerWidth, currentHeight: window.innerHeight }"
     x-init="window.addEventListener('resize', () => { currentWidth = window.innerWidth; currentHeight = window.innerHeight; })"
     class="fixed inset-0 z-99999 lg:hidden bg-primary-dark text-white flex flex-col justify-between p-6 sm:p-10 select-none overflow-y-auto font-sans">
    
    <!-- Background Ambient Glow Accents -->
    <div class="fixed -top-24 -right-24 w-80 h-80 bg-brand-orange/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-24 -left-24 w-80 h-80 bg-primary-light/25 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Section -->
    <div class="relative z-10 flex items-center justify-between w-full max-w-md mx-auto">
        <div class="flex items-center gap-3">
            <img src="/bulogo.png" alt="Bicol University Logo" class="w-9 h-9 object-contain shrink-0" />
            <span class="font-extrabold text-heading tracking-tight text-white">
                <span class="text-brand-orange">IQA</span>rchive
            </span>
        </div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-orange/15 border border-brand-orange/40 text-brand-orange text-label font-bold uppercase tracking-wider">
            <span>Desktop Only</span>
        </div>
    </div>

    <!-- Center Card / Message -->
    <div class="relative z-10 w-full max-w-md mx-auto my-auto py-8 flex flex-col items-center text-center">
        <!-- Device Screen Visual Icon -->
        <div class="relative mb-6">
            <div class="w-20 h-20 rounded-3xl bg-zinc-900/80 border border-zinc-700/80 shadow-2xl flex items-center justify-center text-brand-orange">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" />
                </svg>
            </div>
            <!-- Alert Badge Overlay -->
            <div class="absolute -bottom-1.5 -right-1.5 w-7 h-7 rounded-full bg-brand-orange text-white flex items-center justify-center shadow-md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <!-- Heading -->
        <h1 class="text-heading-lg font-extrabold text-white tracking-tight leading-tight">
            Desktop Browser Required
        </h1>

        <!-- Subtitle -->
        <p class="text-body-sm text-zinc-300 mt-3 leading-relaxed max-w-sm">
            IQArchive is engineered exclusively for desktop workstations. Institutional quality assurance matrices, multi-document viewers, and accreditation tools require a larger display.
        </p>

        <!-- Guidance Card -->
        <div class="w-full mt-6 bg-zinc-900/60 border border-zinc-800/90 rounded-2xl p-5 text-left flex flex-col gap-3.5 backdrop-blur-md">
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-lg bg-brand-orange/20 text-brand-orange flex items-center justify-center shrink-0 mt-0.5 font-bold text-label">
                    1
                </div>
                <div class="flex flex-col">
                    <span class="text-body-sm font-semibold text-white">Switch to a Desktop or Laptop</span>
                    <span class="text-label text-zinc-400 mt-0.5">Please access this portal using a computer with a screen width of 1024px or higher.</span>
                </div>
            </div>

            <hr class="border-zinc-800" />

            <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-lg bg-zinc-800 text-zinc-300 flex items-center justify-center shrink-0 mt-0.5 font-bold text-label">
                    2
                </div>
                <div class="flex flex-col">
                    <span class="text-body-sm font-semibold text-white">Expand Browser Window</span>
                    <span class="text-label text-zinc-400 mt-0.5">If on a tablet or PC, maximize your browser window or rotate to landscape mode.</span>
                </div>
            </div>
        </div>

        <!-- Current Viewport Indicator -->
        <div class="mt-6 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-zinc-900/80 border border-zinc-800 text-zinc-400 text-label font-mono">
            <span>Current display:</span>
            <span class="text-brand-orange font-bold" x-text="currentWidth + 'px × ' + currentHeight + 'px'"></span>
            <span>&bull;</span>
            <span>Min required: 1024px</span>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="relative z-10 w-full max-w-md mx-auto text-center text-label text-zinc-500 pt-4">
        <span>&copy; {{ date('Y') }} Bicol University &bull; Internal Quality Assurance Office</span>
    </div>
</div>
