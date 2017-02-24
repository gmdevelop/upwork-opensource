<?php

class DatetimeHelper {
    public static function getMonthByNum($month, $isShort = false, $isLowCase = false) {
        $return = '';

        switch ($month) {
            case 1: $return = ($isShort ? 'Jan' : 'January'); break;
            case 2: $return = ($isShort ? 'Feb' : 'February'); break;
            case 3: $return = ($isShort ? 'Mar' : 'March'); break;
            case 4: $return = ($isShort ? 'Apr' : 'April'); break;
            case 5: $return = ($isShort ? 'May' : 'May'); break;
            case 6: $return = ($isShort ? 'Jun' : 'June'); break;
            case 7: $return = ($isShort ? 'Jul' : 'July'); break;
            case 8: $return = ($isShort ? 'Aug' : 'August'); break;
            case 9: $return = ($isShort ? 'Sep' : 'September'); break;
            case 10: $return = ($isShort ? 'Oct' : 'October'); break;
            case 11: $return = ($isShort ? 'Nov' : 'November'); break;
            case 12: $return = ($isShort ? 'Dec' : 'December'); break;
        }

        $isLowCase and $return = strtolower($return);

        return $return;
    }
}
