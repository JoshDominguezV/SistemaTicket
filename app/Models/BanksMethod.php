<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanksMethod extends Model
{
    use HasFactory;

    protected $table = 'banks_methods';

    protected $fillable = ['name'];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:banks_methods,name',
        ];
    }
}
