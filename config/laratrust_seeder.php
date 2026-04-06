<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadmin' => [
            'customer'    => 'c,r,u,d',
            'product'     => 'c,r,u,d',
            'order'     => 'c,r,u,d',
            'finance'   => 'c,r,u,d',
            'admin'     => 'c,r,u,d',
            'setting'   => 'c,r,u,d',
            'marketing' => 'c,r,u,d',
            'blog'      => 'c,r,u,d',

        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
