<?php
return [
    'name' => env('RESTAURANT_NAME', 'Hapag'),
    'locations' => [
        [
            'slug' => 'makati',
            'name' => 'Hapag Makati',
            'area' => 'Makati City',
            'description' => 'An intimate garden dining room for relaxed celebrations and date nights.',
            'hours' => '11:00 AM – 10:00 PM',
            'accent' => '#2d6a4f',
        ],
        [
            'slug' => 'bgc',
            'name' => 'Hapag BGC',
            'area' => 'Bonifacio Global City',
            'description' => 'A bright, modern space for business lunches, family dinners, and weekend gatherings.',
            'hours' => '11:00 AM – 10:00 PM',
            'accent' => '#406b7a',
        ],
        [
            'slug' => 'quezon-city',
            'name' => 'Hapag Quezon City',
            'area' => 'Quezon City',
            'description' => 'A warm neighborhood table serving thoughtful Filipino-inspired comfort food.',
            'hours' => '11:00 AM – 9:00 PM',
            'accent' => '#9a6a35',
        ],
    ],
    'admin_password' => env('ADMIN_PASSWORD', 'admin123'),
    'deposit_per_guest' => 100,          // PHP per guest
    'duration' => 120,                   // minutes a table is held
    'slots' => ['11:00','12:00','13:00','14:00','17:00','18:00','19:00','20:00','21:00'],
];
