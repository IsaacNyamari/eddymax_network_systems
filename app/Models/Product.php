<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'name',
        'price',
        'image',
        'short_description',
        'description',
        'model',
        'brand',
        'category_id',
        'slug',
    ];

    /**
     * Get the indexable data array for Algolia.
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Load relationships for search data
        $array['category'] = $this->category ? $this->category->name : null;
        $array['brand_name'] = $this->brand ? $this->brand->name : null;
        $array['images'] = $this->productImages->pluck('image_path')->toArray();

        // Add custom attributes for better search
        $array['_geoloc'] = [
            'lat' => -1.286389, // Nairobi coordinates - adjust as needed
            'lng' => 36.817223,
        ];

        // Add facets for filtering
        $array['facets'] = [
            'category' => $this->category ? $this->category->name : 'Uncategorized',
            'brand' => $this->brand ? $this->brand->name : 'Unknown',
            'price_range' => $this->getPriceRange(),
            'type' => $this->getProductType(),
        ];

        return $array;
    }

    /**
     * Determine the price range for faceting.
     */
    protected function getPriceRange()
    {
        $price = $this->price;

        if ($price < 1000) return 'Under KES 1,000';
        if ($price < 5000) return 'KES 1,000 - 5,000';
        if ($price < 10000) return 'KES 5,000 - 10,000';
        if ($price < 50000) return 'KES 10,000 - 50,000';
        if ($price < 100000) return 'KES 50,000 - 100,000';
        return 'Over KES 100,000';
    }

    /**
     * Determine product type based on category.
     */
    protected function getProductType()
    {
        if (!$this->category) return 'Other';

        $categoryName = strtolower($this->category->name);

        if (str_contains($categoryName, 'router') || str_contains($categoryName, 'switch')) {
            return 'Networking';
        }

        if (str_contains($categoryName, 'cctv') || str_contains($categoryName, 'security')) {
            return 'Security Systems';
        }

        if (str_contains($categoryName, 'laptop') || str_contains($categoryName, 'desktop')) {
            return 'Computer Systems';
        }

        if (str_contains($categoryName, 'voip') || str_contains($categoryName, 'phone')) {
            return 'Telephony';
        }

        if (str_contains($categoryName, 'software') || str_contains($categoryName, 'license')) {
            return 'Software';
        }

        return 'Accessories';
    }

    /**
     * Get the index name for Algolia.
     */
    public function searchableAs()
    {
        return 'edymax_products';
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable()
    {
        return $this->deleted_at === null; // Only index non-deleted products
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price', 'product_name')
            ->withTimestamps();
    }

    public function productImages()
    {
        return $this->morphMany(ProductImages::class, 'imageable');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class);
    }
}
