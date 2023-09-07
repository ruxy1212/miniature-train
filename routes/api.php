<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Date;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/task1', function (Request $request) {
    if($request->query('slack_name') && $request->query('track')){
        $slackName = $request->query('slack_name');
        $trackName = $request->query('track');
        $currentDay = Date::now()->format('l');
        $uctTime = Date::now()->utc();
        $githubFileUrl = "mnm";
        $githubRepoUrl = "mnm";
        $response = [
            'slack_name' => $slackName,
            'current_day' => $currentDay,
            'utc_time' => $uctTime,
            'track' => $trackName,
            'github_file_url' => $githubFileUrl,
            'github_repo_url' => $githubRepoUrl,
            'status_code' => 200
        ];
        return response()->json($response);
    }else{
        return response()->json(['status_code' => 400, 'message' => 'Request parameter incomplete']);
    }
});

