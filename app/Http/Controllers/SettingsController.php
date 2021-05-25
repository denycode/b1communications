<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Library\Ajax;
use App\Library\AjaxSideLayout;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Permissions;
use App\Model\Profile;
use App\Model\ProfileMaster;
use App\Model\Setting;
use App\Model\Organization;
use App\Model\Server;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Crypt;

use \Illuminate\Support\Facades\View as View;

class SettingsController extends Controller
{
    public function index(Ajax $ajax){
        if(!Helper::CheckPermission('settings','users','view') && !Auth::user()->IsAdmin){
            return view('layouts.error.404');
        }else{
            return view('settings.index');
        }
    }

    public function getSettings(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $page = $request->input('page',1);
        $record_per_page = config('constant.record_per_page');
        $start_from = ($page-1) * $record_per_page;
        if($tabid == Setting::USERS){
            $users = User::skip($start_from)
                ->take($record_per_page)
                ->get();
            $total_users = User::count();

            $html = View::make('settings.users.table',['users' => $users,'total_users' => $total_users])->render();
            return $ajax->success()
                ->appendParam('html',$html)
                ->jscallback('load_ajax_tab')
                ->response();
        }
        elseif ($tabid == Setting::PROFILE_MASTER){

            $profiles = Profile::skip($start_from)
                ->take($record_per_page)
                ->get();
            $total_profiles = Profile::count();

            $html = View::make('settings.profile_master.table',['profiles' => $profiles,'total_profiles' => $total_profiles])->render();
            return $ajax->success()
                ->appendParam('html',$html)
                ->jscallback('load_ajax_tab')
                ->response();
        }
    }

    public function addUser($end_uid,Ajax $ajax){
        $uid = Crypt::decrypt($end_uid);
        $profiles = Profile::where('is_active',1)
            ->get();

        $title = ($uid == '0') ? 'Add User' : 'Edit User';
        $user = array();
        $organization_server = '';
        if($uid != '0'){
            $user = User::where('id',$uid)->first();
            $organization = Organization::find($user->organization_id);
            $organization_server = $organization->server_ID;
        }
        //dd($user);
        
        
        $servers = \App\Model\Server::where('is_active',1)->get();
        $Organization = \App\Model\Organization::where('is_active',1)->get()->toArray();
        //dd($Organization);
        $content = View::make('settings.forms.adduser',['profiles' => $profiles,'user' => $user,'servers' => $servers, 'server_id' => $organization_server, 'Organizations' => $Organization])->render();

        $sdata = [
            'content' => $content
        ];
        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.side-popup-layout', $sdata);
        $html = $view->render();


        return $ajax->success()->appendParam('html',$html)->jscallback('loadSideLayout')->response();
    }

