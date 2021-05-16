<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tickets extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_seller',
        'name_client',
        'email_client',
        'subject',
        'description',
    ];
}
