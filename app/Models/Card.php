<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Card extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    protected $casts = [
        'order' => 'integer',
        'status' => 'integer',
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];

    protected $fillable = ['title', 'description', 'order', 'status', 'column_id'];
    // protected $dates = ['deleted_at'];


    public function column()
    {

        return $this->belongsTo(Column::class);
    }
}
