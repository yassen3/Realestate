<?php

namespace App\Http\Controllers\Backend;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Amenities;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PropertyMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rules\Unique;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PropertyController extends Controller
{
    public function AllProperty()
    {
        $properties = Property::latest()->get();
        return view('backend.property.all_property',compact('properties'));
    }

    public function AddProperties(){
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view('backend.property.add_property',compact('propertytype','amenities','activeAgent','pstate'));
    }

    public function StoreProperties(request $request)
     {
        // $request->validate([

        //     'ptype_id' => 'required',
        //     'property_name' => 'required',
        //     'property_status' => 'required',
        //     'lowest_price' => 'required',
        //     'max_price' => 'required',
        //     'property_thambnail' => 'required',
        //     'multi_img' => 'required',
        //     'bedrooms' => 'required',
        //     'bathrooms' => 'required',
        //     'garage' => 'required',
        //     'garage_size' => 'required',
        //     'address' => 'required',
        //     'city' => 'required',
        //     'state' => 'required',
        //     'postal_code' => 'required',
        //     'propery_size' => 'required',
        //     'neighborhood' => 'required',
        //     'latitude' => 'required',
        //     'longtitude' => 'required',
        //     'amenities_id' => 'required',
        //     'agent_id' => 'required',
        //     'short_desc' => 'required',
        //     'long_desc' => 'required',
        //     'facility_name' => 'required',
        //     'distance' => 'required',
        // ]);


        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        $pcode = IdGenerator::generate(['table' =>'properties', 'field' => 'property_code','length'=> 5,'prefix' =>'PC']);
        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thambnail/'.$name_gen);
        $save_url = 'upload/property/thambnail/'.$name_gen;


           $property_id = Property::insertGetId([

            'ptype_id' =>$request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' =>$request->property_name,
            'property_slug' =>strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' =>$pcode,
            'property_status' =>$request->property_status,

            'lowest_price' =>$request->lowest_price,
            'max_price' =>$request->max_price,
            'short_desc' =>$request->short_desc,
            'long_desc' =>$request->long_desc,
            'bedrooms' =>$request->bedrooms,
            'bathrooms' =>$request->bathrooms,
            'garage' =>$request->garage,
            'garage_size' =>$request->garage_size,

            'property_size' =>$request->property_size,
            'property_video' =>$request->property_video,
            'address' =>$request->address,
            'city' =>$request->city,
            'state' =>$request->state,
            'postal_code' =>$request->postal_code,

            'neighborhood' =>$request->neighborhood,
            'latitude' =>$request->latitude,
            'longtitude' =>$request->longtitude,
            'featured' =>$request->featured,
            'hot' =>$request->hot,
            'agent_id' =>$request->agent_id,
            'status' => 1,
            'property_thambnail' => $save_url,
            'created_at' => Carbon::now(),


           ]);
           // Begin Multiple Image Upload

           $images = $request->file('multi_img');
           foreach($images as $img){
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
            $uploadImages = 'upload/property/multi_image/'.$make_name;

            // $request->validate([
            //     'multi_img[]' => 'required',
            // ]);
            MultiImage::insert([

                'property_id'=>$property_id,
                'photo_name'=>$uploadImages,
                'created_at'=> Carbon::now()
            ]);
           }  // End Foreach
           // End Multiple Image Upload

           // Add Facility

            $facilities = Count($request->facility_name);
            if($facilities != NULL){
            for($i=0; $i< $facilities; $i++){
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            }
        }
           // End Facility

           $notification = array(
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.properties')->with($notification);

    }  // End Method


    public function EditProperties($id){
     $properties = Property::findorfail($id);
     $facilities = Facility::where('property_id',$id)->get();
     $type = $properties->amenities_id;
     $pstate = State::latest()->get();
     $properties_amenities = explode(',',$type);
     $multiImage = MultiImage::where('property_id',$id)->get();
     $propertytype = PropertyType::latest()->get();
     $amenities = Amenities::latest()->get();
     $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();

     return view('backend.property.edit_property',compact('properties','propertytype','amenities','activeAgent','properties_amenities','multiImage','facilities','pstate'));

    } //End Method


    public function UpdateProperties(request $request){

        // $request->validate([

        //     'ptype_id' => 'required',
        //     'property_name' => 'required',
        //     'property_status' => 'required',
        //     'lowest_price' => 'required',
        //     'max_price' => 'required',
        //     // 'property_thambnail' => 'required',
        //     // 'multi_img' => 'required',
        //     'bedrooms' => 'required',
        //     'bathrooms' => 'required',
        //     'garage' => 'required',
        //     'garage_size' => 'required',
        //     'address' => 'required',
        //     'city' => 'required',
        //     'state' => 'required',
        //     'postal_code' => 'required',
        //     'propery_size' => 'required',
        //     'neighborhood' => 'required',
        //     'latitude' => 'required',
        //     'longtitude' => 'required',
        //     'amenities_id' => 'required',
        //     'agent_id' => 'required',
        //     'short_desc' => 'required',
        //     'long_desc' => 'required',
        //     'facility_name' => 'required',
        //     // 'distance' => 'required',
        // ]);


        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        $property_id = $request->id;

        Property::findorfail($property_id)->update([
            'ptype_id' =>$request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' =>$request->property_name,
            'property_slug' =>strtolower(str_replace(' ', '-', $request->property_name)),

            'property_status' =>$request->property_status,

            'lowest_price' =>$request->lowest_price,
            'max_price' =>$request->max_price,
            'short_desc' =>$request->short_desc,
            'long_desc' =>$request->long_desc,
            'bedrooms' =>$request->bedrooms,
            'bathrooms' =>$request->bathrooms,
            'garage' =>$request->garage,
            'garage_size' =>$request->garage_size,

            'property_size' =>$request->property_size,
            'property_video' =>$request->property_video,
            'address' =>$request->address,
            'city' =>$request->city,
            'state' =>$request->state,
            'postal_code' =>$request->postal_code,

            'neighborhood' =>$request->neighborhood,
            'latitude' =>$request->latitude,
            'longtitude' =>$request->longtitude,
            'featured' =>$request->featured,
            'hot' =>$request->hot,
            'agent_id' =>$request->agent_id,
            'status' => 1,

            'updated_at' => Carbon::now(),

        ]);
        $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.properties')->with($notification);



    } // End Method

    public function UpdatePropertiesThambnail(request $request){

        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thambnail/'.$name_gen);
        $save_url = 'upload/property/thambnail/'.$name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }

        Property::findOrFail($pro_id)->update([

            'property_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Property Main Thambnail Updated Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.properties')->with($notification);

    } // End Method


    public function UpdatePropertiesMultiimage(request $request){

        // $request->validate([

        //     'multi_img[{{$img->id}}]'=>'required',
        // ]);
     $imgs = $request->multi_img;
     foreach($imgs as $id=>$img){
       $imgDel = MultiImage::findorfail($id);
       unlink($imgDel->photo_name);
       $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
       Image::make($img)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
       $uploadImages = 'upload/property/multi_image/'.$make_name;

       MultiImage::where('id',$id)->update([
        'photo_name' => $uploadImages,
        'updated_at' => Carbon::now(),
       ]);
     }
     $notification = array(
        'message' => 'Property Multi Image Updated Successfully',
        'alert-type' => 'success',
       );

       return redirect()->route('all.properties')->with($notification);

    } // End Method


    public function DeletePropertiesMultiimage($id){

        $oldImg = MultiImage::findorfail($id);
        unlink($oldImg->photo_name);
        MultiImage::findorfail($id)->delete();

        $notification = array(
        'message' => 'Property Multi Image Deleted Successfully',
        'alert-type' => 'success',
       );

       return redirect()->route('all.properties')->with($notification);

    } // End Method


    public function StoreNewMultiimage(request $request){

        $new_multi = $request->imageid;
        $image = $request->file('multi_img');

        $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
        $uploadImages = 'upload/property/multi_image/'.$make_name;

        MultiImage::insert([
            'property_id' => $new_multi,
            'photo_name' => $uploadImages,
            'created_at' =>Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Property Multi Image Added Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('all.properties')->with($notification);

    } // End Method

    public function UpdatePropertyFacilities(request $request){

        $pid = $request->id;
        if($request->facility_name == null) {
            return redirect()->back();
        }
        else{
        Facility::where('property_id',$pid)->delete();
        $facilities = Count($request->facility_name);

            for($i=0; $i < $facilities; $i++){
                $fcount = new Facility();
                $fcount->property_id = $pid ;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            }  // End For

            }
            $notification = array(
                'message' => 'Property Facility Updated Successfully',
                'alert-type' => 'success',
               );

               return redirect()->route('all.properties')->with($notification);
        }  // End Method


        public function DeleteProperties($id){


            $property = Property::findorfail($id);
            unlink($property->property_thambnail);

            Property::findorfail($id)->delete();

            $image = MultiImage::where('property_id',$id)->get();
            foreach($image as $img){
                unlink($img->photo_name);
                MultiImage::where('property_id',$id)->delete();
            }
            $facilitiesData = Facility::where('property_id',$id)->get();
            foreach($facilitiesData as $item){
                $item->facility_name;
                Facility::where('property_id',$id)->delete();
            }

            $notification = array(
                'message' => 'Property Deleted Successfully',
                'alert-type' => 'success',
               );

               return redirect()->route('all.properties')->with($notification);
        } // End Method

        public function DetailsProperties($id){

            $properties = Property::findorfail($id);
            $facilities = Facility::where('property_id',$id)->get();
            $type = $properties->amenities_id;
            $properties_amenities = explode(',',$type);
            $multiImage = MultiImage::where('property_id',$id)->get();
            $propertytype = PropertyType::latest()->get();
            $amenities = Amenities::latest()->get();
            $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();

            return view('backend.property.details_property',compact('properties','propertytype','amenities','activeAgent','properties_amenities','multiImage','facilities'));

           } //End Method

           public function InactiveProperties(request $request){

            $pid = $request->id;
            Property::findorfail($pid)->update([
                'status' => 0,
            ]);

            $notification = array(
                'message' => 'Property Inactive Successfully',
                'alert-type' => 'success',
               );

               return redirect()->route('all.properties')->with($notification);

           } //End Method

           public function activeProperties(request $request){

            $pid = $request->id;
            Property::findorfail($pid)->update([
                'status' => 1,
            ]);

            $notification = array(
                'message' => 'Property Activated Successfully',
                'alert-type' => 'success',
               );

               return redirect()->route('all.properties')->with($notification);

           } //End Method

           public function AdminPackageHistory(){

            $packagehistory = PackagePlan::latest()->get();
            return view('backend.package.package_history',compact('packagehistory'));
           }

           public function PackageInvoice($id){

            $packagehistory = PackagePlan::where('id',$id)->first();
            $pdf = Pdf::loadView('backend.package.package_history_invoice',compact('packagehistory'))->setPaper('a4')->setOption([
                'tempDir'=>public_path(),
                'chroot'=>public_path(),
            ]);
            return $pdf->download('invoice.pdf');
        }

        public function AdminPropertyMessage(){

        $usermsg = PropertyMessage::latest()->get();
        return view('backend.message.all_message',compact('usermsg'));
        }

        public function AdminMessageDetails($id){
            $uid = Auth::user()->id;
            $usermsg = PropertyMessage::latest()->get();

            $msgdetails = PropertyMessage::findOrFail($id);
            return view('backend.message.message_details',compact('usermsg','msgdetails'));
        }
    }
