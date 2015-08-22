<?php
namespace App;

use App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\DocumentManagerContract;
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
 * @property-read string $real_preview
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Relations:
 *
 * @property-read User $user
 *
 */
class Document extends Model
{
    const PERMISSIONS_PUBLIC  = 1;
    const PERMISSIONS_PRIVATE = 2;

    /**
     * @var string
     */
    protected $table = 'files';

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public static function scopeLatest(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @param $path
     * @return string
     */
    public function getPathAttribute($path)
    {
        return \App\Document\DocumentManager::UPLOADS_PATH . $path;
    }

    /**
     * @param $path
     * @return string
     */
    public function getPreviewAttribute($path)
    {
        return App::make(DocumentManagerContract::class)
            ->fromPreview($this);
    }

    /**
     * @return string
     */
    public function getRealPreviewAttribute()
    {
        if (array_key_exists('preview', $this->attributes)) {
            return $this->attributes['preview'];
        }
        return '';
    }
}
