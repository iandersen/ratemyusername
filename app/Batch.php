<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';
    protected $guarded = [];

    protected $casts = [
        'is_processed' => 'boolean'
    ];

    public function usernames(){
        return $this->belongsToMany(Username::class, 'batch_usernames', 'batch_id', 'username_id');
    }
}
