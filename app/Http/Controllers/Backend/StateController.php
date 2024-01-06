<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class StateController extends Controller
{
    public function AllState(){
        $state = State::latest()->get();
        return view('backend.state.all_state',compact('state'));
    }

    public function AddState(){
        return view('backend.state.add_state');
    }

    public function StoreState(request $request){
        $request->validate([
            'state_name' => 'required|unique:states|max:200',
            'state_image' => 'required|image',
        ]);
        $image = $request->file('state_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,275)->save('upload/state/'.$name_gen);
        $save_url = 'upload/state/'.$name_gen;
        State::insert([
            'state_name'=> $request->state_name,
            'state_image'=> $save_url,
        ]);
        $notification = array(
            'message' => 'State Inserted Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.state')->with($notification);

    }

    public function EditState($id){
        $state = State::findorfail($id);
        return view('backend.state.edit_state',compact('state'));
    }

    public function UpdateState(Request $request){
        $state_id = $request->id;
         if($request->file('state_image')){
            $image = $request->file('state_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,275)->save('upload/state/'.$name_gen);
        $save_url = 'upload/state/'.$name_gen;
        State::findorfail($state_id)->update([
            'state_name'=> $request->state_name,
            'state_image'=> $save_url,
        ]);
        $notification = array(
            'message' => 'State Updated Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.state')->with($notification);
         }
         else{
            State::findorfail($state_id)->update([
                'state_name'=> $request->state_name,

            ]);
         }
         $notification = array(
            'message' => 'State Updated Successfully Without Image',
            'alert-type' => 'success',
           );

           return redirect()->route('all.state')->with($notification);
    }

    public function DeleteState($id){
        $state = State::findorfail($id);
        $img = $state->state_image;
        unlink($img);
        State::findorfail($id)->delete();
        $notification = array(
            'message' => 'State Deleted Successfully ',
            'alert-type' => 'success',
           );

           return redirect()->route('all.state')->with($notification);
    }
    }