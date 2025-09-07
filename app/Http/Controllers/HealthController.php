<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function index()
    {
        try {
            DB::connection()->getPdo();
            Cache::put('health_check', 'ok', 5);
            $cache = Cache::get('health_check') === 'ok';
            return response()->json([
                'status' => 'ok',
                'db' => true,
                'cache' => $cache,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'degraded',
                'db' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

