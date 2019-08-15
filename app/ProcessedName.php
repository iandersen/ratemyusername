<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessedName extends Model
{
    protected $table = 'processed';
    protected $guarded = [];

    public function batch(){
        return $this->belongsTo(Batch::class);
    }
}
