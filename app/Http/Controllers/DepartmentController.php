<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Model\Departmentorganizationmapping;
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


class DepartmentController extends Controller
{
    public function index(){
        return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'departments.index'),[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
            'redirectTo' => Route('dashboard.index')
        ]);
    }

    public function getDepartments(Request $request,Ajax $ajax){
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
            $aAssocDepartment = \App\Model\Departmentorganizationmapping::where('server_id',Auth::user()->organization->server_ID)
                ->where('organization_id',Auth::user()->organization_id)
                ->get(['department_id'])
                ->toArray();

            $departments = array_column($aAssocDepartment, 'department_id');
            $cConnection = DatabaseConnection::setConnection(Auth::user()->organization->server);
             if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
            $dDepartments = $cConnection->table('ringgroups')->whereIn('grpnum',$departments)->skip($position)
                ->take($records_per_page)->orderBy('grpnum')->get();
            $dDepartments = collect($dDepartments)->map(function($x){ return (array) $x; })->toArray();
            //echo '<pre>'; print_r($dDepartments); die;
            $tabName = 'Departments';
            if($rType == 'pagination'){
                $html = View::make('departments.tabs.list.table',['dDepartments' => $dDepartments,'tab' => $tabName])->render();
            }else{
                $html = View::make('departments.tabs.list.index',['dDepartments' => $dDepartments,'tab' => $tabName])->render();
            }

            $tTotalDepartments = $cConnection->table('ringgroups')->whereIn('grpnum',$departments)->count();

            $paginationhtml = View::make('departments.tabs.list.pagination-html',[
                'total_records' => $tTotalDepartments,
                'records' => $dDepartments,
                'position' => $position,
                'records_per_page' => $records_per_page,
                'page' => $page,
                'tab' => $tabName
            ])->render();

            return $ajax->success()
                ->appendParam('Departments', $dDepartments)
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

    public function editDepartment($enc_department_id,Ajax $ajax){
        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
         if(!$connection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $department_id = Crypt::decrypt($enc_department_id);
        if($department_id != '0'){

            $dDepartment = $connection->table('ringgroups')->where('grpnum',$department_id)->first();

            $pagetitle = 'Edit Department';
            /*if(!$dDepartment){
                return $ajax->fail()
                    ->message('Department not found')
                    ->jscallback()
                    ->response();
            }*/

            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'departments.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'department' => $dDepartment,
                'sStrategies' => Controller::Strategies,
                'pagetitle' => $pagetitle
            ]);
        }else{
            $pagetitle = 'Add Department';

            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'departments.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'sStrategies' => Controller::Strategies,
                'pagetitle' => $pagetitle
            ]);
        }
    }

    public function updateDepartment(Request $request,Ajax $ajax){
        $grplists = !empty($request->input('grplist')) ? json_decode($request->input('grplist'),true) : [];
        $rules = [
            'description' => 'required',
            'strategy' => 'required',
            'grptime' => 'required',
            //'grppre' => 'required',
            'grplist' => 'required'
        ];

        $messages = [
            'description.required' => 'Description is required',
            'strategy.required' => 'Mode is required',
            'grptime.required' => 'Ring Time is required',
            //'grppre.required' => 'CID Prefix is required',
            'grplist.required' => 'List is required',

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->after(function ($validator) use($request,$grplists){
            if(count($grplists) == 0){
                $validator->errors()->add('grplist', 'At least one extension is required' );
            }
        });
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }

        $newgrplist = [];
        foreach ($grplists as $grplist){
            $symbol = '';
            if($grplist['type'] == 'external') $symbol = '#';
            array_push($newgrplist,$grplist['id'].$symbol);
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
        $dDepartmentExist = $connection->table('ringgroups')->where('grpnum',$request->input('grpnum'))->count();
        if($dDepartmentExist == 0){
            $connection->table('ringgroups')
                ->insert([
                    'grpnum' => trim($request->input('grpnum')),
                    'description' => trim($request->input('description')),
                    'strategy' => trim($request->input('strategy')),
                    'grptime' => trim($request->input('grptime')),
                    'grppre' => trim($request->input('grppre')),
                    'grplist' =>  count($newgrplist) > 0 ? implode('-',$newgrplist) : '',
                    'rvolume' =>  '',
                    'postdest' => trim($request->input('postdest')),
                ]);

            $departmentmapping = new Departmentorganizationmapping();
            $departmentmapping->department_id = trim($request->input('grpnum'));
            $departmentmapping->organization_id = trim(Auth::user()->organization_id);
            $departmentmapping->server_id = trim(Auth::user()->organization->server_ID);
            $departmentmapping->is_active = 1;
            $departmentmapping->save();
            $ajax->message('Department added successfully');
        }else{
            $connection->table('ringgroups')
                ->where('grpnum',$request->input('grpnum'))
                ->update([
                    'strategy' => trim($request->input('strategy')),
                    'grptime' => trim($request->input('grptime')),
                    'grppre' => trim($request->input('grppre')),
                    'grplist' =>  count($newgrplist) > 0 ? implode('-',$newgrplist) : '',
                    'postdest' => trim($request->input('postdest')),
                ]);
            $ajax->message('Department updated successfully');
        }
        return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->redirectTo(Route('department.index'))
            ->response();
    }
}
