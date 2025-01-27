<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['title','body','user_id'];

    /**
     * user proprietaire du Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
