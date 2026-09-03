<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offices = [
            'General Administration' => 'Central administration and general records.',
            'Research Office' => 'Office of the Vice President for Research, Development, and Extension.',
            'University Library' => 'Main and college library records and policies.',
            'Human Resource' => 'HRMO records, faculty and staff files.',
            'Admissions Office' => 'Student admissions and registrar records.',
            'Quality Assurance Office' => 'Internal Quality Assurance records and frameworks.',
        ];

        foreach ($offices as $name => $desc) {
            Office::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
        }
    }
}
