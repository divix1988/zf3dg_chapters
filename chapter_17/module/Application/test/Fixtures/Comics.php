<?php

$fixture = [
    [
        'id' => 1,
        'title' => 'Przykładowy komiks',
        'thumb' => 'public/images/comics/test.jpg',
        'pages' => [
            [
                'id' => 1,
                'image' => 'public/images/comics/test_1.jpg'
            ],
            [
                'id' => 2,
                'image' => 'public/images/comics/test_2.jpg'
            ]
        ]
    ],
    [
        'id' => 2,
        'title' => 'Spiderman',
        'thumb' => 'public/images/comics/spiderman.jpg',
        'pages' => [
            [
                'id' => 2,
                'image' => 'public/images/comics/spiderman_1.jpg'
            ],
            [
                'id' => 3,
                'image' => 'public/images/comics/spiderman_2.jpg'
            ]
        ]
    ],
    [
        'id' => 3,
        'title' => 'Spiderman',
        'thumb' => 'public/images/comics/batman.jpg',
        'pages' => [
            [
                'id' => 2,
                'image' => 'public/images/comics/batman_1.jpg'
            ],
            [
                'id' => 3,
                'image' => 'public/images/comics/batman_2.jpg'
            ]
        ]
    ]
];

return $fixture;