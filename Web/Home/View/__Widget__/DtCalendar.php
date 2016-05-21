<?php
    /*
    $dFirstDay = date('Y-m-01');
    $dLastDay = date('Y-m-d', strtotime($dFirstDay.' + 1 month - 1 day'));
    $iFirstDayInWeek = (int)date('N', strtotime($dFirstDay));
    $iDays = (int)date('j', strtotime($dLastDay));
    $aTempTds = array();
    $sTableContent = '';
    if($iFirstDayInWeek == 7){
        $iFirstDayInWeek = 0;
    }
    for($i = 0; $i < $iFirstDayInWeek; $i++){
        array_push($aTempTds, '<td></td>');
    }
    for($i = 1; $i <= $iDays; $i++){
        array_push($aTempTds, '<td>'.$i.'</td>');
    }
    if(count($aTempTds) % 7 > 0){
        $iTempCount = 7 - count($aTempTds) % 7;
        for($i = 0; $i < $iTempCount; $i++){
            array_push($aTempTds, '<td></td>');
        }
    }
    foreach($aTempTds as $key => $val){
        if($key % 7 == 0){
            $sTableContent .= '<tr>';
        }
        $sTableContent .= $val;
        if(($key + 1) % 7 == 0){
            $sTableContent .= '</tr>';
        }
    }
    */
?>

<div class="dt-calendar">
    <div class="calendar-head">
        <span class="calendar-head-content"></span>
        <div class="switch-month text-bold">
            <a class="prev-month" href="" data-switch="prev"><</a>
            <a class="next-month" href="" data-switch="next">></a>
        </div>
    </div>
    <div class="calendar-body">
        <table class="calendar-table">
            <thead>
                <tr>
                    <th>日</th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
                    <th>六</th>
                </tr>
            </thead>
            <tbody class="calendar-days">
            </tbody>
        </table>
    </div>
</div>
