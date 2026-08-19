<?php

namespace Database\Seeders;

use App\Models\ComplianceRequirement;
use App\Models\Instrument;
use App\Models\Program;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allPrograms = Program::all();
        $progIndex = 0;

        $seedAccreditation = function ($levelName, $count) use (&$progIndex, $allPrograms) {
            for ($i = 1; $i <= $count; $i++) {
                if ($progIndex >= $allPrograms->count()) break;

                $program = $allPrograms[$progIndex++];

                $inst = Instrument::create([
                    'name' => "AACCUP {$levelName} Criteria for {$program->name}",
                    'code' => "INST-{$program->code}-" . strtoupper(str_replace(' ', '', $levelName)),
                    'level' => $levelName,
                    'description' => "Accreditation guidelines and evaluation areas for {$program->name} level {$levelName}.",
                ]);

                $status = 'complied';
                if ($progIndex % 6 === 0) {
                    $status = 'in_progress';
                } elseif ($progIndex % 15 === 0) {
                    $status = 'overdue';
                } elseif ($progIndex % 20 === 0) {
                    $status = 'pending';
                }

                ComplianceRequirement::create([
                    'instrument_id' => $inst->id,
                    'program_id' => $program->id,
                    'description' => "Complete documentation file compilations for {$levelName} accreditation.",
                    'due_date' => now()->addDays(rand(-30, 90)),
                    'status' => $status,
                ]);
            }
        };

        $seedAccreditation('Level IV', 11);
        $seedAccreditation('Level III', 32);
        $seedAccreditation('Level II', 35);
        $seedAccreditation('Level I', 38);
        $seedAccreditation('Candidate', 4);
    }
}
