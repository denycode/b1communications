<?php

return [
    'title' => 'Cp',
    'loader_label' => 'Cp',
    'footer_label' => 'Cp',
    'creator' => 'B1Communications',
    'organization_name' => 'B1Communications',
    'record_per_page' => 10,
    'permissions' => [
        'modules' => [
            'organization' => [
                'show_as' => 'Organization',
                'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                'submodules' => []
            ],
            'extension' => [
                'show_as' => 'Extension',
                'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                'submodules' => []
            ],
            'department' => [
                'show_as' => 'Department',
                'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                'submodules' => []
            ],
            'phonenumber' => [
                'show_as' => 'Phone Number',
                'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                'submodules' => []
            ],
            'announcement' => [
                'show_as' => 'Announcement',
                'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                'submodules' => []
            ],
            'settings' => [
                'show_as' => 'Settings',
                'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                'submodules' => [
                    'users' => [
                        'show_as' => 'Users',
                        'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                        'submodules' => []
                    ],
                    'profile' => [
                        'show_as' => 'Profiles',
                        'rights' => ['add' => 0,'view' => 0, 'edit' => 0, 'trash' => 0],
                        'submodules' => []
                    ]
                ]
            ]
        ]
    ]
];
