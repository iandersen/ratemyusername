<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnprocessedName extends Model
{
    protected $table = 'to_process';
    protected $guarded = [];

    public function batch(){
        return $this->belongsTo(Batch::class);
    }
}
