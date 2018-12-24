<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '分享',
                'description' => '分享创造，分享发现',
                'post_count' => 0,
                'created_at' => NULL,
                'updated_at' => '2018-12-18 15:35:36',
                '_lft' => 1,
                '_rgt' => 2,
                'parent_id' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '教程',
                'description' => '开发技巧、推荐扩展包等',
                'post_count' => 0,
                'created_at' => NULL,
                'updated_at' => '2018-12-18 15:35:36',
                '_lft' => 3,
                '_rgt' => 14,
                'parent_id' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '问答',
                'description' => '请保持友善，互帮互助',
                'post_count' => 0,
                'created_at' => NULL,
                'updated_at' => '2018-12-18 15:35:36',
                '_lft' => 15,
                '_rgt' => 16,
                'parent_id' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '公告',
                'description' => '站点公告',
                'post_count' => 0,
                'created_at' => NULL,
                'updated_at' => '2018-12-18 15:35:36',
                '_lft' => 17,
                '_rgt' => 18,
                'parent_id' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '接口',
                'description' => NULL,
                'post_count' => 0,
                'created_at' => '2018-12-18 15:37:18',
                'updated_at' => '2018-12-18 15:37:18',
                '_lft' => 4,
                '_rgt' => 5,
                'parent_id' => 2,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '小程序',
                'description' => NULL,
                'post_count' => 0,
                'created_at' => '2018-12-18 15:38:26',
                'updated_at' => '2018-12-18 15:38:26',
                '_lft' => 6,
                '_rgt' => 11,
                'parent_id' => 2,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'WePY',
                'description' => NULL,
                'post_count' => 0,
                'created_at' => '2018-12-18 15:39:04',
                'updated_at' => '2018-12-18 15:39:04',
                '_lft' => 7,
                '_rgt' => 8,
                'parent_id' => 6,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'MpVue',
                'description' => NULL,
                'post_count' => 0,
                'created_at' => '2018-12-18 15:40:20',
                'updated_at' => '2018-12-18 15:40:20',
                '_lft' => 9,
                '_rgt' => 10,
                'parent_id' => 6,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '电商',
                'description' => NULL,
                'post_count' => 0,
                'created_at' => '2018-12-18 15:41:12',
                'updated_at' => '2018-12-18 15:41:12',
                '_lft' => 12,
                '_rgt' => 13,
                'parent_id' => 2,
            ),
        ));
        
        
    }
}