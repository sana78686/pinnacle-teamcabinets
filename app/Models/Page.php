<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Page extends Model
{
    use HasFactory, Notifiable, BelongsToTenant;

    public const SLUG_ABOUT = 'about';

    public const SLUG_BLOG = 'blog';

    protected $connection = 'tenant';

    protected $fillable = [
        'tenant_id',
        'parent_id',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'show_in_menu',
        'order_no',
        'status',
    ];


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

    /** @return array<int, string> */
    public static function reservedTopLevelSlugs(): array
    {
        return array_values(array_unique(array_merge(
            [self::SLUG_BLOG, self::SLUG_ABOUT, 'contact', 'contact-us'],
            config('tenant_storefront.reserved_slugs', [])
        )));
    }

    public function isCmsPage(): bool
    {
        if ($this->isBlogIndex() || $this->isBlogPost()) {
            return false;
        }

        return $this->parent_id !== null
            || ! in_array($this->slug, self::reservedTopLevelSlugs(), true);
    }

    /** Custom storefront pages only (excludes blog, articles, and reserved system pages). */
    public function scopeCmsOnly(Builder $query): Builder
    {
        $blogId = static::findBlogPage()?->id;
        $reserved = static::reservedTopLevelSlugs();

        return $query
            ->when($blogId, function (Builder $q) use ($blogId) {
                $q->where(function (Builder $q2) use ($blogId) {
                    $q2->whereNull('parent_id')
                        ->orWhere('parent_id', '!=', $blogId);
                });
            })
            ->where(function (Builder $q) use ($reserved) {
                $q->whereNotNull('parent_id')
                    ->orWhereNotIn('slug', $reserved);
            });
    }

    /** Tenant panel list: all pages except blog articles (includes system About/Blog/Contact pages). */
    public function scopePanelList(Builder $query): Builder
    {
        $blogId = static::findBlogPage()?->id;

        if (! $blogId) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($blogId) {
            $q->whereNull('parent_id')
                ->orWhere('parent_id', '!=', $blogId);
        });
    }

    public function isReservedSystemPage(): bool
    {
        return $this->parent_id === null
            && in_array($this->slug, self::reservedTopLevelSlugs(), true);
    }

    public function panelEditUrl(): string
    {
        if ($this->isBlogPost()) {
            return route('pages.edit', $this->id);
        }

        return match ($this->slug) {
            self::SLUG_ABOUT, 'about-us' => route('tenant_storefront_about'),
            self::SLUG_BLOG => route('tenant_storefront_blog'),
            'contact', 'contact-us' => route('tenant_contact_page_settings'),
            default => route('pages.edit', $this->id),
        };
    }

    /** Blog posts (children of the blog index page). */
    public function scopeBlogPosts(Builder $query): Builder
    {
        $blogId = static::findBlogPage()?->id;

        if (! $blogId) {
            return $query->whereRaw('0 = 1');
        }

        return $query->where('parent_id', $blogId);
    }
}
