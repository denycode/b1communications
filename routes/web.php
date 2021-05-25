<?php
namespace App\Http\Controllers\Auth;
use App\Library\Ajax;
use App\Model\UserDetail;
use App\Model\UserRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache',array('as'=>'register',function(){
    Artisan::call('cache:clear');
    return true;
}));


Route::get('login',array('as'=>'login','name' => 'login',function(){
    //echo bcrypt('aAvneet@123');
    if(Auth::check()){
        return redirect('dashboard');
    }
    return view('users.login');
}));

Route::get('/',array('as'=>'login','name' => 'login',function(){
    //echo bcrypt('aAvneet@123');
    if(Auth::check()){
        return redirect('dashboard');
    }
    return view('users.login');
}));


Route::get('password/emails',array('as'=>'resetpassword',function(){
    return view('users.forgetpassword');
}));

Route::post('/login', function(Request $request,Ajax $ajax){
    $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    $messages = [
        'email.required' => 'Email is required',
        'email.email' => 'Email format is invaild',
        'password.required' => 'Password is required'
    ];
    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) {
        return $ajax->fail()
            ->form_errors($validator->errors())
            ->jscallback()
            ->response();
    }

    $credentials = array('email' => $request->input('email'), 'password' => $request->input('password'),'is_active' => 1);

    if(Auth::attempt($credentials, true)){
        Auth::login(Auth::user(), true);
        return $ajax->success()->redirectTo('dashboard')->jscallback()->response();

    } else {
        //return 'Sorry, but your Credentials seem to be wrong';
        return $ajax->fail()
            ->message('Sorry, but your Credentials seem to be wrong')->jscallback()->response();

        /*$validator->errors()->add('email', 'Sorry, but your Credentials seem to be wrong');
        return $ajax->fail()
            ->form_errors($validator->errors())
            ->jscallback()
            ->response();*/
    }

});

Route::get('logout',function (){
    Auth::logout();
    return redirect('login');
});

Route::group(['middleware' => ['auth']], function () {
   // Route::get('/', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

    /*************** Profile - Start************/
    Route::get('/profile/{uid}', 'UserController@viewProfile');
    Route::post('/updateprofile', 'UserController@updateProfile');
    Route::post('/user/metadata', 'UserController@updateUserMeta');
    Route::post('/user/profileimage', 'UserController@updateProfileImage');
    /*************** Profile - End************/

    /**************** Extension - Start *****************/
    Route::get('/extensions', 'ExtensionController@index')->name('extension.index');
    Route::get('/extensions/get', 'ExtensionController@getExtensions');
    Route::get('/extension/edit/{id}', 'ExtensionController@editExtension');
    Route::post('/extension/update', 'ExtensionController@updateExtension');

    // Smart Follow
    Route::post('/smartfollow/update', 'ExtensionController@updateSmartFollow');
    /**************** Extension - End *****************/

    /**************** Common functions - Start *****************/
    Route::get('/common/getextensionslist', 'CommonController@getExtensionsList');
    Route::get('/common/addexternalextension', 'CommonController@addExternalExtension');
    Route::post('/common/getextensionslist', 'CommonController@updateExtensionsList');
    Route::get('/common/tooltip/{module}/{field}', 'CommonController@showTooltip');
    /**************** Common functions - End *****************/

    /**************** Phone Numbers - Start *****************/
    Route::get('/phonenumbers', 'PhonenumbersController@index')->name('phonenumber.index');;
    Route::get('/phonenumbers/get', 'PhonenumbersController@getPhonenumbers');
    Route::get('/phonenumber/edit/{id}', 'PhonenumbersController@editPhonenumber');
    Route::post('/phonenumber/update', 'PhonenumbersController@updatePhonenumber');
    /**************** Phone Numbers - End *****************/

    /**************** Announcement - Start *****************/
    Route::get('/announcement', 'AnnouncementController@index')->name('announcement.index');;
    Route::get('/announcement/get', 'AnnouncementController@getAnnouncements');
    Route::get('/announcement/edit/{id}', 'AnnouncementController@editAnnouncement');
    Route::post('/announcement/update', 'AnnouncementController@updateAnnouncement');
    /**************** Announcement - End *****************/

    /**************** Department - Start *****************/
    Route::get('/departments', 'DepartmentController@index')->name('department.index');
    Route::get('/departments/get', 'DepartmentController@getDepartments');
    Route::get('/department/edit/{id}', 'DepartmentController@editDepartment');
    Route::post('/department/update', 'DepartmentController@updateDepartment');
    /**************** Department - End *****************/

    /**************** Organizations - Start *****************/
    Route::get('/organizations', 'OrganizationController@index')->name('organization.index');
    Route::get('/organizations/get', 'OrganizationController@getOrganizations');
    Route::get('/organization/edit/{id}', 'OrganizationController@editOrganization');
    Route::get('/organization/unassignedextensions/{id}', 'OrganizationController@unassignedExtensions');
    Route::get('/organization/unassigneddepartments/{id}', 'OrganizationController@unassignedDepartments');
    Route::get('/organization/unassignedphonenumbers/{id}', 'OrganizationController@unassignedPhoneNumbers');
    Route::get('/organization/unassignedannouncements/{id}', 'OrganizationController@unassignedAnnouncements');
    Route::get('/organization/allusers', 'OrganizationController@allUsers');
    Route::post('/organization/unassignedupdate', 'OrganizationController@unassignedUpdate');
    Route::post('/organization/update', 'OrganizationController@updateOrganization');
    Route::get('/organization/changestatus/{id}', 'OrganizationController@changeStatus');
    Route::get('/organization/access/{id}', 'OrganizationController@changeAccess');
    /**************** Organizations - End *****************/

    Route::get('/users', 'SettingsController@index');
    Route::post('/settings/get', 'SettingsController@getSettings');

    Route::get('/settings/adduser/{id?}', 'SettingsController@addUser');
    Route::post('/settings/adduser', 'SettingsController@postUser');
    Route::get('/settings/deleteuser/{id}', 'SettingsController@trashUser');
    Route::get('/settings/changeuserstatus/{id}', 'SettingsController@changeUserStatus');

    Route::get('/settings/addprofile/{id?}', 'SettingsController@addProfile');
    Route::post('/settings/addprofile', 'SettingsController@postProfile');
    Route::get('/settings/deleteprofile/{id}', 'SettingsController@trashProfile');
    Route::get('/settings/changeprofilestatus/{id}', 'SettingsController@changeProfileStatus');

    Route::get('/settings/permission/{id}', 'SettingsController@profilePermissions');
    Route::post('/profile/permissions', 'SettingsController@updatePermissions');

});

