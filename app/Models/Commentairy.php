<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentairy extends Model
{
    use HasFactory;
    protected $table ='commentairy';
    protected $fillable=[
        'commentairy',
        'user_id',
        'recipe_id'
        
    ];
}
