<?php

namespace App\Models;

use App\Sys\SysApi;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Log
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $event
 * @property string $ip_address
 * @property int $user_id
 * @property string|null $user_agent
 * @property string|null $target_type
 * @property mixed|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereTargetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserId($value)
 * @mixin \Eloquent
 */
class Log extends Model
{
    protected $sysApi;
    protected $fillable = ['url', 'event', 'ip_address', 'user_id', 'user_agent', 'target_type', 'data'];

    public function __construct()
    {
        $this->sysApi = new SysApi();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function log($event, $entity = null, $saveData = null)
    {
        $data['event'] = $event;
        $data['url'] = url()->current();
        $data['ip_address'] = request()->ip();
        $data['user_id'] = auth()->user()->id ?? 0;
        $data['user_agent'] = request()->userAgent();
        $data['target_type'] = $entity == null ? get_class($entity) : 'undefine';
        $data['data'] = json_encode($saveData);

        $this::create($data);

        return response([
            'data' => $entity,
            'result' => true,
            'message' => __('api_messages.api_ok'),
        ], $this->sysApi::_API_OK);
    }
}
