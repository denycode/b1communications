<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Model\Announcementorganizationmapping;
use App\Model\Autoattendantorganizationmapping;
use App\Model\Timegrouporganizationmapping;
use App\Model\Timeconditionorganizationmapping;
use App\Model\Departmentorganizationmapping;
use App\Model\Extensionorganizationmapping;
use App\Model\Daynightorganizationmapping;
use App\Model\Organization;
use App\Model\Phoneorganizationmapping;
use App\Rules\DepartmentRange;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use DB;
use Config;
use Auth;
use Crypt;
use Validator;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\View as View;



class OrganizationController extends Controller
{

    public function index(){
        return view('organizations.index',[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)'
        ]);
    }

    public function getOrganizations(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $sort = $request->input('sort') ? $request->input('sort') : '';
        $dir = $request->input('dir') ? $request->input('dir') : '';
        $page = $request->input('page',1);
        $records_per_page = 5; //config('constant.record_per_page');
        $sort = ($sort == "") ? "Order By CampaignId DESC" : $sort == 'CampaignId' ? "Order By CampaignId DESC" : "Order By $sort $dir";
        $rType = $request->input('rtype','');
        $filters = $request->input('filters',[]);
        $position = ($page-1) * $records_per_page;

        try {
            $oOrganizations = \App\Model\Organization::skip($position)
                ->take($records_per_page)->orderBy('organization_name')
                ->get();

            $tTotalOrganizations = \App\Model\Organization::count();

            $tabName = 'Organizations';
            if($rType == 'pagination'){
                $html = View::make('organizations.tabs.list.table',['oOrganizations' => $oOrganizations,'tab' => $tabName])->render();
            }else{
                $html = View::make('organizations.tabs.list.index',['oOrganizations' => $oOrganizations,'tab' => $tabName])->render();
            }
            $paginationhtml = View::make('organizations.tabs.list.pagination-html',[
                'total_records' => $tTotalOrganizations,
                'records' => $oOrganizations,
                'position' => $position,
                'records_per_page' => $records_per_page,
                'page' => $page,
                'tab' => $tabName
            ])->render();

            return $ajax->success()
                ->appendParam('Organizations', $oOrganizations)
                ->appendParam('html',$html)
                ->appendParam('paginationHtml',$paginationhtml)
                ->jscallback('load_ajax_tab')
                ->response();
        } catch(\Exception $ex){
            return $ajax->fail()
                ->message($ex->getMessage())
                ->response();
        }
    }

    public function editOrganization($enc_organization_id,Ajax $ajax){
        $organization_id = Crypt::decrypt($enc_organization_id);
        if($organization_id != '0'){
            $oOrganization = Organization::where('id',$organization_id)->first();
            /*if(!$dDepartment){
                return $ajax->fail()
                    ->message('Department not found')
                    ->jscallback()
                    ->response();
            }*/
            $cConnection = DatabaseConnection::setConnection($oOrganization->server);
             if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
            $organizationExtensions = Extensionorganizationmapping::where('organization_id',$organization_id)
                ->pluck('extension')
                ->toArray();

            $eExtensionLists = $cConnection->table('users')
                ->whereIn('extension',$organizationExtensions)
                ->orderBy('extension')
                ->get(['extension','name']);


            $organizationDepartments = Departmentorganizationmapping::where('organization_id',$organization_id)
                ->pluck('department_id')
                ->toArray();
            $dDepartmentLists = $cConnection->table('ringgroups')
                ->whereIn('grpnum',$organizationDepartments)
                ->orderBy('grpnum')
                ->get(['grpnum','description']);

            $organizationPhoneNumbers = Phoneorganizationmapping::where('organization_id',$organization_id)
                ->pluck('phone_number')
                ->toArray();
            $pPhoneNumbersLists = $cConnection->table('incoming')
                ->whereIn('extension',$organizationPhoneNumbers)
                ->orderBy('extension')
                ->get(['extension','description']);

            $organizationUsersLists = \App\User::where('organization_id',$organization_id)
                ->get();

            $organizationAnnouncements = Announcementorganizationmapping::where('organization_id',$organization_id)
                ->pluck('announcement_id')
                ->toArray();
            $aAnnouncementsLists = $cConnection->table('announcement')
                ->whereIn('announcement_id',$organizationAnnouncements)
                ->orderBy('announcement_id')
                ->get(['announcement_id','description']);

            ////Auto attendant////
            $organizationAutoattendants = Autoattendantorganizationmapping::where('organization_id',$organization_id)
                ->pluck('autoattendant_id')
                ->toArray();
            $aAutoattendantsLists = $cConnection->table('ivr_details')
                ->whereIn('id',$organizationAutoattendants)
                ->orderBy('id')
                ->get(['id','name']);

            ////Time Group////
            $organizationTimegroups = Timegrouporganizationmapping::where('organization_id',$organization_id)
                ->pluck('timegroup_id')
                ->toArray();
            $tTimegroupLists = $cConnection->table('timegroups_groups')
                ->whereIn('id',$organizationTimegroups)
                ->orderBy('id')
                ->get(['id','description']);

            ////Time Condition////
            $organizationTimeconditions = Timeconditionorganizationmapping::where('organization_id',$organization_id)
                ->pluck('timecondition_id')
                ->toArray();
            $tTimeconditionLists = $cConnection->table('timeconditions')
                ->whereIn('timeconditions_id',$organizationTimeconditions)
                ->orderBy('timeconditions_id')
                ->get(['timeconditions_id','displayname']);

            ////Day Night////
            $organizationDaynights = Daynightorganizationmapping::where('organization_id',$organization_id)
                ->pluck('daynight_id')
                ->toArray();
            $tDaynightLists = $cConnection->table('daynight')
                ->whereIn('ext',$organizationDaynights)
                ->where('dmode','fc_description')
                ->orderBy('ext')
                ->get();
      
            return view('organizations.form.add',[
                'title' => 'Edit Organization',
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)',
                'organization' => $oOrganization,
                'eExtensionLists' => $eExtensionLists,
                'dDepartmentLists' => $dDepartmentLists,
                'pPhoneNumbersLists' => $pPhoneNumbersLists,
                'aAnnouncementsLists' => $aAnnouncementsLists,
                'aAutoattendantsLists' => $aAutoattendantsLists,
                'tTimegroupsLists' => $tTimegroupLists,
                'tTimeconditionLists' => $tTimeconditionLists,
                'tDaynightLists' => $tDaynightLists,
                'uUsersLists' => $organizationUsersLists,
                'orgExtensions' => count($organizationExtensions) > 0 ? $organizationExtensions : [],
                'orgDepartments' => count($organizationDepartments) > 0 ? $organizationDepartments : [],
                'orgPhoneNumbers' => count($organizationPhoneNumbers) > 0 ? $organizationPhoneNumbers : [],
                'orgAnnouncements' => count($organizationAnnouncements) > 0 ? $organizationAnnouncements : [],
                'orgAutoattendants' => count($organizationAutoattendants) > 0 ? $organizationAutoattendants : [],
                'orgTimegroupLists' => count($organizationTimegroups) > 0 ? $organizationTimegroups : [],
                'orgTimeconditionLists' => count($organizationTimeconditions) > 0 ? $organizationTimeconditions : [],
                'organizationDaynights' => count($organizationDaynights) > 0 ? $organizationDaynights : []
            ]);
        }else{
            return view('organizations.form.add',[
                'title' => 'Add Organization',
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)',
            ]);
        }
    }

    /**
     * @param Request $request
     * @param Ajax $ajax
     * @return mixed
     */
    public function unassignedExtensions($enc_org_id,Request $request,Ajax $ajax){
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }

        $aAssignedExtensions = Extensionorganizationmapping::where('server_id',$organization->server_ID)->pluck('extension')->toArray();

        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $eExtensions = $cConnection->table('users')
            ->whereNotIn('extension',$aAssignedExtensions)
            ->orderBy('extension')
            ->get(['extension','name']);

        $title = 'Choose Extensions';
        $content = View::make('organizations.popup.extensions',[
            'eExtensions' => $eExtensions,
            'lists' => !empty($exts) ? explode(',',$exts) : []
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }

    public function unassignedDepartments($enc_org_id,Request $request,Ajax $ajax){
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }

        $aAssignedDepartments = Departmentorganizationmapping::where('server_id',$organization->server_ID)->pluck('department_id')->toArray();

        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $dDepartments = $cConnection->table('ringgroups')
            ->whereNotIn('grpnum',$aAssignedDepartments)
            ->orderBy('grpnum')
            ->get(['grpnum','description']);

        $title = 'Choose Department';
        $content = View::make('organizations.popup.departments',[
            'dDepartments' => $dDepartments,
            'lists' => !empty($exts) ? explode(',',$exts) : []
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }

    public function unassignedPhoneNumbers($enc_org_id,Request $request,Ajax $ajax){
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }

        $aAssignedPhoneNumbers = Phoneorganizationmapping::where('server_id',$organization->server_ID)->pluck('phone_number')->toArray();

        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }

        $pPhoneNumbers = $cConnection->table('incoming')
            ->whereNotIn('extension',$aAssignedPhoneNumbers)
            ->orderBy('extension')
            ->get(['extension','description']);

        $title = 'Choose Phone Number';
        $content = View::make('organizations.popup.phonenumbers',[
            'pPhoneNumbers' => $pPhoneNumbers
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }

    public function unassignedAnnouncements($enc_org_id,Request $request,Ajax $ajax){
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }

        $aAssignedAnnouncements = Announcementorganizationmapping::where('server_id',$organization->server_ID)->pluck('announcement_id')->toArray();
        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $aAnnouncements = $cConnection->table('announcement')
            ->whereNotIn('announcement_id',$aAssignedAnnouncements)
            ->orderBy('announcement_id')
            ->get(['announcement_id','description']);

        $title = 'Choose Announcement';
        $content = View::make('organizations.popup.announcements',[
            'aAnnouncements' => $aAnnouncements
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }
    public function unassignedautoattendants($enc_org_id,Request $request,Ajax $ajax){
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }

        $aAssignedAutoattendants = Autoattendantorganizationmapping::where('server_id',$organization->server_ID)->pluck('autoattendant_id')->toArray();
        //dd($aAssignedAutoattendants);
        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $aAutoattendants = $cConnection->table('ivr_details')
            ->whereNotIn('id',$aAssignedAutoattendants)
            ->orderBy('id')
            ->get(['id','name']);

        $title = 'Choose Auto Attendant';
        $content = View::make('organizations.popup.autoattendants',[
            'aAutoattendants' => $aAutoattendants
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }
    public function unassignedtimegroups($enc_org_id,Request $request,Ajax $ajax){  
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }

        $aAssignedTimegroups = Timegrouporganizationmapping::where('server_id',$organization->server_ID)->pluck('timegroup_id')->toArray();
        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $tTimegroups = $cConnection->table('timegroups_groups')
            ->whereNotIn('id',$aAssignedTimegroups)
            ->orderBy('id')
            ->get(['id','description']);


        $title = 'Choose Time Group';
        $content = View::make('organizations.popup.timegroups',[
            'tTimegroups' => $tTimegroups
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }

    public function unassignedtimeconditions($enc_org_id,Request $request,Ajax $ajax){  
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }
        $aAssignedTimeconditions = Timeconditionorganizationmapping::where('server_id',$organization->server_ID)->pluck('timecondition_id')->toArray();
        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $tTimeconditions = $cConnection->table('timeconditions')
            ->whereNotIn('timeconditions_id',$aAssignedTimeconditions)
            ->orderBy('timeconditions_id')
            ->get(['timeconditions_id','displayname']);


        $title = 'Choose Time Condition';
        $content = View::make('organizations.popup.timeconditions',[
            'tTimeconditions' => $tTimeconditions
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }

    public function unassigneddaynights($enc_org_id,Request $request,Ajax $ajax){  
        $organization_id = Crypt::decrypt($enc_org_id);
        $organization = Organization::find($organization_id);
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found')
                ->jscallback()
                ->response();
        }
        $aAssignedDaynights = Daynightorganizationmapping::where('server_id',$organization->server_ID)->pluck('daynight_id')->toArray();
        $cConnection = DatabaseConnection::setConnection($organization->server);
         if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $dDaynights = $cConnection->table('daynight')
            ->whereNotIn('ext',$aAssignedDaynights)
            ->where('dmode','fc_description')
            ->orderBy('ext')
            ->get();

        $title = 'Choose Day & Night Buttons';
        $content = View::make('organizations.popup.daynights',[
            'dDaynights' => $dDaynights
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();

    }

    public function allUsers(Ajax $ajax){
        $uUsers = \App\User::whereNull('organization_id')->where('is_active',1)->get();

        $title = 'Choose User';
        $content = View::make('organizations.popup.users',[
            'uUsers' => $uUsers
        ])->render();

        $size = 'modal-md';
        $sdata = [
            'content' => $content
        ];

        if (isset($title)) {
            $sdata['title'] = $title;
        }
        if (isset($size)) {
            $sdata['size'] = $size;
        }

        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();
    }

    public function unassignedUpdate(Request $request,Ajax $ajax){
        $type = $request->input('type','');
        $grplist = $request->input('grplist','');
        return $ajax->success()
            ->appendParam('grplist', $grplist)
            ->jscallback('ajax_org_'.$type.'_list')
            ->response();
    }

    public function updateOrganization(Request $request,Ajax $ajax){
        $organization_id = Crypt::decrypt($request->input('enc_id'));
        $extensions = $request->input('extensions','');
        $departments = $request->input('departments','');
        $phonenumbers = $request->input('phonenumbers','');
        $announcements = $request->input('announcements','');
        $autoattendants = $request->input('autoattendants','');
        $timegroups = $request->input('timegroups','');
        $timeconditions = $request->input('timeconditions','');
        $daynights = $request->input('daynights','');
        $users = $request->input('users','');
        $rules = [
            'organization_name' => 'required|min:2|max:25',
            'server_ID' => 'required'
        ];

        $messages = [
            'organization_name.required' => 'Organization name is required',
            'organization_name.min' => 'Organization name is minimum 2 characters',
            'organization_name.max' => 'Organization name is maximum 25 characters',
            'server_ID.required' => 'Server is required'
        ];

        if($organization_id != 0){
            $organization = Organization::find($organization_id);
            if(!$organization){
                return $ajax->fail()
                    ->message('Organization not found')
                    ->jscallback()
                    ->response();
            }
        }else{
            $organization = new Organization();
            $rules['department_range_from'] = 'required|numeric|min:100|max:100000';
            $rules['department_range_to'] = 'required|numeric|min:100|max:100000';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if($organization_id == 0){

            $validator->after(function ($validator) use ($request) {
                if(
                    !empty(trim($request->input('department_range_from'))) &&
                    !empty(trim($request->input('department_range_to'))) &&
                    (trim($request->input('department_range_from')) > trim($request->input('department_range_to')) )
                ){
                    $validator->errors()->add('department_range_to', 'Department range can\'t be less then department range from' );
                }else{
                    $range = new DepartmentRange();
                    $resultrange = $range->checkRange(trim($request->input('department_range_from')),trim($request->input('department_range_to')));
                    if(!$resultrange) {
                        $validator->errors()->add('department_range_from', 'Department range from is already in used');
                        $validator->errors()->add('department_range_to', 'Department range to is already in used');
                    }
                }
            });
        }

        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }

        $organization->organization_name = trim($request->input('organization_name'));
        $ajax->message(' Organization updated successfully');
        if($organization_id == 0) {
            $organization->server_ID = trim($request->input('server_ID'));
            $organization->department_range = trim($request->input('department_range_from')).'-'.trim($request->input('department_range_to'));
            $ajax->message(' Organization added successfully');
        }

        $organization->save();

        //Extension Mapping
        Extensionorganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($extensions)){
            if(strpos($extensions, ',') !== false){
                $extsArr = explode(',',$extensions);
            } else{
                $extsArr = [$extensions];
            }
            $data = [];
            foreach ($extsArr as $ext){
                array_push($data,[
                    'extension' => $ext,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Extensionorganizationmapping::insert($data);
        }

        // Department mapping
        Departmentorganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($departments)){
            if(strpos($departments, ',') !== false){
                $departArr = explode(',',$departments);
            } else{
                $departArr = [$departments];
            }
            $data = [];

            foreach ($departArr as $depart){
                array_push($data,[
                    'department_id' => $depart,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Departmentorganizationmapping::insert($data);
        }

        // Phone number mapping
        Phoneorganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($phonenumbers)){
            if(strpos($phonenumbers, ',') !== false){
                $phonenArr = explode(',',$phonenumbers);
            } else{
                $phonenArr = [$phonenumbers];
            }
            $data = [];

            foreach ($phonenArr as $phonen){
                array_push($data,[
                    'phone_number' => $phonen,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Phoneorganizationmapping::insert($data);
        }

        // Announcements mapping
        Announcementorganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($announcements)){
            if(strpos($announcements, ',') !== false){
                $announArr = explode(',',$announcements);
            } else{
                $announArr = [$announcements];
            }
            $data = [];

            foreach ($announArr as $announ){
                array_push($data,[
                    'announcement_id' => $announ,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Announcementorganizationmapping::insert($data);
        }

        // Auto Attendants mapping
        Autoattendantorganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($autoattendants)){
            if(strpos($autoattendants, ',') !== false){
                $announArr = explode(',',$autoattendants);
            } else{
                $announArr = [$autoattendants];
            }
            $data = [];

            foreach ($announArr as $announ){
                array_push($data,[
                    'autoattendant_id' => $announ,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Autoattendantorganizationmapping::insert($data);
        }

        // Time Groups mapping
        Timegrouporganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($timegroups)){
            if(strpos($timegroups, ',') !== false){
                $announArr = explode(',',$timegroups);
            } else{
                $announArr = [$timegroups];
            }
            $data = [];

            foreach ($announArr as $announ){
                array_push($data,[
                    'timegroup_id' => $announ,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Timegrouporganizationmapping::insert($data);
        }

        // Time Condition mapping
        Timeconditionorganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($timeconditions)){
            if(strpos($timeconditions, ',') !== false){
                $announArr = explode(',',$timeconditions);
            } else{
                $announArr = [$timeconditions];
            }
            $data = [];

            foreach ($announArr as $announ){
                array_push($data,[
                    'timecondition_id' => $announ,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Timeconditionorganizationmapping::insert($data);
        }

        // Day Night mapping
        Daynightorganizationmapping::where('organization_id',$organization->id)->delete();
        if(!empty($daynights)){
            if(strpos($daynights, ',') !== false){
                $announArr = explode(',',$daynights);
            } else{
                $announArr = [$daynights];
            }
            $data = [];

            foreach ($announArr as $announ){
                array_push($data,[
                    'daynight_id' => $announ,
                    'organization_id' => $organization->id,
                    'server_id' => $organization->server_ID,
                    'is_active' => 1
                ]);
            }
            Daynightorganizationmapping::insert($data);
        }

        // Users mapping
        \App\User::where('organization_id',$organization->id)
            ->update([
                'organization_id' => null
            ]);

        if(!empty($users)){
            if(strpos($users, ',') !== false){
                $userIdsArr = explode(',',$users);
            } else{
                $userIdsArr = [$users];
            }

            \App\User::whereIn('id',$userIdsArr)
                ->update([
                    'organization_id' => $organization->id
                ]);
        }

        return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->redirectTo(route('organization.index'))
            ->response();
    }

    public function changeStatus($enc_uid,Request $request,Ajax $ajax){
        /*if(!Auth::user()->IsSuperAdmin){
            return view('layouts.error_pages.404');
        }*/

        $uid = Crypt::decrypt($enc_uid);
        $organization = Organization::where('id',$uid)->first();
        $sStatusToggle = $organization->is_active == 1 ? 0 : 1;
        if(!$organization){
            return $ajax->fail()
                ->message('Organization not found !')
                ->jscallback()
                ->response();
        }
        Organization::where('id',$uid)->update(['is_active' => $sStatusToggle]);
        $statusText  = $organization->is_active == 1 ? 'InActive' : 'Active';
        return $ajax->success()
            ->message('Organization '.$statusText)
            ->appendParam('is_active', $sStatusToggle)
            ->jscallback('ajax_status_toggle')
            ->response();
    }

    public function changeAccess($enc_organization_id, Ajax $ajax){
        if(Helper::CheckPermission(null,'organization','edit') || Auth::user()->IsAdmin){
            $organization_id = Crypt::decrypt($enc_organization_id);
            $organization = Organization::find($organization_id);
            if(!$organization){
                return $ajax->fail()
                    ->message('Organization not found')
                    ->jscallback()
                    ->response();
            }
            \App\User::where('id',Auth::id())->update([
                'organization_id' => $organization_id
            ]);

            return $ajax->success()
                ->message('Organization users list updated successfully')
                ->appendParam('organization_name',$organization->organization_name)
                ->jscallback('ajax_org_access')
                ->response();

        }else{
            return $ajax->fail()
                ->message('Access denied !')
                ->jscallback()
                ->response();
        }
    }
}
