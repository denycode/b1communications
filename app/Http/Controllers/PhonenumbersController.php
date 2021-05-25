<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Model\Phoneorganizationmapping;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use DB;
use Config;
use Auth;
use Crypt;
use Validator;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\View as View;


class PhonenumbersController extends Controller
{
    public function index(){
        return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'phonenumbers.index'),[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
            'redirectTo' => Route('dashboard.index'),
            'sStrategies' => Controller::Strategies
        ]);
    }

    public function getPhonenumbers(Request $request,Ajax $ajax){
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
            $aAssocPhoneNumber = Phoneorganizationmapping::where('organization_id',Auth::user()->organization_id)
                ->where('server_id',Auth::user()->organization->server_ID)
                ->get(['phone_number','sms_compatible'])
                ->toArray();

            $phone_numbers = array_column($aAssocPhoneNumber, 'phone_number');
            $cConnection = DatabaseConnection::setConnection(Auth::user()->organization->server);
             if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
            $pPhoneNumbers = $cConnection->table('incoming')->whereIn('extension',$phone_numbers)->skip($position)
                ->take($records_per_page)->orderBy('extension')->get();
            $pPhoneNumbers = collect($pPhoneNumbers)->map(function($x){ return (array) $x; })->toArray();

            $sc_key = array_search('1', array_column($aAssocPhoneNumber, 'sms_compatible'));
            $sms_compatible_number = '';
            if($sc_key !== false){
                $sms_compatible_number =  $aAssocPhoneNumber[$sc_key]['phone_number'];
            }
            $tabName = 'Phone Numbers';
            if($rType == 'pagination'){
                $html = View::make('phonenumbers.tabs.list.table',[
                    'pPhoneNumbers' => $pPhoneNumbers,
                    'tab' => $tabName,
                    'sms_compatible_number' => $sms_compatible_number
                ])->render();
            }else{
                $html = View::make('phonenumbers.tabs.list.index',[
                    'pPhoneNumbers' => $pPhoneNumbers,
                    'tab' => $tabName,
                    'sms_compatible_number' => $sms_compatible_number
                ])->render();
            }

            $tTotalPhoneNumbers = $cConnection->table('incoming')->whereIn('extension',$phone_numbers)->count();

            $paginationhtml = View::make('phonenumbers.tabs.list.pagination-html',[
                'total_records' => $tTotalPhoneNumbers,
                'records' => $pPhoneNumbers,
                'position' => $position,
                'records_per_page' => $records_per_page,
                'page' => $page,
                'tab' => $tabName
            ])->render();

            return $ajax->success()
                ->appendParam('PhoneNumbers', $pPhoneNumbers)
                ->appendParam('html',$html)
                ->appendParam('sms_compatible_number',$sms_compatible_number)
                ->appendParam('paginationHtml',$paginationhtml)
                ->jscallback('load_ajax_tab')
                ->response();
        } catch(\Exception $ex){
            return $ajax->fail()
                ->message($ex->getMessage())
                ->response();
        }
    }

    public function editPhonenumber($enc_extension_id,Ajax $ajax){
        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
         if(!$connection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        if($enc_extension_id != '0'){
            $extension_id = Crypt::decrypt($enc_extension_id);
            $pPhoneNumber = $connection->table('incoming')
                ->where('extension',$extension_id)
                ->first(['extension','description','destination']);

            if(!$pPhoneNumber){
                return $ajax->fail()
                    ->message('Phone number not found')
                    ->jscallback()
                    ->response();
            }

            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'phonenumbers.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'phonenumber' => $pPhoneNumber
            ]);
        }else{
            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'phonenumbers.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
            ]);
        }
    }

    public function updatePhonenumber(Request $request,Ajax $ajax){
        $rules = [
            'description' => 'required',
            'destination' => 'required',
        ];

        $messages = [
            'description.required' => 'Description is required',
            'destination.required' => 'Destination is required'

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }

        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
         if(!$connection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $pPhoneNumberExist = $connection->table('incoming')->where('extension',$request->input('extension'))->count();
        if($pPhoneNumberExist == 0){
            return $ajax->fail()
                ->message('Phone number not found')
                ->jscallback()
                ->response();
        }

        $connection->table('incoming')
            ->where('extension',$request->input('extension'))
            ->update([
                'description' => trim($request->input('description')),
                'destination' => trim($request->input('destination'))
            ]);

        return $ajax->success()
            ->jscallback()
            ->reload_page(true)
            ->message('Phone number updated successfully')
            ->response();

    }

    public function changeSMScompatible($enc_phone_number, Ajax $ajax){
        if(Auth::user()->IsCSR || Auth::user()->IsAdmin){
            $phone_number = Crypt::decrypt($enc_phone_number);
            $phoneOrgMapping = Phoneorganizationmapping::where('phone_number',$phone_number)->first();
            if(!$phoneOrgMapping){
                return $ajax->fail()
                    ->message('Phone number not found')
                    ->jscallback()
                    ->response();
            }
            Phoneorganizationmapping::where('organization_id',$phoneOrgMapping->organization_id)->update([
                'sms_compatible' => 0
            ]);
            
            $phoneOrgMapping->sms_compatible = 1;
            $phoneOrgMapping->save();

            return $ajax->success()
                ->message('SMS compatible updated successfully')
                ->appendParam('phone_number',$phoneOrgMapping->phone_number)
                ->jscallback('ajax_sms_compatible')
                ->response();

        }else{
            return $ajax->fail()
                ->message('Access denied !')
                ->jscallback()
                ->response();
        }
    }
}
