<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    use HasFactory;

    protected $table = 'moneys';

    public $timestamps = false;

    protected $appends = ['month_year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function monthYear(): Attribute
    {
        return Attribute::make(
            get: fn ($_, $attributes) => readAsHuman($attributes['month'], 'm', 'F')
                .' '. readAsHuman($attributes['year'], 'Y'),
        );
    }
}
