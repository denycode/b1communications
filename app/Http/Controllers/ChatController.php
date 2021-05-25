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

class ChatController extends Controller
{
    public function index(){
        return view(Helper::OrgNotFound(Auth::user()->IsOrganizationAssigned,'chat.index'),[
            'organization_name' => Auth::user()->IsOrganizationAssigned ? Auth::user()->organization->organization_name : '',
            'redirectTo' => Route('dashboard.index')
        ]);
    }
}