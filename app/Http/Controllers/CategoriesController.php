<?php

namespace App\Http\Controllers;

use App\Blog;
use App\User;
use App\Category;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::withTrashed();
        $blogs = Blog::withTrashed();
        $total_Blogs = Blog::count();
        $total_User = User::count();
        $total_Cat = Category::count();

        if ($request->has('categories_name')) {
            $categories = $categories->where('categories_name', 'LIKE', '%'.$request->get('categories_name').'%');
        }
        $categories = $categories->paginate(20);
        return view('categories.index')->with('categoriesData', $categories)->with('total_Blogs', $total_Blogs)->with('total_User', $total_User)->with('total_Cat', $total_Cat);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Category $category = null)
    {
        $total_Blogs = Blog::count();
        $total_User = User::count();
        $total_Cat = Category::count();
        $category = $category ?: new Category;
        return view('categories.form')->with('category', $category)->with('total_Blogs', $total_Blogs)->with('total_User', $total_User)->with('total_Cat', $total_Cat);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(CategoryRequest $request, Category $category)
    {
        $category = Category::firstOrNew(['id' => $request->get('id')]);
        $category->id = $request->get('id');
        $category->categories_name = $request->get('categories_name');

        $category->save();

        $message = 'category Added';
        return redirect()->route('category.index')->withMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Category $category)
    {
        $category->delete();
        $message = 'category Deleted.';
        return redirect()->back()->withMessage($message);
    }

    /**
     * Restore the specified deleted resource to storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($categoryId)
    {
        $category = Category::withTrashed()->find($categoryId);
        $category->restore();
        $message = 'category Restored.';
        return redirect()->back()->withMessage($message);
    }

    public function forceDelete($categoryId)
    {
        $category = Category::withTrashed()->find($categoryId);
        $category->forceDelete();
        $message = 'category permanently deleted.';
        return redirect()->back()->withMessage($message);
    }
}
