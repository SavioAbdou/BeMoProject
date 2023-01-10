<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $fillable = ['title'];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function delete()
    {
        $this->cards()->delete();
        return parent::delete();
    }
}
