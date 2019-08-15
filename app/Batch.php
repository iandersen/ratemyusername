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

    public function processed(){
        return $this->hasMany(ProcessedName::class);
    }

    public function unprocessed(){
        return $this->hasMany(UnprocessedName::class);
    }
}
