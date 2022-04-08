<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Basecontroller as BaseController;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class BlogController extends BaseController
{
    /*
     Display Blog Listing
    */
    public function index(){
        $blogs = Blog::all();

        return $this->sendResponse(BlogResource::collection($blogs),'Blogs retrived successfully');
    }

    /*
     Store Blog
    */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=>'required',
            'description'=>'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error..', $validator->errors());
        }

        $blog = Blog::create($input);
        return $this->sendResponse(new BlogResource($blog),'Blog Created successfully..');
       
    }

    public function show($id){
        $blog = Blog::find($id);
        if(is_null($blog)){
            return $this->sendEroor('Blog Not Found');
        }

        return $this->sendResponse(new BlogResource($blog),'Blog retrived successfully');
    }

    public function update(Request $request, Blog $blog){
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error..', $validator->errors());
        }
        
        $blog->title = $input['title'];
        $blog->description = $input['description'];

        $blog->save();

        return $this->sendResponse(new BlogResource($blog), 'Blog updated successfully');
    }

    public function destroy(Blog $blog){
            $blog->delete();
        return $this->sendResponse([], 'Blog deleted successfully');

    }

}
