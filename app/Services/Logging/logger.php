<?php

namespace App\Services\Logging;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Logger
{
    public function __invoke(string $logText)
    {
        try {
            return DB::table('logs')->insert([
                'user_id' => auth()->id(),
                'level' => 'info',
                'log_text' => $logText,
                'logged_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('DB logger failed: ' . $e->getMessage(), ['log' => $logText]);
            return false;
        }
    }
}

