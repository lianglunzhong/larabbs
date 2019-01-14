<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Link extends Model implements Sortable
{
    use SortableTrait {
        scopeOrdered as sorttableScopeOrdered;
    }

    use HasTranslations;

    public $translatable = ['title'];


    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = ['title', 'link'];

    // public $cache_key = 'larabbs_links';
    protected $rememberCacheTag = 'larabbs_links';
    protected $cache_expire_in_minutes = 1440;

    public function getAllCached()
    {
        $links = $this->ordered();

        if (!app()->isLocal()) {
            $this->cachePrefix .= app()->getLocale();
            $this->remember($this->cache_expire_in_minutes);
        }

        return $links->get();
    }

    public function scopeOrdered($query)
    {
        return $this->sorttableScopeOrdered($query);
    }
}