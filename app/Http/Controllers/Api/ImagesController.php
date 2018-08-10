<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Transformers\ImageTransformer;
use App\Http\Requests\Api\ImageRequest;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        $user = $this->user();

        $size = $request->type == 'avatar' ? 262 : 1024;


        // str_plural 把字符串变为复数形式

        $result = $uploader->save($request->image, str_plural($request->type), $user->id, $size);

        // 数据库保存的路径是相对路径
        $image->path = $result['path'];
        $image->type = $request->type;
        $image->user_id = $user->id;
        $image->save();

        // api 接口，最后上传成功返回时，图片地址添加上服务器地址
        $image->path = config('app.url') . $image->path;

        return $this->response->item($image, new ImageTransformer())->setStatusCode(201);
    }
}
