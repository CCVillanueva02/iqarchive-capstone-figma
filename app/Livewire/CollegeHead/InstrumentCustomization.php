<?php

namespace App\Livewire\CollegeHead;

use App\Models\Accreditation;
use App\Models\AuditLog;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentParameter;
use App\Models\InstrumentCriterion;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Program Accreditation Instrument Setup')]
class InstrumentCustomization extends Component
{
    public int $accreditationId;

    public ?int $activeAreaId = null;
    public ?int $activeParameterId = null;
    public string $activeSection = 'systems';

    // Modals State
    public bool $showAddParameterModal = false;
    public bool $showAddCriterionModal = false;
    public bool $showFinalizeModal = false;

    // Form: Add Parameter
    public string $paramCode = '';
    public string $paramName = '';
    public string $paramDescription = '';

    // Form: Add/Edit Criterion
    public ?int $editingCriterionId = null;
    public string $criterionCode = '';
    public string $criterionStatement = '';
    public string $criterionDescription = '';
    public array $criterionTags = [];
    public string $newTagInput = '';

    public function mount(int $accreditation)
    {
        $this->accreditationId = $accreditation;
        $user = Auth::user();

        $acc = Accreditation::with(['program.college', 'taskForce', 'instrument'])->findOrFail($this->accreditationId);

        // Security check: Scoped to Dean's college or central IQA
        if ($user->hasRole('college-head') && $user->college_id && $acc->program->college_id !== $user->college_id) {
            abort(403, 'Unauthorized access to another college\'s accreditation instrument.');
        }

        // If accreditation does not yet have an instantiated instrument, clone from master template
        if (! $acc->instrument) {
            $masterTemplate = Instrument::where('is_template', true)
                ->where('accreditation_type', 'program')
                ->latest()
                ->first();

            if (! $masterTemplate) {
                // Fallback to any active master template
                $masterTemplate = Instrument::where('is_template', true)->first();
            }

            if ($masterTemplate) {
                $masterTemplate->cloneForProgram($acc->program, $acc, $user);
                $acc->load('instrument.areas.parameters.criteria');
            }
        }

        // Set initial selected area & parameter
        if ($acc->instrument && $acc->instrument->areas->isNotEmpty()) {
            $firstArea = $acc->instrument->areas->first();
            $this->activeAreaId = $firstArea->id;

            if ($firstArea->parameters->isNotEmpty()) {
                $this->activeParameterId = $firstArea->parameters->first()->id;
            }
        }
    }

    public function getAccreditationProperty()
    {
        return Accreditation::with([
            'program.college',
            'taskForce.members',
            'instrument.areas.parameters.criteria',
            'instrument.complianceRequirements'
        ])->find($this->accreditationId);
    }

    public function selectArea(int $areaId)
    {
        $this->activeAreaId = $areaId;
        $area = InstrumentArea::with('parameters')->find($areaId);

        if ($area && $area->parameters->isNotEmpty()) {
            $this->activeParameterId = $area->parameters->first()->id;
        } else {
            $this->activeParameterId = null;
        }
        $this->activeSection = 'systems';
    }

    public function selectParameter(int $paramId)
    {
        $this->activeParameterId = $paramId;
    }

    public function setSection(string $section)
    {
        $this->activeSection = $section;
    }

    // ── Add Parameter ────────────────────────────────────────────────

    public function openAddParameterModal()
    {
        $area = InstrumentArea::with('parameters')->find($this->activeAreaId);
        $nextLetter = chr(65 + ($area ? $area->parameters->count() : 0));
        $this->paramCode = "Parameter {$nextLetter}";
        $this->paramName = '';
        $this->paramDescription = '';
        $this->showAddParameterModal = true;
    }

    public function closeAddParameterModal()
    {
        $this->showAddParameterModal = false;
        $this->reset(['paramCode', 'paramName', 'paramDescription']);
    }

    public function saveCustomParameter()
    {
        $this->validate([
            'paramCode' => 'required|string|max:30',
            'paramName' => 'required|string|max:255',
        ]);

        $area = InstrumentArea::with('parameters')->findOrFail($this->activeAreaId);

        $param = InstrumentParameter::create([
            'instrument_area_id' => $area->id,
            'code' => trim($this->paramCode),
            'name' => trim($this->paramName),
            'description' => trim($this->paramDescription),
            'order' => $area->parameters->count() + 1,
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Dean added custom parameter {$param->code} ({$param->name}) for {$this->accreditation->program->name}",
            'target_type' => 'InstrumentParameter',
            'target_id' => $param->id,
            'timestamp' => now(),
        ]);

        $this->activeParameterId = $param->id;
        $this->closeAddParameterModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Parameter Added', 'text' => "Custom parameter {$param->code} added."]);
    }

    // ── Add / Edit Criterion ─────────────────────────────────────────

