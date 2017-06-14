<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('buildDayDropdown'))
{
    function buildDayDropdown($name='',$value='')
    {
        $days = range(1, 31);
		$day_list[''] = 'Day';
        foreach($days as $day)
        {
            $day_list[$day] = $day;
        } 		
        return form_dropdown($name, $day_list, $value);
    }
}	

if ( !function_exists('buildYearDropdown'))
{
	function buildYearDropdown($name='',$value='')
    {        
        $years = range(1922, date("Y"));
		$year_list[''] = 'Year';
        foreach($years as $year)
        {
            $year_list[$year] = $year;
        }    
        
        return form_dropdown($name, $year_list, $value);
    }
}

if (!function_exists('buildMonthDropdown'))
{
    function buildMonthDropdown($name='',$value='')
    {
        $month=array(
			''	=>'Month',
            '01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December');
        return form_dropdown($name, $month, $value);
    }
}