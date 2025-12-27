<?php

return [
    'driver' => 'gd', // or 'imagick'
    
    'quality' => 90,
    
    'sizes' => [
        'thumbnail' => [150, 150],
        'small' => [300, 300],
        'medium' => [600, 400],
        'large' => [1200, 800],
    ],
    
    'watermark' => [
        'enabled' => false,
        'path' => public_path('images/watermark.png'),
        'position' => 'bottom-right',
        'opacity' => 50,
    ],
];