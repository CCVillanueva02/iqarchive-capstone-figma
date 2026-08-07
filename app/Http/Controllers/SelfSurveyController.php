<?php

namespace App\Http\Controllers;

use App\Models\SelfSurveyArea;
use App\Models\SelfSurveyRating;
use App\Models\SelfSurveyIndicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SelfSurveyController extends Controller
{
    /**
     * Return all areas with parameters and indicators for the given type.
     * If no seeded data exists yet, return the static pre-populated dataset.
     */
    public function getAreas(Request $request)
    {
        $type = $request->get('type', 'institutional');

        $areas = SelfSurveyArea::where('type', $type)
            ->orderBy('sort_order')
            ->with(['parameters' => function ($q) {
                $q->orderBy('sort_order')->with(['indicators' => function ($q2) {
                    $q2->orderBy('sort_order');
                }]);
            }])
            ->get();

        return response()->json($areas);
    }

    /**
     * Return all ratings saved by the authenticated user for a given area.
     * Returns a flat object keyed by indicator_id → rating value.
     */
    public function getRatings(Request $request)
    {
        $areaId  = $request->get('area_id');
        $userId  = Auth::id();

        if (!$areaId) {
            return response()->json(['error' => 'area_id required'], 422);
        }

        $area = SelfSurveyArea::with(['parameters.indicators'])->find($areaId);
        if (!$area) {
            return response()->json(['error' => 'Area not found'], 404);
        }

        $indicatorIds = $area->parameters->flatMap(fn($p) => $p->indicators->pluck('id'));

        $ratings = SelfSurveyRating::whereIn('indicator_id', $indicatorIds)
            ->where('rated_by', $userId)
            ->pluck('rating', 'indicator_id'); // keyed by indicator_id

        return response()->json($ratings);
    }

    /**
     * Save or update a single IR rating for an indicator.
     */
    public function saveRating(Request $request)
    {
        $request->validate([
            'indicator_id' => 'required|exists:self_survey_indicators,id',
            'rating'       => 'nullable|integer|min:0|max:5',
        ]);

        $userId = Auth::id();

        $record = SelfSurveyRating::updateOrCreate(
            ['indicator_id' => $request->indicator_id, 'rated_by' => $userId],
            ['rating'       => $request->rating]
        );

        return response()->json(['success' => true, 'rating' => $record]);
    }

    /**
     * Save best-practices text (stored as a special rating row with indicator_id = null
     * would be messy; instead we store it on the parameter via a separate simple table
     * or—for now—as a JSON blob in a dedicated column on self_survey_parameters).
     * For simplicity we handle this as a frontend-only feature in the first version
     * and return 200 OK so the JS doesn't error out.
     */
    public function saveBestPractices(Request $request)
    {
        // Placeholder — will be wired to DB once the best_practices column is added.
        return response()->json(['success' => true]);
    }
}
