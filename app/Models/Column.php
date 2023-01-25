<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    // public static function boot ()
    // {
    //     parent::boot();

    //     self::deleting(function (Column $column) {

    //         foreach ($column->cards as $card)
    //         {
    //             $card->delete();
    //         }
    //     });
    // }
    protected $fillable = ['title', 'description'];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    //column can have many cards
    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy('order');
    }
}
