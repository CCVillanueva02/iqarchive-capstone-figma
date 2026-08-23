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

        $userProgram = $user->program ? [
            'id' => $user->program->id,
            'name' => $user->program->name,
            'code' => $user->program->code,
            'college' => $user->program->college ? $user->program->college->name : '',
            'collegeCode' => $user->program->college ? $user->program->college->code : '',
            'college_id' => $user->program->college_id,
            'level' => $user->program->accreditation_level ?: 'Candidate Status',
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
