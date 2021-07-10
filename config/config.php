<?php

return [
    /** BelongsToAuth */

    /**
     * Name of the column that represents the foreign key of the creator user.
     * This column is used to identify the records associated with that user.
     * Used in: ...\Concerns\BelongsToAuth | ...\Rules\Auth
     */

    'auth_foreign_id_column' => 'user_id',

    /** SetAttributesUppercase */
];
