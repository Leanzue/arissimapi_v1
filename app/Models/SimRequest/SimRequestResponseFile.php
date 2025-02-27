<?php

namespace App\Models\SimRequest;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SimRequestResponseFile
 * @package App\Models
 *
 * @property string|null $iccid
 * @property string|null $status
 *
 * @property string|null $status_change_date_str
 * @property Carbon|null $status_change_date
 * @property integer|null $sim_request_id
 *
 * @property SimRequest $simrequest
 */
class SimRequestResponseFile extends Model
{
    /** @use HasFactory<\Database\Factories\SimRequestResponseFileFactory> */
    use HasFactory;
    protected $guarded = [];

    public function simrequest(): BelongsTo
    {
        return $this->belongsTo(SimRequest::class, 'sim_request_id');
    }
}
