<?php
namespace App\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Departmentorganizationmapping;
use App\Model\Organization;
use Auth;
use Config;
use DB;
use Illuminate\Support\Facades\Artisan;
use Intervention\Image\Image;
use \Illuminate\Support\Facades\View as View;

class Helper
{
    public static function ajax_pagination($page,$records,$total_records,$title,$record_per_page) {
        $prev = $page - 1;
        $next = $page + 1;
        $adjacents = "2";
        $lastpage = ceil($total_records/$record_per_page);
        $lpm1 = $lastpage - 1;
        $pagination = "";
        if($lastpage > 1)
        {
            $pagination .= "<div class='pagination'>";
            if ($page > 1)
                $pagination.= "<a href=\"#Page=".($prev)."\" onClick='changePagination(".($prev).");'>&laquo; Previous&nbsp;&nbsp;</a>";
            else
                $pagination.= "<span class='disabled'>&laquo; Previous&nbsp;&nbsp;</span>";
            if ($lastpage < 7 + ($adjacents * 2))
            {
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                    else
                        $pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";

                }
            }

            elseif($lastpage > 5 + ($adjacents * 2))
            {
                if($page < 1 + ($adjacents * 2))
                {
                    for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"#Page=".($lpm1)."\" onClick='changePagination(".($lpm1).");'>$lpm1</a>";
                    $pagination.= "<a href=\"#Page=".($lastpage)."\" onClick='changePagination(".($lastpage).");'>$lastpage</a>";

                }
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<a href=\"#Page=\"1\"\" onClick='changePagination(1);'>1</a>";
                    $pagination.= "<a href=\"#Page=\"2\"\" onClick='changePagination(2);'>2</a>";
                    $pagination.= "...";
                    for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";
                    }
                    $pagination.= "..";
                    $pagination.= "<a href=\"#Page=".($lpm1)."\" onClick='changePagination(".($lpm1).");'>$lpm1</a>";
                    $pagination.= "<a href=\"#Page=".($lastpage)."\" onClick='changePagination(".($lastpage).");'>$lastpage</a>";
                }
                else
                {
                    $pagination.= "<a href=\"#Page=\"1\"\" onClick='changePagination(1);'>1</a>";
                    $pagination.= "<a href=\"#Page=\"2\"\" onClick='changePagination(2);'>2</a>";
                    $pagination.= "..";
                    for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href=\"#Page=".($counter)."\" onClick='changePagination(".($counter).");'>$counter</a>";
                    }
                }
            }
            if($page < $counter - 1)
                $pagination.= "<a href=\"#Page=".($next)."\" onClick='changePagination(".($next).");'>Next &raquo;</a>";
            else
                $pagination.= "<span class='disabled'>Next &raquo;</span>";

            $pagination.= "</div>";
            return $pagination;
        }

    }

    /**
     * Created By : Gurpreet Singh
     * Purpose : Get dynamic pagination version 2
     *
     * @param $page
     * @param $position
     * @param $record_per_page
     * @param $records
     * @param $total_records
     * @return string
     */
    public static function ajax_pagination_v2($page,$position,$record_per_page,$records,$total_records){
        $pagination = '';

        /************ Previous button ----- *********************/
        if($page == 1){
            $pagination .= '<a class="paginate_button" aria-controls="taskList" )=""><i class="fa fa-chevron-left"></i></a>';
        }elseif ($page > 1){
            $pagination .= '<a class="paginate_button" aria-controls="taskList" data-idx="'.($page - 1).'" tabindex="'.($page - 1).'" onclick="pagination_v2(this,\'All\')"><i class="fa fa-chevron-left"></i></a>';
        }
        /************ Previous button ----- *********************/

        $pagination .= '<b>'.($position + 1).'</b> - <b>'.($total_records >= $record_per_page ? $record_per_page : $total_records).' of '.$total_records.'</b>';


        /************ Next button ----- *********************/
        if(($total_records) > $record_per_page){
            $pagination .= '<a class="paginate_button" aria-controls="taskList" data-idx="'.($page + 1).'" tabindex="'.($page + 1).'" onclick="pagination_v2(this,\'All\')"><i class="fa fa-chevron-right"></i></a>';
        }else{
            $pagination .= '<a class="paginate_button" aria-controls="taskList" )=""><i class="fa fa-chevron-right"></i></a>';
        }
        /************ Next button ----- *********************/
        return $pagination;
    }

    public static function pagination_v2($total_records,$records_per_page,$page,$type,$position =0,$taskcount = 0,$funCnt = 2){
        $start = ($page - 1) * $records_per_page;
        $prev = $page - 1;
        $next = $page + 1;
        $pagination = "";
        $lastpage = ceil($total_records / $records_per_page);
        if($lastpage > 1){
            $pagination .= "<div class='dataTables_paginate paging_simple_numbers mlst-pgn-poschn' id='taskList_paginate'>";

            if($prev == 0){
                $pagination .= "<a class='paginate_button disabled mr-1' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList'><i class='fas fa-angle-double-left p-1' style='color: #b7dee8;'></i></a>";

                $pagination .= "<a class='paginate_button disabled' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList'><i class='fa fa-chevron-left p-1' style='color: #b7dee8;'></i></a>";

            } else {
                $pagination .= "<a class='paginate_button mr-1' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList' data-idx='1' onclick=pagination_v".$funCnt."(this,'$type')><i class='fas fa-angle-double-left p-1' style='color: #b7dee8;'></i></a>";

                $pagination .= "<a class='paginate_button' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList' data-idx='".($prev)."' onclick=pagination_v".$funCnt."(this,'$type')><i class='fa fa-chevron-left p-1' style='color: #b7dee8;'></i></a>";
            }
            $nPos = $position + 1;
            if(($taskcount >= $records_per_page) && $position == 0) {
                $pagination .= " <b>" . $nPos . "</b> - <b>" . $records_per_page . " of " . $total_records ."</b>";
            } else if(($taskcount >= $records_per_page) && $position > 0) {
                $recds = $position + $taskcount;
                $pagination .= " <b>" . $nPos. "</b> - <b>" . $recds . " of " . $total_records ."</b>";
            } else {
                $recds = $position + $taskcount;
                $pagination .= " <b>" . $nPos . "</b> - <b>" . $recds . " of " . $total_records ."</b>";
            }

            if($next == ($lastpage + 1)){
                $pagination .= " <a class='paginate_button disabled' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList'><i class='fa fa-chevron-right p-1' style='color: #b7dee8;'></i></a>";

                $pagination .= " <a class='paginate_button disabled' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList'><i class='fas fa-angle-double-right p-1' style='color: #b7dee8;'></i></a>";

            } else {
                $pagination .= " <a class='paginate_button' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList' data-idx='".($next)."' tabindex='" .($next). "' onclick=pagination_v".$funCnt."(this,'$type')><i class='fa fa-chevron-right p-1' style='color: #b7dee8;'></i></a>";

                $pagination .= " <a class='paginate_button' style='border: 1px solid #b7dee8;cursor: pointer;' aria-controls='taskList' data-idx='".($lastpage)."' tabindex='" .($lastpage). "' onclick=pagination_v".$funCnt."(this,'$type')><i class='fas fa-angle-double-right p-1' style='color: #b7dee8;'></i></a>";
            }

            $pagination .="</div>";
        }
        return $pagination;
    }

    /**
     * Created By : Gurpreet Singh
     * Purpose    : To get particular value from associative array
     *
     * @param null $parent
     * @param $module
     * @param $right
     * @param $array
     * @return null
     */
    public static function searchForId($parent = null,$module,$right, $array) {
        foreach ($array as $key => $val) {
            if ($val['parents'] === $parent && $val['module'] === $module && $val['rights_name'] == $right) {
                return $val['is_rights'];
            }
        }
        return null;
    }

    /**
     * Created By : Gurpreet Singh
     * Purpose    : To check the permission for active user.
     *
     * @param null $parent
     * @param $module
     * @param $right
     * @return bool
     */
    public static function CheckPermission($parent = '',$module,$right){
        $permissions = Auth::user()->permissions;
        //echo '<pre>'; print_r($permissions); echo '</pre>'; die;
        if($permissions){
            foreach ($permissions as $key => $val) {
                if ($val->parents === $parent && $val->module === $module && $val->rights_name == $right) {
                    return $val->is_rights == 1 ? true : false;
                }
            }
        }
        return false;
    }

    public static function setEnv($envKey,$envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = strtok($str, "{$envKey}=");
        echo env('DB_HOST2');
        echo "{$envKey}={$oldValue}";  die;
        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }

    public static function format_phonenumber($phone_number)
    {
        $count = strlen((string) $phone_number);
        if($count > 10)  $phone_number = (int) substr((string) $phone_number, 1);
        else if($count < 10)  return $phone_number;
        $cleaned = preg_replace('/[^[:digit:]]/', '', $phone_number);
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
    }

    public static function OrgNotFound($exist = false,$view){
        if(!$exist){
            return 'errors.404.organization';
        }
        return $view;
    }

    public static function showTooltip($module,$hoverfield){
        try{
            $fields = config('helps.modules.'.$module.'.fields');
            $help_text = '';
            if(count($fields) > 0){
                foreach ($fields as $field){
                    if($field['key'] == $hoverfield){
                        $help_text = $field['help_text'];
                        break;
                    }
                }
            }

            $html = View::make('common.tooltip',[
                'help_text' => $help_text
            ])->render();

            return $html;
        }catch (\Exception $exception){
            return '';
        }
    }

    public static function findNextDepartmentID($organization){
        try{
            $connection = DatabaseConnection::setConnection($organization->server);

            $department_range_arr = explode('-',$organization['department_range']);
            $department_range_numbers = range($department_range_arr[0],$department_range_arr[1]);
            $DBdepartment_ids = Departmentorganizationmapping::where('server_id',$organization->server_ID)->pluck('department_id')->toArray();

            $new_list=array_diff($department_range_numbers,$DBdepartment_ids);

            $grpnums = $connection->table('ringgroups')
                ->whereIn('grpnum',$new_list)
                ->pluck('grpnum')
                ->toArray();

            $new_list1 = array_values(array_diff($new_list,$grpnums));
            return count($new_list1) > 0 ? $new_list1[0] : false;

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public static function getDateTime($timeslotinfo = '09:00-12:00|*|*|*'){
        $timeslotArr = explode("|",$timeslotinfo);
        $timeStartHour = $timeStartMintue = $timeEndHour = $timeEndMintue = 0;
        $startDisplayDay = $endDisplayDay = $startDayValue = $endDayValue = '';

        //Time slot parsing
        if(isset($timeslotArr[0]) && $timeslotArr[0] != '*'){
            $timeinfo = explode('-',$timeslotArr[0]);

            $timeStartInfo = explode(':',$timeinfo[0]);
            $timeStartHour = $timeStartInfo[0];
            $timeStartMintue = $timeStartInfo[1];

            $timeEndInfo = explode(':',$timeinfo[1]);
            $timeEndHour = $timeEndInfo[0];
            $timeEndMintue = $timeEndInfo[1];
        }

        //Week days parsing
        if(isset($timeslotArr[1]) && $timeslotArr[1] != '*'){
            $daysinfo = explode('-',$timeslotArr[1]);
            $startDisplayDay = isset(Controller::WEEK_DAYS[$daysinfo[0]]) ? Controller::WEEK_DAYS[$daysinfo[0]] : '';
            $endDisplayDay = isset(Controller::WEEK_DAYS[$daysinfo[1]]) ? Controller::WEEK_DAYS[$daysinfo[1]] : '';
            $startDayValue = isset($daysinfo[0]) ? $daysinfo[0] : '';
            $endDayValue = isset($daysinfo[1]) ? $daysinfo[1] : '';
        }

        return [
            'start_hour' => $timeStartHour,
            'start_mintue' => $timeStartMintue,
            'end_hour' => $timeEndHour,
            'end_mintue' => $timeEndMintue,
            'startDisplayDay' =>  $startDisplayDay,
            'endDisplayDay' =>  $endDisplayDay,
            'startDayValue' =>  $startDayValue,
            'endDayValue' =>  $endDayValue,
        ];
    }

    public static function createDateTime($request = '',$timegroup_id = ''){
        
            $time = $request->time[$timegroup_id];
            $week = $request->week[$timegroup_id];
            if( $week['sweek'] == null || $week['eweek'] == null){
                $times = $time['shour'].':'.$time['sminut'].'-'.$time['ehour'].':'.$time['eminut'].'|*|*|*';
            }else{
                $times = $time['shour'].':'.$time['sminut'].'-'.$time['ehour'].':'.$time['eminut'].'|'.$week['sweek'].'-'.$week['eweek'].'|*|*';
            }
            return $times;

    }

}
?>
