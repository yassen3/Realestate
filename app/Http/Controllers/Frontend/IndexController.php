<?php

namespace App\Http\Controllers\Frontend;

use App\Models\State;
use App\Models\Facility;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PropertyMessage;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function PropertyDetails($id,$slug){
        $multiImage = MultiImage::where('property_id',$id)->get();
        $property = Property::findorfail($id);
        $amenities = $property->amenities_id;
        $property_amen = explode(',',$amenities);
        $facilites = Facility::where('property_id',$id)->get();
        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id',$type_id)->where('id','!=',$id)->orderby('id','DESC')->limit(3)->get();
      return view('Frontend.property.property_details',compact('property','multiImage','property_amen','facilites','relatedProperty'));
    }

    public function PropertyMessage(request $request){

        $pid = $request->property_id;
        $aid = $request->agent_id;

        if(Auth::check()){

            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $aid,
                'property_id' => $pid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Message Send Successfully ',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        else{
            $notification = array(
                'message' => 'Please Login First ',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function AgentDetails($id){
        $agent = User::findOrFail($id);
        $property = Property::where('agent_id',$id)->get();
        $featured = Property::where('featured','1')->limit(3)->get();
        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        return view('frontend.agent.agent_details',compact('agent','property','featured','rentProperty','buyProperty'));
    }

    public function AgentDetailsMessage(request $request)
    {
        $aid = $request->agent_id;
        if(Auth::check()){
            PropertyMessage::insert([
               'user_id'=> Auth::user()->id,
               'agent_id'=> $aid,
               'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Message Send Successfully ',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        else{
            $notification = array(
                'message' => 'Please Login First ',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);

        }
    }

    public function RentProperty(){
        $property = Property::where('status','1')->where('property_status','rent')->paginate(4);
        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        return view('frontend.property.rent_property',compact('property','rentProperty','buyProperty'));
    }

    public function BuyProperty(){
        $property = Property::where('status','1')->where('property_status','buy')->paginate(4);
        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        return view('frontend.property.buy_property',compact('property','rentProperty','buyProperty'));
    }

    public function PropertyType($id){
        $property = Property::where('status','1')->where('ptype_id',$id)->paginate(2);
        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        $p_type = PropertyType::where('id',$id)->first();
        return view('frontend.property.property_type',compact('property','rentProperty','buyProperty','p_type'));
    }

    public function StateDetails($id){
        $property = Property::where('status','1')->where('state',$id)->paginate(2);
        $bstate = State::where('id',$id)->first();
        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        return view('frontend.property.state_property',compact('property','bstate','rentProperty','buyProperty'));
    }

    public function BuyPropertySearch(request $request){

        $item = $request->search;
        $sstate = $request->state;
        $stype = $request->ptype_id;
        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        $property = Property::where('property_name','LIKE','%'.$item.'%')->where('property_status','buy')
        ->with('type','pstate')->whereHas('pstate',function($q) use ($sstate){
            $q->where('state_name','like','%'.$sstate.'%');
        })
        ->whereHas('type',function($q) use ($stype){
            $q->where('type_name','like','%'.$stype.'%');
        })
        ->paginate(5);
        return view('frontend.property.property_search',compact('property','rentProperty','buyProperty'));
    }

    public function RentPropertySearch(request $request){
        $item = $request->search;
        $sstate = $request->state;
        $stype = $request->ptype_id;

        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        $property = Property::where('property_name','like','%'.$item. '%')->where('property_status','rent')
        ->with('type','pstate')->whereHas('pstate',function($q) use ($sstate){
            $q->where('state_name','like','%'.$sstate.'%');
        })
        ->whereHas('type',function($q) use ($stype){
            $q->where('type_name','like','%'.$stype.'%');
        })
        ->paginate(5);
        return view('frontend.property.property_search',compact('property','rentProperty','buyProperty'));
    }

    public function AllPropertySearch(request $request){

        $property_status = $request->property_status;
        $sstate = $request->state;
        $stype = $request->ptype_id;
        $rooms = $request->rooms;
        $bathrooms = $request->bathrooms;

        $rentProperty = Property::where('property_status','rent')->get();
        $buyProperty = Property::where('property_status','buy')->get();
        $property = Property::where('status','1')->where('property_status',$property_status)->where('bedrooms',$rooms)->where('bathrooms',$bathrooms)
        ->with('type','pstate')->whereHas('pstate',function($q) use ($sstate){
            $q->where('state_name','like','%'.$sstate.'%');
        })
        ->whereHas('type',function($q) use ($stype){
            $q->where('type_name','like','%'.$stype.'%');
        })
        ->paginate(5);
        return view('frontend.property.property_search',compact('property','rentProperty','buyProperty'));
    }

    public function StoreSchedule(request $request){

        $aid = $request->agent_id;
        $pid = $request->property_id;
        if(Auth::check()) {

          Schedule::insert([

            'user_id' => Auth::user()->id,
            'property_id' => $pid,
            'agent_id' => $aid,
            'tour_date' => $request->tour_date,
            'tour_time' => $request->tour_time,
            'message' => $request->message,
            'created_at' => Carbon::now(),
          ]);

          $notification = array(
            'message' => 'Request Sent Successfully',
            'alert-type' => 'success',
          );
           return redirect()->back()->with($notification);
        }
        else{
            $notification = array(
                'message' => 'Please Login First',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }
}