<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailData extends Model
{
    use HasFactory;
    
    
    protected $table = 'email_data';
    public $timestamps = true;
    protected $guarded = ['id'];
    
}
