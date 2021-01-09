<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Wallets
    Route::apiResource('wallets', 'WalletApiController');

    // Video Lists
    Route::post('video-lists/media', 'VideoListApiController@storeMedia')->name('video-lists.storeMedia');
    Route::apiResource('video-lists', 'VideoListApiController');

    // Languages
    Route::apiResource('languages', 'LanguagesApiController');

    // Categories
    Route::post('categories/media', 'CategoriesApiController@storeMedia')->name('categories.storeMedia');
    Route::apiResource('categories', 'CategoriesApiController');

    // Settings
    Route::apiResource('settings', 'SettingsApiController');

    // Tags
    Route::apiResource('tags', 'TagsApiController');

    // Events
    Route::post('events/media', 'EventsApiController@storeMedia')->name('events.storeMedia');
    Route::apiResource('events', 'EventsApiController');

    // Followers
    Route::apiResource('followers', 'FollowersApiController');

    // Profile Likes
    Route::apiResource('profile-likes', 'ProfileLikesApiController');

    // Video Likes
    Route::apiResource('video-likes', 'VideoLikesApiController');

    // Video Comments
    Route::apiResource('video-comments', 'VideoCommentsApiController');

    // Coin Masters
    Route::apiResource('coin-masters', 'CoinMasterApiController');

    // Coin Tasks
    Route::apiResource('coin-tasks', 'CoinTaskApiController');

    // Withdraws
    Route::apiResource('withdraws', 'WithdrawApiController');

    // Channels
    Route::apiResource('channels', 'ChannelsApiController');
});
