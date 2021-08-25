<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $table = 'reply';

    protected $fillable = [
        'text_reply',
        'comment_id',
        'user_id',
    ];

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment', 'comment_id', 'id');
    }
}
