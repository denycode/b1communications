<?php
namespace App\Helpers;
use App\Model\Server;
use Config;
use DB;
use Auth;

class freepbx
{

	public static function getToken($params = ['client_id' => '', 'client_secret' => '']){
		$freepbx_token_url = config('constant.freepbx_token_url');

		$json = json_encode([
			'grant_type' => 'client_credentials',
			'client_id' => $params['client_id'],
			'client_secret' => $params['client_secret']
		]);

		$chObj = curl_init();
		curl_setopt($chObj, CURLOPT_URL, $freepbx_token_url);
		curl_setopt($chObj, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chObj, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($chObj, CURLOPT_HEADER, false);
		curl_setopt($chObj, CURLOPT_VERBOSE, false);
		curl_setopt($chObj, CURLOPT_POSTFIELDS, $json);
		curl_setopt($chObj, CURLOPT_HTTPHEADER,
			array(
				'User-Agent: PHP Script',
				'Content-Type: application/json;charset=utf-8'
			)
		);

		$response = curl_exec($chObj);
		curl_close($chObj);

		return json_decode($response);
	}

	public static function runGraphQL($params = ['query' => '','auth_token' => '']){
        $freepbx_graphql_url = config('constant.freepbx_graphql_url');
        $authToken = $params['auth_token'];
        $query_string = $params['query'];
        $query = <<<JSON
			$query_string
			JSON;
        $json = json_encode(['query' => $query]);
        $headers = array(
            'User-Agent: PHP Script',
            'Content-Type: application/json;charset=utf-8',
            'Authorization: Bearer '.$authToken
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $freepbx_graphql_url);
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
