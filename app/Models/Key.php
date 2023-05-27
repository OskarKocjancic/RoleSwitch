<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;
    protected $table = "keys";
    protected $fillable = [
        'api_key',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}