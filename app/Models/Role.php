<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    use HasFactory;

    /////////////////////////////////////////////
    ////// Role get and set attributes////////////
    /////////////////////////////////////////////
    public function name(): Attribute
    {
        return new Attribute(
            fn($value) => ucwords(str_replace('_', ' ', $value)),
            fn($value) => strtolower($value),
        );
    }
    /////////////////////////////////////////////
    //////////// Role Relationships//////////////
    /////////////////////////////////////////////
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    /////////////////////////////////////////////
    // Roles where significance is lower in db//
    /////////////////////////////////////////////
    public static function significance(User $user)
    {
        return Role::Where('significance', '<=', $user->role->significance)->get();
    }

    public static function highest()
    {
        return Role::where('significance', '=', Role::max('significance'))->first();
    }

    public static function lowest()
    {
        return   Role::where('significance', '=', Role::min('significance'))->first();

    }

    public static function middle()
    {
        return Role::where('significance', '=', floor(Role::count() / 2))->first();
    }
}
