<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\College;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of all programs.
     */
    public function index()
    {
        $programs = Program::with('college')->orderBy('name')->get()->map(function ($p) {
            $collegeCode = $p->college ? $p->college->code : 'BU';
            $iconBg = match ($collegeCode) {
                'CS' => 'bg-blue-50 text-[#1b355a]',
                'CENG' => 'bg-amber-50 text-amber-700',
                'CAL' => 'bg-rose-50 text-rose-700',
                'CED' => 'bg-purple-50 text-purple-700',
                'CN' => 'bg-teal-50 text-teal-700',
                'CBEM' => 'bg-emerald-50 text-emerald-700',
                default => 'bg-slate-100 text-slate-700',
            };

            return [
                'id' => $p->id,
                'code' => $p->code,
                'name' => $p->name,
                'college' => $p->college ? $p->college->name : 'BU College',
                'collegeCode' => $collegeCode,
                'college_id' => $p->college_id,
                'level' => $p->accreditation_level ?: 'Candidate Status',
                'iconBg' => $iconBg,
            ];
        });

        return response()->json($programs);
    }

    /**
     * Store a newly created program.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // Allow IQA Admin and System Administrator
        $isAllowed = $user->hasRole('iqa-admin') || 
                     $user->hasRole('system-administrator') || 
                     in_array($user->role, ['iqa-admin', 'system-administrator']);

        if (!$isAllowed) {
            return response()->json(['error' => 'Unauthorized. Only IQA Admin and System Administrator can create programs.'], 403);
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
        $colleges = College::orderBy('name')->get(['id', 'name', 'code']);
        return response()->json($colleges);
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
