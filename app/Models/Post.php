<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function scopeFilter($query, $filters)
    {
        if(isset($filters['category']) && $filters['category'] != null && $filters['category'] != 'all') {

            // $query->whereExists(function($query) use($filters){
            //     return $query->from('categories')
            //         ->where('slug', $filters['category'])
            //         ->whereColumn('id', 'posts.category_id');
            // });

            $query->whereHas('category', function ($q) use($filters){
                return $q->where('slug', $filters['category']);
            });
        }

        if(isset($filters['search']) && $filters['search'] != null) {
            $query->where(function($q) use ($filters) {
                return $q->where('title', 'like', "%{$filters['search']}%")
                    ->orWhere('body', 'like', "%{$filters['search']}%");
            });
        }

        if(isset($filters['author']) && $filters['author'] != null) {
            $query->whereHas('author', function($q) use ($filters){
                return $q->where('username', $filters['author']);
            });
        }

        return $query;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
