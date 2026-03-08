<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Models;

use Illuminate\Database\Eloquent\Model;

class SharkordSyncLog extends Model
{
    protected $table = 'sharkord_sync_logs';

    protected $guarded = [];

    protected $casts = [
        'payload_excerpt_json' => 'array',
        'response_excerpt_json' => 'array',
    ];
}
