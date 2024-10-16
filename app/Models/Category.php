<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    //Cara pertama dalam menyiapkan mess asigment
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    //cara kedua
    // User dapat memasukan data apa saja yang membahayakan sistem
    protected $guarded =[
        'id',
    ];

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
