<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'label','menu_name','controller','action','order','route','parent'];


    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}