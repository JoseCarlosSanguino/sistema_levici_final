<?php
namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'name','description','id', 'label'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function users()
    {
        return $this
            ->belongsToMany('app\User')
            ->withTimestamps();
    }


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
