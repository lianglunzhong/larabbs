<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;
use Cache;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-' . str_random(15);
        // laravel-phone 扩展包提供的号码解析函数
        $phone = phone($request->phone, 'CN', 'E164');
        // 这里要特别注意 ltrim 的用法，并不是去除字符串左侧 +86 这三个字符，而是删除字符串中左侧任何匹配 +, 8 或 6 的字符。也就是 ltrim('+8668+123', '+86'); 的结果为 123，我们当前的场景，手机号一定会以 1 开头，所有不会出现意外的情况
        $phone = ltrim($phone, '+86');

        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);

        Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];


        return $this->response->array($result)->setStatusCode(201);
    }
}
