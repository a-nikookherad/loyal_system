<?php

namespace App\Http\Controllers\V1\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index($category, $post = null)
    {
        if (!empty($category) && !empty($post)) {
            //category and post
            $postInstance = Post::query()
                ->where("slug", $post)
                ->with(["parent", "category"])
                ->whereHas("category", function (Builder $builder) use ($category) {
                    $builder->where("slug", $category);
                })
                ->orWhereHas("parent", function (Builder $builder) use ($category) {
                    $builder->where("slug", $category);
                })
                ->latest("created_at")
                ->first();
            if ($postInstance instanceof Post) {
                return view("blog.pages.landing", compact("postInstance"));
            }
            return abort(404);
        } elseif (!empty($category) && empty($post)) {
            //check post
            $postInstance = Post::query()
                ->with(["parent", "category"])
                ->where("slug", $category)
                ->first();
            if ($postInstance instanceof Post) {
                return view("blog.pages.landing", compact("postInstance"));
            }

            //check category
            $categoryInstance = Category::query()
                ->with(["parent"])
                ->where("slug", $category)
                ->first();
            if ($categoryInstance instanceof Category) {
                return view("blog.pages.landing", compact("categoryInstance"));
            }

            return abort(404);
        }

        return abort(404);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
