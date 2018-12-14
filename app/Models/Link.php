<?php

namespace App\Models;

class Link extends Model
{
    protected $fillable = ['title', 'link'];

    // public $cache_key = 'larabbs_links';
    protected $rememberCacheTag = 'larabbs_links';
    protected $cache_expire_in_minutes = 1440;

    public function getAllCached()
    {
        return $this->remember($this->cache_expire_in_minutes)->get();
    }
}
