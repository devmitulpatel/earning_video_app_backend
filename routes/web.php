<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Permission Groups
    Route::delete('permission-groups/destroy', 'PermissionGroupController@massDestroy')->name('permission-groups.massDestroy');
    Route::resource('permission-groups', 'PermissionGroupController', ['except' => ['show']]);

    // Wallets
    Route::delete('wallets/destroy', 'WalletController@massDestroy')->name('wallets.massDestroy');
    Route::resource('wallets', 'WalletController');

    // Video Lists
    Route::delete('video-lists/destroy', 'VideoListController@massDestroy')->name('video-lists.massDestroy');
    Route::post('video-lists/media', 'VideoListController@storeMedia')->name('video-lists.storeMedia');
    Route::post('video-lists/ckmedia', 'VideoListController@storeCKEditorImages')->name('video-lists.storeCKEditorImages');
    Route::resource('video-lists', 'VideoListController');

    // Languages
    Route::delete('languages/destroy', 'LanguagesController@massDestroy')->name('languages.massDestroy');
    Route::resource('languages', 'LanguagesController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoriesController@storeMedia')->name('categories.storeMedia');
    Route::post('categories/ckmedia', 'CategoriesController@storeCKEditorImages')->name('categories.storeCKEditorImages');
    Route::resource('categories', 'CategoriesController');

    // Settings
    Route::delete('settings/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');
    Route::resource('settings', 'SettingsController');

    // Tags
    Route::delete('tags/destroy', 'TagsController@massDestroy')->name('tags.massDestroy');
    Route::resource('tags', 'TagsController');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::post('events/media', 'EventsController@storeMedia')->name('events.storeMedia');
    Route::post('events/ckmedia', 'EventsController@storeCKEditorImages')->name('events.storeCKEditorImages');
    Route::resource('events', 'EventsController');

    // Followers
    Route::delete('followers/destroy', 'FollowersController@massDestroy')->name('followers.massDestroy');
    Route::resource('followers', 'FollowersController');

    // Profile Likes
    Route::delete('profile-likes/destroy', 'ProfileLikesController@massDestroy')->name('profile-likes.massDestroy');
    Route::resource('profile-likes', 'ProfileLikesController');

    // Video Likes
    Route::delete('video-likes/destroy', 'VideoLikesController@massDestroy')->name('video-likes.massDestroy');
    Route::resource('video-likes', 'VideoLikesController');

    // Video Comments
    Route::delete('video-comments/destroy', 'VideoCommentsController@massDestroy')->name('video-comments.massDestroy');
    Route::resource('video-comments', 'VideoCommentsController');

    // Coin Masters
    Route::delete('coin-masters/destroy', 'CoinMasterController@massDestroy')->name('coin-masters.massDestroy');
    Route::resource('coin-masters', 'CoinMasterController');

    // Coin Tasks
    Route::delete('coin-tasks/destroy', 'CoinTaskController@massDestroy')->name('coin-tasks.massDestroy');
    Route::resource('coin-tasks', 'CoinTaskController');

    // Withdraws
    Route::delete('withdraws/destroy', 'WithdrawController@massDestroy')->name('withdraws.massDestroy');
    Route::resource('withdraws', 'WithdrawController');

    // Channels
    Route::delete('channels/destroy', 'ChannelsController@massDestroy')->name('channels.massDestroy');
    Route::resource('channels', 'ChannelsController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
