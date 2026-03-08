<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Models;

use Illuminate\Database\Eloquent\Model;

class SharkordConnectorSetting extends Model
{
    protected $table = 'sharkord_connector_settings';

    protected $guarded = [];

    protected $casts = [
        'allowed_alliance_ids_json' => 'array',
        'allowed_corp_ids_json' => 'array',
        'allowed_guest_groups_json' => 'array',
        'deny_groups_json' => 'array',
        'auto_push_disable_restore' => 'boolean',
        'dry_run_mode' => 'boolean',
        'enabled' => 'boolean',
    ];
}
