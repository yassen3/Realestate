<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Compare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    public function AddToCompare(Request $request, $property_id){

        if(Auth::check()){

            $exists = Compare::where('user_id',Auth::id())->where('property_id',$property_id)->first();

            if (!$exists) {
                Compare::insert([
                'user_id' => Auth::id(),
                'property_id' => $property_id,
                'created_at' => Carbon::now()
                ]);
                return response()->json(['success' => 'Successfully Added On Your Compare List']);
            }else{
                return response()->json(['error' => 'This Property Has Already in your Compare List']);
            }

        }else{
            return response()->json(['error' => 'At First Login Your Account']);
        }


    } // End Method

    public function UserCompare(){

        return view('frontend.dashboard.compare');
    } // End Method

    public function GetCompareProperty(){
        $compare = Compare::with('property')->where('user_id',Auth::id())->latest()->get();

        return response()->json($compare);

    }// End Method

    public function compareRemove($id){

        Compare::where('user_id',Auth::id())->where('id',$id)->delete();
        return response()->json(['success' => 'Property Removed Successfully From Your Compare List']);
    } // End Method

}