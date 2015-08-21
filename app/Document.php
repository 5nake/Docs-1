<?php
namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Document
 * @package App
 *
 * Active Record properties:
 *
 * @property-read int $id
 * @property int $user_id
 * @property string $title
 * @property int $permissions
 * @property string $path
 * @property string $token
 * @property string $mime
 * @property int $size
 * @property string $preview
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Relations:
 *
 * @property-read User $user
 */
class Document extends Model
{
    protected $table = 'files';

    /**
     * @param Builder $query
     * @return mixed
     */
    public static function scopeLatest(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
