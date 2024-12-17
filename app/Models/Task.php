<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     protected $fillable = ['title', 'description', 'status'];

     public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
        })->when($filters['filterStatus'] ?? null, function ($query, $filterStatus) {
            if ($filterStatus === 'true') {
                $query->where('status', true);
            } elseif ($filterStatus === 'false') {
                $query->where('status', false);
            }
        });
    }

}
