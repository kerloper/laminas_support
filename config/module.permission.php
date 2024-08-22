<?php

return [


    'api' => [],

    'admin' => [
        [
            'module' => 'support',
            'section' => 'admin',
            'package' => 'installer',
            'handler' => 'installer',
            'permission' => 'admin-support-installer-installer',
            'role' => [
                'admin',
                'member',
            ],
        ],

    ],

];