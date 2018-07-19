<?php

namespace App\Http\Controllers;

use App\Blog;
use App\User;
use App\Category;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = Blog::withTrashed()->orderBy('id', 'DESC');
        $total_Blogs = Blog::count();
        $total_User = User::count();
        $total_Cat = Category::count();
        $categories = DB::table('categories')->get();
        
		if ($request->has('blogs_title')) {
			$blogs = $blogs->where('blogs_title', 'LIKE', '%'.$request->get('blogs_title').'%');
		}
        if ($request->has('categories')) {
            $blogs = $blogs->where('category_id', '=', $request->get('categories'));
        }
        if ($request->has('start_date') AND $request->has('end_date')) {
            $sdate = urldecode($request->get('start_date'));
            $sdate = trim($sdate);
            //$sdate = str_replace('/', '-', $sdate);
            $sdate = date("Y-m-d",strtotime($sdate));

            $edate = urldecode($request->get('end_date'));
            $edate = trim($edate);
            //$edate = str_replace('/', '-', $edate);
            $edate = date("Y-m-d",strtotime($edate));

            $blogs = $blogs->where('created_at', '>=', $sdate." 00:00:00")
                           ->where('created_at', '<=', $edate." 23:59:59");

            //$blogs = $blogs->where("created_at >= ? AND created_at <= ?", 
             //               array($sdate." 00:00:00", $edate." 23:59:59"));

            //$blogs = $blogs->whereBetween('created_at', [$sdate, $edate]);
        }
		if ($request->has('blogs_body')) {
			$blogs = $blogs->where('blogs_body', 'LIKE', '%'.$request->get('blogs_body').'%');
		}
        $blogs = $blogs->paginate(20);
        return view('blogs.index')->with('blogsData', $blogs)->with('categories', $categories)->with('total_Blogs', $total_Blogs)->with('total_User', $total_User)->with('total_Cat', $total_Cat);
        //return $edate;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Blog $blog = null)
    {
        $blog = $blog ?: new Blog;
        $users = \App\User::pluck('name', 'id')->toArray();
        $categories = \App\Category::pluck('categories_name', 'id')->toArray();
        return view('blogs.form')->with('blog', $blog)->with('users', $users)->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(BlogRequest $request, Blog $blog)
    {
        $blog = Blog::firstOrNew(['id' => $request->get('id')]);
        $blog->id = $request->get('id');
        $blog->user_id = $request->get('user_id');
		$blog->blogs_title = $request->get('blogs_title');
		$blog->blogs_body = $request->get('blogs_body');
        $blog->category_id = $request->get('category_id');

        $blog->save();

        $message = 'blog Added';
        return redirect()->route('blog.index')->withMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Blog $blog)
    {
        $blog->delete();
        $message = 'blog Deleted.';
        return redirect()->back()->withMessage($message);
    }

    /**
     * Restore the specified deleted resource to storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($blogId)
    {
        $blog = Blog::withTrashed()->find($blogId);
        $blog->restore();
        $message = 'blog Restored.';
        return redirect()->back()->withMessage($message);
    }

    public function forceDelete($blogId)
    {
        $blog = Blog::withTrashed()->find($blogId);
        $blog->forceDelete();
        $message = 'blog permanently deleted.';
        return redirect()->back()->withMessage($message);
    }
}
