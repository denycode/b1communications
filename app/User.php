<?php

namespace App;

use App\Model\Attachment;
use App\Model\Organization;
use App\Model\Server;
use App\Model\UserDetail;
use App\Model\UserMeta;
use App\Model\UserRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','is_active','profile_id',
    ];

    const ENDUSER = 'P1571923543';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getIsOrganizationAssignedAttribute(){
        if(!is_null($this->organization_id) && !is_null($this->organization)){
           return true;
        }
        return false;
    }

    public function getAuthTokenAttribute(){
        if(isset($this->AuthToken)) {
            return $this->AuthToken;
        }
        return true;
    }


    public function getFullNameAttribute(){
        return ucwords("{$this->first_name} {$this->last_name}");
    }

    public function getNameEmailAttribute(){
        return "{$this->first_name} {$this->last_name}  ({$this->organization->organization_name})";
    }

    public function getIsAdminAttribute(){
        switch ($this->profile_id){
            case 'P1568809591':
                return true;
                break;

            default:
                return false;
            break;
        }
    }

    public function getIsCSRAttribute(){
        switch ($this->profile_id){
            case 'P1582183468':
                return true;
                break;

            default:
                return false;
            break;
        }
    }

    public function organization(){
        return $this->hasOne(Organization::class,'id','organization_id');
    }

    public function profile(){
        return $this->hasOne(Model\Profile::class,'profile_id','profile_id');
    }

    public function permissions(){
        return $this->hasMany(Model\Permissions::class,'profile_id','profile_id');
    }

    public function server(){
        return $this->hasManyThrough(
            Organization::class,
            Server::class,
            'id', // Foreign key on the cars table...
            'id', // Foreign key on the owners table...
            'organization_id', // Local key on the mechanics table...
            'server_ID' // Local key on the cars table...
        );
    }

    public function customers(){
        return $this->hasOne(UserRole::class,'added_by_u_dataid','u_dataid')->where('role','=','customer');
    }

    public function umeta(){
        return $this->hasMany(UserMeta::class,'user_id','id');
    }

    public function attachment(){
        return $this->hasOne(Attachment::class,'u_dataid','u_dataid')->where('type','=','user');
    }

    public function getProfileImageAttribute(){
        $dummy_imag = '/ds_attachments/users/dummy_man.png';
        return isset($this->attachment) ? '/ds_attachments/users/'.$this->FullName.'/'.$this->attachment->attachment_url : $dummy_imag;
    }

    public function getProfileImageThumbAttribute(){
        $dummy_imag = '/ds_attachments/users/dummy_man.png';
        return isset($this->attachment) ? '/ds_attachments/users/'.$this->FullName.'/thumb/'.$this->attachment->attachment_url : $dummy_imag;
    }
}
