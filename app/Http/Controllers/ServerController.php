<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\freepbx;
use App\Helpers\Helper;
use App\Helpers\Appconnection;
use App\Library\Ajax;
use App\Model\Announcementorganizationmapping;
use App\Model\Departmentorganizationmapping;
use App\Model\Extensionorganizationmapping;
use App\Model\Server;
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

class ServerController extends Controller
{
	 public function index(){
        return view('servers.index',[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)'
        ]);
    }

	public function getServers(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $sort = $request->input('sort') ? $request->input('sort') : '';
        $dir = $request->input('dir') ? $request->input('dir') : '';
        $page = $request->input('page',1);
        $records_per_page = 5; //config('constant.record_per_page');
        ///$sort = ($sort == "") ? "Order By CampaignId DESC" : $sort == 'CampaignId' ? "Order By CampaignId DESC" : "Order By $sort $dir";
        $rType = $request->input('rtype','');
        $filters = $request->input('filters',[]);
        $position = ($page-1) * $records_per_page;

        try {
            $oServers = \App\Model\Server::skip($position)
                ->take($records_per_page)
                ->get();

            $tTotalServers = \App\Model\Server::count();

            $tabName = 'servers';
            if($rType == 'pagination'){
                $html = View::make('servers.tabs.list.table',['oServers' => $oServers,'tab' => $tabName])->render();
            }else{
                $html = View::make('servers.tabs.list.index',['oServers' => $oServers,'tab' => $tabName])->render();
            }
            $paginationhtml = View::make('servers.tabs.list.pagination-html',[
                'total_records' => $tTotalServers,
                'records' => $oServers,
                'position' => $position,
                'records_per_page' => $records_per_page,
                'page' => $page,
                'tab' => $tabName
            ])->render();

            return $ajax->success()
                ->appendParam('Organizations', $oServers)
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

    public function editServers($enc_server_id,Ajax $ajax){

        $server_id = Crypt::decrypt($enc_server_id);
        //die($server_id);
        if($server_id != '0'){

            $sServer = Server::where('id',$server_id)->first();

            $pagetitle = 'Edit Department';
            /*if(!$dDepartment){
                return $ajax->fail()
                    ->message('Department not found')
                    ->jscallback()
                    ->response();
            }*/

            return view('servers.form.add',[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '(Not Assigned)',
                'sServer' => $sServer,
                'pagetitle' => $pagetitle
            ]);
        }else{
            $pagetitle = 'Add Server';

            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'servers.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'sStrategies' => Controller::Strategies,
                'pagetitle' => $pagetitle
            ]);
        }
    }

    public function checkvalidation(Request $request,Ajax $ajax){
        $tabName = $request->action;
        if($tabName == 'general'){
            $name = $request->name;
            $description = $request->description;
            $rules = [
                'name' => 'required',
                'description' => 'required'
            ];
            $messages = [
                'namw.required' => 'Name is required',
                'description.required' => 'Description is required'
            ];
        }
        if($tabName == 'mysqlconn'){
            $host = $request->host;
            $username = $request->username;
            $password = $request->password;
            $dbname = $request->dbname;
            $rules = [
                'host' => 'required',
                'username' => 'required',
                'password' => 'required',
                'dbname' => 'required'
            ];
            $messages = [
                'host.required' => 'Host name is required',
                'username.required' => 'User name is required',
                'password.required' => 'Password is required',
                'dbname.required' => 'Database name is required'
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }else{
             return $ajax->success()
                ->appendParam('tabName',$tabName)
                ->jscallback('ajax_server_steps')
                ->response();
        }
    }

    public function updateServer(Request $request,Ajax $ajax){
        $tabName = $request->input('action');
    	$enc_server_id = $request->input('id');
    	$server_id = Crypt::decrypt($enc_server_id);

        $name = $request->input('name','');
        $description = $request->input('description','');
        $host = $request->input('host','');
        $username = $request->input('username','');
        $dbname = $request->input('dbname','');
        $password = $request->input('password','');
        $app_name = $request->input('app_name','');
        $client_id = $request->input('client_id','');
        $client_secret = $request->input('client_secret','');

        $rules = [
            'name' => 'required',
            'description' => 'required',
            'host' => 'required',
            'username' => 'required',
            'dbname' => 'required',
            'password' => 'required',
            'app_name' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required'
        ];
        $messages = [
            'name.required' => 'Name is required',
            'description.required' => 'Description is required',
            'host.required' => 'Host name is required',
            'username.required' => 'User name is required',
            'dbname.required' => 'Database name is required',
            'password.required' => 'Password is required',
            'app_name.required' => 'Application name is required',
            'client_id.required' => 'Client ID is required',
            'client_secret.required' => 'Client Secret is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }
        if($server_id != 0){

            $server = Server::find($server_id);

            if(!$server){
                return $ajax->fail()
                    ->message('Server not found')
                    ->jscallback()
                    ->response();
            }

          	$server->name = $name;
            $server->description = $description;
            $server->host = $host;
            $server->username = $username;
            $server->dbname = $dbname;
            $server->password = $password;
			$server->app_name = $app_name;
            $server->client_id = $client_id;
            $server->client_secret = $client_secret;
            $server->is_active = 1;

            $server->save();

            return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->message('Update successfully')
            ->redirectTo(route('server.index'))
            ->response();
        }else{

        	$server = new Server();

            $server->name = $name;
            $server->description = $description;
            $server->host = $host;
            $server->username = $username;
            $server->dbname = $dbname;
            $server->password = $password;
            $server->app_name = $app_name;
            $server->client_id = $client_id;
            $server->client_secret = $client_secret;
            $server->is_active = 1;

            $server->save();

            return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->message('Server saved successfully')
            ->redirectTo(route('server.index'))
            ->response();

        }
    }

    public function checkconnection(Request $request,Ajax $ajax){
        $action = $request->action;
        if($action == 'mysql_conn'){
            $cConnection = DatabaseConnection::setConnection($request);
             if(!$cConnection){
                return $ajax->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response([
                'success' => false
            ]);
            }
            $response = $cConnection->table('users')
                ->orderBy('extension')
                ->take(5)
                ->get(['extension','name']);
           $view = 'servers.popup.extensions';

        }else if($action == 'app_conn'){

            $getTokenResponse = freepbx::getToken([
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret
            ]);

            if(isset($getTokenResponse->error)){
                return $ajax->fail()
                    ->jscallback()
                    ->message($getTokenResponse->message)
                    ->response();
            }

            Session::put(['AuthToken' => $getTokenResponse->access_token]);
            $token = $getTokenResponse->access_token;
            $response = freepbx::runGraphQL([
                'query' => 'query{ fetchAllExtensions { status extension { id extensionId } }}',
                'auth_token' => $token
            ]);

            $response = isset($response->data->fetchAllExtensions->extension) ? $response->data->fetchAllExtensions->extension : [];
            if(!$response){
                 return $ajax->fail()->jscallback()
                    ->appendParam('redirect',true)
                    ->redirectTo(route('error.index'))
                    ->message('Database connection error')
                    ->response();
            }
            $view = 'servers.popup.apiextention';
        }
        $title = 'Extensions';
        $content = View::make($view,[
                'eExtensions' => $response,
                'lists' =>  []
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
                ->response();
    }
}
?>
