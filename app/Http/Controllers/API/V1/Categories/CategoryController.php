<?php

namespace App\Http\Controllers\API\V1\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Category\CategoryStoreRequest;
use App\Http\Requests\API\V1\Category\CategoryUpdateRequest;
use App\Http\Resources\API\V1\Category\CategoryResourceCollection;
use App\Http\Resources\API\V1\Post\PostResourceCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categoriesCollection = Category::query()
            ->with("posts")
            ->paginate(\request("per_page") ?? 10);

        return $this->successResponse(__("messages.categories_list"), [new CategoryResourceCollection($categoriesCollection)],);
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            $catData = $request->only([
                "slug",
                "title",
                "subtitle",
                "description",
                "parent_id",
            ]);
            $categoryInstance = Category::query()
                ->create($catData);

            return $this->successResponse(__("messages.category_created_successfully"), [$categoryInstance], 201);
        } catch (\Throwable $exception) {
            throw ($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
