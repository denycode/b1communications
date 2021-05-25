<?php

namespace App\Http\Controllers;

use App\Helpers\DatabaseConnection;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Model\Announcementorganizationmapping;
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


class AnnouncementController extends Controller
{
    public function index(){
        return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'announcement.index'),[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
            'redirectTo' => Route('dashboard.index'),
            'sStrategies' => Controller::Strategies
        ]);
    }

    public function getAnnouncements(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $sort = $request->input('sort') ? $request->input('sort') : '';
        $dir = $request->input('dir') ? $request->input('dir') : '';
        $page = $request->input('page',1);
        $records_per_page = 5; //config('constant.record_per_page');

        $rType = $request->input('rtype','');
        $filters = $request->input('filters',[]);
        $position = ($page-1) * $records_per_page;

        try {
            $aAssocAnnouncement = Announcementorganizationmapping::where('organization_id',Auth::user()->organization_id)
                ->where('server_id',Auth::user()->organization->server_ID)
                ->pluck('announcement_id')
                ->toArray();

            //dd($aAssocAnnouncement);

            //$announcements = array_column($aAssocAnnouncement, 'announcement_id');
            $cConnection = DatabaseConnection::setConnection(Auth::user()->organization->server);
            if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
            $aAnnouncements = $cConnection->table('announcement')->whereIn('announcement_id',$aAssocAnnouncement)->skip($position)
                ->take($records_per_page)->orderBy('description')->get();
            $aAnnouncements = collect($aAnnouncements)->map(function($x){ return (array) $x; })->toArray();
            $tabName = 'Announcements';
            if($rType == 'pagination'){
                $html = View::make('announcement.tabs.list.table',['aAnnouncements' => $aAnnouncements,'tab' => $tabName])->render();
            }else{
                $html = View::make('announcement.tabs.list.index',['aAnnouncements' => $aAnnouncements,'tab' => $tabName])->render();
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

    public function editAnnouncement($enc_announcement_id,Ajax $ajax){
        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
         if(!$connection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $announcement_id = Crypt::decrypt($enc_announcement_id);
        if($announcement_id != '0'){

            $aAnnouncement = $connection->table('announcement')->where('announcement_id',$announcement_id)->first(['announcement_id','description','post_dest']);
            $pageTitle = 'Edit Announcement';
            /*if(!$pPhoneNumber){
                return $ajax->fail()
                    ->message('Phone number not found')
                    ->jscallback()
                    ->response();
            }*/

            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'announcement.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'announcement' => $aAnnouncement,
                'pageTitle' => $pageTitle
            ]);
        }else{
            $pageTitle = 'Add Announcement';
            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'announcement.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'pageTitle' => $pageTitle
            ]);
        }
    }

    public function updateAnnouncement(Request $request,Ajax $ajax){
        $rules = [
            'description' => 'required',
            'post_dest' => 'required',
        ];

        $messages = [
            'description.required' => 'Description is required',
            'post_dest.required' => 'Post destination is required'

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
        $aAnnouncementExist = $connection->table('announcement')->where('announcement_id',$request->input('announcement_id'))->count();
        if($aAnnouncementExist == 0){
            return $ajax->fail()
                ->message('Announcement not found')
                ->jscallback()
                ->response();
        }

        $connection->table('announcement')
            ->where('announcement_id',$request->input('announcement_id'))
            ->update([
                'description' => trim($request->input('description')),
                'post_dest' => trim($request->input('post_dest'))
            ]);

        return $ajax->success()
            ->jscallback()
            ->appendParam('redirect',true)
            ->redirectTo(Route('announcement.index'))
            ->message('Announcement updated successfully')
            ->response();

    }
}
