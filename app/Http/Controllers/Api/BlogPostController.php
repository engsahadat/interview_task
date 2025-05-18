<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BlogPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class BlogPostController extends Controller
{
    // Fetch all blog post
    public function index()
    {
        try {
            $blodPost = BlogPostService::getAllPost();
            return response()->json([
                'success' => true,
                'data'    => $blodPost
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch post.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Create a new blog post
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string',
            'content'        => 'required|string',
            'user_id'        => 'nullable|integer',
            'published_at'   => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $PostData = $validator->validated();
            $post = BlogPostService::createPost($PostData);
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully.',
                'data'    => $post,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post.',
            ], 500);
        }
    }


    // Show post
    public function show($id)
    {
        try {
            $post = BlogPostService::getPostById($id);
            return response()->json([
                'success' => true,
                'data'    => $post
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch post.',
            ], 500);
        }
    }

    // Update a post
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string',
            'content'        => 'required|string',
            'user_id'        => 'nullable|integer',
            'published_at'   => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors'  => $validator->errors(),
            ], 422);
        }
        try {
            $postData = $validator->validated();
            $post = BlogPostService::updatePost($id, $postData);
            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully.',
                'data'    => $post
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update post.',
            ], 500);
        }
    }

    // Delete a post
    public function destroy($id)
    {
        try {
            BlogPostService::deletePost($id);
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
                'error'   => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete post',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
