<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function reports(){
    $reports = Report::all();

    if ($reports->isEmpty()) {
        return response()->json('There are no reports made at the moment');
    } else {
        $groupedReports = $reports->groupBy('PostID');

        $reportData = [];

        foreach ($groupedReports as $postID => $group) {
            $post = Post::find($postID);

            if ($post) {
                $reportData[] = [
                    'post' => $post,
                    'reports' => $group,
                ];
            }
        }

        return response()->json($reportData);
    }
}

    public function acceptReport($PostID)
    {
    // Report::where('PostID', $PostID)->delete();

    Post::where('PostID', $PostID)->delete();
    return response()->json('Post removed, and associated reports deleted successfully');
    }
    public function deleteReport($PostID){
        Report::where('PostID', $PostID)->delete();
        return response()->json('Report deleted successfully');
    }
}
