<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, Notifiable, BelongsToTenant;

    public const SLUG_ABOUT = 'about';

    public const SLUG_BLOG = 'blog';

    protected $guarded = [];

    protected $connection = 'tenant';


    // protected $fillable = [
    //    'tenant_id', 'parent_id','title','slug','content',
    // //    'meta_title',
    //     // 'meta_description','show_in_menu','order_no','status'
    // ];


    public function parent() {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public static function findContactPage(): ?self
    {
        return static::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->where('slug', 'contact')
                    ->orWhere('slug', 'contact-us')
                    ->orWhere('title', 'like', '%contact%');
            })
            ->orderByRaw("CASE WHEN slug IN ('contact', 'contact-us') THEN 0 ELSE 1 END")
            ->first();
    }

    public static function findAboutPage(): ?self
    {
        return static::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->where('slug', self::SLUG_ABOUT)
                    ->orWhere('slug', 'about-us');
            })
            ->orderByRaw("CASE WHEN slug = ? THEN 0 ELSE 1 END", [self::SLUG_ABOUT])
            ->first();
    }

    public static function findBlogPage(): ?self
    {
        return static::query()
            ->where('slug', self::SLUG_BLOG)
            ->whereNull('parent_id')
            ->first();
    }

    public function isBlogIndex(): bool
    {
        return $this->slug === self::SLUG_BLOG && $this->parent_id === null;
    }

    public function isBlogPost(): bool
    {
        if (! $this->parent_id) {
            return false;
        }

        $blog = static::findBlogPage();

        return $blog && (int) $this->parent_id === (int) $blog->id;
    }
}
