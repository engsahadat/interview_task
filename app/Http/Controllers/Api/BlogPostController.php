<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BlogPostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Dummy", version="1.0.0")
 * @OA\Tag(
 *     name="BlogPosts",
 *     description="Operations about blog posts"
 * )
 */
class BlogPostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     tags={"BlogPosts"},
     *     @OA\Response(
     *         response=200,
     *         description="Post fetched successfully"
     *     )
     * )
     */
    public function index()
    {
        try {
            $blodPost = BlogPostService::getAllPost();
            return response()->json([
                'success' => true,
                'message' => 'Post fetched successfully',
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

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"BlogPosts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="user_id", type="integer", nullable=true),
     *             @OA\Property(property="published_at", type="timestamp", format="date-time", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors occurred"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a post by ID",
     *     tags={"BlogPosts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post fetched successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $post = BlogPostService::getPostById($id);
            return response()->json([
                'success' => true,
                'message' => 'Post fetched successfully',
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

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update a post",
     *     tags={"BlogPosts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="user_id", type="integer", nullable=true),
     *             @OA\Property(property="published_at", type="string", format="date-time", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a post",
     *     tags={"BlogPosts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
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
