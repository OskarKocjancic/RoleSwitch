<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;
    protected $table = "prompts";
    protected $fillable = [
        'name',
        'prompt',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}