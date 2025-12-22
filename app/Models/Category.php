<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all products including child category products
     */
    public function getAllProducts($perPage = 20)
    {
        $categoryIds = $this->getAllDescendantIds();
        $categoryIds[] = $this->id;

        return Product::whereIn('category_id', $categoryIds)
            ->with('category') // Optional: eager load category
            ->paginate($perPage);
    }
    public function getFullPathAttribute()
    {
        $path = [];
        $category = $this;

        while ($category) {
            array_unshift($path, $category->name);
            $category = $category->parent;
        }

        return implode(' → ', $path);
    }

    // Alias for blade compatibility
    public function fullPath()
    {
        return $this->full_path;
    }
    /**
     * Get all descendant category IDs recursively
     */
    public function getAllDescendantIds()
    {
        $ids = [];

        // Load children if not already loaded
        if (!$this->relationLoaded('children')) {
            $this->load('children');
        }

        foreach ($this->children as $child) {
            $ids[] = $child->id;

            // Recursively get children's descendants
            if ($child->children->isNotEmpty()) {
                $ids = array_merge($ids, $child->getAllDescendantIds());
            }
        }

        return $ids;
    }

    /**
     * Check if category has any products (including child categories)
     */
    public function hasAnyProducts()
    {
        $categoryIds = $this->getAllDescendantIds();
        $categoryIds[] = $this->id;

        return Product::whereIn('category_id', $categoryIds)->exists();
    }
}
