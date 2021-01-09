<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'permission_group_create',
            ],
            [
                'id'    => 18,
                'title' => 'permission_group_edit',
            ],
            [
                'id'    => 19,
                'title' => 'permission_group_delete',
            ],
            [
                'id'    => 20,
                'title' => 'permission_group_access',
            ],
            [
                'id'    => 21,
                'title' => 'wallet_create',
            ],
            [
                'id'    => 22,
                'title' => 'wallet_edit',
            ],
            [
                'id'    => 23,
                'title' => 'wallet_show',
            ],
            [
                'id'    => 24,
                'title' => 'wallet_delete',
            ],
            [
                'id'    => 25,
                'title' => 'wallet_access',
            ],
            [
                'id'    => 26,
                'title' => 'video_access',
            ],
            [
                'id'    => 27,
                'title' => 'video_list_create',
            ],
            [
                'id'    => 28,
                'title' => 'video_list_edit',
            ],
            [
                'id'    => 29,
                'title' => 'video_list_show',
            ],
            [
                'id'    => 30,
                'title' => 'video_list_delete',
            ],
            [
                'id'    => 31,
                'title' => 'video_list_access',
            ],
            [
                'id'    => 32,
                'title' => 'admin_access',
            ],
            [
                'id'    => 33,
                'title' => 'language_create',
            ],
            [
                'id'    => 34,
                'title' => 'language_edit',
            ],
            [
                'id'    => 35,
                'title' => 'language_show',
            ],
            [
                'id'    => 36,
                'title' => 'language_delete',
            ],
            [
                'id'    => 37,
                'title' => 'language_access',
            ],
            [
                'id'    => 38,
                'title' => 'category_create',
            ],
            [
                'id'    => 39,
                'title' => 'category_edit',
            ],
            [
                'id'    => 40,
                'title' => 'category_show',
            ],
            [
                'id'    => 41,
                'title' => 'category_delete',
            ],
            [
                'id'    => 42,
                'title' => 'category_access',
            ],
            [
                'id'    => 43,
                'title' => 'setting_create',
            ],
            [
                'id'    => 44,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 45,
                'title' => 'setting_show',
            ],
            [
                'id'    => 46,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 47,
                'title' => 'setting_access',
            ],
            [
                'id'    => 48,
                'title' => 'tag_create',
            ],
            [
                'id'    => 49,
                'title' => 'tag_edit',
            ],
            [
                'id'    => 50,
                'title' => 'tag_show',
            ],
            [
                'id'    => 51,
                'title' => 'tag_delete',
            ],
            [
                'id'    => 52,
                'title' => 'tag_access',
            ],
            [
                'id'    => 53,
                'title' => 'event_create',
            ],
            [
                'id'    => 54,
                'title' => 'event_edit',
            ],
            [
                'id'    => 55,
                'title' => 'event_show',
            ],
            [
                'id'    => 56,
                'title' => 'event_delete',
            ],
            [
                'id'    => 57,
                'title' => 'event_access',
            ],
            [
                'id'    => 58,
                'title' => 'follower_create',
            ],
            [
                'id'    => 59,
                'title' => 'follower_edit',
            ],
            [
                'id'    => 60,
                'title' => 'follower_show',
            ],
            [
                'id'    => 61,
                'title' => 'follower_delete',
            ],
            [
                'id'    => 62,
                'title' => 'follower_access',
            ],
            [
                'id'    => 63,
                'title' => 'profile_like_create',
            ],
            [
                'id'    => 64,
                'title' => 'profile_like_edit',
            ],
            [
                'id'    => 65,
                'title' => 'profile_like_show',
            ],
            [
                'id'    => 66,
                'title' => 'profile_like_delete',
            ],
            [
                'id'    => 67,
                'title' => 'profile_like_access',
            ],
            [
                'id'    => 68,
                'title' => 'video_like_create',
            ],
            [
                'id'    => 69,
                'title' => 'video_like_edit',
            ],
            [
                'id'    => 70,
                'title' => 'video_like_show',
            ],
            [
                'id'    => 71,
                'title' => 'video_like_delete',
            ],
            [
                'id'    => 72,
                'title' => 'video_like_access',
            ],
            [
                'id'    => 73,
                'title' => 'video_comment_create',
            ],
            [
                'id'    => 74,
                'title' => 'video_comment_edit',
            ],
            [
                'id'    => 75,
                'title' => 'video_comment_show',
            ],
            [
                'id'    => 76,
                'title' => 'video_comment_delete',
            ],
            [
                'id'    => 77,
                'title' => 'video_comment_access',
            ],
            [
                'id'    => 78,
                'title' => 'coin_master_create',
            ],
            [
                'id'    => 79,
                'title' => 'coin_master_edit',
            ],
            [
                'id'    => 80,
                'title' => 'coin_master_show',
            ],
            [
                'id'    => 81,
                'title' => 'coin_master_delete',
            ],
            [
                'id'    => 82,
                'title' => 'coin_master_access',
            ],
            [
                'id'    => 83,
                'title' => 'coin_task_create',
            ],
            [
                'id'    => 84,
                'title' => 'coin_task_edit',
            ],
            [
                'id'    => 85,
                'title' => 'coin_task_show',
            ],
            [
                'id'    => 86,
                'title' => 'coin_task_delete',
            ],
            [
                'id'    => 87,
                'title' => 'coin_task_access',
            ],
            [
                'id'    => 88,
                'title' => 'withdraw_create',
            ],
            [
                'id'    => 89,
                'title' => 'withdraw_edit',
            ],
            [
                'id'    => 90,
                'title' => 'withdraw_show',
            ],
            [
                'id'    => 91,
                'title' => 'withdraw_delete',
            ],
            [
                'id'    => 92,
                'title' => 'withdraw_access',
            ],
            [
                'id'    => 93,
                'title' => 'channel_create',
            ],
            [
                'id'    => 94,
                'title' => 'channel_edit',
            ],
            [
                'id'    => 95,
                'title' => 'channel_show',
            ],
            [
                'id'    => 96,
                'title' => 'channel_delete',
            ],
            [
                'id'    => 97,
                'title' => 'channel_access',
            ],
            [
                'id'    => 98,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
