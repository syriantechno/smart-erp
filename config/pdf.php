<?php

return [
    'format' => 'A4-L',
    'mode' => 'utf-8',
    'directionality' => 'rtl',
    'default_font' => 'cairo',
    'font_dir' => [
        public_path('fonts'),
    ],
    'fonts' => [
        'cairo' => [
            'R' => 'Cairo-Regular.ttf',
            'B' => 'Cairo-Bold.ttf',
        ],
        'xbriyaz' => [
            'R' => 'XB-Riyaz.ttf',
        ],
    ],
    'options' => [
        'autoScriptToLang' => true,
        'autoLangToFont' => true,
        'useSubstitutions' => true,
    ],
];
