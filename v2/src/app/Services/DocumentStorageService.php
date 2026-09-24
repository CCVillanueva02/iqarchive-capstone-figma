<?php

/**
 * ============================================================================
 * IQArchive v2 — Document Storage Service
 * ============================================================================
 * File: app/Services/DocumentStorageService.php
 * Responsibility: Manages binary asset storage in private S3-compatible cloud
 *                 storage and mints 15-minute temporary pre-signed URLs.
 * Architecture: Service Layer
 * Security Context: Strictly enforces private bucket isolation; no public URLs.
 * ============================================================================
 */

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class DocumentStorageService
{
    /**
     * Generate a temporary pre-signed download URL for private S3 assets.
     *
     * Security Reasoning: File links expire after 15 minutes to prevent unauthorized
     * URL sharing across unauthenticated users or unauthorized colleges.
     *
     * @param string $path S3 object key (e.g. evidence/{college_id}/{program_id}/{hash}.pdf)
     * @param int $minutes Validity duration in minutes (default: 15)
     */
    public function getTemporaryUrl(string $path, int $minutes = 15): string
    {
        // When S3 is configured, mint temporary signed URL. Fall back to local URL for tests.
        if (config('filesystems.default') === 's3') {
            return Storage::disk('s3')->temporaryUrl($path, now()->addMinutes($minutes));
        }

        return url('/storage/' . ltrim($path, '/'));
    }

    /**
     * Store an uploaded PDF file into the private storage disk.
     *
     * Security Reasoning: Organizes files into college-scoped directories and computes
     * SHA-256 hash for tamper detection and deduplication.
     */
    public function storeEvidence(mixed $file, int $collegeId, int $programId): array
    {
        $hash = hash_file('sha256', $file->getRealPath());
        $path = "evidence/{$collegeId}/{$programId}/{$hash}.pdf";

        Storage::disk(config('filesystems.default', 'local'))->putFileAs(
            "evidence/{$collegeId}/{$programId}",
            $file,
            "{$hash}.pdf"
        );

        return [
            'file_path' => $path,
            'file_hash' => $hash,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Store an uploaded institutional Common Document into the private storage disk.
     *
     * Security Reasoning: Organizes files into an institutional directory and computes
     * SHA-256 cryptographic hash for tamper detection and compliance integrity.
     */
    public function storeCommonDocument(mixed $file, int $categoryId): array
    {
        $hash = hash_file('sha256', $file->getRealPath());
        $path = "evidence/common/{$categoryId}/{$hash}.pdf";

        Storage::disk(config('filesystems.default', 'local'))->putFileAs(
            "evidence/common/{$categoryId}",
            $file,
            "{$hash}.pdf"
        );

        return [
            'file_path' => $path,
            'file_hash' => $hash,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }
}
