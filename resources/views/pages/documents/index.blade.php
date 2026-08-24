<x-layouts::app :title="__('Documents')">
    @php
        $user = auth()->user();
        $userRole = $user->role;
        $canSeeCommonDocs = in_array($userRole, ['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'task-force-member', 'college-head', 'system-administrator']);
        $canSeeInstitutionalDocs = in_array($userRole, ['iqa-staff', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);
        $isUnrestricted = in_array($userRole, ['iqa-staff', 'system-administrator']) || $user->hasAnyRole(['iqa-staff', 'system-administrator']);
        
        $userCollege = $user->college ? [
            'id' => $user->college->id,
            'name' => $user->college->name,
            'code' => $user->college->code,
            'campus' => $user->college->campus ?: 'BU Campus',
            'description' => $user->college->campus ?: 'BU Academic Unit',
            'programCount' => $user->college->programs()->count(),
        ] : null;

        $resolvedProgram = $user->program;
        if (!$resolvedProgram && ($user->hasRole('task-force-member') || $user->role === 'task-force-member')) {
            $tf = $user->taskForces()->whereNotNull('program_id')->first();
            $resolvedProgram = $tf?->program;
        }

        $latestAccred = $resolvedProgram ? $resolvedProgram->accreditations()->latest()->first() : null;
        $isInstrumentVerified = $latestAccred && in_array($latestAccred->status, [
            'document_preparation',
            'uploading',
            'dean_verification',
            'submitted',
            'completed',
        ]);

        $userProgram = $resolvedProgram ? [
            'id' => $resolvedProgram->id,
            'name' => $resolvedProgram->name,
            'code' => $resolvedProgram->code,
            'college' => $resolvedProgram->college ? $resolvedProgram->college->name : '',
            'collegeCode' => $resolvedProgram->college ? $resolvedProgram->college->code : '',
            'college_id' => $resolvedProgram->college_id,
            'level' => $resolvedProgram->accreditation_level ?: 'Candidate Status',
            'accreditation_id' => $latestAccred?->id,
            'accreditation_status' => $latestAccred?->status ?? 'no_active_accreditation',
            'instrument_verified' => $isInstrumentVerified,
        ] : null;

        $defaultTab = $canSeeCommonDocs ? 'common-documents' : 'program-accreditation';
        $activeTab = request()->query('tab', $defaultTab);
        if (!$canSeeCommonDocs && $activeTab === 'common-documents') {
            $activeTab = 'program-accreditation';
        }
        if (!$canSeeInstitutionalDocs && $activeTab === 'institutional-accreditation') {
            $activeTab = 'program-accreditation';
        }
    @endphp
    <div x-data="documentWorkspace({ 
        userId: {{ $user->id }}, 
        userRole: '{{ $userRole }}', 
        activeTab: '{{ $activeTab }}',
        isUnrestricted: {{ $isUnrestricted ? 'true' : 'false' }},
        userCollege: {{ $userCollege ? json_encode($userCollege) : 'null' }},
        userProgram: {{ $userProgram ? json_encode($userProgram) : 'null' }}
    })" class="w-full px-8 py-8 flex flex-col gap-6 bg-surface-subtle min-h-screen relative overflow-hidden">
        @include('pages.documents.partials.header')

        @if ($canSeeCommonDocs)
        @include('pages.documents.partials.common-documents')
        @endif

        @include('pages.documents.partials.program-accreditation')

        @if ($canSeeInstitutionalDocs)
        @include('pages.documents.partials.institutional-accreditation')
        @endif

        @include('pages.documents.partials.detail-drawer')
    </div>
</x-layouts::app>
