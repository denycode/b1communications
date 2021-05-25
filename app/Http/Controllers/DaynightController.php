<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Model\Daynightorganizationmapping;
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

class DaynightController extends Controller
{
    public function index(){
        return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'daynight.index'),[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
            'redirectTo' => Route('dashboard.index'),
            'sStrategies' => Controller::Strategies
        ]);
    }

    public function getDaynight(Request $request,Ajax $ajax){
    	$tabid = $request->input('tabid');
        $sort = $request->input('sort') ? $request->input('sort') : '';
        $dir = $request->input('dir') ? $request->input('dir') : '';
        $page = $request->input('page',1);
        $records_per_page = 50; //config('constant.record_per_page');

        $rType = $request->input('rtype','');
        $filters = $request->input('filters',[]);
        $position = ($page-1) * $records_per_page;

        try {
            $aAssocDaynight = Daynightorganizationmapping::where('organization_id',Auth::user()->organization_id)
                ->where('server_id',Auth::user()->organization->server_ID)
                ->pluck('daynight_id')
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
            $dDaynight = $cConnection->table('daynight')->whereIn('ext',$aAssocDaynight)->skip($position)
                ->take($records_per_page)->get();
                dd($dDaynight);
            $dDaynight = collect($dDaynight)->map(function($x){ return (array) $x; })->toArray();
            
            $tabName = 'Day & Night Buttons';
            if($rType == 'pagination'){
                $html = View::make('daynight.tabs.list.table',['dDaynight' => $dDaynight,'tab' => $tabName])->render();
            }else{
                $html = View::make('daynight.tabs.list.index',['dDaynight' => $dDaynight,'tab' => $tabName])->render();
            }

            $tTotalAnnouncements = $cConnection->table('incoming')->whereIn('extension',$aAnnouncements)->count();

            $paginationhtml = View::make('announcement.tabs.list.pagination-html',[
                'total_records' => $tTotalAnnouncements,
                'records' => $aAnnouncements,
                'position' => $position,
                'records_per_page' => $records_per_page,
                'page' => $page,
                'tab' => $tabName
            ])->render();

            return $ajax->success()
                ->appendParam('Announcements', $aAnnouncements)
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
}