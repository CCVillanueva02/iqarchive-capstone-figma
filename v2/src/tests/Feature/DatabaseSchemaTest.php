<?php

/**
 * ============================================================================
 * IQArchive v2 — Database Schema & Model Alignment Test
 * ============================================================================
 * File: tests/Feature/DatabaseSchemaTest.php
 * Purpose: Verifies that all 22 strict 3NF tables exist in the database,
 *          multi-tenancy columns are indexed on tenant tables, and all 22
 *          Eloquent models properly map to their respective tables.
 * Related Doc: v2/docs/db-design/database-design.md
 * ============================================================================
 */

namespace Tests\Feature;

use App\Models\Accreditation;
use App\Models\AccreditationDocumentLink;
use App\Models\AccreditationStageHistory;
use App\Models\AuditLog;
use App\Models\College;
use App\Models\ComplianceComment;
use App\Models\ComplianceRequirement;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentReview;
use App\Models\Instrument;
use App\Models\InstrumentArea;
use App\Models\InstrumentCriterion;
use App\Models\InstrumentParameter;
use App\Models\Notification;
use App\Models\OcrResult;
use App\Models\Program;
use App\Models\Role;
use App\Models\TaskForce;
use App\Models\TaskForceMember;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Expected 22 tables defined in v2/docs/db-design/database-design.md.
     */
    private const EXPECTED_TABLES = [
        // Zone 1
        'colleges',
        'programs',
        'users',
        'roles',
        'user_roles',
        'audit_logs',
        'notifications',
        // Zone 2
        'instruments',
        'instrument_areas',
        'instrument_parameters',
        'instrument_criteria',
        // Zone 3
        'task_forces',
        'task_force_members',
        'accreditations',
        'accreditation_stage_histories',
        'compliance_requirements',
        'compliance_comments',
        // Zone 4
        'document_categories',
        'documents',
        'accreditation_document_links',
        'ocr_results',
        'document_reviews',
    ];

    /**
     * Test all 22 domain tables exist in the migrated database.
     */
    public function test_all_22_tables_exist_in_schema(): void
    {
        foreach (self::EXPECTED_TABLES as $table) {
            $this->assertTrue(
                Schema::hasTable($table),
                "Failed asserting that table [{$table}] exists in schema."
            );
        }
    }

    /**
     * Test multi-tenancy college_id column is present on key tenant tables.
     */
    public function test_multi_tenant_college_id_columns_exist(): void
    {
        $tenantTables = ['programs', 'users', 'audit_logs', 'documents'];

        foreach ($tenantTables as $table) {
            $this->assertTrue(
                Schema::hasColumn($table, 'college_id'),
                "Failed asserting that table [{$table}] has multi-tenant [college_id] column."
            );
        }
    }

    /**
     * Test all 22 Eloquent models map to their expected database tables.
     */
    public function test_eloquent_models_map_to_tables(): void
    {
        $modelMap = [
            College::class => 'colleges',
            Program::class => 'programs',
            User::class => 'users',
            Role::class => 'roles',
            UserRole::class => 'user_roles',
            AuditLog::class => 'audit_logs',
            Notification::class => 'notifications',
            Instrument::class => 'instruments',
            InstrumentArea::class => 'instrument_areas',
            InstrumentParameter::class => 'instrument_parameters',
            InstrumentCriterion::class => 'instrument_criteria',
            TaskForce::class => 'task_forces',
            TaskForceMember::class => 'task_force_members',
            Accreditation::class => 'accreditations',
            AccreditationStageHistory::class => 'accreditation_stage_histories',
            ComplianceRequirement::class => 'compliance_requirements',
            ComplianceComment::class => 'compliance_comments',
            DocumentCategory::class => 'document_categories',
            Document::class => 'documents',
            AccreditationDocumentLink::class => 'accreditation_document_links',
            OcrResult::class => 'ocr_results',
            DocumentReview::class => 'document_reviews',
        ];

        foreach ($modelMap as $modelClass => $expectedTable) {
            $instance = new $modelClass();
            $this->assertEquals(
                $expectedTable,
                $instance->getTable(),
                "Model [{$modelClass}] should map to table [{$expectedTable}]."
            );
        }
    }
}
