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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// 游客可以访问的接口
Route::group([
    'namespace' => 'Api',
], function ($router) {
    // 登录
    $router->post('authorizations', 'AuthorizationsController@login')->name('api.authorizations.login');
    // 全站搜索
    $router->get('search', 'SearchController@index')->name('api.search.index');
});


// 需要 token 验证的接口
Route::group([
    'namespace'  => 'Api',
    'middleware' => 'auth:api',
], function ($router) {
    // 刷新token
    $router->put('authorizations/refresh', 'AuthorizationsController@refresh')
        ->name('api.authorizations.refresh');
    // 删除token
    $router->delete('authorizations/logout', 'AuthorizationsController@logout')
        ->name('api.authorizations.logout');
    // 获取当前登录用户信息
    $router->get('me', 'AuthorizationsController@me')->name('api.me.show');

    // 图片资源
//    $router->post('images', 'ImagesController@store')->name('api.images.store');
//    $router->post('images?action=update', 'ImagesController@update')->name('api.images.update');
//    $router->delete('images', 'ImagesController@destroy')->name('api.images.destroy');

    // 分类
//    $router->post('blog/categories', 'BlogCategoriesController@store')->name('api.blog.articles.store');

    // 评论
    $router->post('replies', 'RepliesController@store')->name('api.replies.store');
    $router->delete('replies/{reply}', 'RepliesController@destroy')->name('api.replies.destroy');
    //文章点赞和收藏
    $router->post('topics', 'TopicsController@VoteCollect')->name('api.topics.vote_collect');
    //上传头像
    $router->post('images', 'ImagesController@store')->name('api.image_upload');
    //关注或取消关注用户
    $router->post('attentions','UserAttentionsController@attention')->name('api.user_attention');

});
