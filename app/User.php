<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function countries(){
    	return $this->belongsTo(Country::class);
    }
    public function posts(){
    	return $this->hasMany(Post::class);
    }
    public function roles(){
    	return $this->belongsToMany(Role::class);
    }

    public function permissions(){
    	 return $this->hasManyThrough('App\Permission', 'App\Role');
    }
}
