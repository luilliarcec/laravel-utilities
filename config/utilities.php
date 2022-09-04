<?php

return [
    /** HasAuthenticatedCreator */

    'authenticated' => [
        'key' => 'user_id', // Foreign Key Name
        'model' => config('auth.providers.users.model'), // Model Name
        'use_constrained' => false, // For macro generate column
    ],

    /** SetAttributesUppercase */

    /**
     * Here you should register all those attributes that should be ignored globally,
     * or if you don't want to mess up your model, add your attributes to ignore here.
     */

    'attributes_ignored_globally' => [],
];
