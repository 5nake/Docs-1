<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;

class User extends Eloquent
    implements UserInterface,
        RemindableInterface
{
    use UserTrait,
        RemindableTrait;

    protected $table = 'users';

    protected $hidden = ['password', 'remember_token'];


    public function getMaxVolumeAttribute()
    {
        return 1024*1024*1024;
    }

    public function getCurrentVolumeAttribute()
    {
        return UplFile::getSize($this);
    }


    public static function createFromResponse($data)
    {
        $u = User
            ::where('login', '=', $data->login)
            ->orWhere('email', '=', $data->email)
            ->first();

        if (!$u) {
            $u           = new User;
            $u->login    = $data->login;
            $u->avatar   = $data->avatar;
            $u->email    = $data->email;
            $u->password = Hash::make($data->email . $data->login . $data->id);
            $u->save();
        }
        Auth::login($u, true);

        return $u;
    }
}
