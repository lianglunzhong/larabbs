<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


	public function store(ReplyRequest $request, Reply $reply)
	{
		// $reply = Reply::create($request->all());
        $reply->content =  $request->content;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();

		return redirect()->to($reply->topic->link())->with('success', '回复成功');
	}


	public function destroy(Reply $reply)
	{
        try {
            $this->authorize('destroy', $reply);
        } catch (\Exception $e) {
            return abort(403, '对不起，你无权访问此页面！');
        }

		$reply->delete();

		return redirect()->to($reply->topic->link())->with('success', '成功删除回复.');
	}
}