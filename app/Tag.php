<?php
namespace App;

use Carbon\Carbon;

/**
 * Class Tag
 * @package App
 *
 * Properties:
 *
 * @property-read int $id
 * @property string $title
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 */
class Tag extends \Eloquent
{
    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'documents_tags');
    }
}
