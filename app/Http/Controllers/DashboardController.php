<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index_old(){
$accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImU0NzY3N2U5Yzc0ZmI1YmFlN2RiMjQzMDY4NWI0ZjdlNTIyYmQzNTliYzQ4MDc1ZjU3NjcwZGY1ZDM2NWIzOGJmOTE1NTkxOGI0N2FjMTAxIn0.eyJhdWQiOiI5ZjYzMjBiNmY5NGUwNGMzNGM4OWM0Y2MxYjQxMzlmNTE3Y2RhYWFhODlhNDYwMDhmM2M3NzNhODRkNmFiZThjIiwianRpIjoiZTQ3Njc3ZTljNzRmYjViYWU3ZGIyNDMwNjg1YjRmN2U1MjJiZDM1OWJjNDgwNzVmNTc2NzBkZjVkMzY1YjM4YmY5MTU1OTE4YjQ3YWMxMDEiLCJpYXQiOjE2MTc5OTg1MTIsIm5iZiI6MTYxNzk5ODUxMiwiZXhwIjoxNjE4MDAyMTEyLCJzdWIiOiIiLCJzY29wZXMiOlsiZ3FsIiwicmVzdCJdfQ.VCMXy5pk2QVGReMui9IlA56s-Ab7tw_XyZcQSfDpmtk-FAVD8oe8Aw_C64scfcQ29ffS22VG0ikgnfZ0TPq4yFMJBNNILyKzXFO4UyMYUROISwfYvb4-H1oCpmq3ePjKbtICTfEiyhNOM8Wn1zMN8iIHnC5r_K65brE7Q5kTP0fczlO79jY2tXFr-_Ec8mMU9tGdN2SKpts3tVAAW9XdLrzuKCeav0tlTqdWPBHu_NXPT0tp3oG1jizAnL670WBxbc-VJk8vKKkEMoykiR4q4TPqQGhKHn2ZKn_-C87YBiWoo-v-fCvE3CQDW_kVzZSYFAXbZD_4faGi9_N39fpYRA";

        $endpoint = "http://staging.b1communications.ca/admin/api/api/gql";

        $query = <<<JSON
query{
  fetchVoiceMail(extensionId: 1001) {
    status
    message
    context
    password
    name
    email
    pager
    attach
    saycid
    envelope
    delete
  }
}
JSON;
        $json = json_encode(['query' => $query]);

        $chObj = curl_init();
        curl_setopt($chObj, CURLOPT_URL, 'http://staging.b1communications.ca/admin/api/api/gql');
curl_setopt($chObj, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chObj, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($chObj, CURLOPT_HEADER, false);
curl_setopt($chObj, CURLOPT_VERBOSE, false);
curl_setopt($chObj, CURLOPT_POSTFIELDS, $json);
curl_setopt($chObj, CURLOPT_HTTPHEADER,
    array(
        'User-Agent: PHP Script',
        'Content-Type: application/json;charset=utf-8',
        'Authorization: Bearer '.$accessToken
    )
);

$response = curl_exec($chObj);
        curl_close($chObj);

echo '<pre>';
print_r(json_decode($response,true));
        die;
        return view('dashboard.index');
    }

    public function index(){
        return view('dashboard.index');
    }
}
