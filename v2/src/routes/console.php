<?php

use App\Models\AuditLog;
use App\Models\College;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('audit:mock {--count=20 : Number of mock audit log entries to generate}', function () {
    $count = (int) $this->option('count');
    $this->info("Generating {$count} mock audit log events...");

    $users = User::withoutGlobalScopes()->where('status', 'active')->get();
    $colleges = College::all();

    $actions = [
        ['action' => 'document.upload.area', 'target' => 'App\Models\Document', 'category' => 'document'],
        ['action' => 'document.dean_approved', 'target' => 'App\Models\Document', 'category' => 'document'],
        ['action' => 'document.iqa_approved', 'target' => 'App\Models\Document', 'category' => 'document'],
        ['action' => 'document.rejected', 'target' => 'App\Models\Document', 'category' => 'document'],
        ['action' => 'document.downloaded', 'target' => 'App\Models\Document', 'category' => 'document'],
        ['action' => 'auth.login', 'target' => 'App\Models\User', 'category' => 'auth'],
        ['action' => 'auth.logout', 'target' => 'App\Models\User', 'category' => 'auth'],
        ['action' => 'auth.domain_rejected', 'target' => 'App\Models\User', 'category' => 'auth'],
        ['action' => 'stage.transitioned', 'target' => 'App\Models\Program', 'category' => 'accreditation'],
        ['action' => 'taskforce.deficit_flagged', 'target' => 'App\Models\Program', 'category' => 'accreditation'],
    ];

    $sampleTitles = [
        'Curriculum Mapping & Syllabi Matrix 2026.pdf',
        'Faculty Development Plan & Retention Policy.pdf',
        'Physical Plant & Laboratory Safety Audit.xlsx',
        'Student Support Services Annual Report.pdf',
        'Institutional Research Grants Portfolio.pdf',
        'Library Holding & E-Resource Subscription Audit.pdf',
    ];

    for ($i = 0; $i < $count; $i++) {
        $event = $actions[array_rand($actions)];
        $user = ($event['action'] === 'auth.domain_rejected') ? null : $users->random();
        $college = ($user && $user->college_id) ? $colleges->firstWhere('id', $user->college_id) : $colleges->random();

        // Randomize timestamp over past 30 days
        $minutesAgo = rand(5, 43200); // Up to 30 days
        $createdAt = Carbon::now()->subMinutes($minutesAgo);

        $details = ['mock_generated' => true];
        if ($event['category'] === 'document') {
            $details['title'] = $sampleTitles[array_rand($sampleTitles)];
            $details['file_hash'] = hash('sha256', uniqid('doc_', true));
            if ($event['action'] === 'document.dean_approved') {
                $details['previous'] = ['status' => 'draft', 'is_endorsed' => false];
                $details['updated'] = ['status' => 'dean_appr', 'is_endorsed' => true];
            } elseif ($event['action'] === 'document.rejected') {
                $details['remarks'] = 'Returned: Incomplete committee signatures.';
                $details['previous'] = ['status' => 'draft'];
                $details['updated'] = ['status' => 'rejected'];
            }
        } elseif ($event['action'] === 'auth.domain_rejected') {
            $details['attempted_email'] = 'guest_' . rand(100, 999) . '@external.com';
            $details['reason'] = 'Unauthorized domain rejection';
        }

        AuditLog::withoutGlobalScopes()->create([
            'college_id' => $user ? $college?->id : null,
            'user_id' => $user?->id,
            'action' => $event['action'],
            'target_type' => $event['target'],
            'target_id' => (string) rand(1, 200),
            'ip_address' => '192.168.' . rand(1, 50) . '.' . rand(2, 250),
            'details' => $details,
            'created_at' => $createdAt,
        ]);
    }

    $this->info("✓ Successfully generated {$count} mock audit log entries.");
})->purpose('Generate realistic mock audit log events for compliance UI testing');
