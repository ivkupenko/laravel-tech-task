<?php

namespace App\Services\Logging;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\LogLevel;

class Logger
{
    public function __invoke(string $logText, LogLevel $logLevel = LogLevel::info)
    {
        try {
            return DB::table('logs')->insert([
                'user_id' => auth()->id(),
                'level' => $logLevel->value,
                'log_text' => $logText,
                'logged_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('DB logger failed: ' . $e->getMessage(), ['log' => $logText]);
            return false;
        }
    }
}

