<?php

return [
    /*
    |--------------------------------------------------------------------------
    | System Prefixes
    |--------------------------------------------------------------------------
    |
    | This file contains all the prefixes used throughout the system
    | for generating unique codes for various entities.
    |
    */

    'company' => env('PREFIX_COMPANY', 'COMP'),
    'department' => env('PREFIX_DEPARTMENT', 'DEPT'),
    'position' => env('PREFIX_POSITION', 'POS'),
    'employee' => env('PREFIX_EMPLOYEE', 'EMP'),
    'shift' => env('PREFIX_SHIFT', 'SHIFT'),
    'attendance' => env('PREFIX_ATTENDANCE', 'ATT'),
];