    public function postUser(Request $request, Ajax $ajax){
        $userId = $request->input('id') != '0' ? ','.$request->input('id') : '';
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email'.$userId,
            'phone' => 'required',
            'organization_id' => 'required',
            'profile_id' => 'required',
        ];
        if(empty($userId) || !empty(trim($request->input('password')))){
            $rules = [
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6',
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
            if(
                !empty(trim($request->input('password'))) &&
                (trim($request->input('password')) != trim($request->input('confirm_password')))
            ){
                $validator->errors()->add('confirm_password', 'Confirm Password doesn\'t match with password');
            }
        });
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }

        if($request->input('id') != '0'){
            $user = User::where('id',$request->input('id'))->first();
            //$user->profile_id = $user->profile_id;
            $ajax->message('User Updated Successfully');
        }else{
            $user = new User();
            $ajax->message('User Created Successfully');
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->profile_id = (Auth::user()->IsAdmin) ? $request->profile_id : User::ENDUSER;
        }
        $user->password =  !empty(trim($request->input('password'))) ? bcrypt(trim($request->input('password'))) : ($request->input('id') != '0') ? $user->password : bcrypt(123456);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->organization_id = $request->organization_id;
        $user->country = $request->country;
        $user->is_active = $request->is_active ? $request->is_active : 0;;
        $user->profile_id = (Auth::user()->IsAdmin) ? $request->profile_id : User::ENDUSER;
        $user->save();

        return $ajax->success()
            ->jscallback('ajax_profile_load')
            ->reload_page()
            ->response();
    }

    public function addProfile($enc_pid, Ajax $ajax){
        $pid = Crypt::decrypt($enc_pid);
        $title = ($pid == '0') ? 'Add Profile' : 'Edit Profile';
        $profile = array();


        if($pid != '0'){
            $profile = Profile::where('profile_id',$pid)->first();
        }

        $content = View::make('settings.forms.addprofile',['profile' => $profile])->render();

        $sdata = [
            'content' => $content
        ];
        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.side-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()->appendParam('html',$html)->jscallback('loadSideLayout')->response();
    }

    public function postProfile(Request $request, Ajax $ajax){
        $profileId = $request->input('id') != '0' ? ','.$request->input('id') : '';
        $rules = [
            'profile_name' => 'required|unique:profiles,profile_name'.$profileId
        ];

        $messages = [
            'profile_name.required' => 'Profile name is required',
            'profile_name.unique' => 'Profile name already in use'

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }


        if($request->input('profile_id') != '0'){
            $profile = Profile::where('profile_id',$request->input('profile_id'))->first();
            $ajax->message('Profile Updated Successfully');
        }else{
            $profile = new Profile();
            $profile->profile_id = 'P'.time();
            $ajax->message('Profile Created Successfully');
        }

        $profile->profile_name = $request->profile_name;
        $profile->is_active = $request->is_active ? $request->is_active : 0;
        $profile->save();

        return $ajax->success()
            ->jscallback('ajax_profile_load')
            ->reload_page()
            ->response();
    }

    public function changeProfileStatus($enc_pid,Request $request,Ajax $ajax){
        /*if(!Auth::user()->IsSuperAdmin){
            return view('layouts.error_pages.404');
        }*/

        $pid = Crypt::decrypt($enc_pid);
        $profile = Profile::where('profile_id',$pid)->first();
        $sStatusToggle = $profile->is_active == 1 ? 0 : 1;
        if(!$profile){
            return $ajax->fail()
                ->message('Profile not found !')
                ->jscallback()
                ->response();
        }
        Profile::where('profile_id',$pid)->update(['is_active' => $sStatusToggle]);
        $statusText  = $profile->is_active == 1 ? 'InActive' : 'Active';
        return $ajax->success()
            ->message('Profile '.$statusText)
            ->appendParam('is_active', $sStatusToggle)
            ->jscallback('ajax_status_toggle')
            ->response();
    }

    public function changeUserStatus($enc_uid,Request $request,Ajax $ajax){
        /*if(!Auth::user()->IsSuperAdmin){
            return view('layouts.error_pages.404');
        }*/

        $uid = Crypt::decrypt($enc_uid);
        $user = User::where('id',$uid)->first();
        $sStatusToggle = $user->is_active == 1 ? 0 : 1;
        if(!$user){
            return $ajax->fail()
                ->message('User not found !')
                ->jscallback()
                ->response();
        }
        User::where('id',$uid)->update(['is_active' => $sStatusToggle]);
        $statusText  = $user->is_active == 1 ? 'InActive' : 'Active';
        return $ajax->success()
            ->message('User '.$statusText)
            ->appendParam('is_active', $sStatusToggle)
            ->jscallback('ajax_status_toggle')
            ->response();
    }

    public function trashUser($enc_uid,Request $request,Ajax $ajax){
        /*if(!Auth::user()->IsSuperAdmin){
            return view('layouts.error_pages.404');
        }*/

        $uid = Crypt::decrypt($enc_uid);
        $user = User::where('id',$uid)->first();
        if(!$user){
            return $ajax->fail()
                ->message('User not found !')
                ->jscallback()
                ->response();
        }
        User::where('id',$uid)->delete();
       return $ajax->success()
            ->message('User Trashed')
            ->jscallback('ajax_profile_load')
            ->response();
    }

    public function trashProfile($enc_pid,Request $request,Ajax $ajax){
        /*if(!Auth::user()->IsSuperAdmin){
            return view('layouts.error_pages.404');
        }*/

        $pid = Crypt::decrypt($enc_pid);
        $profile = Profile::where('profile_id',$pid)->first();
        if(!$profile){
            return $ajax->fail()
                ->message('Profile not found !')
                ->jscallback()
                ->response();
        }
        Profile::where('profile_id',$pid)->delete();
         return $ajax->success()
            ->message('Profile Trashed')
            ->jscallback('ajax_profile_load')
            ->response();
    }


    public function profilePermissions($enc_pid, Ajax $ajax){
        $pid = Crypt::decrypt($enc_pid);
        $profile = Profile::where('profile_id',$pid)->first();
        $title = isset($profile) ? $profile->profile_name.' Profile Permissions' : 'Profile Permissions';
        $DBpermissions = Permissions::where('profile_id',$pid)->get();
        $content = View::make('settings.forms.profile-permissions',['DBpermissions' => $DBpermissions,'profileid'=>$pid])->render();
        $sdata = [
            'content' => $content
        ];
        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.side-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html',$html)
            ->appendParam('DBpermissions',$DBpermissions)
            ->jscallback('loadSideLayout')
            ->response();
    }

    public function updatePermissions(Request $request,Ajax $ajax){
        $profile_id = $request->input('profile_id');
        Permissions::where('profile_id',$profile_id)->update(['is_rights' => 0]);
        $permissions = $request->input('permissions');
        foreach ($permissions as $module=>$permission){
            if(isset($permission['rights'])){
                foreach ($permission['rights'] as $rightname => $right){
                    $pr = Permissions::where('profile_id',$profile_id)
                        ->where('module',$module)
                        ->where('rights_name',$rightname)
                        ->where('parents',$permission['parents'])
                        ->first();
                    if(!$pr){
                        unset($pr);
                        $pr = new Permissions();
                    }

                    $pr->permission_id = time().mt_rand(10,1000);
                    $pr->profile_id = $profile_id;
                    $pr->module = $module;
                    $pr->rights_name = $rightname;
                    $pr->is_rights = $right;
                    $pr->parents = $permission['parents'];
                    $pr->save();
                }
            }

        }

        return $ajax->success()
            ->message('Profile Updated')
            ->jscallback('ajax_profile_load')
            ->response();

    }

}
