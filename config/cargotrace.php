<?php

return [
    // Threshold keterlambatan (dalam jam) — sesuaikan dengan skenario kelompok Anda
    'delay_threshold_hours' => env('CARGOTRACE_DELAY_THRESHOLD', 12),

    // Aturan severity berdasarkan durasi keterlambatan (jam)
    'delay_severity_rules' => [
        'low_max' => 6,     // 0 - 6 jam: LOW
        'medium_max' => 24, // >6 - 24 jam: MEDIUM, >24 jam: HIGH
    ],

    // Daftar status yang valid dan alur transisi yang diperbolehkan
    'status_transitions' => [
        'CREATED' => ['BOOKED', 'CANCELLED'],
        'BOOKED' => ['PICKED_UP', 'CANCELLED'],
        'PICKED_UP' => ['IN_TRANSIT'],
        'IN_TRANSIT' => ['DELIVERED'],
        'DELIVERED' => [], // Status terminal: tidak bisa berubah sembarangan
        'CANCELLED' => [], // Status terminal
    ],

    // Jenis exception yang diizinkan
    'exception_types' => [
        'CUSTOMS_HOLD',
        'WEATHER_DELAY',
        'PORT_CONGESTION',
        'DAMAGED',
        'MISROUTED',
        'DOCUMENTATION_ISSUE',
    ],
];