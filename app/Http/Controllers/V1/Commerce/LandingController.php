<?php

namespace App\Http\Controllers\V1\Commerce;

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
                ->with(["parent", "children", "category"])
                ->whereHas("category", function (Builder $builder) use ($category) {
                    $builder->where("slug", $category);
                })
                ->latest("created_at")
                ->first();
            return view("commerce.pages.landing", compact("postInstance"));
        } elseif (!empty($category) && empty($post)) {
            //check post
            $postInstance = Post::query()
                ->with(["parent", "children", "category"])
                ->where("slug", $category)
                ->first();
            if (!$postInstance instanceof Post) {
                //check category
                $categoryInstance = Category::query()
                    ->where("slug", $category)
                    ->first();
                if (!$categoryInstance instanceof Category) {
                    return view("errors.404");
                }
                return view("commerce.pages.landing", compact("categoryInstance"));
            }
            return view("commerce.pages.landing", compact("postInstance"));
        }

        return view("errors.404");
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
