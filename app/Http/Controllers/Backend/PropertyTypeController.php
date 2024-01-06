<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use App\Models\Amenities;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function AllType(){
        $types = PropertyType::latest()->get();
        return view('backend.type.all_type',compact('types'));
    }
    public function AddType(){

        return view('backend.type.add_type');
    }

    public function StoreType(request $request){
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required',
        ]);
        PropertyType::create([
            'type_name' =>$request->type_name,
            'type_icon' =>$request->type_icon,
        ]);
        $notification = array(
            'message' => 'Property Type Addedd Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.type')->with($notification);
    }
    public function EditType(string $id){
        $types = PropertyType::findorfail($id);
        return view('backend.type.edit_type',compact('types'));
    }

    public function UpdateType(Request $request)
    {
        $prop_id = $request->id;
        $types = PropertyType::findorfail($prop_id);
        $types->update([
            'type_name' =>$request->type_name,
            'type_icon' =>$request->type_icon,
        ]);
        $notification = array(
            'message' => 'Property Type Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.type')->with($notification);


    }
    public function DeleteType($id){

        PropertyType::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method

    //// End ProppertyType /////

    // Begin Amenties//
    public function AllAmenities(){
        $amenities = Amenities::latest()->get();
        return view('backend.amenities.all_amenities',compact('amenities'));
    }

    public function StoreAmenities(request $request)
    {
        $request->validate([
            'amenities_name' => 'required|max:200',

        ]);
        Amenities::create([
            'amenities_name' =>$request->amenities_name,

        ]);

        $notification = array(
            'message' => 'Amenities Added Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.amenities')->with($notification);
    }

    public function EditAmenities($id){
        $amenities = Amenities::findorfail($id);
        return view('backend.amenities.edit_amenitie',compact('amenities'));
    }

    public function UpdateAmenities(Request $request)
    {
        $prop_id = $request->id;
        $amenities = Amenities::findorfail($prop_id);
        $amenities->update([
            'amenities_name' =>$request->amenities_name,

        ]);
        $notification = array(
            'message' => 'Amenities Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.amenities')->with($notification);

    }

    public function DeleteAmenities($id)
    {
        Amenities::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Amenitie Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    }