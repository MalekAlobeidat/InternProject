<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Post;
use App\Models\Privacysetting;
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
        $report = Report::where('UserID', $UserID)->where('PostID', $PostID)->get();
    
        if ($report->isNotEmpty()) {
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
