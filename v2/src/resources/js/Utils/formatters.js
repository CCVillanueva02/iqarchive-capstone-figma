/**
 * Shared formatting utilities for IQArchive frontend views.
 * Author: Carl Justine Tuazon
 */

/**
 * Format date to standard institutional format (e.g., "Sep 22, 2026").
 */
export function formatDate(dateString) {
    if (!dateString) return '—';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    }).format(date);
}

/**
 * Format file size in bytes to human-readable string (KB, MB).
 */
export function formatBytes(bytes, decimals = 1) {
    if (!bytes || bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(decimals)) + ' ' + sizes[i];
}

/**
 * Return semantic DaisyUI badge class based on AACCUP numerical score (1.00 - 5.00).
 */
export function getScoreBadgeVariant(score) {
    const num = parseFloat(score);
    if (isNaN(num)) return 'badge-ghost';
    if (num >= 4.5) return 'badge-success';
    if (num >= 3.5) return 'badge-info';
    if (num >= 2.5) return 'badge-warning';
    return 'badge-error';
}
