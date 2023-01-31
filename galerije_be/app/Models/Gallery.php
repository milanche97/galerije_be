<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function scopeSearchByTerm($query, $term = "", $user_id = "")
    {
        $query->with('user', 'images', 'comments');

        if ($user_id) {
            $query = $query->where('user_id', '=', $user_id);
        }

        if (!$term && !$user_id) {
            return $query;
        }

        return  $query->where(function ($querry2) use ($term) {
            $querry2->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhereHas('user', function ($querry3) use ($term) {
                    $querry3->where('first_name', 'like', "%{$term}%")
                        ->orWhere('last_name', 'like', "$%{$term}%");
                });
        });
    }

}
