<?php

namespace App\Livewire\Configuration;

use App\Models\AuditLog;
use App\Models\College;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentCriterion;
use App\Models\InstrumentParameter;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Accreditation Instruments Configuration')]
class Instruments extends Component
{
    use WithPagination;

    // Scope: 'program' or 'institutional'
    public string $accreditationScope = 'program'; // program, institutional

    // Program Selector: null for Master Template Baseline, or specific Program ID
    public ?int $selectedProgramId = null;

    // Active Instrument Category (Supporting Documents, Self-Survey, Compliance Reports)
    public string $activeCategory = 'supporting-docs'; // supporting-docs, self-survey, compliance-reports

    // Selected Active Instrument for the Builder
    public ?int $selectedInstrumentId = null;

    public ?int $activeAreaId = null;

    public ?int $activeParameterId = null;

    public string $activeSection = 'systems'; // systems, implementation, outcomes, best_practices

    // Modals Visibility
    public bool $showCreateTemplateModal = false;

    public bool $showCloneTemplateModal = false;

    public bool $showAreaModal = false;

    public bool $showParameterModal = false;

    public bool $showCriterionModal = false;

    public bool $showDeleteModal = false;

    // Form State: Template Creation / Cloning
    public string $templateName = '';

    public string $templateCode = '';

    public string $templateLevel = 'Level III';

    public string $templateType = 'program';

    public string $templateVersion = '2026.1';

    public string $templateDescription = '';

    public ?int $sourceTemplateId = null;

    public ?int $cloneTargetProgramId = null;

    // Form State: Area
    public ?int $editingAreaId = null;

    public string $areaCode = '';

    public string $areaName = '';

    public int $areaOrder = 1;

    public ?float $areaWeight = null;

    public string $areaDescription = '';

    // Form State: Parameter
    public ?int $editingParameterId = null;

    public string $parameterCode = '';

    public string $parameterName = '';

    public int $parameterOrder = 1;

    public string $parameterDescription = '';

    // Form State: Criterion / Item
    public ?int $editingCriterionId = null;

    public string $criterionCode = '';

    public string $criterionStatement = '';

    public string $criterionDescription = '';

    public array $criterionTags = [];

    public string $newTagInput = '';

    public int $criterionOrder = 1;

    // Delete Target State
    public string $deleteType = ''; // template, area, parameter, criterion

    public ?int $deleteTargetId = null;

    public string $deleteTargetTitle = '';

    protected $queryString = [
        'accreditationScope' => ['except' => 'program'],
        'selectedProgramId' => ['except' => null],
        'activeCategory' => ['except' => 'supporting-docs'],
    ];

    public function mount()
    {
        $user = Auth::user();
        if (! $user || ! $user->hasRole(['iqa-staff', 'system-administrator', 'university-administrator', 'college-head'])) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->hasRole('college-head') && $user->college_id) {
            $this->accreditationScope = 'program';
        }

