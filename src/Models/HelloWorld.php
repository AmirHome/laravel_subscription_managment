<?php

namespace amirhome\HelloWorld\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelloWorld extends Model
{
    use HasFactory;

    protected $fillable = ['message'];
} 