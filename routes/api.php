<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users', function () {

    $start = strtotime(date('M Y', strtotime('-1 Year')));
    $end = strtotime(date('M Y'));
    $current = $start;
    $months = [];
    $months[date('M Y', $start)] = 0;
    while ($current < $end) {
        $next = date('Y-M-01', $current) . '+1 month';
        $current = strtotime($next);
        $months[date('M Y', $current)] = 0;
    }
    dd($months);


    $users = User::query()->orderBy('created_at')->get()->groupBy(function ($val) {
        return Carbon::parse($val->created_at)->format('M Y');
    })
        ->map(function ($eachMonth) {
            return $eachMonth->count();
        })
        ->toArray();

    return response()->json([
        'users' => $users
    ]);
});
