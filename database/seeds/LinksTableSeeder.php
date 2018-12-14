<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('links')->delete();
        
        \DB::table('links')->insert(array (
            0 => 
            array (
                'title' => 'Devon Prohaska',
                'link' => 'http://www.heller.biz/',
            ),
            1 => 
            array (
                'title' => 'Ms. Cynthia Tillman',
                'link' => 'http://hoeger.net/quia-quo-quasi-accusantium-corporis-dolorem',
            ),
            2 => 
            array (
                'title' => 'Dr. Dewitt Barton',
                'link' => 'http://www.sanford.org/',
            ),
            3 => 
            array (
                'title' => 'Prof. Peter Larson Sr.',
                'link' => 'http://www.haag.com/',
            ),
            4 => 
            array (
                'title' => 'Piper Sauer',
                'link' => 'http://www.cremin.com/',
            ),
            5 => 
            array (
                'title' => 'Jailyn Boyer',
                'link' => 'https://www.kuhn.com/molestiae-odit-alias-et-iusto-fugiat-et-ab',
            ),
        ));
        
        
    }
}