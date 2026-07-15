<?php

return [
    'temporary_file_upload' => [
        'disk' => strtolower((string) env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK', 'public')),
        'rules' => ['required', 'file', 'max:40960'],
        'directory' => 'livewire-tmp',
        'middleware' => 'throttle:60,1',
        'preview_mimes' => [
            'png',
            'gif',
            'bmp',
            'svg',
            'wav',
            'mp4',
            'mov',
            'avi',
            'wmv',
            'mp3',
            'm4a',
            'jpg',
            'jpeg',
            'mpga',
            'webp',
            'wma',
            'avif',
        ],
        'max_upload_time' => 15,
        'cleanup' => true,
    ],
];
