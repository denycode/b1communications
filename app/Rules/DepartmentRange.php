<?php

namespace App\Rules;

use App\Model\Organization;
use Illuminate\Contracts\Validation\Rule;

class DepartmentRange implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $department_ranges = Organization::where('department_range','!=','')->pluck('department_range');
        $pass = true;
        foreach ($department_ranges as $department_range){
            $range = explode('-',$department_range);
            $department_range_numbers = range($range[0],$range[1]);
            $result = array_search(trim($value),$department_range_numbers);
            /*var_dump(is_numeric($result));
            echo '<pre>';
            echo $result.'---'; print_r($department_range_numbers);
            die($value);*/
            if(is_numeric($result)){
                $pass = false;
                return $pass;
                break;
            }
        }
        return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }

    public function checkRange($from,$to){
        $DBdepartment_ranges = Organization::where('department_range','!=','')->pluck('department_range');
        $pass = true;
        foreach ($DBdepartment_ranges as $DBdepartment_range){

            $range = explode('-',$DBdepartment_range);
            $department_range_numbers = range($range[0],$range[1]);
            $input_department_range_numbers = range($from,$to);
            $matches = array_intersect($department_range_numbers, $input_department_range_numbers);
            if(count($matches) > 0){
                $pass = false;
                return $pass;
                break;
            }
        }
        return $pass;
    }
}