        $this->resolveActiveInstrument();
    }

    public function switchScope(string $scope)
    {
        $user = Auth::user();
        if ($user && $user->hasRole('college-head')) {
            $this->accreditationScope = 'program';
        } else {
            $this->accreditationScope = in_array($scope, ['program', 'institutional']) ? $scope : 'program';
        }

        if ($this->accreditationScope === 'institutional') {
            $this->selectedProgramId = null;
        }
        $this->resolveActiveInstrument();
    }

    public function selectProgram($programId = null)
    {
        $this->selectedProgramId = ! empty($programId) ? (int) $programId : null;
        $this->resolveActiveInstrument();
    }

    public function clearProgramFilter()
    {
        $this->selectedProgramId = null;
        $this->resolveActiveInstrument();
    }

    public function switchCategory(string $category)
    {
        $this->activeCategory = $category;
        $this->resolveActiveInstrument();
    }

    public function resolveActiveInstrument()
    {
        // 1. If Institutional Scope
        if ($this->accreditationScope === 'institutional') {
            $targetCode = match ($this->activeCategory) {
                'supporting-docs' => 'INST-INST-SUPPORTING-DOCS',
                'self-survey' => 'INST-INST-SELF-SURVEY',
                'compliance-reports' => 'INST-INST-COMPLIANCE-REPORT',
                default => 'INST-INST-SUPPORTING-DOCS',
            };

            $inst = Instrument::where('code', $targetCode)->first()
                ?? Instrument::where('is_template', true)->where('accreditation_type', 'institutional')->first();

            if ($inst) {
                $this->selectInstrument($inst->id);
            }

            return;
        }

        // 2. If Program Scope with a Specific Program Selected
        if ($this->selectedProgramId) {
            $program = Program::find($this->selectedProgramId);
            if ($program) {
                // Check if program has a custom instrument for this category
                $targetMasterCode = match ($this->activeCategory) {
                    'supporting-docs' => 'INST-PROG-SUPPORTING-DOCS',
                    'self-survey' => 'INST-PROG-SELF-SURVEY',
                    'compliance-reports' => 'INST-PROG-COMPLIANCE-REPORT',
                    default => 'INST-PROG-SUPPORTING-DOCS',
                };

                $customInst = Instrument::where('program_id', $program->id)
                    ->where('is_template', false)
                    ->latest()
                    ->first();

                if ($customInst) {
                    $this->selectInstrument($customInst->id);
                } else {
                    // Display none / empty state with Clone CTA
                    $this->selectedInstrumentId = null;
                    $this->activeAreaId = null;
                    $this->activeParameterId = null;
                }

                return;
            }
        }

        // 3. Program Scope Default Master Template
        $targetCode = match ($this->activeCategory) {
            'supporting-docs' => 'INST-PROG-SUPPORTING-DOCS',
            'self-survey' => 'INST-PROG-SELF-SURVEY',
            'compliance-reports' => 'INST-PROG-COMPLIANCE-REPORT',
            default => 'INST-PROG-SUPPORTING-DOCS',
        };

        $inst = Instrument::where('code', $targetCode)->first()
            ?? Instrument::where('is_template', true)->where('accreditation_type', 'program')->first();

        if ($inst) {
            $this->selectInstrument($inst->id);
        }
    }

    public function cloneMasterForProgram()
    {
        if (! $this->selectedProgramId) {
            return;
        }

        $program = Program::findOrFail($this->selectedProgramId);
        $masterCode = match ($this->activeCategory) {
            'supporting-docs' => 'INST-PROG-SUPPORTING-DOCS',
            'self-survey' => 'INST-PROG-SELF-SURVEY',
            'compliance-reports' => 'INST-PROG-COMPLIANCE-REPORT',
            default => 'INST-PROG-SUPPORTING-DOCS',
        };

        $master = Instrument::where('code', $masterCode)->first()
            ?? Instrument::where('is_template', true)->where('accreditation_type', 'program')->first();

        if (! $master) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Error', 'text' => 'Master Template not found.']);

            return;
        }

        $cloned = $master->cloneForProgram($program, null, Auth::user());

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "IQA Staff cloned Master Instrument for program {$program->name} ({$program->code})",
            'target_type' => 'Instrument',
            'target_id' => $cloned->id,
            'timestamp' => now(),
        ]);

        $this->selectInstrument($cloned->id);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Instrument Cloned!',
            'text' => "Master Template successfully cloned for {$program->name}. You can now customize program-specific criteria.",
        ]);
    }

    public function selectInstrument($id)
    {
        $id = (int) $id;
        $this->selectedInstrumentId = $id;
        $instrument = Instrument::with(['areas.parameters.criteria'])->find($id);

        if ($instrument && $instrument->areas->isNotEmpty()) {
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

        $this->activeSection = 'systems';
    }

    public function selectArea($areaId)
    {
        $areaId = (int) $areaId;
        $this->activeAreaId = $areaId;
        $area = InstrumentArea::with('parameters')->find($areaId);

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

    // ── Template Actions ─────────────────────────────────────────────

    public function openCreateTemplateModal()
    {
        $this->reset(['templateName', 'templateCode', 'templateLevel', 'templateType', 'templateVersion', 'templateDescription']);
        $this->templateLevel = 'Level III';
        $this->templateType = 'program';
        $this->templateVersion = '2026.1';
        $this->showCreateTemplateModal = true;
    }

    public function closeCreateTemplateModal()
    {
        $this->showCreateTemplateModal = false;
    }

    public function saveTemplate()
    {
        $this->validate([
            'templateName' => 'required|string|min:3|max:150',
            'templateCode' => 'required|string|max:50|unique:instruments,code',
            'templateLevel' => 'required|string',
            'templateVersion' => 'required|string|max:20',
            'templateDescription' => 'nullable|string|max:500',
        ]);

        $instrument = Instrument::create([
            'name' => trim($this->templateName),
            'code' => strtoupper(trim($this->templateCode)),
            'level' => $this->templateLevel,
            'accreditation_type' => $this->templateType,
            'version' => trim($this->templateVersion),
            'is_template' => true,
            'status' => 'active',
            'description' => trim($this->templateDescription),
            'created_by' => Auth::id(),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Created Instrument Master Template: {$instrument->name} ({$instrument->code})",
            'target_type' => 'Instrument',
            'target_id' => $instrument->id,
            'timestamp' => now(),
        ]);

        $this->closeCreateTemplateModal();
        $this->selectInstrument($instrument->id);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Master Template Created!',
            'text' => "Template '{$instrument->name}' is ready for area and parameter definition.",
        ]);
    }

    public function openCloneModal($sourceId)
    {
        $source = Instrument::findOrFail((int) $sourceId);
        $this->sourceTemplateId = $source->id;
        $this->cloneTargetProgramId = $this->selectedProgramId;

        if ($this->cloneTargetProgramId) {
            $prog = Program::find($this->cloneTargetProgramId);
            $this->templateName = "{$source->name} - ".($prog ? $prog->name : 'Program');
            $this->templateCode = ($prog ? "INST-{$prog->code}-" : "{$source->code}-").strtoupper(str_replace(' ', '', $source->level ?? 'LVL')).'-'.now()->year;
        } else {
            $this->templateName = "Copy of {$source->name}";
            $this->templateCode = "{$source->code}-COPY-".rand(10, 99);
        }

        $this->templateLevel = $source->level ?? 'Level III';
        $this->templateType = $source->accreditation_type ?? 'program';
        $this->templateVersion = $source->version ?? '2026.1';
        $this->templateDescription = "Cloned from {$source->name}.";
        $this->showCloneTemplateModal = true;
    }

    public function closeCloneModal()
    {
        $this->showCloneTemplateModal = false;
        $this->sourceTemplateId = null;
        $this->cloneTargetProgramId = null;
    }

    public function cloneTemplate()
    {
        $this->validate([
            'templateName' => 'required|string|min:3|max:150',
            'templateCode' => 'required|string|max:50|unique:instruments,code',
        ]);

        $source = Instrument::with(['areas.parameters.criteria'])->findOrFail($this->sourceTemplateId);
        $targetProgram = $this->cloneTargetProgramId ? Program::find($this->cloneTargetProgramId) : null;

        $newInstrument = DB::transaction(function () use ($source, $targetProgram) {
            $cloned = Instrument::create([
                'name' => trim($this->templateName),
                'code' => strtoupper(trim($this->templateCode)),
                'level' => $this->templateLevel,
                'accreditation_type' => $targetProgram ? 'program' : $this->templateType,
                'program_id' => $targetProgram?->id,
                'version' => trim($this->templateVersion),
                'is_template' => $targetProgram ? false : true,
                'status' => 'active',
                'description' => trim($this->templateDescription),
                'created_by' => Auth::id(),
            ]);

            foreach ($source->areas as $area) {
                $clonedArea = InstrumentArea::create([
                    'instrument_id' => $cloned->id,
                    'name' => $area->name,
                    'code' => $area->code,
                    'order' => $area->order,
                    'weight' => $area->weight,
                    'description' => $area->description,
                ]);

                foreach ($area->parameters as $param) {
                    $clonedParam = InstrumentParameter::create([
                        'instrument_area_id' => $clonedArea->id,
                        'code' => $param->code,
                        'name' => $param->name,
                        'description' => $param->description,
                        'order' => $param->order,
                        'weight' => $param->weight,
                    ]);

                    foreach ($param->criteria as $crit) {
                        InstrumentCriterion::create([
                            'instrument_parameter_id' => $clonedParam->id,
                            'section' => $crit->section,
                            'code' => $crit->code,
                            'statement' => $crit->statement,
                            'description' => $crit->description,
                            'required_tags' => $crit->required_tags,
                            'order' => $crit->order,
                        ]);
                    }
                }
            }

            return $cloned;
        });

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $targetProgram
                ? "Duplicated Instrument from {$source->name} to Program {$targetProgram->name}: {$newInstrument->name}"
                : "Duplicated Master Template from {$source->name} to {$newInstrument->name}",
            'target_type' => 'Instrument',
            'target_id' => $newInstrument->id,
            'timestamp' => now(),
        ]);

        if ($targetProgram) {
            $this->selectedProgramId = $targetProgram->id;
        }

        $this->closeCloneModal();
        $this->selectInstrument($newInstrument->id);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Instrument Duplicated!',
            'text' => $targetProgram
                ? "Instrument duplicated specifically for {$targetProgram->name}."
                : "Template '{$newInstrument->name}' created successfully.",
        ]);
    }

    // ── Area Actions ─────────────────────────────────────────────────

    public function openAreaModal(?int $areaId = null)
    {
        $this->editingAreaId = $areaId;
        if ($areaId) {
            $area = InstrumentArea::findOrFail($areaId);
            $this->areaCode = $area->code;
            $this->areaName = $area->name;
            $this->areaOrder = $area->order;
            $this->areaWeight = $area->weight ? (float) $area->weight : null;
            $this->areaDescription = $area->description ?? '';
        } else {
            $instrument = Instrument::with('areas')->find($this->selectedInstrumentId);
            $nextOrder = $instrument ? ($instrument->areas->count() + 1) : 1;
            $this->areaCode = 'Area '.$this->toRoman($nextOrder);
            $this->areaName = '';
            $this->areaOrder = $nextOrder;
            $this->areaWeight = 10.00;
            $this->areaDescription = '';
        }
        $this->showAreaModal = true;
    }

    public function closeAreaModal()
    {
        $this->showAreaModal = false;
        $this->editingAreaId = null;
    }

    public function saveArea()
    {
        $this->validate([
            'areaCode' => 'required|string|max:30',
            'areaName' => 'required|string|max:255',
            'areaOrder' => 'required|integer|min:1',
            'areaWeight' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($this->editingAreaId) {
            $area = InstrumentArea::findOrFail($this->editingAreaId);
            $area->update([
                'code' => trim($this->areaCode),
                'name' => trim($this->areaName),
                'order' => $this->areaOrder,
                'weight' => $this->areaWeight,
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
            'action' => "Configured Instrument Area: {$area->code} ({$area->name})",
            'target_type' => 'InstrumentArea',
            'target_id' => $area->id,
            'timestamp' => now(),
        ]);

        $this->closeAreaModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Area Saved', 'text' => $msg]);
    }

    // ── Parameter Actions ─────────────────────────────────────────────

    public function openParameterModal(?int $paramId = null)
    {
        $this->editingParameterId = $paramId;
        if ($paramId) {
            $param = InstrumentParameter::findOrFail($paramId);
            $this->parameterCode = $param->code;
            $this->parameterName = $param->name;
            $this->parameterOrder = $param->order;
            $this->parameterDescription = $param->description ?? '';
        } else {
            $area = InstrumentArea::with('parameters')->find($this->activeAreaId);
            $nextLetter = chr(65 + ($area ? $area->parameters->count() : 0));
            $this->parameterCode = "Parameter {$nextLetter}";
            $this->parameterName = '';
            $this->parameterOrder = $area ? ($area->parameters->count() + 1) : 1;
            $this->parameterDescription = '';
        }
        $this->showParameterModal = true;
    }

    public function closeParameterModal()
    {
        $this->showParameterModal = false;
        $this->editingParameterId = null;
    }

    public function saveParameter()
    {
        $this->validate([
            'parameterCode' => 'required|string|max:30',
            'parameterName' => 'required|string|max:255',
            'parameterOrder' => 'required|integer|min:1',
        ]);

        if ($this->editingParameterId) {
            $param = InstrumentParameter::findOrFail($this->editingParameterId);
            $param->update([
                'code' => trim($this->parameterCode),
                'name' => trim($this->parameterName),
                'order' => $this->parameterOrder,
                'description' => trim($this->parameterDescription),
            ]);
            $msg = "Parameter {$param->code} updated.";
        } else {
            $param = InstrumentParameter::create([
                'instrument_area_id' => $this->activeAreaId,
                'code' => trim($this->parameterCode),
                'name' => trim($this->parameterName),
                'order' => $this->parameterOrder,
                'description' => trim($this->parameterDescription),
            ]);
            $this->activeParameterId = $param->id;
            $msg = "New parameter {$param->code} added to area.";
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Configured Instrument Parameter: {$param->code} ({$param->name})",
            'target_type' => 'InstrumentParameter',
            'target_id' => $param->id,
            'timestamp' => now(),
        ]);

        $this->closeParameterModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Parameter Saved', 'text' => $msg]);
    }

    // ── Criterion / Checklist Items Actions ───────────────────────────

    public function openCriterionModal(?int $criterionId = null)
    {
        $this->editingCriterionId = $criterionId;
        $this->newTagInput = '';

        if ($criterionId) {
            $crit = InstrumentCriterion::findOrFail($criterionId);
            $this->criterionCode = $crit->code;
            $this->criterionStatement = $crit->statement;
            $this->criterionDescription = $crit->description ?? '';
            $this->criterionTags = is_array($crit->required_tags) ? $crit->required_tags : [];
            $this->criterionOrder = $crit->order;
        } else {
            $prefix = match ($this->activeSection) {
                'systems' => 'S',
                'implementation' => 'I',
                'outcomes' => 'O',
                'best_practices' => 'BP',
                default => 'C',
            };
            $existingCount = InstrumentCriterion::where('instrument_parameter_id', $this->activeParameterId)
                ->where('section', $this->activeSection)
                ->count();

            $this->criterionCode = "{$prefix}.".($existingCount + 1);
            $this->criterionStatement = '';
            $this->criterionDescription = '';
            $this->criterionTags = [];
            $this->criterionOrder = $existingCount + 1;
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
        if (empty($raw)) {
            return;
        }

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
            $msg = "New criterion {$crit->code} added to section.";
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => "Configured Criterion: {$crit->code} under section {$crit->section}",
            'target_type' => 'InstrumentCriterion',
            'target_id' => $crit->id,
            'timestamp' => now(),
        ]);

        $this->closeCriterionModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Criterion Saved', 'text' => $msg]);
    }

    // ── Delete Confirmation Handler ───────────────────────────────────

    public function confirmDelete(string $type, int $id, string $title)
    {
        $this->deleteType = $type;
        $this->deleteTargetId = $id;
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

        if ($type === 'template') {
            $instrument = Instrument::findOrFail($id);
            $name = $instrument->name;
            $instrument->delete();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => "Deleted Master Instrument Template: {$name}",
                'target_type' => 'Instrument',
                'target_id' => $id,
                'timestamp' => now(),
            ]);

            $next = Instrument::first();
            if ($next) {
                $this->selectInstrument($next->id);
            } else {
                $this->selectedInstrumentId = null;
            }
        } elseif ($type === 'area') {
            $area = InstrumentArea::findOrFail($id);
            $area->delete();
            $this->selectInstrument($this->selectedInstrumentId);
        } elseif ($type === 'parameter') {
            $param = InstrumentParameter::findOrFail($id);
            $param->delete();
            $this->selectArea($this->activeAreaId);
        } elseif ($type === 'criterion') {
            $crit = InstrumentCriterion::findOrFail($id);
            $crit->delete();
        }

        $this->closeDeleteModal();
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Item Deleted', 'text' => 'The selected record was successfully removed.']);
    }

    private function toRoman(int $num): string
    {
        $map = [
            10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I',
        ];
        $result = '';
        foreach ($map as $value => $roman) {
            while ($num >= $value) {
                $result .= $roman;
                $num -= $value;
            }
        }

        return $result ?: 'I';
    }

    public function render()
    {
        $selectedInstrument = $this->selectedInstrumentId
            ? Instrument::with(['areas.parameters.criteria', 'program.college'])->find($this->selectedInstrumentId)
            : null;

        $activeArea = $this->activeAreaId && $selectedInstrument
            ? $selectedInstrument->areas->firstWhere('id', $this->activeAreaId)
            : null;

        $activeParameter = $this->activeParameterId && $activeArea
            ? $activeArea->parameters->firstWhere('id', $this->activeParameterId)
            : null;

        $activeCriteria = $activeParameter
            ? $activeParameter->criteria->where('section', $this->activeSection)->values()
            : collect();

        $selectedAreasCount = $selectedInstrument ? $selectedInstrument->areas->count() : 0;
        $selectedParametersCount = $selectedInstrument ? $selectedInstrument->areas->sum(fn ($a) => $a->parameters->count()) : 0;
        $selectedCriteriaCount = $selectedInstrument ? $selectedInstrument->areas->sum(fn ($a) => $a->parameters->sum(fn ($p) => $p->criteria->count())) : 0;

        $user = Auth::user();
        if ($user && $user->hasRole('college-head') && $user->college_id) {
            $colleges = College::where('id', $user->college_id)
                ->with(['programs' => fn ($q) => $q->orderBy('name')])
                ->get();
        } else {
            $colleges = College::with(['programs' => fn ($q) => $q->orderBy('name')])
                ->orderBy('name')
                ->get();
        }

        $selectedProgram = $this->selectedProgramId ? Program::with('college')->find($this->selectedProgramId) : null;

        return view('livewire.configuration.instruments', [
            'accreditationScope' => $this->accreditationScope,
            'selectedProgramId' => $this->selectedProgramId,
            'selectedProgram' => $selectedProgram,
            'colleges' => $colleges,
            'activeCategory' => $this->activeCategory,
            'selectedInstrument' => $selectedInstrument,
            'activeArea' => $activeArea,
            'activeParameter' => $activeParameter,
            'activeCriteria' => $activeCriteria,
            'selectedAreasCount' => $selectedAreasCount,
            'selectedParametersCount' => $selectedParametersCount,
            'selectedCriteriaCount' => $selectedCriteriaCount,
        ]);
    }
}
