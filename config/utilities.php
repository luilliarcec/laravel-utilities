<?php

return [
    /** BelongsToAuth */

    /**
     * Name of the column that represents the foreign key of the creator user.
     * This column is used to identify the records associated with that user.
     */

    'auth_key_name' => 'user_id',

    /** SetAttributesUppercase */

    /**
     * Here you should register all those attributes that should be ignored globally,
     * or if you don't want to mess up your model, add your attributes to ignore here.
     */

    'attributes_ignored_globally' => [],
];
