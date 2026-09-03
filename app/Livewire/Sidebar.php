<?php

/**
 * IQArchive Navigation: Backend Sidebar Component
 *
 * Architectural Role:
 * Livewire component managing persistent navigation state across SPA transitions.
 * Wrapped in Livewire's @persist directive so the sidebar DOM shell remains
 * permanently mounted and never refreshes or loses scroll position when users
 * navigate through workspace, operational, or administrative modules.
 *
 * Security & RBAC:
 * Resolves the authenticated user's normalized role and enforces visibility
 * gates for Task Forces, Instruments, System Admin audit trails, and role dashboards.
 * Section expansion states are persisted directly in the server-side session.
 */

namespace App\Livewire;

use App\Models\Accreditation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    /**
     * Authenticated user role (normalized: iqa-admin/iqa-member -> iqa-staff).
     */
    public string $role = '';

    /**
     * List of currently expanded accordion section keys (e.g. ['documents', 'monitoring']).
     * Persisted in Laravel session to survive hard reloads and navigations.
     *
     * @var array<int, string>
     */
    public array $openSections = [];

    /**
     * Dean-specific active accreditation cycle ID (if role is college-head).
     */
    public ?int $activeDeanAccreditationId = null;

    /**
     * Whether the active cycle requires immediate dean instrument action.
     */
    public bool $deanNeedsInstrumentAction = false;

    /**
     * Mount the component and initialize role and session-backed state.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $rawRole = $user?->role ?? '';

        // Normalize sub-roles to standard iqa-staff
        if (in_array($rawRole, ['iqa-admin', 'iqa-member'], true)) {
            $rawRole = 'iqa-staff';
        }
        $this->role = $rawRole;

        // Resolve Dean active instrument status if college-head
        if ($this->role === 'college-head' && $user?->college_id) {
            $activeAccreditation = Accreditation::whereHas('program', function ($q) use ($user) {
                $q->where('college_id', $user->college_id);
            })
                ->whereIn('status', [
                    'task_force_approved',
                    'instrument_building',
                    'document_preparation',
                    'uploading',
                    'dean_verification',
                ])
                ->latest()
                ->first();

            if ($activeAccreditation) {
                $this->activeDeanAccreditationId = $activeAccreditation->id;
                $this->deanNeedsInstrumentAction = in_array(
                    $activeAccreditation->status,
                    ['task_force_approved', 'instrument_building'],
                    true
                );
            }
        }

        // Initialize open sections from session, or auto-detect from current route
        $savedSections = session('sidebar.open_sections');
        if (is_array($savedSections)) {
            $this->openSections = array_values(array_unique($savedSections));
        } else {
            $defaults = [];
            if (request()->routeIs('documents.*')) {
                $defaults[] = 'documents';
            }
            if (request()->routeIs('monitoring.*')) {
                $defaults[] = 'monitoring';
            }
            $this->openSections = $defaults;
            session(['sidebar.open_sections' => $this->openSections]);
        }
    }

    /**
     * Toggle an accordion section (e.g. 'documents', 'monitoring') and persist to session.
     */
    public function toggleSection(string $section): void
    {
        if (in_array($section, $this->openSections, true)) {
            $this->openSections = array_values(array_diff($this->openSections, [$section]));
        } else {
            $this->openSections[] = $section;
        }

        session(['sidebar.open_sections' => $this->openSections]);
    }

    /**
     * Render the Livewire component view.
     */
    public function render(): View
    {
        return view('livewire.sidebar');
    }
}
