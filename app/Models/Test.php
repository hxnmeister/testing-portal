<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];
    protected $with = ['questions', 'results'];

    public function questions() :HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function results() :HasMany
    {
        return $this->hasMany(Result::class);
    }
}
