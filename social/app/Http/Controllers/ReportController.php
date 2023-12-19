<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Privacysetting;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function makeReport($UserID, $PostID)
    {
    // Check if there is a report for the same user, post, and date
    $existingReport = Report::where('UserID', $UserID)
                            ->where('PostID', $PostID)
                            ->whereDate('created_at', Carbon::today())
                            ->first();           
        if ($existingReport !== null && $existingReport->count() > 0) {
            return response()->json(['message' => 'already reported'], 201);
        }
        $report = new Report();
        $report->UserID = $UserID;
        $report->PostID = $PostID;
        $report->save();

        $response = 'Your report has been submitted. A moderator will review to see if this post follows community guidelines.';

        return response()->json($response);
    }




}
