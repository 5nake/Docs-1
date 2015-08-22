<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Collection;

/**
 * Class User
 * @package App
 *
 * Active Record properties:
 *
 * @property-read int $id
 * @property string $login
 * @property string $avatar
 * @property string $email
 * @property string $password
 * @property-read string $remember_token
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * Relations:
 *
 * @property-read Collection<Document> $documents
 */
class User extends Model implements
    AuthenticatableContract,
    CanResetPasswordContract
{

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return BelongsTo
     */
    public function documents()
    {
        return $this->belongsTo(Document::class, 'id', 'user_id');
    }
}
