<?php

namespace App\Support\Pages;

class BlogPage extends ListingPage
{
    public static function info(): array
    {
        return ['label' => 'Blog Page', 'route' => 'blog.index', 'views' => 'frontend.blog.sections'];
    }

    protected static function title(): string
    {
        return 'Blog';
    }

    protected static function metaDescription(): string
    {
        return 'News, guides and insights about solar and renewable energy.';
    }

    protected static function listingFields(): array
    {
        return [
            'per_page' => ['label' => 'Posts per Page', 'type' => 'number', 'default' => 5],
            'read_more' => ['label' => 'Read More Button', 'type' => 'text', 'default' => 'Read More'],
            'search_title' => ['label' => 'Sidebar: Search Title', 'type' => 'text', 'default' => 'Search Here'],
            'categories_title' => ['label' => 'Sidebar: Categories Title', 'type' => 'text', 'default' => 'Categories'],
            'recent_title' => ['label' => 'Sidebar: Recent Posts Title', 'type' => 'text', 'default' => 'Recent Blog'],
            'tags_title' => ['label' => 'Sidebar: Tags Title', 'type' => 'text', 'default' => 'Popular Tag'],
            'empty_text' => ['label' => 'Text When No Posts Found', 'type' => 'text', 'default' => 'No posts found.'],
        ];
    }
}
