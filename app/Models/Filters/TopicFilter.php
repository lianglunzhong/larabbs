<?php namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class TopicFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [
        'replies' => ['replyer_id'],
    ];

    public function title($title)
    {
        return $this->whereLike('title', $title); // where('title', 'LIKE', '%'.$title.'%')
    }

    public function minViewCount($minCount)
    {
        return $this->where('view_count', '>', $minCount);
    }

    public function category($cid)
    {
        return $this->where('category_id', $cid);
    }

    public function order($value)
    {
        switch ($value) {
            case 'recent':
                $this->recent();
                break;
            default:
                $this->recentReplied();
                break;
        }
    }

    public function setup()
    {
        // 如果没有传 order，则默认使用 default
        if (!$this->input('order')) {
            $this->push('order', 'default');
        }
    }
}
