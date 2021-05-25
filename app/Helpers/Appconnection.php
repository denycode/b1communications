<?php
namespace App\Helpers;
use App\Model\Server;
use Config;
use DB;
use Auth;

class Appconnection
{
	public static function appconnGraphql($params){
		
		$endpoint = "http://staging.b1communications.ca/admin/api/api/gql";
		$authToken = $params;
		$query = <<<JSON
			query{
			  fetchAllExtensions {
			    status
			    extension {
			      id
			      extensionId
			    }
			  }
			}
			JSON;
		$json = json_encode(['query' => $query]);
		$headers = array(
				        'User-Agent: PHP Script',
				        'Content-Type: application/json;charset=utf-8',
				        'Authorization: Bearer '.$authToken
				    );

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		

		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return json_decode($response);
	}
}
