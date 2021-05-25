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
use App\Model\Organization;
use App\Model\Phoneorganizationmapping;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Config;
use Auth;
use Crypt;
use Validator;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\View as View;


class CommonController extends Controller
{
    /**
     * @param Request $request
     * @param Ajax $ajax
     * @return mixed
     */
    public function getExtensionsList_v1(Request $request,Ajax $ajax){
        $lists = ($request->input('list') && !empty($request->input('list'))) ?
                    explode('-',$request->input('list')) :
                    [];

        $eExtensions = Extensionorganizationmapping::where('organization_id',Auth::user()->organization->id)
            ->where('server_id',Auth::user()->organization->server_ID)
            ->where('is_active',1)
            ->pluck('extension')
            ->toArray();

        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
        if(!$connection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $ids_ordered = implode(',', $lists);
        $eExtensionsData = $connection->table('users')
            ->whereIn('extension',$eExtensions)
            ->orderByRaw(DB::raw("FIELD(extension, $ids_ordered)"))
            ->get(['extension','name']);

        $title = 'Choose Extensions';
        $content = View::make('common.choose',[
            'eExtensions' => $eExtensionsData,
            'lists' => $lists
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

    /**
     * @param Request $request
     * @param Ajax $ajax
     * @return mixed
     */
    public function updateExtensionsList_v1(Request $request,Ajax $ajax){
        $grplist = $request->input('grplist',[]);
        return $ajax->success()
            ->appendParam('grplist', $grplist)
            ->jscallback('ajax_extensions_list')
            ->response();
    }

    /**
     * @param Request $request
     * @param Ajax $ajax
     * @return mixed
     */
    public function getExtensionsList(Request $request,Ajax $ajax){
        $eExtensions = [];
        $eExtensionRange = Extensionorganizationmapping::where('organization_id',Auth::user()->organization->id)
            ->where('server_id',Auth::user()->organization->server_ID)
            ->pluck('extension')
            ->toArray();

        $cConnection = DatabaseConnection::setConnection(Auth::user()->organization->server);
        if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $eExtensions = $cConnection->table('users')
            ->whereIn('extension',$eExtensionRange)
            ->orderBy('extension')
            ->get(['extension','name']);

        $title = 'Choose Extensions';
        $content = View::make('common.choose',[
            'eExtensions' => $eExtensions,
            'lists' => []
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

    /**
     * @param Request $request
     * @param Ajax $ajax
     * @return mixed
     */
    public function updateExtensionsList(Request $request,Ajax $ajax){
        $type = $request->input('type','');
        $grplist = $request->input('grplist','');

        return $ajax->success()
            ->appendParam('grplist', $type == 'internal' ?
                $grplist :
                preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1$2$3', $grplist). "\n".'::'.$grplist)
            ->jscallback($type == 'internal' ? 'ajax_extensions_list' : 'ajax_external_extensions_list')
            ->response();
    }

    public function addExternalExtension(Ajax $ajax){

        $title = 'External Extension';
        $content = View::make('common.external-extension')->render();
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

    public function changeDestination($enc_id,Ajax $ajax){
        $attr = Crypt::decrypt($enc_id);
        $dest = View::make('common.popup.changedestination',['attr' => $attr])->render();
        $sdata = [
            'content' => $dest,
            'size' => 'modal-md',
            'title' => 'Select Destination'
        ];
        $view = View::make('layouts.modal-popup-layout', $sdata);
        $html = $view->render();
        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('loadModalLayout')
            ->response();
    }

    public function destinationValue(Request $request,Ajax $ajax){
        //$destinations = Controller::Destination;
        $dest = explode('::',$request->dest);
        $destination = Controller::Destination[$dest[0]];
        $org_dest = $destination;
        $cConnection = DatabaseConnection::setConnection(Auth::user()->organization->server);
        if(!$cConnection){
            return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
        }
        $icon = $options = $select_name = $vmoptions = '';
        if($destination == 'Announcement') {
            $aAssocPhoneNumber = Announcementorganizationmapping::where('server_id', Auth::user()->organization->server_ID)
                ->pluck('announcement_id')
                ->toArray();
            $aAnnouncements = $cConnection->table('announcement')
                ->whereIN('announcement_id', $aAssocPhoneNumber)
                ->orderBy('announcement_id')
                ->get(['announcement_id', 'description']);
            foreach ($aAnnouncements as $aAnnouncement) {
                if ($aAnnouncement->description) {
                    $options .= '<option value="' . $aAnnouncement->announcement_id . '::' . $aAnnouncement->description . '">' . $aAnnouncement->description . '</option>';
                }
            }
            $select_name = 'Announcement';
            $icon = 'ti-announcement';

        }else if($destination == 'Auto Attendant'){
            $aAssignedAutoattendants = Autoattendantorganizationmapping::where('server_id',Auth::user()->organization->server_ID)
                ->pluck('autoattendant_id')
                ->toArray();

            $aAutoattendants = $cConnection->table('ivr_details')
                ->whereIN('id',$aAssignedAutoattendants)
                ->orderBy('id')
                ->get(['id','name']);

            foreach($aAutoattendants as $aAutoattendant){
                if( $aAutoattendant->name ){
                    $options .= '<option value="'.$aAutoattendant->id.'::'.$aAutoattendant->name.'">'.$aAutoattendant->name.'</option>';
                }
            }

            $select_name = $destination;
            $icon = 'ti-bag';

        }else if($destination == 'Extension'){
            $aAssignedExtensions = Extensionorganizationmapping::where('organization_id',Auth::user()->organization->id)
                ->where('server_id',Auth::user()->organization->server_ID)
                ->pluck('extension')
                ->toArray();

            $eExtensions = $cConnection->table('users')
                ->whereIN('extension',$aAssignedExtensions)
                ->orderBy('extension')
                ->get(['extension','name']);

            foreach($eExtensions as $eExtension){
                if( $eExtension->name != '' ){
                    $options .= '<option value="'.$eExtension->extension.'::'.$eExtension->name.'">'.$eExtension->name.'</option>';
                }
            }

            $select_name = $destination;
            $icon = 'ti-id-badge';

        }else if($destination == 'Time Condition'){
            $aAssignedTimeconditions = Timeconditionorganizationmapping::where('server_id',Auth::user()->organization->server_ID)
                ->pluck('timecondition_id')
                ->toArray();
            $tTimeconditions = $cConnection->table('timeconditions')
                ->whereIN('timeconditions_id',$aAssignedTimeconditions)
                ->orderBy('timeconditions_id')
                ->get(['timeconditions_id','displayname']);

            foreach($tTimeconditions as $tTimecondition){
                if( $tTimecondition->displayname ){
                    $options .= '<option value="'.$tTimecondition->timeconditions_id.'::'.$tTimecondition->displayname.'">'.$tTimecondition->displayname.'</option>';
                }
            }

            $select_name = $destination;
            $icon = 'ti-timer';

        }else if($destination == 'Department'){
            $aAssignedDepartments = Departmentorganizationmapping::where('server_id',Auth::user()->organization->server_ID)
                ->pluck('department_id')
                ->toArray();
            $dDepartments = $cConnection->table('ringgroups')
                ->whereIN('grpnum',$aAssignedDepartments)
                ->orderBy('grpnum')
                ->get(['grpnum','description']);

            foreach($dDepartments as $dDepartment){
                if( $dDepartment->description ){
                    $options .= '<option value="'.$dDepartment->grpnum.'::'.$dDepartment->description.'">'.$dDepartment->description.' '.$dDepartment->grpnum.'</option>';
                }
            }

            $select_name = $destination;
            $icon = 'ti-layout-grid2';
        }else if($destination == 'Hang up call'){
            $options .= '<option value="hangup::Hang up call">Hang up call</option>';

            $select_name = $destination;
            $icon = 'ti-close';
        }else if($destination == 'Voice Mail'){
            $aAssignedExtensions = Extensionorganizationmapping::where('organization_id',Auth::user()->organization->id)
                ->where('server_id',Auth::user()->organization->server_ID)
                ->pluck('extension')
                ->toArray();

            $eExtensions = $cConnection->table('users')
                ->whereIN('extension',$aAssignedExtensions)
                ->orderBy('extension')
                ->get(['extension','name']);

            foreach($eExtensions as $eExtension){
                if( $eExtension->name != '' ){
                    $options .= '<option value="'.$eExtension->extension.'::'.$eExtension->name.'">'.$eExtension->name.'</option>';
                }
            }

            foreach(Controller::VOICE_MAIL_MESSAGES as $mkey => $message){
                $vmoptions .= '<option value="'.$mkey.'::'.$message.'">'.$message.'</option>';

            }

            $select_name = 'Voice Mail';
            $destination = 'Extension';
            $icon = 'ti-microphone';
        }

        $html = View::make('common.popup.seletbox',[
            'options' => $options,
            'vmoptions' => $vmoptions,
            'select_name' => $select_name,
            'icon' => $icon,
            'org_dest' => $org_dest,
            'label' => 'Select '. ucwords($destination)
        ])->render();

        return $ajax->success()
            ->appendParam('html', $html)
            ->jscallback('ajax_destination_steps')
            ->response();
    }

    public function getDestinationParams(Request $request,Ajax $ajax){
        $rules = [
            'destination' => 'required',
            'destination_id' => 'required',
        ];


        $messages = [
            'destination.required' => 'Destination field is required',
            'destination_id.required' => 'Destination value is required',

        ];

        if($request->has('vmmessage')){
            $rules['vmmessage'] = 'required';
            $messages['vmmessage.required'] = 'Voice Mail message is required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }
        if($request->has('vmmessage')) {
            $ajax->appendParam('vmmessage', $request->vmmessage);
        }

        return $ajax->success()
            ->appendParam('destination',$request->destination)
            ->appendParam('destination_id',$request->destination_id)
            ->appendParam('icon_class',$request->icon_class)
            ->appendParam('selector',$request->selector)
            ->appendParam('org_dest',$request->org_dest)
            ->jscallback('ajax_destination_values')
            ->response();
    }
}
