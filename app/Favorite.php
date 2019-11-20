<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'html_url',
        'owner_login',
        'stargazers_count',
        'user_id',
        'repo_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
