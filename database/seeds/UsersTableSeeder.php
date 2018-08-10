<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
            '/images/users/default_avatar.gif',
            '/images/users/default_avatar.png',
            '/images/users/elyse.png',
            '/images/users/kristy.png',
            '/images/users/matthew.png',
            '/images/users/molly.png',
        ];

        // 生成数据集合
        $users = factory(User::class)
                        ->times(10)
                        ->make()
                        ->each(function($user, $index) use ($faker, $avatars) {
                            // 从头像数组中随机取出一个并赋值
                            $user->avatar = $faker->randomElement($avatars);
                        });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'KekeO';
        $user->email = '2546763702@qq.com';
        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');
        $user->save();

        // 单独处理第二个用户的数据
        $user = User::find(2);
        $user->name = 'Llz';
        $user->email = '123456@qq.com';
        // 将 2 号用户指派为『管理员』
        $user->assignRole('Maintainer');
        $user->save();
    }
}
