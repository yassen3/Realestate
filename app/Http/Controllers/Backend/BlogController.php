<?php

namespace App\Http\Controllers\Backend;

use App\Models\comment;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Notifications\Notification;

class BlogController extends Controller
{
    public function AllBlogCategory(){
        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category',compact('category'));
    }

    public function StoreBlogCategory(request $request){
         BlogCategory::insert([
            'category_name'=> $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-', $request->category_name)),
         ]);
         $notification = array(
            'message' => 'Category Created Successfully',
            'alert-type' =>'success'
         );
         return redirect()->back()->with($notification);
    }

    public function EditBlogCategory($id){
        $categories = BlogCategory::findorfail($id);
        return response()->json($categories);
    }

    public function UpdateBlogCategory(request $request){

        $cat_id = $request->cat_id;
        BlogCategory::findorfail($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','_',$request->category_name)),

        ]);
        $notification = array(
            'message' =>  'Blog Category Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
        }

        public function DeleteBlogCategory($id){
            BlogCategory::findorfail($id)->delete();
            $notification = array(
                'message' => 'Blog Category Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        public function AllPost(){
            $posts = BlogPost::latest()->get();
            return view('backend.post.all_post',compact('posts'));
        }

        public function AddPost(){
            $blogcat = BlogCategory::latest()->get();
            return view('backend.post.add_post',compact('blogcat'));
        }

        public function StorePost(request $request){
            $image = $request ->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image) ->resize(370,250)->save('upload/post/'.$name_gen);
            $save_url = 'upload/post/'.$name_gen;

        BlogPost::insert([
            'blogcat_id' => $request ->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => $request->post_slug,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc,
            'post_tags' => $request->post_tags,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Post Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.post')->with($notification);
        }

        public function EditPost($id){
            $post = BlogPost::findorfail($id);
            $blogcat = BlogCategory::latest()->get();
            return view('backend.post.edit_post',compact('post','blogcat'));
        }

        public function UpdatePost(request $request){
            $post_id = $request->id;
            if($request->file('post_image')){
                $image = $request->file('post_image');
                $name_gen = hexdec(uniqid()).''.$image->getClientOriginalExtension();
                Image::make($image)->resize(370,250)->save('upload/post/'.$name_gen);
                $save_url = 'upload/post/'.$name_gen;

                BlogPost::findorfail($post_id)->update([
                    'blogcat_id' => $request ->blogcat_id,
                    'user_id' => Auth::user()->id,
                    'post_title' => $request->post_title,
                    'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                    'short_desc' => $request->short_desc,
                    'long_desc' => $request->long_desc,
                    'post_tags' => $request->post_tags,
                    'post_image' => $save_url,
                    'created_at' => Carbon::now(),
                ]);
                $notification = array(
                    'message' => 'Post Uppdated Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('all.post')->with($notification);
                }
                 else{
                BlogPost::findorfail($post_id)->update([
                    'blogcat_id' => $request ->blogcat_id,
                    'user_id' => Auth::user()->id,
                    'post_title' => $request->post_title,
                    'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                    'short_desc' => $request->short_desc,
                    'long_desc' => $request->long_desc,
                    'post_tags' => $request->post_tags,
                    'created_at' => Carbon::now(),
                ]);
                $notification = array(
                    'message' => 'Post Updated Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('all.post')->with($notification);
            }
        }
        public function DeletePost($id){
            $post = BlogPost::findorfail($id);
            $img = $post->post_image;
            unlink($img);
            BlogPost::findorfail($id)->delete();

            $notification = array(
                'message' => 'Post Uppdated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.post')->with($notification);
        }

        public function BlogDetails($slug){
            $blog = BlogPost::where('post_slug',$slug)->first();
            $category = BlogCategory::latest()->get();
            $dposts = BlogPost::latest()->limit(3)->get();
            $tags = $blog->post_tags;
            $tags_all = explode(',', $tags);
            return view('frontend.blog.blog_details',compact('blog','tags_all','category','dposts'));
        }

        public function BlogCatList($id){
            $blog = BlogPost::where('blogcat_id',$id)->get();
            $breadcat = BlogCategory::where('id',$id)->first();
            $category = BlogCategory::latest()->get();
            $dposts = BlogPost::latest()->limit(3)->get();
            return view('frontend.blog.blog_cat_list',compact('blog','category','breadcat','dposts'));
        }

        public function BlogList(){
            $blog = BlogPost::latest()->paginate(8);
            $category = BlogCategory::latest()->get();
            $dposts = BlogPost::latest()->limit(3)->get();
            return view('frontend.blog.blog_list',compact('blog','category','dposts'));
        }

        public function StoreComment(request $request){

            $pid = $request->post_id;

            comment::insert([
                'user_id' => Auth::user()->id,
                'post_id' => $pid,
                'parent_id' => null,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => carbon::now(),
            ]);
            $notification = array(
                'message' => 'message Created Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        public function AdminBlogComment(){
            $comments = Comment::where('parent_id',null)->latest()->get();
            return view('backend.comment.comment_all',compact('comments'));
        }

        public function AdminCommentReplay($id){
            $comments = Comment::where('id',$id)->first();
            return view('backend.comment.replay_comment',compact('comments'));
        }

        public function ReplayMessage(Request $request){

            $id = $request->id;
            $user_id = $request->user_id;
            $post_id = $request->post_id;

            comment::insert([
                'user_id' => $user_id,
                'post_id' => $post_id,
                'parent_id' => $id,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => carbon::now(),
            ]);
            $notification = array(
                'message' => 'Replay Inserted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);

        }
    }
