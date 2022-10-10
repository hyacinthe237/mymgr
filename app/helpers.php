<?php



if (!function_exists('generate_number'))
{
    /**
     * generate_number helper function
     *
     * @param $model
     * @return Int
     */
    function generate_number($model): Int
    {  
        $lastItem = $model->all()->last();
        if ($lastItem):
           $incr = random_int(1, 5);
           $number = $lastItem->number + $incr;
        else:
           $number = 1010010;
        endif;

        $exist = $model->where('number', $number)->first();

        if ($exist) :
            generate_number($model);
        else:
            return $number;
        endif;

    }
}


if (!function_exists('array_sort_by_column'))
{
    /**
     * array_sort_by_column helper function
     *
     * @param Array arr
     * @param $string col
     * @param $string dir
     * @return array
     */
    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC): Void
    {
        $sort_col = array();
        foreach ($arr as $key=> $row):
            $sort_col[$key] = $row[$col];
        endforeach;

        array_multisort($sort_col, $dir, $arr);
     }
}

if (!function_exists('is_empty'))
{
    /**
     * check if a variable is empty and not equal to 0
     *
     * @param $mixed var
     * @return booelan
     */
    function is_empty($var):Bool
    {
        if (empty($var) === true):
        
            if (($var === 0) || ($var === '0')):
                return false;
            endif;

            return true;

        endif;

        return false;
    }
}

