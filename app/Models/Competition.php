<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'rules',
        'prizes',
        'image',
        'start_date',
        'end_date',
        'registration_deadline',
        'max_participants',
        'entry_fee',
        'status',
        'views'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'entry_fee' => 'decimal:2',
        'views' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($competition) {
            if (empty($competition->slug)) {
                $competition->slug = Str::slug($competition->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function confirmedRegistrations()
    {
        return $this->hasMany(Registration::class)->where('status', 'confirmed');
    }

    public function scopeTrending($query)
    {
        return $query->where('status', 'published')
            ->orderByDesc('views')
            ->orderByDesc('created_at');
    }

    public function scopeMostRegistrations($query)
    {
        return $query->where('status', 'published')
            ->withCount('confirmedRegistrations')
            ->orderByDesc('confirmed_registrations_count');
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'published')
            ->orderByDesc('created_at');
    }
}
