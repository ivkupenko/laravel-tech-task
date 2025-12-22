<?php

namespace App\Enums;

    enum LogLevel: string {
        case info = 'info';
        case warning = 'warning';
        case error = 'error';
    }
