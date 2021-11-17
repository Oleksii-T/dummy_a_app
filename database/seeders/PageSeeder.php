<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::updateOrCreate(
            ['url' => 'login'],
            [
                'url' => 'login',
                'title' => 'Login',
                'status' => 'static',
                'seo_title' => 'Tradesim | Login',
                'seo_description' => 'Login',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'sign-up'],
            [
                'url' => 'sign-up',
                'title' => 'Sign up',
                'status' => 'static',
                'seo_title' => 'Tradesim | Sign up',
                'seo_description' => 'Sign up',
            ]
        );

        Page::updateOrCreate(
            ['url' => ''],
            [
                'url' => '',
                'title' => 'Home page',
                'status' => 'static',
                'seo_title' => 'Tradesim | Home page',
                'seo_description' => 'Home page',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'blogs'],
            [
                'url' => 'blogs',
                'title' => 'Blogs',
                'status' => 'static',
                'seo_title' => 'Tradesim | Blogs',
                'seo_description' => 'Blogs',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'faq'],
            [
                'url' => 'faq',
                'title' => 'Faq',
                'status' => 'static',
                'seo_title' => 'Tradesim | Faq',
                'seo_description' => 'Faq',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'contact-us'],
            [
                'url' => 'contact-us',
                'title' => 'Contact us',
                'status' => 'static',
                'seo_title' => 'Tradesim | Contact us',
                'seo_description' => 'Contact us',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'checkout'],
            [
                'url' => 'checkout',
                'title' => 'Checkout',
                'status' => 'static',
                'seo_title' => 'Tradesim | Checkout',
                'seo_description' => 'Checkout',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'pricing'],
            [
                'url' => 'pricing',
                'title' => 'Pricing',
                'status' => 'static',
                'seo_title' => 'Tradesim | Pricing',
                'seo_description' => 'Pricing',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'dashboard'],
            [
                'url' => 'dashboard',
                'title' => 'Trading Dashboard',
                'status' => 'static',
                'seo_title' => 'Tradesim | Trading Dashboard',
                'seo_description' => 'Trading Dashboard',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'account'],
            [
                'url' => 'account',
                'title' => 'Account',
                'status' => 'static',
                'seo_title' => 'Tradesim | Account',
                'seo_description' => 'Account',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'terms'],
            [
                'url' => 'terms',
                'title' => 'Terms',
                'status' => 'static',
                'seo_title' => 'Tradesim | Terms',
                'seo_description' => 'Terms',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'privacy'],
            [
                'url' => 'privacy',
                'title' => 'privacy',
                'status' => 'static',
                'seo_title' => 'Tradesim | Privacy',
                'seo_description' => 'Privacy',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'how-it-works'],
            [
                'url' => 'how-it-works',
                'title' => 'How It Works',
                'status' => 'static',
                'seo_title' => 'Tradesim | How It Works',
                'seo_description' => 'How It Works',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'about'],
            [
                'url' => 'about',
                'title' => 'About',
                'status' => 'static',
                'seo_title' => 'Tradesim | About',
                'seo_description' => 'About',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'refunds'],
            [
                'url' => 'refunds',
                'title' => 'Refunds',
                'status' => 'static',
                'seo_title' => 'Tradesim | Refunds',
                'seo_description' => 'Refunds',
            ]
        );

        Page::updateOrCreate(
            ['url' => 'features'],
            [
                'url' => 'features',
                'title' => 'Features',
                'status' => 'static',
                'seo_title' => 'Tradesim | Features',
                'seo_description' => 'Features',
            ]
        );
    }
}
