<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name', 'team', 'season', 'description', 'price', 'compare_price',
        'image_url', 'image_path', 'sizes', 'stock', 'featured', 'active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'sizes' => 'array',
            'featured' => 'boolean',
            'active' => 'boolean',
        ];
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn () => 'R$ '.number_format((float) $this->price, 2, ',', '.'));
    }

    protected function imageSource(): Attribute
    {
        return Attribute::get(fn () => $this->image_path
            ? Storage::disk('public')->url($this->image_path)
            : $this->image_url
        );
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