    public function openAddCriterionModal(?int $criterionId = null)
    {
        $this->editingCriterionId = $criterionId;
        $this->newTagInput = '';

        if ($criterionId) {
            $crit = InstrumentCriterion::findOrFail($criterionId);
            $this->criterionCode = $crit->code;
            $this->criterionStatement = $crit->statement;
            $this->criterionDescription = $crit->description ?? '';
            $this->criterionTags = is_array($crit->required_tags) ? $crit->required_tags : [];
        } else {
            $prefix = match($this->activeSection) {
                'systems' => 'S',
                'implementation' => 'I',
                'outcomes' => 'O',
                'best_practices' => 'BP',
                default => 'C',
            };
            $count = InstrumentCriterion::where('instrument_parameter_id', $this->activeParameterId)
                ->where('section', $this->activeSection)
                ->count();

            $this->criterionCode = "{$prefix}." . ($count + 1);
            $this->criterionStatement = '';
            $this->criterionDescription = '';
            $this->criterionTags = [];
        }

        $this->showAddCriterionModal = true;
    }

    public function closeAddCriterionModal()
    {
        $this->showAddCriterionModal = false;
        $this->editingCriterionId = null;
        $this->criterionTags = [];
        $this->newTagInput = '';
    }

    public function addTag()
    {
        $raw = trim($this->newTagInput);
        if (empty($raw)) return;

        $tag = str_starts_with($raw, '#') ? $raw : "#{$raw}";
        $tag = preg_replace('/\s+/', '_', $tag);

        if (! in_array($tag, $this->criterionTags)) {
            $this->criterionTags[] = $tag;
        }

        $this->newTagInput = '';
    }

    public function removeTag(int $index)
    {
        if (isset($this->criterionTags[$index])) {
            unset($this->criterionTags[$index]);
            $this->criterionTags = array_values($this->criterionTags);
        }
    }

    public function saveCriterion()
    {
        $this->validate([
            'criterionCode' => 'required|string|max:20',
            'criterionStatement' => 'required|string|min:3',
        ]);

        if ($this->editingCriterionId) {
            $crit = InstrumentCriterion::findOrFail($this->editingCriterionId);
            $crit->update([
                'code' => trim($this->criterionCode),
                'statement' => trim($this->criterionStatement),
                'description' => trim($this->criterionDescription),
                'required_tags' => $this->criterionTags,
            ]);
            $msg = "Criterion {$crit->code} updated.";
        } else {
            $count = InstrumentCriterion::where('instrument_parameter_id', $this->activeParameterId)
                ->where('section', $this->activeSection)
                ->count();

            $crit = InstrumentCriterion::create([
                'instrument_parameter_id' => $this->activeParameterId,
                'section' => $this->activeSection,
                'code' => trim($this->criterionCode),
                'statement' => trim($this->criterionStatement),
                'description' => trim($this->criterionDescription),
                'required_tags' => $this->criterionTags,
                'order' => $count + 1,
            ]);
            $msg = "Criterion {$crit->code} added to section.";
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Dean configured criterion {$crit->code} for {$this->accreditation->program->name}",
            'target_type' => 'InstrumentCriterion',
            'target_id' => $crit->id,
            'timestamp' => now(),
        ]);

        $this->closeAddCriterionModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Criterion Saved', 'text' => $msg]);
    }

    // ── Finalize & Unlock Evidence Repository (Advance to Stage 5) ───

    public function openFinalizeModal()
    {
        $this->showFinalizeModal = true;
    }

    public function closeFinalizeModal()
    {
        $this->showFinalizeModal = false;
    }

    public function finalizeInstrument()
    {
        $acc = $this->accreditation;
        $user = Auth::user();

        // 1. Advance accreditation status to document_preparation
        $acc->update([
            'status' => 'document_preparation',
        ]);

        // 2. Notify Task Force members that upload workspace is active
        if ($acc->taskForce && $acc->taskForce->members->isNotEmpty()) {
            foreach ($acc->taskForce->members as $member) {
                Notification::create([
                    'user_id' => $member->id,
                    'type' => 'info',
                    'message' => "Accreditation instrument for {$acc->program->name} is finalized. The Evidence Repository is now open for uploads.",
                    'is_read' => false,
                ]);
            }
        }

        // 3. Log Audit Entry
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Dean finalized instrument for {$acc->program->name}. Status advanced to document_preparation.",
            'target_type' => 'Accreditation',
            'target_id' => $acc->id,
            'timestamp' => now(),
        ]);

        $this->closeFinalizeModal();

        session()->flash('status', "Instrument setup completed for {$acc->program->name}! Evidence repository is now unlocked for the Task Force.");
        return redirect()->route('dashboard.college-head');
    }

    public function render()
    {
        $acc = $this->accreditation;

        $activeArea = $this->activeAreaId && $acc?->instrument
            ? $acc->instrument->areas->firstWhere('id', $this->activeAreaId)
            : null;

        $activeParameter = $this->activeParameterId && $activeArea
            ? $activeArea->parameters->firstWhere('id', $this->activeParameterId)
            : null;

        $activeCriteria = $activeParameter
            ? $activeParameter->criteria->where('section', $this->activeSection)->values()
            : collect();

        return view('livewire.college-head.instrument-customization', [
            'accreditation' => $acc,
            'activeArea' => $activeArea,
            'activeParameter' => $activeParameter,
            'activeCriteria' => $activeCriteria,
        ]);
    }
}
