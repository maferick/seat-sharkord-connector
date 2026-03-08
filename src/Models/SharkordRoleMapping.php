<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Models;

use Illuminate\Database\Eloquent\Model;

class SharkordRoleMapping extends Model
{
    protected $table = 'sharkord_role_mappings';

    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
