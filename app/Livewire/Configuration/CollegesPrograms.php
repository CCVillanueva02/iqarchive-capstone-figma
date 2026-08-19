<?php

namespace App\Livewire\Configuration;

use App\Models\College;
use App\Models\Program;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Colleges & Programs')]
class CollegesPrograms extends Component
{
    use WithPagination;

    // Search and filter state
    public $search = '';
    public $campusFilter = '';
    public $collegeFilter = '';
    public $levelFilter = '';

    // Authorization property
    public bool $canManage = false;

    // College Modals State
    public bool $showCreateCollegeModal = false;
    public bool $showEditCollegeModal = false;
    public bool $showDeleteCollegeModal = false;

    // Program Modals State
    public bool $showCreateProgramModal = false;
    public bool $showEditProgramModal = false;
    public bool $showDeleteProgramModal = false;

    // College Form Data
    public $collegeId = null;
    public $college_name = '';
    public $college_code = '';
    public $college_campus = 'Main Campus (Legazpi)';
    public $targetCollegeName = '';

    // Program Form Data
    public $programId = null;
    public $program_college_id = '';
    public $program_name = '';
    public $program_code = '';
    public $program_accreditation_level = 'Candidate Status';
    public $targetProgramName = '';

    // Expanded College Accordions Tracking
    public array $expandedCollegeIds = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'campusFilter' => ['except' => ''],
        'collegeFilter' => ['except' => ''],
        'levelFilter' => ['except' => ''],
    ];

    public function mount()
    {
        $user = auth()->user();
        if (!$user || !Gate::allows('viewCollegesAndPrograms')) {
            abort(403, 'Unauthorized action.');
        }

        $this->canManage = Gate::allows('manageCollegesAndPrograms');

        // Expand all colleges by default
        $this->expandedCollegeIds = College::pluck('id')->toArray();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCampusFilter()
    {
        $this->resetPage();
    }

    public function updatingCollegeFilter()
    {
        $this->resetPage();
    }

    public function updatingLevelFilter()
    {
        $this->resetPage();
    }

    public function toggleCollegeExpand($id)
    {
        if (in_array($id, $this->expandedCollegeIds)) {
            $this->expandedCollegeIds = array_diff($this->expandedCollegeIds, [$id]);
        } else {
            $this->expandedCollegeIds[] = $id;
        }
    }

    // ==========================================
    // COLLEGE CRUD ACTIONS
    // ==========================================

    public function openCreateCollegeModal()
    {
        if (!$this->canManage) abort(403);
        $this->resetCollegeForm();
        $this->showCreateCollegeModal = true;
    }

    public function closeCreateCollegeModal()
    {
        $this->showCreateCollegeModal = false;
        $this->resetCollegeForm();
    }

    public function createCollege()
    {
        if (!$this->canManage) abort(403);

        $validated = $this->validate([
            'college_name' => ['required', 'string', 'max:255'],
            'college_code' => ['required', 'string', 'max:50', 'unique:colleges,code'],
            'college_campus' => ['required', 'string', 'max:255'],
        ], [
            'college_name.required' => 'Please enter the college/academic unit name.',
            'college_code.required' => 'Please enter a unique college code/abbreviation.',
            'college_code.unique' => 'This college code is already registered.',
            'college_campus.required' => 'Please enter or select the campus.',
        ]);

        DB::transaction(function () use ($validated) {
            $college = College::create([
                'name' => trim($validated['college_name']),
                'code' => strtoupper(trim($validated['college_code'])),
                'campus' => trim($validated['college_campus']),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'CREATE_COLLEGE',
                'target_type' => College::class,
                'target_id' => $college->id,
                'timestamp' => now(),
            ]);

            if (!in_array($college->id, $this->expandedCollegeIds)) {
                $this->expandedCollegeIds[] = $college->id;
            }
        });

        $this->closeCreateCollegeModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('College Added!'),
            'text' => __('New college/unit registered successfully.'),
        ]);
    }

    public function openEditCollegeModal($id)
    {
        if (!$this->canManage) abort(403);
        $this->resetCollegeForm();
        $college = College::findOrFail($id);

        $this->collegeId = $college->id;
        $this->college_name = $college->name;
        $this->college_code = $college->code;
        $this->college_campus = $college->campus ?: 'Main Campus (Legazpi)';

        $this->showEditCollegeModal = true;
    }

    public function closeEditCollegeModal()
    {
        $this->showEditCollegeModal = false;
        $this->resetCollegeForm();
    }

    public function updateCollege()
    {
        if (!$this->canManage) abort(403);

        $college = College::findOrFail($this->collegeId);

        $validated = $this->validate([
            'college_name' => ['required', 'string', 'max:255'],
            'college_code' => ['required', 'string', 'max:50', 'unique:colleges,code,' . $this->collegeId],
            'college_campus' => ['required', 'string', 'max:255'],
        ], [
            'college_name.required' => 'Please enter the college/academic unit name.',
            'college_code.required' => 'Please enter a unique college code/abbreviation.',
            'college_code.unique' => 'This college code is already in use.',
            'college_campus.required' => 'Please enter or select the campus.',
        ]);

        DB::transaction(function () use ($college, $validated) {
            $college->update([
                'name' => trim($validated['college_name']),
                'code' => strtoupper(trim($validated['college_code'])),
                'campus' => trim($validated['college_campus']),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'UPDATE_COLLEGE',
                'target_type' => College::class,
                'target_id' => $college->id,
                'timestamp' => now(),
            ]);
        });

        $this->closeEditCollegeModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('College Updated!'),
            'text' => __('College details updated successfully.'),
        ]);
    }

    public function openDeleteCollegeModal($id)
    {
        if (!$this->canManage) abort(403);
        $college = College::withCount('programs')->findOrFail($id);
        $this->collegeId = $college->id;
        $this->targetCollegeName = $college->name . ' (' . $college->code . ')';
        $this->showDeleteCollegeModal = true;
    }

    public function closeDeleteCollegeModal()
    {
        $this->showDeleteCollegeModal = false;
        $this->collegeId = null;
        $this->targetCollegeName = '';
    }

    public function deleteCollege()
    {
        if (!$this->canManage) abort(403);

        $college = College::findOrFail($this->collegeId);

        DB::transaction(function () use ($college) {
            // Also soft delete associated programs
            $college->programs()->delete();
            $college->delete();

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'DELETE_COLLEGE',
                'target_type' => College::class,
                'target_id' => $college->id,
                'timestamp' => now(),
            ]);
        });

        $this->closeDeleteCollegeModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('College Removed'),
            'text' => __('College and its associated programs soft-deleted.'),
        ]);
    }

    private function resetCollegeForm()
    {
        $this->collegeId = null;
        $this->college_name = '';
        $this->college_code = '';
        $this->college_campus = 'Main Campus (Legazpi)';
        $this->targetCollegeName = '';
        $this->resetValidation();
    }

    // ==========================================
    // PROGRAM CRUD ACTIONS
    // ==========================================

    public function openCreateProgramModal(?int $presetCollegeId = null)
    {
        if (!$this->canManage) abort(403);
        $this->resetProgramForm();
        if ($presetCollegeId) {
            $this->program_college_id = $presetCollegeId;
        }
        $this->showCreateProgramModal = true;
    }

    public function closeCreateProgramModal()
    {
        $this->showCreateProgramModal = false;
        $this->resetProgramForm();
    }

    public function createProgram()
    {
        if (!$this->canManage) abort(403);

        $validated = $this->validate([
            'program_college_id' => ['required', 'exists:colleges,id'],
            'program_name' => ['required', 'string', 'max:255'],
            'program_code' => ['required', 'string', 'max:50', 'unique:programs,code'],
            'program_accreditation_level' => ['required', 'string', 'max:255'],
        ], [
            'program_college_id.required' => 'Please select the parent college/department.',
            'program_name.required' => 'Please enter the degree program name.',
            'program_code.required' => 'Please enter a unique program code (e.g. BSCS).',
            'program_code.unique' => 'This program code is already registered.',
            'program_accreditation_level.required' => 'Please select accreditation level.',
        ]);

        DB::transaction(function () use ($validated) {
            $program = Program::create([
                'college_id' => $validated['program_college_id'],
                'name' => trim($validated['program_name']),
                'code' => strtoupper(trim($validated['program_code'])),
                'accreditation_level' => $validated['program_accreditation_level'],
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'CREATE_PROGRAM',
                'target_type' => Program::class,
                'target_id' => $program->id,
                'timestamp' => now(),
            ]);

            if (!in_array($validated['program_college_id'], $this->expandedCollegeIds)) {
                $this->expandedCollegeIds[] = $validated['program_college_id'];
            }
        });

        $this->closeCreateProgramModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('Program Created!'),
            'text' => __('Academic program registered successfully.'),
        ]);
    }

    public function openEditProgramModal($id)
    {
        if (!$this->canManage) abort(403);
        $this->resetProgramForm();
        $program = Program::findOrFail($id);

        $this->programId = $program->id;
        $this->program_college_id = $program->college_id;
        $this->program_name = $program->name;
        $this->program_code = $program->code;
        $this->program_accreditation_level = $program->accreditation_level ?: 'Candidate Status';

        $this->showEditProgramModal = true;
    }

    public function closeEditProgramModal()
    {
        $this->showEditProgramModal = false;
        $this->resetProgramForm();
    }

    public function updateProgram()
    {
        if (!$this->canManage) abort(403);

        $program = Program::findOrFail($this->programId);

        $validated = $this->validate([
            'program_college_id' => ['required', 'exists:colleges,id'],
            'program_name' => ['required', 'string', 'max:255'],
            'program_code' => ['required', 'string', 'max:50', 'unique:programs,code,' . $this->programId],
            'program_accreditation_level' => ['required', 'string', 'max:255'],
        ], [
            'program_college_id.required' => 'Please select the parent college/department.',
            'program_name.required' => 'Please enter the degree program name.',
            'program_code.required' => 'Please enter a unique program code (e.g. BSCS).',
            'program_code.unique' => 'This program code is already registered.',
            'program_accreditation_level.required' => 'Please select accreditation level.',
        ]);

        DB::transaction(function () use ($program, $validated) {
            $program->update([
                'college_id' => $validated['program_college_id'],
                'name' => trim($validated['program_name']),
                'code' => strtoupper(trim($validated['program_code'])),
                'accreditation_level' => $validated['program_accreditation_level'],
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'UPDATE_PROGRAM',
                'target_type' => Program::class,
                'target_id' => $program->id,
                'timestamp' => now(),
            ]);
        });

        $this->closeEditProgramModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('Program Updated!'),
            'text' => __('Academic program details updated successfully.'),
        ]);
    }

    public function openDeleteProgramModal($id)
    {
        if (!$this->canManage) abort(403);
        $program = Program::findOrFail($id);
        $this->programId = $program->id;
        $this->targetProgramName = $program->name . ' (' . $program->code . ')';
        $this->showDeleteProgramModal = true;
    }

    public function closeDeleteProgramModal()
    {
        $this->showDeleteProgramModal = false;
        $this->programId = null;
        $this->targetProgramName = '';
    }

    public function deleteProgram()
    {
        if (!$this->canManage) abort(403);

        $program = Program::findOrFail($this->programId);

        DB::transaction(function () use ($program) {
            $program->delete();

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'DELETE_PROGRAM',
                'target_type' => Program::class,
                'target_id' => $program->id,
                'timestamp' => now(),
            ]);
        });

        $this->closeDeleteProgramModal();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => __('Program Soft-Deleted'),
            'text' => __('Academic program soft-deleted successfully.'),
        ]);
    }

    private function resetProgramForm()
    {
        $this->programId = null;
        $this->program_college_id = '';
        $this->program_name = '';
        $this->program_code = '';
        $this->program_accreditation_level = 'Candidate Status';
        $this->targetProgramName = '';
        $this->resetValidation();
    }

    // ==========================================
    // RENDER
    // ==========================================

    public function render()
    {
        $collegesQuery = College::with(['programs' => function ($pq) {
            if (!empty($this->levelFilter)) {
                $pq->where('accreditation_level', $this->levelFilter);
            }
            if (!empty($this->search)) {
                $pq->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            }
            $pq->orderBy('name', 'asc');
        }])
        ->withCount('programs');

        if (!empty($this->campusFilter)) {
            $collegesQuery->where('campus', $this->campusFilter);
        }

        if (!empty($this->collegeFilter)) {
            $collegesQuery->where('id', $this->collegeFilter);
        }

        if (!empty($this->search)) {
            $collegesQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%')
                    ->orWhere('campus', 'like', '%' . $this->search . '%')
                    ->orWhereHas('programs', function ($pq) {
                        $pq->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('code', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $colleges = $collegesQuery->orderBy('campus', 'asc')->orderBy('name', 'asc')->get();

        // Overall stats
        $totalColleges = College::count();
        $totalPrograms = Program::count();
        $accreditedPrograms = Program::where('accreditation_level', '!=', 'Candidate Status')->count();
        $candidatePrograms = Program::where('accreditation_level', 'Candidate Status')->count();

        $allCollegesDropdown = College::orderBy('name', 'asc')->get(['id', 'name', 'code', 'campus']);
        $campusesList = College::distinct()->pluck('campus')->filter()->values()->toArray();

        $accreditationLevels = [
            'Candidate Status',
            'Level I Accredited',
            'Level II Re-accredited',
            'Level III Re-accredited',
            'Level IV Re-accredited',
        ];

        return view('livewire.configuration.colleges-programs', [
            'colleges' => $colleges,
            'allCollegesDropdown' => $allCollegesDropdown,
            'campusesList' => $campusesList,
            'totalColleges' => $totalColleges,
            'totalPrograms' => $totalPrograms,
            'accreditedPrograms' => $accreditedPrograms,
            'candidatePrograms' => $candidatePrograms,
            'accreditationLevels' => $accreditationLevels,
        ]);
    }
}
