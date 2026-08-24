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
    public string $activeCategory = 'supporting-docs';

    public ?int $selectedInstrumentId = null;
    public ?int $activeAreaId = null;
    public ?int $activeParameterId = null;
    public string $activeSection = 'systems';

    // Modals State
    public bool $showAreaModal = false;
    public bool $showParameterModal = false;
    public bool $showCriterionModal = false;
    public bool $showFinalizeModal = false;
    public bool $showDeleteModal = false;

    // Form: Add/Edit Area
    public ?int $editingAreaId = null;
    public string $areaCode = '';
    public string $areaName = '';
    public float $areaWeight = 10.00;
    public int $areaOrder = 1;
    public string $areaDescription = '';

    // Form: Add/Edit Parameter
    public ?int $editingParameterId = null;
    public string $paramCode = '';
    public string $paramName = '';
    public int $paramOrder = 1;
    public string $paramDescription = '';

    // Form: Add/Edit Criterion
    public ?int $editingCriterionId = null;
    public string $criterionCode = '';
    public string $criterionStatement = '';
    public string $criterionDescription = '';
    public array $criterionTags = [];
    public string $newTagInput = '';
    public int $criterionOrder = 1;

    // Form: Delete Confirmation
    public string $deleteType = '';
    public ?int $deleteTargetId = null;
    public string $deleteTargetTitle = '';

    public function mount(int $accreditation)
    {
        $this->accreditationId = $accreditation;
        $user = Auth::user();

        $acc = Accreditation::with(['program.college', 'taskForce'])->findOrFail($this->accreditationId);

        // Security check: Scoped to Dean's college or central IQA
        if ($user->hasRole('college-head') && $user->college_id && $acc->program->college_id !== $user->college_id) {
            abort(403, 'Unauthorized access to another college\'s accreditation instrument.');
        }

        $this->resolveActiveInstrument();
    }

    public function switchCategory(string $category)
    {
        $this->activeCategory = in_array($category, ['supporting-docs', 'self-survey', 'compliance-reports']) ? $category : 'supporting-docs';
        $this->resolveActiveInstrument();
    }

    public function resolveActiveInstrument()
    {
        $acc = Accreditation::with(['program.college'])->findOrFail($this->accreditationId);
        $user = Auth::user();

        $masterCode = match($this->activeCategory) {
            'supporting-docs' => 'INST-PROG-SUPPORTING-DOCS',
            'self-survey' => 'INST-PROG-SELF-SURVEY',
            'compliance-reports' => 'INST-PROG-COMPLIANCE-REPORT',
            default => 'INST-PROG-SUPPORTING-DOCS',
        };

        $categoryPattern = match($this->activeCategory) {
            'supporting-docs' => 'SUPP',
            'self-survey' => 'SURVEY',
            'compliance-reports' => 'COMPLIANCE',
            default => 'SUPP',
        };

        // Check if an instrument instance already exists for this accreditation and category
        $instrument = Instrument::with(['areas.parameters.criteria'])
            ->where('accreditation_id', $acc->id)
            ->where(function ($q) use ($categoryPattern) {
                $q->where('code', 'like', "%{$categoryPattern}%")
                  ->orWhere('name', 'like', "%" . match($categoryPattern) {
                      'SURVEY' => 'Self-Survey',
                      'COMPLIANCE' => 'Compliance',
                      default => 'Supporting',
                  } . "%");
            })
            ->first();

        // Fallback for primary supporting docs if older un-suffixed record exists
        if (! $instrument && $this->activeCategory === 'supporting-docs') {
            $instrument = Instrument::with(['areas.parameters.criteria'])
                ->where('accreditation_id', $acc->id)
                ->where('is_template', false)
                ->first();
        }

        // If not found or empty (0 areas), look for a program instance or clone from the baseline
        if (! $instrument || $instrument->areas->isEmpty()) {
            if ($instrument && $instrument->areas->isEmpty()) {
                $instrument->delete();
            }

            $masterTemplate = Instrument::where('code', $masterCode)->first()
                ?? Instrument::where('is_template', true)->where('accreditation_type', 'program')->whereHas('areas')->first();

            if ($masterTemplate) {
                $instrument = $masterTemplate->cloneForProgram($acc->program, $acc, $user);
                $instrument->load('areas.parameters.criteria');
            }
        }

        if ($instrument) {
            $this->selectedInstrumentId = $instrument->id;

            if ($instrument->areas->isNotEmpty()) {
                $firstArea = $instrument->areas->first();
                $this->activeAreaId = $firstArea->id;

                if ($firstArea->parameters->isNotEmpty()) {
                    $this->activeParameterId = $firstArea->parameters->first()->id;
                } else {
                    $this->activeParameterId = null;
                }
            } else {
                $this->activeAreaId = null;
                $this->activeParameterId = null;
            }
        } else {
            $this->selectedInstrumentId = null;
            $this->activeAreaId = null;
            $this->activeParameterId = null;
        }

        $this->activeSection = 'systems';
    }

    public function selectArea($areaId)
    {
        $this->activeAreaId = (int) $areaId;
        $area = InstrumentArea::with('parameters')->find($this->activeAreaId);

        if ($area && $area->parameters->isNotEmpty()) {
            $this->activeParameterId = $area->parameters->first()->id;
        } else {
            $this->activeParameterId = null;
        }
    }

    public function selectParameter($paramId)
    {
        $this->activeParameterId = (int) $paramId;
    }

    public function setSection(string $section)
    {
        $this->activeSection = $section;
    }

    // ── Area Actions ──────────────────────────────────────────────────

    public function openAreaModal($areaId = null)
    {
        $this->editingAreaId = $areaId ? (int) $areaId : null;

        if ($this->editingAreaId) {
            $area = InstrumentArea::findOrFail($this->editingAreaId);
            $this->areaCode = $area->code;
            $this->areaName = $area->name;
            $this->areaWeight = (float) $area->weight;
            $this->areaOrder = $area->order;
            $this->areaDescription = $area->description ?? '';
        } else {
            $inst = Instrument::with('areas')->find($this->selectedInstrumentId);
            $nextNum = ($inst ? $inst->areas->count() : 0) + 1;
            $this->areaCode = "Area " . $this->toRoman($nextNum);
            $this->areaName = '';
            $this->areaWeight = 10.00;
            $this->areaOrder = $nextNum;
            $this->areaDescription = '';
        }

        $this->showAreaModal = true;
    }

    public function closeAreaModal()
    {
        $this->showAreaModal = false;
        $this->editingAreaId = null;
        $this->reset(['areaCode', 'areaName', 'areaWeight', 'areaOrder', 'areaDescription']);
    }

    public function saveArea()
    {
        $this->validate([
            'areaCode' => 'required|string|max:30',
            'areaName' => 'required|string|max:255',
            'areaWeight' => 'required|numeric|min:0|max:100',
            'areaOrder' => 'required|integer|min:1',
        ]);

        if ($this->editingAreaId) {
            $area = InstrumentArea::findOrFail($this->editingAreaId);
            $area->update([
                'code' => trim($this->areaCode),
                'name' => trim($this->areaName),
                'weight' => $this->areaWeight,
                'order' => $this->areaOrder,
                'description' => trim($this->areaDescription),
            ]);
            $msg = "Area {$area->code} updated successfully.";
        } else {
            $area = InstrumentArea::create([
                'instrument_id' => $this->selectedInstrumentId,
                'code' => trim($this->areaCode),
                'name' => trim($this->areaName),
                'order' => $this->areaOrder,
                'weight' => $this->areaWeight,
                'description' => trim($this->areaDescription),
            ]);
            $this->activeAreaId = $area->id;
            $msg = "New Area {$area->code} added.";
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Dean configured Area: {$area->code} ({$area->name}) for {$this->accreditation->program->name}",
            'target_type' => 'InstrumentArea',
            'target_id' => $area->id,
            'timestamp' => now(),
        ]);

        $this->closeAreaModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Area Saved', 'text' => $msg]);
    }

    // ── Parameter Actions ─────────────────────────────────────────────

    public function openAddParameterModal($paramId = null)
    {
        $this->editingParameterId = $paramId ? (int) $paramId : null;

        if ($this->editingParameterId) {
            $param = InstrumentParameter::findOrFail($this->editingParameterId);
            $this->paramCode = $param->code;
            $this->paramName = $param->name;
            $this->paramOrder = $param->order;
            $this->paramDescription = $param->description ?? '';
        } else {
            $area = InstrumentArea::with('parameters')->find($this->activeAreaId);
            $nextLetter = chr(65 + ($area ? $area->parameters->count() : 0));
            $this->paramCode = "Parameter {$nextLetter}";
            $this->paramName = '';
            $this->paramOrder = $area ? ($area->parameters->count() + 1) : 1;
            $this->paramDescription = '';
        }
        $this->showParameterModal = true;
    }

    public function closeParameterModal()
    {
        $this->showParameterModal = false;
        $this->editingParameterId = null;
        $this->reset(['paramCode', 'paramName', 'paramOrder', 'paramDescription']);
    }

    public function saveCustomParameter()
    {
        $this->validate([
            'paramCode' => 'required|string|max:30',
            'paramName' => 'required|string|max:255',
            'paramOrder' => 'required|integer|min:1',
        ]);

        if ($this->editingParameterId) {
            $param = InstrumentParameter::findOrFail($this->editingParameterId);
            $param->update([
                'code' => trim($this->paramCode),
                'name' => trim($this->paramName),
                'order' => $this->paramOrder,
                'description' => trim($this->paramDescription),
            ]);
            $msg = "Parameter {$param->code} updated.";
        } else {
            $area = InstrumentArea::with('parameters')->findOrFail($this->activeAreaId);
            $param = InstrumentParameter::create([
                'instrument_area_id' => $area->id,
                'code' => trim($this->paramCode),
                'name' => trim($this->paramName),
                'order' => $this->paramOrder,
                'description' => trim($this->paramDescription),
            ]);
            $msg = "Custom parameter {$param->code} added.";
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Dean configured parameter {$param->code} ({$param->name}) for {$this->accreditation->program->name}",
            'target_type' => 'InstrumentParameter',
            'target_id' => $param->id,
            'timestamp' => now(),
        ]);

        $this->activeParameterId = $param->id;
        $this->closeParameterModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Parameter Saved', 'text' => $msg]);
    }

    // ── Criterion / Checklist Actions ─────────────────────────────────

    public function openAddCriterionModal($criterionId = null)
    {
        $this->editingCriterionId = $criterionId ? (int) $criterionId : null;
        $this->newTagInput = '';

        if ($this->editingCriterionId) {
            $crit = InstrumentCriterion::findOrFail($this->editingCriterionId);
            $this->criterionCode = $crit->code;
            $this->criterionStatement = $crit->statement;
            $this->criterionDescription = $crit->description ?? '';
            $this->criterionTags = is_array($crit->required_tags) ? $crit->required_tags : [];
            $this->criterionOrder = $crit->order;
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
            $this->criterionOrder = $count + 1;
        }

        $this->showCriterionModal = true;
    }

    public function closeCriterionModal()
    {
        $this->showCriterionModal = false;
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

    public function removeTag($index)
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
            'criterionOrder' => 'required|integer|min:1',
        ]);

        if ($this->editingCriterionId) {
            $crit = InstrumentCriterion::findOrFail($this->editingCriterionId);
            $crit->update([
                'code' => trim($this->criterionCode),
                'statement' => trim($this->criterionStatement),
                'description' => trim($this->criterionDescription),
                'required_tags' => $this->criterionTags,
                'order' => $this->criterionOrder,
            ]);
            $msg = "Criterion {$crit->code} updated.";
        } else {
            $crit = InstrumentCriterion::create([
                'instrument_parameter_id' => $this->activeParameterId,
                'section' => $this->activeSection,
                'code' => trim($this->criterionCode),
                'statement' => trim($this->criterionStatement),
                'description' => trim($this->criterionDescription),
                'required_tags' => $this->criterionTags,
                'order' => $this->criterionOrder,
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

        $this->closeCriterionModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Criterion Saved', 'text' => $msg]);
    }

    // ── Delete Confirmation ───────────────────────────────────────────

    public function openDeleteModal(string $type, $id, string $title)
    {
        $this->deleteType = $type;
        $this->deleteTargetId = (int) $id;
        $this->deleteTargetTitle = $title;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteType = '';
        $this->deleteTargetId = null;
        $this->deleteTargetTitle = '';
    }

    public function executeDelete()
    {
        $type = $this->deleteType;
        $id = $this->deleteTargetId;

        if ($type === 'area') {
            $area = InstrumentArea::findOrFail($id);
            $area->delete();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => "Dean deleted Area {$area->code} from {$this->accreditation->program->name}",
                'target_type' => 'InstrumentArea',
                'target_id' => $id,
                'timestamp' => now(),
            ]);

            $inst = Instrument::with('areas')->find($this->selectedInstrumentId);
            $this->activeAreaId = $inst?->areas->first()?->id;
            $this->activeParameterId = $inst?->areas->first()?->parameters->first()?->id;
        } elseif ($type === 'parameter') {
            $param = InstrumentParameter::findOrFail($id);
            $param->delete();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => "Dean deleted Parameter {$param->code} from {$this->accreditation->program->name}",
                'target_type' => 'InstrumentParameter',
                'target_id' => $id,
                'timestamp' => now(),
            ]);

            $area = InstrumentArea::with('parameters')->find($this->activeAreaId);
            $this->activeParameterId = $area?->parameters->first()?->id;
        } elseif ($type === 'criterion') {
            $crit = InstrumentCriterion::findOrFail($id);
            $crit->delete();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => "Dean deleted Criterion {$crit->code} from {$this->accreditation->program->name}",
                'target_type' => 'InstrumentCriterion',
                'target_id' => $id,
                'timestamp' => now(),
            ]);
        }

        $this->closeDeleteModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Deleted Successfully', 'text' => "Item removed."]);
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
                    'message' => "Accreditation instruments for {$acc->program->name} are finalized. The Evidence Repository is now open for uploads.",
                    'is_read' => false,
                ]);
            }
        }

        // 3. Log Audit Entry
        AuditLog::create([
            'user_id' => $user->id,
            'action' => "Dean finalized instruments for {$acc->program->name}. Status advanced to document_preparation.",
            'target_type' => 'Accreditation',
            'target_id' => $acc->id,
            'timestamp' => now(),
        ]);

        $this->closeFinalizeModal();

        session()->flash('status', "Instrument setup completed for {$acc->program->name}! Evidence repository is now unlocked for the Task Force.");
        return redirect()->route('dashboard.college-head');
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

    private function toRoman(int $num): string
    {
        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];
        $result = '';
        foreach ($map as $roman => $value) {
            while ($num >= $value) {
                $result .= $roman;
                $num -= $value;
            }
        }
        return $result ?: 'I';
    }

    public function render()
    {
        $acc = $this->accreditation;

        $instrument = $this->selectedInstrumentId
            ? Instrument::with(['areas.parameters.criteria'])->find($this->selectedInstrumentId)
            : null;

        $activeArea = $this->activeAreaId && $instrument
            ? $instrument->areas->firstWhere('id', $this->activeAreaId)
            : null;

        $activeParameter = $this->activeParameterId && $activeArea
            ? $activeArea->parameters->firstWhere('id', $this->activeParameterId)
            : null;

        $activeCriteria = $activeParameter
            ? $activeParameter->criteria->where('section', $this->activeSection)->values()
            : collect();

        return view('livewire.college-head.instrument-customization', [
            'accreditation' => $acc,
            'selectedInstrument' => $instrument,
            'activeArea' => $activeArea,
            'activeParameter' => $activeParameter,
            'activeCriteria' => $activeCriteria,
        ]);
    }
}
