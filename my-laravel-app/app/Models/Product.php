<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'slug',
        'description',
        'category',
        'product_type',
        'price',
        'commission',
        'status',
        'featured_image',
        'sales_page_url',
        'resources_page_url',
        'thankyou_page_url',
        'meta_title',
        'meta_description',
        'tags',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'commission' => 'decimal:2',
        'tags' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the vendor that owns the product
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Get the product's orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get formatted price with currency symbol
     */
    public function getFormattedPrice()
    {
        // You can customize this based on your currency settings
        $currency = config('app.currency', 'USD');
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'JPY' => '¥',
            'GHS' => '₵',
            'NGN' => '₦',
            'ZAR' => 'R',
            'KES' => 'KSh'
        ];
        
        $symbol = $symbols[$currency] ?? '$';
        return $symbol . number_format($this->price, 2);
    }

    /**
     * Get category display name
     */
    public function getCategoryDisplayName()
    {
        $categories = [
            'electronics' => 'Electronics',
            'clothing' => 'Clothing & Fashion',
            'home-garden' => 'Home & Garden',
            'health-beauty' => 'Health & Beauty',
            'sports-outdoors' => 'Sports & Outdoors',
            'toys-games' => 'Toys & Games',
            'books-media' => 'Books & Media',
            'automotive' => 'Automotive',
            'jewelry' => 'Jewelry & Accessories',
            'food-beverages' => 'Food & Beverages',
            'software' => 'Software & Apps',
            'courses' => 'Online Courses',
            'ebooks' => 'E-books',
            'templates' => 'Templates & Themes',
            'services' => 'Professional Services',
            'consulting' => 'Consulting',
            'other' => 'Other'
        ];

        return $categories[$this->category] ?? ucfirst(str_replace('-', ' ', $this->category));
    }

    /**
     * Get product type icon
     */
    public function getTypeIcon()
    {
        $icons = [
            'digital' => '💻',
            'physical' => '📦',
            'service' => '🔧'
        ];

        return $icons[$this->product_type] ?? '📋';
    }

    /**
     * Get the product's featured image URL
     */
    public function getFeaturedImageUrl()
    {
        if ($this->featured_image) {
            return Storage::url($this->featured_image);
        }
        
        return null;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClass()
    {
        $classes = [
            'active' => 'status-active',
            'pending' => 'status-pending',
            'inactive' => 'status-inactive',
            'draft' => 'status-draft'
        ];

        return $classes[$this->status] ?? 'status-pending';
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for pending products
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for inactive products
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope for products by vendor
     */
    public function scopeByVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    /**
     * Scope for products by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for products by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('product_type', $type);
    }

    /**
     * Search products
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%");
        });
    }

    /**
     * Get short description
     */
    public function getShortDescription($limit = 100)
    {
        return \Illuminate\Support\Str::limit($this->description, $limit);
    }

    /**
     * Check if product has image
     */
    public function hasImage()
    {
        return !empty($this->featured_image);
    }

    /**
     * Get commission amount for a given price
     */
    public function getCommissionAmount($price = null)
    {
        $price = $price ?? $this->price;
        return ($price * $this->commission) / 100;
    }

    /**
     * Check if product is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if product is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if product is inactive
     */
    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    /**
     * Get tags as array
     */
    public function getTagsArray()
    {
        if (is_string($this->tags)) {
            return json_decode($this->tags, true) ?? [];
        }
        
        return $this->tags ?? [];
    }

    /**
     * Get tags as string
     */
    public function getTagsString()
    {
        $tags = $this->getTagsArray();
        return implode(', ', $tags);
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Delete associated files when product is deleted
        static::deleting(function ($product) {
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }
        });
    }
}