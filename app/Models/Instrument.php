<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'program_id',
        'accreditation_id',
        'name',
        'code',
        'level',
        'accreditation_type',
        'version',
        'status',
        'is_template',
        'description',
        'created_by',
    ];

    protected $casts = [
        'is_template' => 'boolean',
    ];

    public function referenceDocument()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function accreditation()
    {
        return $this->belongsTo(Accreditation::class, 'accreditation_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function areas()
    {
        return $this->hasMany(InstrumentArea::class)->orderBy('order', 'asc');
    }

    public function complianceRequirements()
    {
        return $this->hasMany(ComplianceRequirement::class);
    }

    /**
     * Deep clone this Instrument (Areas, Parameters, and Criteria) for a specific Program & Accreditation cycle.
     */
    public function cloneForProgram(Program $program, Accreditation $accreditation, ?User $actor = null): self
    {
        return DB::transaction(function () use ($program, $accreditation, $actor) {
            $clonedInstrument = self::create([
                'name' => "{$this->name} - {$program->name}",
                'code' => "INST-{$program->code}-" . strtoupper(str_replace(' ', '', $this->level ?? 'LVL')) . '-' . now()->year,
                'level' => $this->level ?? $program->accreditation_level,
                'accreditation_type' => $this->accreditation_type ?? 'program',
                'program_id' => $program->id,
                'accreditation_id' => $accreditation->id,
                'is_template' => false,
                'version' => $this->version ?? '2026.1',
                'status' => 'active',
                'description' => "Program-tailored accreditation instrument for {$program->name} ({$program->code}).",
                'created_by' => $actor?->id ?? auth()->id(),
            ]);

            // Deep clone all areas, parameters, criteria
            $this->loadMissing(['areas.parameters.criteria']);

            foreach ($this->areas as $area) {
                $clonedArea = InstrumentArea::create([
                    'instrument_id' => $clonedInstrument->id,
                    'name' => $area->name,
                    'code' => $area->code,
                    'order' => $area->order,
                    'weight' => $area->weight,
                    'description' => $area->description,
                ]);

                foreach ($area->parameters as $parameter) {
                    $clonedParam = InstrumentParameter::create([
                        'instrument_area_id' => $clonedArea->id,
                        'code' => $parameter->code,
                        'name' => $parameter->name,
                        'description' => $parameter->description,
                        'order' => $parameter->order,
                        'weight' => $parameter->weight,
                    ]);

                    foreach ($parameter->criteria as $criterion) {
                        $clonedCriterion = InstrumentCriterion::create([
                            'instrument_parameter_id' => $clonedParam->id,
                            'section' => $criterion->section,
                            'code' => $criterion->code,
                            'statement' => $criterion->statement,
                            'description' => $criterion->description,
                            'required_tags' => $criterion->required_tags,
                            'order' => $criterion->order,
                        ]);

                        // Seed Compliance Requirement linked to this criterion
                        ComplianceRequirement::create([
                            'instrument_id' => $clonedInstrument->id,
                            'program_id' => $program->id,
                            'accreditation_id' => $accreditation->id,
                            'instrument_criterion_id' => $clonedCriterion->id,
                            'description' => $criterion->statement,
                            'due_date' => $accreditation->target_date ? \Carbon\Carbon::parse($accreditation->target_date)->subDays(15) : now()->addMonths(3),
                            'status' => 'pending',
                        ]);
                    }
                }
            }

            return $clonedInstrument;
        });
    }
}
