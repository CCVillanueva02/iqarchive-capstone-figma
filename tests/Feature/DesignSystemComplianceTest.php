<?php

use Symfony\Component\Finder\Finder;

/*
|--------------------------------------------------------------------------
| Design Token Compliance Test
|--------------------------------------------------------------------------
| Scans all Blade views for raw Tailwind classes that bypass the IQArchive
| design tokens defined in resources/css/app.css. Fails the test suite if
| a new non-compliant class slips in via a future PR.
|
| Update EXEMPTIONS below only for deliberate, reviewed exceptions
| (decorative one-offs, status/info callouts) — see the "Exemptions" rule
| in resources/css/token-mapping.md before adding a new entry here.
*/

// Note: slate is deferred to a separate system-wide migration pass
const FORBIDDEN_COLOR_PREFIXES = ['gray', 'neutral', 'blue', 'orange'];
const FORBIDDEN_UTILITY_PREFIXES = [
    'bg', 'text', 'border', 'ring', 'from', 'via', 'to',
    'divide', 'outline', 'decoration', 'placeholder', 'caret',
];

// relative path (from project root) => [line numbers] deliberately exempt
const EXEMPTIONS = [
    'resources/views/pages/documents/partials/institutional-accreditation/self-survey-matrix.blade.php' => [141],
    'resources/views/pages/documents/partials/program-accreditation/self-survey-matrix.blade.php' => [141],
    'resources/views/livewire/task-force/partials/dashboard/modals/submit-to-dean-modal.blade.php' => [18, 19, 20],
    'resources/views/livewire/task-force/partials/stats-row.blade.php' => [12],
    'resources/views/pages/roles/university-administrator/analytics.blade.php' => [213],
    'resources/views/pages/settings/⚡profile.blade.php' => [208],
    'resources/views/welcome.blade.php' => [59],
];

function stripNonScannableBlocks(string $content): string
{
    // JS color strings (Chart.js) and SVG fill attributes (OAuth logos,
    // filetype icons) aren't Tailwind classes — strip before scanning so
    // they're never mistaken for class-based violations, while preserving line numbers.
    $content = preg_replace_callback('/<script\b[^>]*>.*?<\/script>/is', fn($m) => str_repeat("\n", substr_count($m[0], "\n")), $content);
    $content = preg_replace_callback('/<svg\b[^>]*>.*?<\/svg>/is', fn($m) => str_repeat("\n", substr_count($m[0], "\n")), $content);

    return $content;
}

function findDesignTokenViolations(string $filePath, string $relativePath): array
{
    $violations = [];
    $lines = explode("\n", stripNonScannableBlocks(file_get_contents($filePath)));
    $exemptLines = EXEMPTIONS[$relativePath] ?? [];

    $utilities = implode('|', FORBIDDEN_UTILITY_PREFIXES);
    $colors = implode('|', FORBIDDEN_COLOR_PREFIXES);

    $colorPattern = '/\b(' . $utilities . ')-(' . $colors . ')-\d{2,3}\b/';
    $hexPattern = '/\b(' . $utilities . ')-\[#[0-9a-fA-F]{3,6}\]/';
    $fontSizePattern = '/text-\[\d+px\]/';

    foreach ($lines as $i => $line) {
        $lineNumber = $i + 1;

        if (in_array($lineNumber, $exemptLines, true)) {
            continue;
        }

        if (preg_match($colorPattern, $line, $m)
            || preg_match($hexPattern, $line, $m)
            || preg_match($fontSizePattern, $line, $m)) {
            $violations[] = "{$relativePath}:{$lineNumber} — {$m[0]}";
        }
    }

    return $violations;
}

it('has no untokenized Tailwind classes in Blade views', function () {
    $viewsPath = resource_path('views');
    $finder = (new Finder())->files()->in($viewsPath)->name('*.blade.php');

    $allViolations = [];

    foreach ($finder as $file) {
        $relativePath = 'resources/views/' . str_replace('\\', '/', $file->getRelativePathname());
        $allViolations = array_merge(
            $allViolations,
            findDesignTokenViolations($file->getRealPath(), $relativePath)
        );
    }

    expect($allViolations)->toBe(
        [],
        "Design token violations found (see resources/css/token-mapping.md):\n" . implode("\n", $allViolations)
    );
});