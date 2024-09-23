<?php

namespace App\Models;

use App\Core\Traits\SpatieLogsActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use SpatieLogsActivity;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'api_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('assets/avatar/' . $this->image);
        }

        // Optionally, return a default image if the image is not set
        return asset(theme()->getMediaUrlPath().'avatars/blank.png');
    }
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get a fullname combination of first_name and last_name
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Prepare proper error handling for url attribute
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->info) {
            return asset($this->info->avatar_url);
        }

        return asset(theme()->getMediaUrlPath().'avatars/blank.png');
    }

    /**
     * User relation to info model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }



    public function is_admin()
    {
        if (in_array('Admin',$this->roles->pluck('name')->toArray()) || in_array('admin',$this->roles->pluck('name')->toArray())){
            return true;
        } else{
            return false;
        }
    }


    public function perms(){
        $r=[];
     foreach($this->roles as $a){
        foreach($a->permissions as $b){
         $r[] = $b->name;
        }
     }
     return $r;
    }


    public function has_perm($name){
     foreach($this->roles as $a){
        foreach($a->permissions as $b){
             if ($b->name == $name){
                 return true;
             }
        }
     }
     return false;
    }



}
