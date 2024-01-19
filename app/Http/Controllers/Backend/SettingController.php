<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function SmtpSetting(){
        $setting = SmtpSetting::find(1);
        return view('backend.setting.smtp_update',compact('setting'));
    }

    public function UpdateSmtpSetting(Request $request){

        $stmp_id = $request->id;

        SmtpSetting::findOrFail($stmp_id)->update([

                'mailer' => $request->mailer,
                'host' => $request->host,
                'post' => $request->post,
                'username' => $request->username,
                'password' => $request->password,
                'encryption' => $request->encryption,
                'from_address' => $request->from_address,
                'updated_at' =>Carbon::now()
        ]);


           $notification = array(
            'message' => 'Smtp Setting Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);



    }// End Method

    public function SiteSetting(){

        $siteSettings = SiteSetting::findorfail(1);
        return view('backend.setting.site_setting',compact('siteSettings'));
    }

    public function UpdateSiteSetting(request $request){

        $site_id = $request->id;
        if($request->file('logo')){
           $image = $request->file('logo');
       $name_gen = hexdec(uniqid()).'.webp';
       Image::make($image)->encode('webp')->resize(1800,386)->save('upload/logo/'.$name_gen);
       $save_url = 'upload/logo/'.$name_gen;
       SiteSetting::findorfail($site_id)->update([
         'support_phone'=> $request->support_phone,
         'company_address'=> $request->company_address,
         'email'=> $request->email,
         'facebook'=> $request->facebook,
         'twitter'=> $request->twitter,
         'copyright'=> $request->copyright,
         'logo'=> $save_url,
       ]);
       $notification = array(
           'message' => 'Site Setting Updated Successfully with Logo',
           'alert-type' => 'success',
          );

          return redirect()->back()->with($notification);
        }
        else{
           SiteSetting::findorfail($site_id)->update([

            'support_phone'=> $request->support_phone,
            'company_address'=> $request->company_address,
            'email'=> $request->email,
            'facebook'=> $request->facebook,
            'twitter'=> $request->twitter,
            'copyright'=> $request->copyright,

           ]);
        }
        $notification = array(
           'message' => 'Site Setting Updated Successfully Without Logo',
           'alert-type' => 'success',
          );

          return redirect()->back()->with($notification);
    }
}