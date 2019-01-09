<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Link extends Model implements Sortable
{
    use SortableTrait {
        scopeOrdered as sorttableScopeOrdered;
    }


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
        return $this->remember($this->cache_expire_in_minutes)->ordered()->get();
    }

    public function scopeOrdered($query)
    {
        return $this->sorttableScopeOrdered($query);
    }
}