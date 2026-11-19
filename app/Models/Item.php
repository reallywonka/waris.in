<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'condition',
        'condition_note',
        'description',
        'mode',
        'price',
        'barter_request',
        'contact_info',
        'meetup_location',
        'time_handover',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ItemImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ItemImage::class)->where('is_primary', true);
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isLocked(): bool
    {
        return $this->status === 'locked';
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->mode === 'gratis') {
            return 'Gratis';
        }
        if ($this->mode === 'barter') {
            return 'Barter';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->firstWhere('is_primary', true) ?? $this->images->first();
        if ($primary) {
            return str_starts_with($primary->image_path, 'http')
                ? $primary->image_path
                : asset('storage/' . $primary->image_path);
        }
        return 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=800';
    }
}
