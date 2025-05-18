<?php

namespace App\Services;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;

class BlogPostService
{
    // Get all post
    public static function getAllPost()
    {
        return BlogPost::with('user')->latest()->paginate(50);
    }

    // Create a new post
    public static function createPost(array $data)
    {
        $data['user_id'] = Auth::id();
        $data['published_at'] = now();
        return BlogPost::create($data);
    }

    // Get a single post by id
    public static function getPostById($id)
    {
        return BlogPost::findOrFail($id);
    }

    // Update a post
    public static function updatePost($id, array $data)
    {
        $blogPost = self::getPostById($id);
        $blogPost->update($data);
        return $blogPost;
    }

    // Delete a post
    public static function deletePost($id)
    {
        $blogPost = self::getPostById($id);
        $blogPost->delete();
        return true;
    }
}
