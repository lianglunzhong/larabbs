<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'change-locale', 'cors'] //serializer 减少一次嵌套， bindings 把dingo api路由的参数自动绑定到模型上
], function ($api) {
    $api->get('version', function () {
        return response('this is version v1');
    });

    $api->group([
        'middleware' => 'api.throttle', // 调用频率限制
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        // 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');

        // 用户注册
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');

        // 第三方登录
        $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->name('api.socials.authorizations.store');

        // 登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');

        // 小程序登录
        $api->post('weapp/authorizations', 'AuthorizationsController@weappStore')
            ->name('api.weapp.authorizations.store');

        // 小程序注册
        $api->post('weapp/users', 'UsersController@weappStore')
            ->name('api.weapp.users.store');

        // passport 认证登录
        $api->post('authorizations/passport', 'AuthorizationsController@passportStore')
            ->name('api.passport.authorizations.store');

        // 图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');

        // 刷新token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');

        // 刷新token
        $api->put('authorizations/passport/current', 'AuthorizationsController@passportUpdate')
            ->name('api.passport.authorizations.update');

        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.update');
    });

    $api->group([
        'middleware' => 'api.throttle', // 调用频率限制
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {
        /** 游客可以访问的接口 */
        // 分类列表
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');

        // 话题列表
        $api->get('topics', 'TopicsController@index')
            ->name('api.topics.index');

        // 话题详情
        $api->get('topics/{topic}', 'TopicsController@show')
            ->name('apo.topics.show');

        // 某个用户发布的话题列表
        $api->get('users/{user}/topics', 'TopicsController@userIndex')
            ->name('api.users.topics.index');

        // 某个话题的回复列表
        $api->get('topics/{topic}/replies', 'RepliesController@index')
            ->name('api.topics.replies.index');

        // 某个用户的回复列表
        $api->get('users/{user}/replies', 'RepliesController@userIndex')
            ->name('api.users.replies.index');

        // 资源推荐
        $api->get('links', 'LinksController@index')
            ->name('api.links.index');

        // 用户详情
        $api->get('users/{user}', 'UsersController@show')
            ->name('api.users.show');

        // 活跃用户
        $api->get('actived/users', 'UsersController@activedIndex')
            ->name('api.actived.users.index');


        /** 需要 token 验证的接口 */
        $api->group(['middleware' => 'api.auth'], function ($api) {
            // 当前登录用户信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');

            // 编辑登录用户信息
            // put:替换某个资源，需提供完整的资源信息 patch: 部分修改资源，提供部分资源信息
            $api->patch('user', 'UsersController@update')
                ->name('api.user.update');
            // 因为微信小程序的网络请求是不支持 PATCH 方法的
            $api->put('user', 'UsersController@update')
                ->name('api.user.update');

            // 图片资源
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');

            // 发布话题
            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');

            // 修改话题
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');

            // 删除话题
            $api->delete('topics/{topic}', 'TopicsController@destroy')
                ->name('api.topics.destroy');

            // 发布回复
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.topics.replies.store');

            // 删除回复
            $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('api.topics.replies.destroy');

            // 通知列表
            $api->get('user/notifications', 'NotificationsController@index')
                ->name('api.user.notifications.index');

            // 通知统计
            $api->get('user/notifications/stats', 'NotificationsController@stats')
                ->name('api.user.notifications.stats');

            // 标记消息通知为已读（把所有未读消息批量标记为已读）
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');
            $api->put('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');

            // 标记消息通知为已读（单条消息通知）
            $api->put('user/read/notifications/{notification}', 'NotificationsController@readOne')
                ->name('api.user.notifications.readOne');

            // 当前登录用户权限
            $api->get('user/permissions', 'PermissionsController@index')
                ->name('api.user.permissions.index');
        });
    });
});

$api->version('v2', function ($api) {
    $api->get('version', function () {
        return response('this is version v2');
    });
});
