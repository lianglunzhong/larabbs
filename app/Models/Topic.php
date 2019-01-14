<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Topic extends Model
{

    use Filterable, SoftDeletes, SoftCascadeTrait, RevisionableTrait, LogsActivity;

    protected $softCascade = ['replies'];

    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    // 创建模型时是否记录
    protected $revisionCreationsEnabled = true;
    // 只记录的字段
    protected $keepRevisionOf = ['title', 'category_id'];
    // 限制某个模型的记录数
    protected $historyLimit = 5;
    protected $revisionCleanup = true;

    protected static $logAttributes = ['title', 'category_id'];
    protected static $logOnlyDirty = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function topReplies()
    {
        return $this->replies()->limit(5);
    }

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        // 预加载防止 N+1 问题
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        switch ($eventName) {
            case 'created':
                $description = '话题被创建';
                break;
            case 'updated':
                $description = '话题被修改';
                break;
            case 'deleted':
                $description = '话题被删除';
                break;
            default:
                $description = $eventName;
                break;
        }

        return $description;
    }
}