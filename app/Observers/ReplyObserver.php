<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        // XSS 过滤
        // $reply->content = clean($reply->content, 'user_topic_body');
        // htmlspecialchars_decode
        $reply->content = clean(htmlspecialchars($reply->content), 'user_topic_body');
    }


    public function created(Reply $reply)
    {
        // 一次把所有的关联都查询出来
        $reply->loadMissing(['topic', 'user']);

        $topic = $reply->topic;

        // 话题回复统计 + 1
        $topic->increment('reply_count', 1);

        // 触发通知，通知作者话题被回复了
        // $topic->user->notify(new TopicReplied($reply));
        // 如果评论的作者不是话题的作者，才需要通知
        if ( ! $reply->user->isAuthorOf($topic)) {
            $topic->user->notify(new TopicReplied($reply));
        }
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}