<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // This allows you to protect or unprotect your table columns. 
    // An empty guarded array means you can write to any column.
    protected $guarded = [];
}