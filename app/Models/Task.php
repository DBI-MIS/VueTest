<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_completed',
    
    ];
    
    protected $cast = [
        'is_completed' => 'boolean'    
    ];

    public function todo()
    {
        return $this->belongsTo(User::class);
    }
}
