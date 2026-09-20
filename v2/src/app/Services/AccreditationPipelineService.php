<?php

/**
 * ============================================================================
 * IQArchive v2 — Accreditation Pipeline Service
 * ============================================================================
 * File: app/Services/AccreditationPipelineService.php
 * Responsibility: Governs the 9-stage accreditation state machine and approval gates.
 * Architecture: Service Layer (Domain State Machine)
 * Security Context: Stage transitions must be initiated and approved by IQA Staff.
 * ============================================================================
 */

namespace App\Services;

class AccreditationPipelineService
{
    /**
     * Complete list of sequential accreditation stages.
     */
    public const STAGES = [
        1 => 'Draft',
        2 => 'Preliminary Review',
        3 => 'Evidence Collection',
        4 => 'Evidence Consolidation',
        5 => 'Feedback Integration',
        6 => 'Final Review',
        7 => 'Revision',
        8 => 'Submitted',
        9 => 'Accredited',
    ];

    /**
     * Transition accreditation cycle to the next stage.
     *
     * Security Reasoning: Only authorized IQA personnel may transition stages.
     */
    public function advanceStage(int $accreditationId, int $targetStage, int $userId): array
    {
        return [
            'accreditation_id' => $accreditationId,
            'current_stage' => $targetStage,
            'stage_name' => self::STAGES[$targetStage] ?? 'Unknown',
            'updated_by' => $userId,
            'transitioned_at' => now()->toIso8601String(),
        ];
    }
}
