<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Test extends Model
{
    use HasFactory;
    use Sluggable;

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

    public function sluggable(): array
    {
        return 
        [
            'slug' => ['source' => 'title']
        ];
    }
}
