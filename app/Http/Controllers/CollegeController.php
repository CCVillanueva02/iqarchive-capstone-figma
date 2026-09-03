<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:colleges',
        ]);

        $college = College::create($validated);

        return response()->json($college, 201);
    }

    public function update(Request $request, $id)
    {
        $college = College::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:colleges,code,'.$college->id,
        ]);

        $college->update($validated);

        return response()->json($college);
    }

    public function destroy($id)
    {
        $college = College::findOrFail($id);

        // Prevent deletion if it has programs
        if ($college->programs()->exists()) {
            return response()->json(['error' => 'Cannot delete college with existing programs.'], 400);
        }

        $college->delete();

        return response()->json(['success' => true]);
    }
}
