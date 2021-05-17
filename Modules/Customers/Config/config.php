<?php

return [
    'name' => 'Customers',
    /**
     * Always use lower name without custom characters, spaces, etc
     */
    'permissions' => [
        'customers.browse',
        'customers.create',
        'customers.update',
        'customers.destroy'
    ]
];