<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'column_id', 'title', 'description'
    ];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}
