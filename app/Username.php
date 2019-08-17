<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Username extends Model
{
    protected $guarded = [];

    public function batches(){
        return $this->belongsToMany(Batch::class, 'batch_usernames', 'username_id', 'batch_id');
    }
}
