<?php
namespace App\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Announcementorganizationmapping;
use App\Model\Autoattendantorganizationmapping;
use App\Model\Timegrouporganizationmapping;
use App\Model\Timeconditionorganizationmapping;
use App\Model\Departmentorganizationmapping;
use App\Model\Extensionorganizationmapping;
use Auth;
use Config;
use DB;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\Image;
use \Illuminate\Support\Facades\View as View;

class Destination
{
	public static function getdestination($params){
		$connection = DatabaseConnection::setConnection(Auth::user()->organization->server);
		$Destinations = Controller::Destination;
        $name = $id = $dest_name = '';
		$dest = explode(',',$params);
		try{
			if (stripos($dest[0], '-') == true) {
			 	$dest_n = explode('-',$dest[0]);
			    $last = array_pop($dest_n);
				$dest_n = array(implode('-', $dest_n), $last);
			    if(is_numeric(end($dest_n))){
			    	$name = $Destinations[$dest_n[0]];
			        $id = $dest_n[1];
			    }else{
			    	$name = $Destinations[$dest[0]];
			    	$id = $dest[1];
			    }
			}else{
				$name = $Destinations[$dest[0]];
				if(is_numeric($dest[1])){
			    	$id = $dest[1];
			    }else{
			    	return $params;
			    }
			}

			if( $name == 'Extension'){
				$Ex_name = $connection->table('users')->where('extension',$id)->get(['name']);
				$dest_name = '<p><i class="ti-id-badge"></i>  '.$name.': '.$id.' ('.$Ex_name[0]->name.')</p>';
			}
			if( $name == 'Auto Attendant'){
				$Auto_name = $connection->table('ivr_details')->where('id',$id)->get(['name']);
				$dest_name = '<p><i class="ti-bag"></i>  '.$name.': '.$Auto_name[0]->name.'</p>';
			}
			if( $name == 'Announcement'){
				$Ann_name = $connection->table('announcement')->where('announcement_id',$id)->get(['description']);
				$dest_name = '<p><i class="ti-announcement"></i>  '.$name.': '.$Ann_name[0]->description.'</p>';
			}
			if( $name == 'Time Condition'){
				$Tc_name = $connection->table('timeconditions')->where('timeconditions_id',$id)->get(['displayname']);
				$dest_name = '<p><i class="ti-timer"></i>  '.$name.': '.$Tc_name[0]->displayname.'</p>';
			}
			if( $name == 'Department'){
				$D_name = $connection->table('ringgroups')->where('grpnum',$id)->get(['description']);
				$dest_name = '<p><i class="ti-layout-grid2"></i>  '.$name.': '.$id.' ('.$D_name[0]->description.')</p>';
			}
			if( $name == 'Hang up call'){
				//$D_name = $connection->table('ringgroups')->where('grpnum',$id)->get(['description']);
				$dest_name = '<p><i class="ti-close"></i>  '.$name.' </p>';
			}

            if( $name == 'Voice Mail'){
                $vmMessages = Controller::VOICE_MAIL_MESSAGES;
                $key = preg_replace('/[0-9]+/', '', $id);
                $extension = preg_replace('/[a-zA-Z]/', '', $id);
                $vm = isset($vmMessages[$key]) ? $vmMessages[$key] : '';
                $dest_name = '<p><i class="ti-microphone"></i>  Voice Mail - ' . $vm . ' (Ext '.$extension.')</p>';
            }
	        return $dest_name;
    	}catch (\Exception $exception){
            return $exception->getMessage();
        }
	}
}
?>