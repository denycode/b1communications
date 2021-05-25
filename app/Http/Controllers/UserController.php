<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Library\Ajax;
use App\Model\Attachment;
use App\Model\UserDetail;
use App\Model\UserMeta;
use App\User;
use Illuminate\Http\Request;
use Crypt;
use Validator;
use Auth;

class UserController extends Controller
{
    public function viewProfile($enc_uid){
        $uid = Crypt::decrypt($enc_uid);
        $user = User::where('u_dataid',$uid)->withCount('customers')->first();
        if(!$user){
            return view('layouts.error_pages.404');
        }
        return view('users.profile',['user' => $user]);
    }

    public function updateProfile(Request $request,Ajax $ajax){
        $rules = [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required',
            'phone_no' => 'required'
        ];

        $messages = [
            'first_name.required' => 'First name is required',
            'first_name.min' => 'First name is min 3 characters',
            'first_name.max' => 'First name is max 50 characters',
            'last_name.required' => 'Last name is required',
            'phone_no.required' => 'Phone Number is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }
        $udCount = UserDetail::where('u_dataid', '=', $request->input('u_dataid'))->count();
        $UDdata = [
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'zip_code' => $request->input('zip_code'),
            'phone_no' => $request->input('phone_no'),
            'about_me' => $request->input('about_me'),
            'country' => $request->input('country')
        ];
        if($udCount > 0){
            $user = User::where('u_dataid',$request->input('u_dataid'))->first();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->save();

            UserDetail::where('u_dataid', '=', $request->input('u_dataid'))
                ->update($UDdata);
        }

        return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->redirectTo('/profile/'.Crypt::encrypt($request->input('u_dataid')))
            ->message('Profile Updated Successfully')
            ->response();
    }

    public function updateUserMeta(Request $request,Ajax $ajax){
        $userMeta = UserMeta::where('user_id',Auth::id())->where('meta_key',$request->input('meta_key'))->count();
        if($userMeta > 0){
            UserMeta::where('user_id',Auth::id())->where('meta_key',$request->input('meta_key'))->update(['meta_value' => $request->input('meta_value')]);
        }else{
            UserMeta::insert([
                'id' => Auth::id(),
                'meta_key' => $request->input('meta_key'),
                'meta_value' => $request->input('meta_value')
            ]);
        }

        return $ajax->success()
            ->message('Theme Updated')
            ->response();
    }

    public function updateProfileImage(Request $request,Ajax $ajax){
        $rules = [
            'user_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $messages = [
            'user_image.required' => 'Please select image'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }

        if($request->hasfile('user_image'))
        {
            $destinationPath = public_path('/ds_attachments/users/'.Auth::user()->FullName.'/');

            $uploadedData = FileUpload::uploadSingle($request->file('user_image'),$destinationPath,1);
            if(!empty($uploadedData)){
                $attachment = Attachment::where('type_id',Auth::user()->u_dataid)->where('type','user')->first();
                if($attachment){
                    Attachment::where('type_id',Auth::user()->u_dataid)->where('type','user')->update($uploadedData);
                }else{
                    Attachment::insert($uploadedData);
                }
            }
        }
        return $ajax->success()
            ->message('Profile Image Updated Successfully')
            ->appendParam('u_img_pth',Auth::user()->ProfileImageThumb)
            ->jscallback('ajax_update_image')
            ->response();

        //echo '<pre>'; print_r($request->all()); die;
    }

    public function getOrganization(Request $request,Ajax $ajax){
        $id = $request->id;
        $Organization = \App\Model\Organization::where('server_ID',$id)->get();
        if ($Organization->isEmpty()) { 
            return $ajax->fail()
                        ->message('Organization not found')
                        ->appendParam('Organization',$Organization)
                        ->jscallback('ajax_organization_steps')
                        ->response();
        }else{
            return $ajax->success()
                ->appendParam('Organization',$Organization)
                ->jscallback('ajax_organization_steps')
                ->response();
        }
    }
}
