<?php


$apiBased = 'http://10.250.2.9/apis/';
return [
    'meta_description' => '',
    'meta_keywords' => '',
    'meta_project' => 'Admin',

    //api configuration
    'api_key' => '',
    'api' => [
        'test' => [
            'index' => $apiBased . 'trk/trk-condperson/0/showDashboard2',
            'index2' => $apiBased . 'trk/trk-condperson/0/showDashboard2',
        ]
    ]
];