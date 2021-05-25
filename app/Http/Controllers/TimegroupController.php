<?php
namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\freepbx;
use App\Helpers\Helper;
use App\Helpers\Appconnection;
use App\Helpers\createDateTime;
use App\Library\Ajax;
use App\Model\Announcementorganizationmapping;
use App\Model\Autoattendantorganizationmapping;
use App\Model\Timegrouporganizationmapping;
use App\Model\Timeconditionorganizationmapping;
use App\Model\Departmentorganizationmapping;
use App\Model\Extensionorganizationmapping;
use App\Model\Autoattendant;
use App\Model\Phoneorganizationmapping;
use App\Rules\DepartmentRange;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use DB;
use Config;
use Auth;
use Crypt;
use Validator;
use Session;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\View as View;

class TimegroupController extends Controller
{
	 public function index(){
        return view('business_hours.timegroups.index',[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)'
        ]);
    }

    public function gettimegroups(Request $request,Ajax $ajax){
    	//Database: asterisk »Table: ivr_details
        $tabid = $request->input('tabid');
        $sort = $request->input('sort') ? $request->input('sort') : '';
        $dir = $request->input('dir') ? $request->input('dir') : '';
        $page = $request->input('page',1);
        $records_per_page = 5; //config('constant.record_per_page');

        $rType = $request->input('rtype','');
        $filters = $request->input('filters',[]);
        $position = ($page-1) * $records_per_page;
        

    	try {

            $tTimegroup = Timegrouporganizationmapping::where('organization_id',Auth::user()->organization_id)
                ->where('server_id',Auth::user()->organization->server_ID)
                ->pluck('timegroup_id')
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
            if($tabid == 20){
                $timeGroups = $cConnection->table('timegroups_groups')
                    ->whereIn('id',$tTimegroup)
                    ->skip($position)
                    ->take($records_per_page)
                    ->orderByDesc('id')
                    ->get();
                $tabName = 'Time Groups';
                if($rType == 'pagination'){
                    $html = View::make('business_hours.timegroups.tabs.list.table',['timeGroups' => $timeGroups,'tab' => $tabName])->render();
                }else{
                    $html = View::make('business_hours.timegroups.tabs.list.index',['timeGroups' => $timeGroups,'tab' => $tabName])->render();
                }
                $tTotaltimeGroup = $timeGroups->count();
                $paginationhtml = View::make('business_hours.timegroups.tabs.list.pagination-html',[
                    'total_records' => $tTotaltimeGroup,
                    'records' => $timeGroups,
                    'position' => $position,
                    'records_per_page' => $records_per_page,
                    'page' => $page,
                    'tab' => $tabName
                ])->render();
                return $ajax->success()
                    ->appendParam('timeGroups', $timeGroups)
                    ->appendParam('html',$html)
                    ->appendParam('paginationHtml',$paginationhtml)
                    ->jscallback('load_ajax_tab')
                    ->response();
            }
            if($tabid == 21){
                $timeconditions = $cConnection->table('timeconditions')
                    ->select('timeconditions.timeconditions_id','timeconditions.displayname','timeconditions.truegoto','timeconditions.falsegoto','timegroups_groups.description')
                    ->join('timegroups_groups', 'timeconditions.time', '=', 'timegroups_groups.id')
                     ->whereIn('timeconditions_id',$tTimegroup)
                    ->get();
                $tabName = 'Time Conditions';
                if($rType == 'pagination'){
                    $html = View::make('business_hours.timeconditions.tabs.list.table',['timeconditions' => $timeconditions,'tab' => $tabName])->render();
                }else{
                    $html = View::make('business_hours.timeconditions.tabs.list.index',['timeconditions' => $timeconditions,'tab' => $tabName])->render();
                }
                $tTotaltimeGroup = $timeconditions->count();
                $paginationhtml = View::make('business_hours.timeconditions.tabs.list.pagination-html',[
                    'total_records' => $tTotaltimeGroup,
                    'records' => $timeconditions,
                    'position' => $position,
                    'records_per_page' => $records_per_page,
                    'page' => $page,
                    'tab' => $tabName
                ])->render();
                return $ajax->success()
                    ->appendParam('timeGroups', $timeconditions)
                    ->appendParam('html',$html)
                    ->appendParam('paginationHtml',$paginationhtml)
                    ->jscallback('load_ajax_tab')
                    ->response();
            }

        } catch(\Exception $ex){
            return $ajax->fail()
                ->message($ex->getMessage())
                ->response();
        }
    }

    public function timeGroupsDetails($enc_timegroup_id,Ajax $ajax){
    	$connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
    	if(!$connection){
            return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->redirectTo(route('error.index'))
            ->message('Database connection error')
            ->response();
        }

    	$timegroup_id = Crypt::decrypt($enc_timegroup_id);

        $timegroups = $connection->table('timegroups_groups')
            ->select('timegroups_groups.description','timegroups_details.id','timegroups_details.time')
            ->join('timegroups_details', 'timegroups_groups.id', '=', 'timegroups_details.timegroupid')
            ->where('timegroups_groups.id', $timegroup_id)
            ->get();
        $timegroups = collect($timegroups)->map(function($x){ return (array) $x; })->toArray();

        return View::make('business_hours.timegroups.form.timegroup-details',[
            'timegroups' => $timegroups,
            'timegroup_id' => $timegroup_id,
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)'
        ])->render();

    }

    public function timeconditionsDetails($enc_timecondition_id,Ajax $ajax){
        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
        if(!$connection){
            return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->redirectTo(route('error.index'))
            ->message('Database connection error')
            ->response();
        }

        $timecondition_id = Crypt::decrypt($enc_timecondition_id);
        $timeconditions = $connection->table('timeconditions')
                    ->select('business_hours.timeconditions.timeconditions_id','timeconditions.displayname','timeconditions.truegoto','timeconditions.falsegoto','timegroups_groups.description')
                    ->join('timegroups_groups', 'timeconditions.time', '=', 'timegroups_groups.id')
                     ->where('timeconditions_id',$timecondition_id)
                    ->first();

        //$timeconditions = collect($timeconditions)->map(function($x){ return (array) $x; })->toArray();

        return View::make('business_hours.timeconditions.form.timecondition-detail',[
            'timeconditions' => $timeconditions,
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)'
        ])->render();

    }


    public function timeGroupsDelete(Request $request,$enc_timegroup_id,Ajax $ajax){
        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
        if(!$connection){
            return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->redirectTo(route('error.index'))
            ->message('Database connection error')
            ->response();
        }
        $timegroupdetail_id = Crypt::decrypt($enc_timegroup_id);
        $timeGroups = $connection->table('timegroups_details')->where('id',$timegroupdetail_id)->delete();
            return $ajax->success()
                ->jscallback('ajax_delete_timegroupdetail')
                ->appendParam('timegroupdetail_id',$timegroupdetail_id)
                ->message('Delete successfully')
                ->response();
    }


    public function addtimegrouphtml(Request $request,Ajax $ajax){
        
        $html = View::make('business_hours.timegroups.form.new-timegroup-details',[
            'lenght_id' => $request->length
        ])->render();
        return $ajax->success()
                ->appendParam('html',$html)
                ->response();

    }

    public function updatetimeGroups(Request $request,Ajax $ajax){
    	$connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
    	$timegroup_ids = $request->input('timegroup_detail_id');
        foreach($timegroup_ids as $timegroup_id){
            $timegroup_id = Crypt::decrypt($timegroup_id);
            $times = Helper::createDateTime($request,$timegroup_id);
            if(is_numeric($timegroup_id)){
                $connection->table('timegroups_details')
                ->where('id',$timegroup_id)
                ->update([
                    'time' => $times
                ]);
            }else{
                $data = [
                    'timegroupid' => $request->input('timegroupid'),
                    'time' => $times
                ];
                $connection->table('timegroups_details')->insert($data);

            }
            
        }

        return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('timegroups.index'))
                ->response();
        
    
    }

    public function timeconditionsUpdate(Request $request,Ajax $ajax){
        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
        $timecondition_id = $request->input('timeconditions_id');
        $displayname = $request->input('displayname');
        $timecondition_id = Crypt::decrypt($timecondition_id);
        $connection->table('timeconditions')
            ->where('timeconditions_id',$timecondition_id)
            ->update([
                'displayname' => $displayname
            ]);
        return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->message('Time Conditions Update successfully')
                ->redirectTo(route('timegroups.index'))
                ->response();
        
    
    }
}
?>
