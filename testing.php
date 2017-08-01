<?php
class Difference {
    public $years;
    public $months;
    public $days;
    public $totalDays;
    public $invert;
    public function __construct($yearsDif, $monthsDif, $dayDif, $totalDay, $checkInvert){
        $this->years = $yearsDif;
        $this->months = $monthsDif;
        $this->days = $dayDif;
        $this->totalDays = $totalDay;
        $this->invert = $checkInvert;
    }
}

function date_difference($date1, $date2) {
    if (substr($date1, 0, -6) < substr($date2, 0, -6)) {
        $start = $date1;
        $end = $date2;
    } elseif (substr($date1, 0, -6) > substr($date2, 0, -6)) {
        $start = $date2;
        $end = $date1;
    } elseif (substr($date1, 0, -6) == substr($date2, 0, -6)) {
        if (substr($date1, 5, -3) < substr($date2, 5, -3)) {
            $start = $date1;
            $end = $date2;
        } elseif(substr($date1, 5, -3) > substr($date2, 5, -3)) {
            $start = $date2;
            $end = $date1;
        } elseif(substr($date1, 5, -3) == substr($date2, 5, -3)) {
            if (substr($date1, 8) < substr($date2, 8)) {
                $start = $date1;
                $end = $date2;
            } elseif(substr($date1, 8) > substr($date2, 8)) {
                $start = $date2;
                $end = $date1;
            } elseif(substr($date1, 8) == substr($date2, 8)) {
                return 'The dates are the same';
            }
        }
    }
    $yearDif = (substr($end, 0, -6) - substr($start, 0, -6));
    if (substr($start, 5, -3) > substr($end, 5, -3)) {
        $yearDif--;
        $monthDif = ((substr($end, 5, -3) + 12) - substr($start, 5, -3));
    } else {
        $monthDif = (substr($end, 5, -3) - substr($start, 5, -3));
    }
    if (substr($start, 8) > substr($end, 8)) {
        $monthDif--;
        $lastMonth = substr($start, 5, -3) + $monthDif;
        if ($lastMonth > 12) $lastMonth -= 12;
        if ($lastMonth == 1 || $lastMonth == 3 || $lastMonth == 5 || $lastMonth == 7 || $lastMonth == 8 || $lastMonth == 10 || $lastMonth == 12) {
            $daysDif = ((substr($end, 8) + 31) - substr($start, 8));
        } elseif ($lastMonth == 4 || $lastMonth == 6 || $lastMonth == 9 || $lastMonth == 11) {
            $daysDif = ((substr($end, 8) + 30) - substr($start, 8));
        } elseif ($lastMonth == 2 && substr($end, 0, -6)%4 == 0) {
            $daysDif = ((substr($end, 8) + 29) - substr($start, 8));
        } else {
            $daysDif = ((substr($end, 8) + 28) - substr($start, 8));
        }
    } else {
        $daysDif = (substr($end, 8) - substr($start, 8));
    }
    //    Используя функцию ниже, вы не учитываем высокосные года и точное колво дней в месяце, по этому я обратился к strtotime
    //    $totalDays = ($yearDif * 365) + ($monthDif * 30) + $daysDif;
    $totalDays = round(abs(strtotime($start) - strtotime($end))/86400);
    if ($date1 == $start) {
        $invert = true;
    } else {
        $invert = false;
    }
    return new Difference($yearDif, $monthDif, $daysDif, $totalDays, $invert);
}
var_dump(date_difference('2000-12-12', '2005-05-20')) ;
