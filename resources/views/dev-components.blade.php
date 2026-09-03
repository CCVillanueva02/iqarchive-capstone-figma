<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IQArchive — UI Component Kit Showcase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-subtle min-h-screen text-zinc-900 font-sans p-8 antialiased">
    <div class="max-w-6xl mx-auto space-y-10">

        <!-- Header -->
        <div class="border-b border-zinc-200 pb-6">
            <x-ui.page-header
                title="IQArchive Component Kit Showcase"
                subtitle="Live visual reference for the formalized atomic UI design tokens and components."
                :breadcrumbs="[
                    ['label' => 'Developer Hub', 'url' => '/dev'],
                    ['label' => 'UI Kit Showcase']
                ]"
            >
                <x-slot:actions>
                    <x-ui.button variant="secondary" size="sm" onclick="window.print()">Print Spec</x-ui.button>
                    <x-ui.button variant="brand" size="sm">+ New Accreditation</x-ui.button>
                </x-slot:actions>
            </x-ui.page-header>
        </div>

        <!-- 1. Buttons Section -->
        <section class="space-y-4">
            <h2 class="text-heading font-extrabold text-primary-dark">1. Buttons (`&lt;x-ui.button&gt;`)</h2>
            <p class="text-body-sm text-zinc-500">Standardized variants, sizes, and states adhering to IQArchive brand tokens.</p>

            <div class="bg-white rounded-2xl p-6 border border-zinc-200/80 shadow-3xs space-y-6">
                <div>
                    <h4 class="text-label uppercase tracking-wider font-extrabold text-zinc-400 mb-3">Variants</h4>
                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.button variant="primary">Primary (Navy)</x-ui.button>
                        <x-ui.button variant="brand">Brand Action (Orange)</x-ui.button>
                        <x-ui.button variant="secondary">Secondary (Subtle)</x-ui.button>
                        <x-ui.button variant="outline">Outline</x-ui.button>
                        <x-ui.button variant="danger">Danger (Rose)</x-ui.button>
                        <x-ui.button variant="subtle">Subtle Link</x-ui.button>
                        <x-ui.button variant="primary" disabled>Disabled State</x-ui.button>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-100">
                    <h4 class="text-label uppercase tracking-wider font-extrabold text-zinc-400 mb-3">Sizes</h4>
                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.button variant="primary" size="sm">Small Button</x-ui.button>
                        <x-ui.button variant="primary" size="md">Medium (Default)</x-ui.button>
                        <x-ui.button variant="primary" size="lg">Large Hero Button</x-ui.button>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Status Badges Section -->
        <section class="space-y-4">
            <h2 class="text-heading font-extrabold text-primary-dark">2. Status Badges (`&lt;x-ui.status-badge&gt;`)</h2>
            <p class="text-body-sm text-zinc-500">Universal status chips mapping to canonical accreditation workflow states.</p>

            <div class="bg-white rounded-2xl p-6 border border-zinc-200/80 shadow-3xs flex flex-wrap items-center gap-3">
                <x-ui.status-badge status="scheduled" />
                <x-ui.status-badge status="in_progress" />
                <x-ui.status-badge status="pending" />
                <x-ui.status-badge status="submitted" />
                <x-ui.status-badge status="verified" />
                <x-ui.status-badge status="completed" />
                <x-ui.status-badge status="needs_revision" />
                <x-ui.status-badge status="cancelled" />
            </div>
        </section>

        <!-- 3. Stat Cards Section -->
        <section class="space-y-4">
            <h2 class="text-heading font-extrabold text-primary-dark">3. Metric KPI Cards (`&lt;x-ui.stat-card&gt;`)</h2>
            <p class="text-body-sm text-zinc-500">Uniform dashboard cards for metrics, counts, and performance indicators.</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-ui.stat-card label="Active Visits" value="12" sub="Scheduled for AY 2026-2027" status="active" />
                <x-ui.stat-card label="Pending Dean Review" value="5" sub="Awaiting Step 6 verification" status="warning" />
                <x-ui.stat-card label="Needs Revision" value="2" sub="Returned to Task Force" status="brand" />
                <x-ui.stat-card label="Completed Surveys" value="84" sub="100% evidence validated" status="success" />
            </div>
        </section>

        <!-- 4. Filter Toolbar -->
        <section class="space-y-4">
            <h2 class="text-heading font-extrabold text-primary-dark">4. Filter Toolbar (`&lt;x-ui.filter-bar&gt;`)</h2>
            <p class="text-body-sm text-zinc-500">Unified search input with slots for dropdown filters and active chips.</p>

            <x-ui.filter-bar placeholder="Filter accreditation records, colleges, or criteria...">
                <select class="px-3 py-2 bg-surface-subtle border border-zinc-200 rounded-xl text-body-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All Colleges</option>
                    <option value="cs">College of Science</option>
                    <option value="eng">College of Engineering</option>
                    <option value="cal">College of Arts and Letters</option>
                </select>

                <select class="px-3 py-2 bg-surface-subtle border border-zinc-200 rounded-xl text-body-sm text-zinc-700 focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All Statuses</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="in_progress">In Progress</option>
                    <option value="verified">Verified</option>
                </select>
            </x-ui.filter-bar>
        </section>

        <!-- 5. Document Chips -->
        <section class="space-y-4">
            <h2 class="text-heading font-extrabold text-primary-dark">5. Document Preview Chips (`&lt;x-ui.document-chip&gt;`)</h2>
            <p class="text-body-sm text-zinc-500">Consistent file preview chips showing metadata, badges, and action triggers.</p>

            <div class="space-y-3">
                <x-ui.document-chip
                    title="AACCUP Area I Narrative Profile (Vision, Mission & Goals).pdf"
                    size="4.2 MB"
                    type="PDF"
                    date="Aug 28, 2026"
                    uploader="Dr. Santos (Task Force Lead)"
                    status="verified"
                    viewUrl="#"
                    downloadUrl="#"
                />

                <x-ui.document-chip
                    title="Faculty Workload & Class Schedules AY 2025-2026.docx"
                    size="1.8 MB"
                    type="DOCX"
                    date="Sep 01, 2026"
                    uploader="Prof. Cruz"
                    status="needs_revision"
                    viewUrl="#"
                    downloadUrl="#"
                />
            </div>
        </section>

        <!-- 6. Data Table -->
        <section class="space-y-4">
            <h2 class="text-heading font-extrabold text-primary-dark">6. Data Table (`&lt;x-ui.table&gt;`)</h2>
            <p class="text-body-sm text-zinc-500">Uniform table shell with zebra hover rows and standard typography.</p>

            <x-ui.table :headers="['Degree Program', 'College', 'Survey Level', 'Target Date', 'Status', 'Actions']">
                <tr class="hover:bg-zinc-50/80 transition">
                    <td class="py-4 px-6 font-bold text-zinc-900">BS in Computer Science</td>
                    <td class="py-4 px-6 text-zinc-600">College of Science</td>
                    <td class="py-4 px-6 font-mono text-xs font-semibold text-zinc-700">Level III (Re-accredited)</td>
                    <td class="py-4 px-6 font-mono text-xs text-zinc-600">Oct 15, 2026</td>
                    <td class="py-4 px-6"><x-ui.status-badge status="scheduled" /></td>
                    <td class="py-4 px-6">
                        <x-ui.button variant="subtle" size="sm">Manage Visit</x-ui.button>
                    </td>
                </tr>
                <tr class="hover:bg-zinc-50/80 transition">
                    <td class="py-4 px-6 font-bold text-zinc-900">BS in Information Technology</td>
                    <td class="py-4 px-6 text-zinc-600">College of Science</td>
                    <td class="py-4 px-6 font-mono text-xs font-semibold text-zinc-700">Level II</td>
                    <td class="py-4 px-6 font-mono text-xs text-zinc-600">Nov 20, 2026</td>
                    <td class="py-4 px-6"><x-ui.status-badge status="in_progress" /></td>
                    <td class="py-4 px-6">
                        <x-ui.button variant="subtle" size="sm">Manage Visit</x-ui.button>
                    </td>
                </tr>
            </x-ui.table>
        </section>

    </div>
</body>
</html>
