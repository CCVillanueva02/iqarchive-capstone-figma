<?php

/**
 * ============================================================================
 * IQArchive v2 — Common Documents Office Categories Seeder
 * ============================================================================
 * File: database/seeders/CommonDocumentSeeder.php
 * Responsibility: Seeds the 7 Bicol University administrative office categories
 *                 governing the centralized institutional Common Documents vault.
 * Architecture: Database Seeder Layer
 * Security Context: Scope is strictly set to 'institutional'.
 * ============================================================================
 */

namespace Database\Seeders;

use App\Models\DocumentCategory;
use Illuminate\Database\Seeder;

class CommonDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            [
                'name' => 'HRDO',
                'scope' => 'institutional',
                'description' => 'Human Resource Development Office: Plantilla, faculty rankings, appointment guidelines, and personnel welfare policies.',
            ],
            [
                'name' => 'University Registrar',
                'scope' => 'institutional',
                'description' => 'Office of the University Registrar: Academic calendars, admission policies, grading circulars, and graduation statistics.',
            ],
            [
                'name' => 'OSAS',
                'scope' => 'institutional',
                'description' => 'Office of Student Affairs & Services: Student handbooks, organization accreditations, scholarship charters, and grievance guidelines.',
            ],
            [
                'name' => 'VPAA Office',
                'scope' => 'institutional',
                'description' => 'Office of the Vice President for Academic Affairs: Academic Council resolutions, syllabi templates, and instructional guidelines.',
            ],
            [
                'name' => 'BOR Secretariat',
                'scope' => 'institutional',
                'description' => 'Board of Regents Secretariat: University charter, official BOR resolutions, approved policies, and institutional directives.',
            ],
            [
                'name' => 'Budget & Finance',
                'scope' => 'institutional',
                'description' => 'Budget and Financial Management Office: University budget allocations, financial statements, and procurement circulars.',
            ],
            [
                'name' => 'General Services',
                'scope' => 'institutional',
                'description' => 'General Services Office: Campus infrastructure plans, physical plant inventory, safety manuals, and equipment maintenance logs.',
            ],
        ];

        foreach ($offices as $office) {
            DocumentCategory::firstOrCreate(
                ['name' => $office['name'], 'scope' => $office['scope']],
                ['description' => $office['description']]
            );
        }
    }
}
