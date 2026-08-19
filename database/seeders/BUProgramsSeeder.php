<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BUProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('List-of-Programs.txt');
        if (!file_exists($filePath)) {
            $this->command->error('List-of-Programs.txt not found.');
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $currentCollege = null;

        // Function to extract a code (acronym) from a name
        $generateCode = function($name) {
            $words = explode(' ', str_replace(['-', ',', '&', 'and'], '', $name));
            $code = '';
            foreach ($words as $w) {
                if (!empty($w) && ctype_upper($w[0]) && strlen($w) > 2) {
                    $code .= strtoupper($w[0]);
                }
            }
            if (empty($code)) {
                $code = strtoupper(substr($name, 0, 4));
            }
            // For programs, let's keep it simple, they are long.
            return $code;
        };

        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip empty lines or just campuses (if all caps and no dash)
            if (empty($line)) continue;

            // If it's a campus like "LEGAZPI EAST CAMPUS", skip it completely
            if (strtoupper($line) === $line && !str_starts_with($line, '-')) {
                if (str_contains($line, 'CAMPUS')) {
                    continue;
                }
                
                $collegeName = $line;
                $baseCode = $generateCode($collegeName);
                $code = $baseCode;
                $counter = 1;
                while (\App\Models\College::where('code', $code)->exists()) {
                    if (\App\Models\College::where('name', $collegeName)->exists()) {
                        break;
                    }
                    $code = $baseCode . '-' . $counter;
                    $counter++;
                }
                $currentCollege = \App\Models\College::firstOrCreate(
                    ['name' => $collegeName],
                    ['code' => $code]
                );
                continue;
            }

            // If it starts with '-', it's a program
            if (str_starts_with($line, '-')) {
                $programName = trim(substr($line, 1));
                if ($currentCollege) {
                    $baseCode = $generateCode($programName);
                    $code = $baseCode;
                    $counter = 1;
                    while (\App\Models\Program::where('code', $code)->exists()) {
                        // If a program with this code already exists (even if it's the exact same name, maybe in another college)
                        // wait, firstOrCreate will not throw if it's the SAME name and SAME college.
                        if (\App\Models\Program::where('name', $programName)->where('college_id', $currentCollege->id)->exists()) {
                            break;
                        }
                        $code = $baseCode . '-' . $counter;
                        $counter++;
                    }
                    \App\Models\Program::firstOrCreate(
                        ['name' => $programName, 'college_id' => $currentCollege->id],
                        ['code' => $code, 'accreditation_level' => 'Candidate'] // Default level
                    );
                }
            } else {
                // Otherwise it's a College
                $collegeName = $line;
                $baseCode = $generateCode($collegeName);
                $code = $baseCode;
                $counter = 1;
                while (\App\Models\College::where('code', $code)->exists()) {
                    if (\App\Models\College::where('name', $collegeName)->exists()) {
                        break;
                    }
                    $code = $baseCode . '-' . $counter;
                    $counter++;
                }
                $currentCollege = \App\Models\College::firstOrCreate(
                    ['name' => $collegeName],
                    ['code' => $code]
                );
            }
        }
    }
}
