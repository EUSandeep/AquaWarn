<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin']);

Route::get('/admin/users', function () {
    return view('admin.users', ['users' => \App\Models\User::all()]);
})->middleware(['auth', 'admin']);

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'user']);

Route::get('/nodes', function() {
    return view('nodes', ['nodes' => \App\Models\TelemetryNode::all()]);
})->middleware(['auth', 'user']);

Route::get('/nodes/{id}', function($id) {
    $node = \App\Models\TelemetryNode::findOrFail($id);
    return view('node_details', [
        'node' => $node,
        // Performance optimization: use indexed recorded_at for faster ordering
        'latest' => $node->telemetryData()->latest('recorded_at')->first(),
        'historical' => $node->telemetryData()->latest('recorded_at')->take(24)->get()->reverse(),
        'forecast' => $node->forecasts()->orderBy('forecasted_for')->get()
    ]);
})->middleware(['auth', 'user']);

Route::get('/alerts', function() {
    return view('alerts', [
        // Performance optimization: use indexed triggered_at for faster ordering
        'alerts' => \App\Models\Alert::with('telemetryNode')->latest('triggered_at')->get()
    ]);
})->middleware(['auth', 'user']);
