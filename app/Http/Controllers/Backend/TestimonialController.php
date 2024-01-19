<?php

namespace App\Http\Controllers\Backend;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class TestimonialController extends Controller
{
    public function AllTestimonials(){
        $testimonials = Testimonial::latest()->get();
        return view('backend.testimonials.all_testimonials',compact('testimonials'));
    }

    public function AddTestimonials(){
        return view('backend.testimonials.add_testimonials');
    }

    public function StoreTestimonials(request $request){
        $request->validate([
            'name' => 'required|unique:testimonials|max:200',
            'image' => 'required|image',
            'position' => 'required',
            'message' => 'required',
        ]);
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.webp';
        Image::make($image)->encode('webp')->resize(100,100)->save('upload/testimonial/'.$name_gen);
        $save_url = 'upload/testimonial/'.$name_gen;
        Testimonial::insert([
            'name'=> $request->name,
            'position'=> $request->position,
            'message'=> $request->message,
            'image'=> $save_url,
        ]);
        $notification = array(
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.testimonials')->with($notification);

    }
    public function EditTestimonials($id){
        $testimonials = Testimonial::findorfail($id);
        return view('backend.testimonials.edit_testimonials',compact('testimonials'));
    }

    public function UpdateTestimonials(Request $request){
        $testimonial_id = $request->id;
         if($request->file('image')){
            $image = $request->file('image');
        $name_gen = hexdec(uniqid()).'.webp';
        Image::make($image)->encode('webp')->resize(100,100)->save('upload/testimonial/'.$name_gen);
        $save_url = 'upload/testimonial/'.$name_gen;
        Testimonial::findorfail($testimonial_id)->update([
            'name'=> $request->name,
            'position'=> $request->position,
            'message'=> $request->message,
            'image'=> $save_url,
        ]);
        $notification = array(
            'message' => 'Testimonial Updated Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.testimonials')->with($notification);
         }
         else{
            Testimonial::findorfail($testimonial_id)->update([
            'name'=> $request->name,
            'position'=> $request->position,
            'message'=> $request->message,

            ]);
         }
         $notification = array(
            'message' => 'Testimonial Updated Successfully Without Image',
            'alert-type' => 'success',
           );

           return redirect()->route('all.testimonials')->with($notification);
    }

    public function DeleteTestimonials($id){
        $testimonials = Testimonial::findorfail($id);
        $img = $testimonials->image;
        unlink($img);
        Testimonial::findorfail($id)->delete();
        $notification = array(
            'message' => 'Testimonial Deleted Successfully ',
            'alert-type' => 'success',
           );

           return redirect()->route('all.testimonials')->with($notification);
    }
}