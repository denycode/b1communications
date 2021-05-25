<?php
namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\freepbx;
use App\Helpers\Helper;
use App\Helpers\Appconnection;
use App\Library\Ajax;
use App\Model\Announcementorganizationmapping;
use App\Model\Autoattendantorganizationmapping;
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

class AutoattendantController extends Controller
{
	 public function index(){
        return view('autoattendants.index',[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)'
        ]);
    }

    public function getautoattendants(Request $request,Ajax $ajax){
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

            $aAutoAttendant = Autoattendantorganizationmapping::where('organization_id',Auth::user()->organization_id)
                ->where('server_id',Auth::user()->organization->server_ID)
                ->pluck('autoattendant_id')
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
            $autoAttendant = $cConnection->table('ivr_details')->whereIn('id',$aAutoAttendant)->skip($position)->take($records_per_page)->orderBy('name')->get();
            $autoAttendants = collect($autoAttendant)->map(function($x){ return (array) $x; })->toArray();
            $tabName = 'Auto Attendants';
            if($rType == 'pagination'){
                $html = View::make('autoattendants.tabs.list.table',['autoAttendants' => $autoAttendants,'tab' => $tabName])->render();
            }else{
                $html = View::make('autoattendants.tabs.list.index',['autoAttendants' => $autoAttendants,'tab' => $tabName])->render();
            }
            $tTotalAutoattendant = $autoAttendant->count();
            

            $paginationhtml = View::make('autoattendants.tabs.list.pagination-html',[
                'total_records' => $tTotalAutoattendant,
                'records' => $autoAttendants,
                'position' => $position,
                'records_per_page' => $records_per_page,
                'page' => $page,
                'tab' => $tabName
            ])->render();
            return $ajax->success()
                ->appendParam('AutoAttendants', $autoAttendants)
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

    public function editautoattendants($enc_autoatt_id,Ajax $ajax){
    	$connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
    	if(!$connection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
    	$autoAttendant_id = Crypt::decrypt($enc_autoatt_id);

    	$autoAttendant = $connection->table('ivr_details')->where('id',$autoAttendant_id)->first();

    	$autoAttendants = collect($autoAttendant)->map(function($x){ return (array) $x; })->toArray();
    	return view('autoattendants.form.add',[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)',
                'autoAttendant' => $autoAttendant,
                'pagetitle' => 'Edit Auto Attendant'
            ]);


    }

    public function updateautoattendants(Request $request,Ajax $ajax){
    	$connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
    	$name = $request->input('name','');
        $description = $request->input('description','');
        $enc_autoatt_id = $request->input('id','');
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];
        $messages = [
            'name.required' => 'Name is required',
            'description.required' => 'Description is required'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }
        $autoAttendant_id = Crypt::decrypt($enc_autoatt_id);
      	$connection->table('ivr_details')
                ->where('id',$autoAttendant_id)
                ->update([
                    'name' => $name,
                    'description' => $description,
                ]);

            return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->message('Update successfully')
            ->redirectTo(route('autoattendants.index'))
            ->response();
    }
}
?>