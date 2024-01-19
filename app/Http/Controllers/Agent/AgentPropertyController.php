<?php

namespace App\Http\Controllers\Agent;

use Carbon\Carbon;
use App\Models\User;
use App\Models\State;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Schedule;
use App\Models\Amenities;
use App\Mail\ScheduleMail;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\PropertyMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class AgentPropertyController extends Controller
{
    public function AgentAllProperties(){
        $id = Auth::user()->id;
        $properties = Property::where('agent_id',$id)->latest()->get();
        return view('Agent.property.all_properties',compact('properties'));

    }

    public function AgentAddProperties(){
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();
        $id = Auth::user()->id;
        $property = User::where('role','agent')->where('id',$id)->first();
        $pcount = $property->credit;

        if($pcount == 1 || $pcount == 7){
            return redirect()->route('buy.package');
        }
        else{
        return view('Agent.property.add_properties',compact('propertytype','amenities','pstate'));
    }
}

    public function AgentStoreProperties(request $request)
    {
    //    $request->validate([

    //        'ptype_id' => 'required',
    //        'property_name' => 'required',
    //        'property_status' => 'required',
    //        'lowest_price' => 'required',
    //        'max_price' => 'required',
    //        'property_thambnail' => 'required',
    //        'multi_img' => 'required',
    //        'bedrooms' => 'required',
    //        'bathrooms' => 'required',
    //        'garage' => 'required',
    //        'garage_size' => 'required',
    //        'address' => 'required',
    //        'city' => 'required',
    //        'state' => 'required',
    //        'postal_code' => 'required',
    //        'propery_size' => 'required',
    //        'neighborhood' => 'required',
    //        'latitude' => 'required',
    //        'longtitude' => 'required',
    //        'amenities_id' => 'required',
    //        'agent_id' => 'required',
    //        'short_desc' => 'required',
    //        'long_desc' => 'required',
    //        'facility_name' => 'required',
    //        'distance' => 'required',
    //    ]);

        $id = Auth::user()->id;
        $uid = User::findorfail($id);
        $nid = $uid->credit;

        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        $pcode = IdGenerator::generate(['table' =>'properties', 'field' => 'property_code','length'=> 5,'prefix' =>'PC']);
        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image.'.webp';
        Image::make($image)->encode('webp')->resize(370,250)->save('upload/property/thambnail/'.$name_gen);
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
            'agent_id' =>Auth::user()->id,
            'status' => 1,
            'property_thambnail' => $save_url,
            'created_at' => Carbon::now(),


           ]);
           // Begin Multiple Image Upload

           $images = $request->file('multi_img');
           foreach($images as $img){
            $make_name = hexdec(uniqid()).'.'.$img.'.webp';
            Image::make($img)->encode('webp')->resize(770,520)->save('upload/property/multi_image/'.$make_name);
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

           User::where('id',$id)->update([
            'credit'=>DB::raw('1 +'.$nid),
           ]);

           $notification = array(
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('agent.all.properties')->with($notification);
    }

    public function AgentEditProperties($id){
        $properties = Property::findorfail($id);
        $facilities = Facility::where('property_id',$id)->get();
        $type = $properties->amenities_id;
        $properties_amenities = explode(',',$type);
        $multiImage = MultiImage::where('property_id',$id)->get();
        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $pstate = State::latest()->get();

        return view('Agent.property.edit_properties',compact('properties','propertytype','amenities','properties_amenities','multiImage','facilities','pstate'));

       } //End Method

       public function AgentUpdateProperties(request $request){

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
            'agent_id' =>Auth::user()->id,
            'status' => 1,

            'updated_at' => Carbon::now(),

        ]);
        $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('agent.all.properties')->with($notification);



    } // End Method

    public function AgentUpdatePropertiesThambnail(request $request){

        $pro_id = $request->id;
        $oldImage = $request->old_img;

        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image.'.webp';
        Image::make($image)->encode('webp')->resize(370,250)->save('upload/property/thambnail/'.$name_gen);
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

           return redirect()->route('agent.all.properties')->with($notification);

    } // End Method

    public function AgentUpdatePropertiesMultiimage(request $request){

        // $request->validate([

        //     'multi_img[{{$img->id}}]'=>'required',
        // ]);
     $imgs = $request->multi_img;
     foreach($imgs as $id=>$img){
       $imgDel = MultiImage::findorfail($id);
       unlink($imgDel->photo_name);
       $make_name = hexdec(uniqid()).'.'.$img.'.webp';
       Image::make($img)->encode('webp')->resize(770,520)->save('upload/property/multi_image/'.$make_name);
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

       return redirect()->route('agent.all.properties')->with($notification);

    } // End Method

    public function AgentDeletePropertiesMultiimage($id){

        $oldImg = MultiImage::findorfail($id);
        unlink($oldImg->photo_name);
        MultiImage::findorfail($id)->delete();

        $notification = array(
        'message' => 'Property Multi Image Deleted Successfully',
        'alert-type' => 'success',
       );

       return redirect()->route('agent.all.properties')->with($notification);

    } // End Method
    public function AgentStoreNewMultiimage(request $request){

        $new_multi = $request->imageid;
        $image = $request->file('multi_img');

        $make_name = hexdec(uniqid()).'.'.$image.'.webp';
        Image::make($image)->encode('webp')->resize(770,520)->save('upload/property/multi_image/'.$make_name);
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

           return redirect()->route('agent.all.properties')->with($notification);

    } // End Method

    public function AgentUpdatePropertiesFacilities(request $request){

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

               return redirect()->route('agent.all.properties')->with($notification);
        }  // End Method

        public function AgentDetailsProperties($id){

            $properties = Property::findorfail($id);
            $facilities = Facility::where('property_id',$id)->get();
            $type = $properties->amenities_id;
            $properties_amenities = explode(',',$type);
            $multiImage = MultiImage::where('property_id',$id)->get();
            $propertytype = PropertyType::latest()->get();
            $amenities = Amenities::latest()->get();


            return view('Agent.property.details_property',compact('properties','propertytype','amenities','properties_amenities','multiImage','facilities'));

           } //End Method

           public function AgentDeleteProperties($id){


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

               return redirect()->route('agent.all.properties')->with($notification);
        } // End Method

        public function BuyPackage(){
            return view('Agent.package.buy_package');
        }

        public function BuyBuisnessPlan(){
            $id = Auth::user()->id;
            $data = User::findorfail($id);
            return view('Agent.package.business_plan',compact('data'));
        }

        public function StoreBuisnessPlan(request $request){

            $id = Auth::user()->id;
            $uid = User::findorfail($id);
            $nid = $uid->credit;
            PackagePlan::insert([

            'user_id' =>$id,
            'package_name' => 'Buisness',
            'Package_credit' => '3',
            'invoice' => 'ERS'.mt_rand(10000000,999999999),
            'package_amount' => '20',
            'created_at' => Carbon::now(),
        ]);

        User::where('id',$id)->update([
            'credit' => DB::raw('3 +'.$nid),
        ]);

        $notification = array(
            'message' => 'You have Purchases Buisness Package Successfully',
            'alert-type' => 'success',
           );

           return redirect()->route('agent.all.properties')->with($notification);
    } // End Method

    public function BuyProfessionalPlan(){
        $id = Auth::user()->id;
        $data = User::findorfail($id);
        return view('Agent.package.professional_plan',compact('data'));
    }

    public function StoreProfessionalPlan(request $request){

        $id = Auth::user()->id;
        $uid = User::findorfail($id);
        $nid = $uid->credit;
        PackagePlan::insert([

        'user_id' =>$id,
        'package_name' => 'Professional',
        'Package_credit' => '10',
        'invoice' => 'ERS'.mt_rand(10000000,999999999),
        'package_amount' => '20',
        'created_at' => Carbon::now(),
    ]);

    User::where('id',$id)->update([
        'credit' => DB::raw('10 +'.$nid),
    ]);

    $notification = array(
        'message' => 'You have Purchases Professional Package Successfully',
        'alert-type' => 'success',
       );

       return redirect()->route('agent.all.properties')->with($notification);
    }

    public function HistoryPackage(){

        $id = Auth::user()->id;
        $packagehistory = PackagePlan::where('user_id',$id)->get();
        return view('Agent.package.package_history',compact('packagehistory'));
    }

    public function AgentPackageInvoice($id){

        $packagehistory = PackagePlan::where('id',$id)->first();
        $pdf = Pdf::loadView('Agent.package.package_history_invoice',compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir'=>public_path(),
            'chroot'=>public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function AgentPropertyMessage(){

        $id = Auth::user()->id;
        $usermsg = PropertyMessage::where('agent_id',$id)->get();
        return view('agent.message.all_message',compact('usermsg'));
    }
    public function AgentMessageDetails($id){

        $uid = Auth::user()->id;
        $usermsg = PropertyMessage::where('agent_id',$uid)->get();

        $msgdetails = PropertyMessage::findOrFail($id);
        return view('agent.message.message_details',compact('usermsg','msgdetails'));

    }// End Method

    public function AgentScheduleRequest(){

        $id = Auth::user()->id;
        $usermsg = Schedule::where('agent_id',$id)->get();
        return view('agent.schedule.schedule_request',compact('usermsg'));
    }

    public function AgentDetailsSchedule($id){

        $schedule = Schedule::findorfail($id);
        return view('agent.schedule.schedule_details',compact('schedule'));
    }

    public function AgentUpdateSchedule(request $request){

        $sid = $request->id;
        Schedule::findorfail($sid)->update([
            'status' => '1',
        ]);

        $notification = array(
            'message' => 'Schedule Confirmed Successfully',
            'alert-type' => 'success',
           );

           //// Send Mail
           $sendmail = Schedule::findorfail($sid);

           $data = [
            'tour_date' => $sendmail->tour_date,
            'tour_time' => $sendmail->tour_time,

           ];

           Mail::to($request->email)->send(new ScheduleMail($data));

           //// End Sending Mail

           return redirect()->route('agent.schedule.request')->with($notification);
    }
    }