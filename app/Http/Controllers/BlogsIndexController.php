<?php

namespace App\Http\Controllers;

use App\Blog;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;

class BlogsIndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$blogs = DB::table('blogs')
        ->join('users', 'users.id', '=', 'blogs.user_id')
        ->join('categories', 'categories.id', '=', 'blogs.category_id')
        ->paginate(20);
        
		if ($request->has('title')) {
			$blogs = DB::table('blogs')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->join('categories', 'categories.id', '=', 'blogs.category_id')
            ->where('title', 'LIKE', '%'.$request->get('title').'%')
            ->paginate(20);
		}
		if ($request->has('body')) {
			$blogs = DB::table('blogs')
            ->join('users', 'users.id', '=', 'blogs.user_id')
            ->join('categories', 'categories.id', '=', 'blogs.category_id')
            ->where('body', 'LIKE', '%'.$request->get('body').'%')
            ->paginate(20);
		}
        $categories = DB::table('categories')->get();
        //$blogs = $blogs->paginate(20);
        return view('blogs.layouts')->with('blogsData', $blogs)->with('categories', $categories);
        //return $categories;
    }
}
