<?php

namespace App\Http\Controllers;

use App\Mail\VoiceMail;
use App\Helpers\DatabaseConnection;
use App\Helpers\freepbx;
use App\Helpers\Helper;
use App\Library\Ajax;
use App\Model\Extensionorganizationmapping;
use App\Model\Phoneorganizationmapping;
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
use Illuminate\Support\Facades\Mail;

class ExtensionController extends Controller
{
    public function index(){
        return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'extensions.index'),[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
            'redirectTo' => Route('organization.index')
        ]);
    }

    public function getExtensions(Request $request,Ajax $ajax){
        $tabid = $request->input('tabid');
        $sort = $request->input('sort') ? $request->input('sort') : '';
        $dir = $request->input('dir') ? $request->input('dir') : '';
        $page = $request->input('page',1);
        $records_per_page = 5; //config('constant.record_per_page');
        $sort = ($sort == "") ? "Order By CampaignId DESC" : $sort == 'CampaignId' ? "Order By CampaignId DESC" : "Order By $sort $dir";
        $rType = $request->input('rtype','');
        $filters = $request->input('filters',[]);
        $position = ($page-1) * $records_per_page;

        //$user = \App\User::find(Auth::id());
        try {
            //$eExtensionArr = explode('-',Auth::user()->organization->extension_range);
            //$eExtensionRange = range($eExtensionArr[0],$eExtensionArr[1]);
            $cConnection = DatabaseConnection::setConnection(Auth::user()->organization->server);
            if(!$cConnection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
            //$users = $connection->select(DB::raw("SELECT extension,name FROM users WHERE extension BETWEEN ".$extensionrange[0]." AND ".$extensionrange[1]));

            $eExtenstionsLists = Extensionorganizationmapping::where('organization_id', Auth::user()->organization->id)
                ->where('server_id', Auth::user()->organization->server_ID)
                ->pluck('extension')
                ->toArray();

            $eExtensions = $cConnection->table('users')
                ->whereIn('extension',$eExtenstionsLists)
                ->skip($position)
                ->take($records_per_page)
                ->orderBy('extension')
                ->get();

            $eExtensions = collect($eExtensions)->map(function($x){ return (array) $x; })->toArray();
            $tabName = 'Extensions';
            if($rType == 'pagination'){
                $html = View::make('extensions.tabs.list.table',['eExtensions' => $eExtensions,'tab' => $tabName])->render();
            }else{
                $html = View::make('extensions.tabs.list.index',['eExtensions' => $eExtensions,'tab' => $tabName])->render();
            }

            $tTotalExtensions = $cConnection->table('users')->whereIn('extension',$eExtenstionsLists)->count();

            $paginationhtml = View::make('extensions.tabs.list.pagination-html',[
                'total_records' => $tTotalExtensions,
                'records' => $eExtensions,
                'position' => $position,
                'records_per_page' => $records_per_page,
                'page' => $page,
                'tab' => $tabName
            ])->render();

            return $ajax->success()
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

    public function editExtension($enc_extension_id,Ajax $ajax){
        $connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
         if(!$connection){
                return $ajax->success()
                ->jscallback()
                ->appendParam('redirect',true)
                ->redirectTo(route('error.index'))
                ->message('Database connection error')
                ->response();
            }
        $pPhoneNumbers = Phoneorganizationmapping::where('organization_id',Auth::user()->organization->id)
            ->where('server_id',Auth::user()->organization->server_ID)
            ->get(['phone_number']);

        if($enc_extension_id != '0'){
            $extension_id = Crypt::decrypt($enc_extension_id);
            $extension = $connection->table('users')->where('extension',$extension_id)->first(['extension','name','outboundcid']);
            $smartfollow = $connection->table('findmefollow')->where('grpnum',$extension_id)->first();
            $token = Session::get('AuthToken');
            $voicemail = freepbx::runGraphQL(['query' => 'query{ fetchVoiceMail(extensionId: '.$extension_id.') { status message context password name email pager attach saycid envelope delete } }','auth_token' => $token]);
            if(isset($voicemail->error)){
                Auth::logout();
                return redirect('login');
            }
            $title = 'Edit Extension';
            /*if(!$extension){
                return $ajax->fail()
                    ->message('Extension not found')
                    ->jscallback()
                    ->response();
            }*/

            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'extensions.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'extension' => $extension,
                'pPhoneNumbers' => $pPhoneNumbers,
                'sStrategies' => Controller::Strategies,
                'smartfollow' => $smartfollow,
                'voicemail' => isset($voicemail->data->fetchVoiceMail) ? $voicemail->data->fetchVoiceMail : []
            ]);
        }else{
            return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'extensions.form.add'),[
                'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
                'redirectTo' => Route('dashboard.index'),
                'pPhoneNumbers' => $pPhoneNumbers,'sStrategies' => Controller::Strategies
            ]);
        }
    }

    public function updateExtension(Request $request,Ajax $ajax){
        $rules = [
            'name' => 'required',
            'outboundname' => 'required',
            'outboundnumber' => 'required',
        ];

        $messages = [
            'name.required' => 'Extension name is required',
            'outboundname.required' => 'Outbound name is required',
            'outboundnumber.required' => 'Outbound number is required'

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
        $extensionExist = $connection->table('users')->where('extension',$request->input('extension'))->count();

        if($extensionExist > 0){
            $outboundname = $request->input('outboundname');
            $outboundnumber = $request->input('outboundnumber');
            $outboundcid = '"'.$outboundname.'" <'.$outboundnumber.'>';

            $connection->table('users')
                ->where('extension',$request->input('extension'))
                ->update([
                    'name' => trim($request->input('name')),
                    'outboundcid' => trim($outboundcid),
                ]);
        }
        return $ajax->success()
            ->jscallback()
            ->reload_page(true)
            ->message('Extension updated successfully')
            ->response();

    }

    public function updateSmartFollow(Request $request,Ajax $ajax){
        $rules = [
            'pre_ring' => 'required',
            'grptime' => 'required',
            'strategy' => 'required',
            //'grplist' => 'required',
            //'grppre' => 'required',
        ];

        $messages = [
            'pre_ring.required' => 'Ring main extension name is required',
            'grptime.required' => 'Ring other extensions is required',
            'strategy.required' => 'Ring type is required',
            //'grplist.required' => 'Extensions to ring is required',
            //'grppre.required' => 'CID Prefix is required'

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
        $smartfollowExist = $connection->table('findmefollow')->where('grpnum',$request->input('grpnum'))->count();
        $newgrplist = [];

        $grplists = !empty($request->input('grplist')) ? json_decode($request->input('grplist'),true) : [];
        foreach ($grplists as $grplist){
            $symbol = '';
            if($grplist['type'] == 'external') $symbol = '#';
            array_push($newgrplist,$grplist['id'].$symbol);
        }

        if($smartfollowExist > 0){
            $connection->table('findmefollow')
                ->where('grpnum',$request->input('grpnum'))
                ->update([
                    'pre_ring' => trim($request->input('pre_ring')),
                    'grptime' => trim($request->input('grptime')),
                    'strategy' => trim($request->input('strategy')),
                    'grplist' =>  count($newgrplist) > 0 ? implode('-',$newgrplist) : '',
                    'grppre' => trim($request->input('grppre'))
                ]);
        }
        return $ajax->success()
            ->jscallback()
            ->reload_page(true)
            ->message('Smart follow updated successfully')
            ->response();
    }

    public function updateVoicemail(Request $request,Ajax $ajax){
        $rules = $messages = [];
        if($request->input('status') == 'on' && $request->input('attach') == 'on'){
            $rules = [
                'password' => 'required|max:6',
                'email' => 'required|email',
            ];
            $messages = [
                'password.required' => 'More then six number not allowed',
                'email.required' => 'The email address is required',
                'email.email' => 'Please enter a valid email address',
            ];
        }
        elseif ($request->input('status') == 'on' && !$request->input('attach')){
            $rules = [
                'password' => 'required|max:6'
            ];

            $messages = [
                'password.required' => 'More then six number not allowed'
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $ajax->fail()
                ->form_errors($validator->errors())
                ->jscallback()
                ->response();
        }

        $extension = $request->input('extension');
        $token = Session::get('AuthToken');
        if($request->input('status') == 'on'){

            $password = !empty($request->input('password')) == '' ? $request->input('password') : $extension;
            $email = !empty($request->input("email")) ? $request->input("email") : '';
            $pager = !empty($request->input("pager")) ? $request->input("pager") : '';
            $is_delete = $request->input('delete') == 'on' ? 'delete: true' : 'delete: false';
            $is_attach = $request->input('attach') == 'on' ? 'attach: true' : 'attach: false';

            $query =    'mutation {enableVoiceMail(input: { extensionId: "'.$extension.'"
                            password: "'.$password.'"
                            email: "'.$email.'"
                            pager : "'.$pager .'"
                            saycid : true
                            envelope : true
                            '.$is_attach.'
                            '.$is_delete.' }) {status message }}';
        }
        else{
            $query = 'mutation { disableVoiceMail(input: { extensionId: "'.$extension.'" }) { status message }}';
        }
        try{
            freepbx::runGraphQL(['query' => $query,'auth_token' => $token]);
            return $ajax->success()
                ->jscallback()
                ->reload_page(true)
                ->message('Voice Mail updated successfully')
                ->response();
        }catch (\Exception $exception){
            return $ajax->fail()
                ->message('Something is wrong')
                ->jscallback()
                ->response();
        }
    }

    public function ExtensionSendMail(Request $request,Ajax $ajax){
       
        if(is_null($request->email)){
            return $ajax->fail()
                ->message('Email field is empty')
                ->jscallback()
                ->response();
        }
        $curl = curl_init();
        $POSTFIELDS = '{
                "bounce_address":"bounce@bounce.b1communications.ca",
                "from": { "address": "transmail@voicemail.b1communications.ca"},
                "to": [{"email_address": {"address": "'.$request->email.'","name": "'.$request->email.'"}}],
                "subject":"B1Communications",
                "htmlbody":"<div><p>Hello</p><p>Your extension is: '.$request->extension.'</p><p>Your password is: '.$request->password.'</p><p>Voice mail to email is enable for this address: '.$request->email.'</p><p>Thank you</p></div>",
                }
                  ]
                }';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.transmail.com/v1.1/email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Zoho-enczapikey wSsVR60l+hXyWPssmjCrIOhtzVpSAVPzFR973QfwvnX8HPvF8sc7k0KYBg/1FflOE2U/FGNHorwhnB1W2zYJ244pmV1WACiF9mqRe1U4J3x17qnvhDzDWW9dlhCAL4IBwQVvkmJnE8sq+g==",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response);

        if(isset($response->error)){
            return $ajax->fail()
                ->message('Something is wrong')
                ->jscallback()
                ->response();
        }else{
            return $ajax->fail()
                ->jscallback()
                ->message('Voice Mail Send successfully')
                ->response();
        }
    }
}
