<?php

namespace App\Http\Controllers\frontend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function AddToWishList(Request $request, $property_id){

        if(Auth::check()){

            $exists = Wishlist::where('user_id',Auth::id())->where('property_id',$property_id)->first();

            if (!$exists) {
                Wishlist::insert([
                'user_id' => Auth::id(),
                'property_id' => $property_id,
                'created_at' => Carbon::now()
                ]);
                return response()->json(['success' => 'Successfully Added On Your Wishlist']);
            }else{
                return response()->json(['error' => 'This Property Has Already in your WishList']);
            }

        }else{
            return response()->json(['error' => 'At First Login Your Account']);
        }


    } // End Method

    public function UserWishlist(){
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.dashboard.wishlist',compact('userData'));
    }

    public function GetWishlistProperty(){
        $wishlist = WishList::with('property')->where('user_id',Auth::id())->latest()->get();
        $wishQty = WishList::count();

        return response()->json(['wishlist' => $wishlist, 'wishQty' => $wishQty]);

    }

    public function WishlistRemove($id){

        wishlist::where('user_id',Auth::id())->where('id',$id)->delete();
        return response()->json(['success' => 'Property Removed Successfully From Your Wishlist']);
    }


}