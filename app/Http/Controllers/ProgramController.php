<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\College;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    /**
     * Display a listing of all programs.
     * Scoped by role: IQA staff and SysAdmin see all programs; College heads and Task Force members see only their assigned units.
     */
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();
        $query = Program::with(['college', 'accreditations' => function ($q) {
            $q->latest();
        }, 'accreditations.instrument'])->orderBy('name');

        if ($user) {
            $isUnrestricted = $user->hasAnyRole(['iqa-staff', 'iqa-admin', 'system-administrator']) || 
                              in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']);

            if (!$isUnrestricted) {
                // College Head: all programs under their assigned college
                if ($user->hasRole('college-head') || $user->role === 'college-head') {
                    $collegeId = $user->college_id;
                    $query->where('college_id', $collegeId);
                }
                // Task Force Member: only their specific assigned program(s)
                elseif ($user->hasRole('task-force-member') || $user->role === 'task-force-member') {
                    $programIds = array_filter([$user->program_id]);
                    $tfProgramIds = $user->taskForces()->whereNotNull('program_id')->pluck('program_id')->toArray();
                    $allProgramIds = array_unique(array_merge($programIds, $tfProgramIds));
                    if (!empty($allProgramIds)) {
                        $query->whereIn('id', $allProgramIds);
                    } elseif ($user->college_id) {
                        $query->where('college_id', $user->college_id);
                    } else {
                        $query->where('id', 0);
                    }
                }
                // Accreditor: specific program or college
                elseif ($user->hasRole('accreditor') || $user->role === 'accreditor') {
                    if ($user->program_id) {
                        $query->where('id', $user->program_id);
                    } elseif ($user->college_id) {
                        $query->where('college_id', $user->college_id);
                    }
                }
            }
        }

        $programs = $query->get()->map(function ($p) {
            $collegeCode = $p->college ? $p->college->code : 'BU';
            $iconBg = match ($collegeCode) {
                'CS' => 'bg-blue-50 text-[#1b355a]',
                'CENG' => 'bg-amber-50 text-amber-700',
                'CAL' => 'bg-rose-50 text-rose-700',
                'CED' => 'bg-purple-50 text-purple-700',
                'CN' => 'bg-teal-50 text-teal-700',
                'CBEM' => 'bg-emerald-50 text-emerald-700',
                'CSSP' => 'bg-indigo-50 text-indigo-700',
                'IDA' => 'bg-[#002b61]/10 text-[#002b61]',
                'CIT' => 'bg-orange-50 text-orange-700',
                'IPESR' => 'bg-cyan-50 text-cyan-700',
                'JMRIGD' => 'bg-yellow-50 text-yellow-800',
                'CM' => 'bg-red-50 text-red-700',
                'CDM' => 'bg-sky-50 text-sky-700',
                'BUG' => 'bg-lime-50 text-lime-800',
                'BUP' => 'bg-violet-50 text-violet-700',
                'BUTC' => 'bg-fuchsia-50 text-fuchsia-700',
                'BUGC' => 'bg-emerald-50 text-emerald-800',
                default => 'bg-slate-100 text-slate-700',
            };

            // Security & Governance Check: Instrument is verified once College Head finalizes it (status moves to document_preparation or beyond)
            $latestAccred = $p->accreditations->first();
            $accredStatus = $latestAccred?->status ?? 'no_active_accreditation';
            $isInstrumentVerified = $latestAccred && in_array($latestAccred->status, [
                'document_preparation',
                'uploading',
                'dean_verification',
                'submitted',
                'completed',
            ]);

            return [
                'id' => $p->id,
                'code' => $p->code,
                'name' => $p->name,
                'college' => $p->college ? $p->college->name : 'BU College',
                'collegeCode' => $collegeCode,
                'college_id' => $p->college_id,
                'level' => $p->accreditation_level ?: 'Candidate Status',
                'iconBg' => $iconBg,
                'accreditation_id' => $latestAccred?->id,
                'accreditation_status' => $accredStatus,
                'instrument_verified' => $isInstrumentVerified,
            ];
        });

        return response()->json($programs);
    }

    /**
     * Store a newly created program.
     */
    public function store(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // Allow IQA Staff and System Administrator
        $isAllowed = $user->hasRole(['iqa-staff', 'iqa-admin', 'system-administrator']) || 
                     in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']);

        if (!$isAllowed) {
            return response()->json(['error' => 'Unauthorized. Only IQA Staff and System Administrator can create programs.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code',
            'college_id' => 'required|exists:colleges,id',
            'accreditation_level' => 'required|string|max:255',
        ]);

        $program = Program::create($validated);
        $program->load('college');

        $collegeCode = $program->college ? $program->college->code : 'BU';
        $iconBg = match ($collegeCode) {
            'CS' => 'bg-blue-50 text-[#1b355a]',
            'CENG' => 'bg-amber-50 text-amber-700',
            'CAL' => 'bg-rose-50 text-rose-700',
            'CED' => 'bg-purple-50 text-purple-700',
            'CN' => 'bg-teal-50 text-teal-700',
            'CBEM' => 'bg-emerald-50 text-emerald-700',
            default => 'bg-slate-100 text-slate-700',
        };

        return response()->json([
            'message' => 'Academic program created successfully.',
            'program' => [
                'id' => $program->id,
                'code' => $program->code,
                'name' => $program->name,
                'college' => $program->college ? $program->college->name : 'BU College',
                'collegeCode' => $collegeCode,
                'college_id' => $program->college_id,
                'level' => $program->accreditation_level ?: 'Candidate Status',
                'iconBg' => $iconBg,
            ]
        ], 201);
    }

    public function getColleges()
    {
        /** @var User|null $user */
        $user = Auth::user();
        $query = College::withCount('programs')->orderBy('campus', 'asc')->orderBy('name', 'asc');

        if ($user) {
            $isUnrestricted = $user->hasAnyRole(['iqa-staff', 'iqa-admin', 'system-administrator']) || 
                              in_array($user->role, ['iqa-staff', 'iqa-admin', 'system-administrator']);

            if (!$isUnrestricted) {
                // College Head: only their assigned college
                if ($user->hasRole('college-head') || $user->role === 'college-head') {
                    $collegeId = $user->college_id;
                    $query->where('id', $collegeId);
                }
                // Task Force Member: only their assigned college
                elseif ($user->hasRole('task-force-member') || $user->role === 'task-force-member') {
                    $collegeIds = array_filter([$user->college_id]);
                    $tfCollegeIds = $user->taskForces()->whereNotNull('college_id')->pluck('college_id')->toArray();
                    $allCollegeIds = array_unique(array_merge($collegeIds, $tfCollegeIds));
                    if (!empty($allCollegeIds)) {
                        $query->whereIn('id', $allCollegeIds);
                    } else {
                        $query->where('id', 0);
                    }
                }
                // Accreditor: assigned college
                elseif ($user->hasRole('accreditor') || $user->role === 'accreditor') {
                    if ($user->college_id) {
                        $query->where('id', $user->college_id);
                    }
                }
            }
        }

        $colleges = $query->get();

        $data = $colleges->map(function ($c) {
            $code = $c->code;
            $iconBg = match ($code) {
                'CS' => 'bg-blue-50 text-[#1b355a]',
                'CENG' => 'bg-amber-50 text-amber-700',
                'CAL' => 'bg-rose-50 text-rose-700',
                'CED' => 'bg-purple-50 text-purple-700',
                'CN' => 'bg-teal-50 text-teal-700',
                'CBEM' => 'bg-emerald-50 text-emerald-700',
                'CSSP' => 'bg-indigo-50 text-indigo-700',
                'IDA' => 'bg-[#002b61]/10 text-[#002b61]',
                'CIT' => 'bg-orange-50 text-orange-700',
                'IPESR' => 'bg-cyan-50 text-cyan-700',
                'JMRIGD' => 'bg-yellow-50 text-yellow-800',
                'CM' => 'bg-red-50 text-red-700',
                'CDM' => 'bg-sky-50 text-sky-700',
                'BUG' => 'bg-lime-50 text-lime-800',
                'BUP' => 'bg-violet-50 text-violet-700',
                'BUTC' => 'bg-fuchsia-50 text-fuchsia-700',
                'BUGC' => 'bg-emerald-50 text-emerald-800',
                default => 'bg-slate-100 text-slate-700',
            };

            return [
                'id' => $c->id,
                'name' => $c->name,
                'code' => $c->code,
                'campus' => $c->campus ?: 'BU Campus',
                'description' => $c->campus ?: 'BU Academic Unit',
                'iconBg' => $iconBg,
                'programCount' => $c->programs_count,
            ];
        });

        return response()->json($data);
    }

    /**
     * Update an existing program.
     */
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code,' . $program->id,
            'college_id' => 'required|exists:colleges,id',
            'accreditation_level' => 'required|string|max:255',
        ]);

        $program->update($validated);
        $program->load('college');

        return response()->json($program);
    }

    /**
     * Delete a program.
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        
        if ($program->documents()->exists()) {
            return response()->json(['error' => 'Cannot delete program with existing documents.'], 400);
        }

        $program->delete();
        return response()->json(['success' => true]);
    }
}
