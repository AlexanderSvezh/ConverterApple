<?php
function convert_csv_to_ics($File_name,$Headmaster_name)
{
	$temp = explode(".",$File_name);
	$File_name = $temp[0];
	$FAA = $temp[0];
	$fl = fopen ($File_name.".csv",'rt');
	if ($Headmaster_name=="") 
	{
		$File_name.=".ics";
	}
	else 
	{
		$File_name.= "(".$Headmaster_name.")".".ics";	
	}
	$fl_rez = fopen($File_name,'w');
	fwrite($fl_rez,"BEGIN:VCALENDAR\nCALSSCALE:GREGORIAN\n");
	if ($fl) 
	{
		$fm = file ($FAA.".csv");
		$mc = count ($fm);
		for($i = 0; $i<$mc; $i++)
		{
			$ms = explode(";",$fm[$i]);
			if ($ms[0] != "")
			{	
				$date =explode(" ",$ms[0]); 
				$day = $date[0];
				switch($date[1])
				{
					case "янв" : $month = "01"; break;
					case "фев" : $month = "02"; break;
					case "мар" : $month = "03"; break;
					case "апр" : $month = "04"; break;
					case "май" : $month = "05"; break;
					case "июн" : $month = "06"; break;
					case "июл" : $month = "07"; break;
					case "авг" : $month = "08"; break;
					case "сен" : $month = "09"; break;
					case "окт" : $month = "10"; break;
					case "ноя" : $month = "11"; break;
					case "дек" : $month = "12"; break;
				}
				$year = "20".$date[2];
				$date = $year.$month.$day;
				$str = "";
				//$pr=false;
				//$str.=$date."<br>";
				for($j=1; $j<count($ms)-1; $j++)
				{
					if ($j<3)  $str.=$ms[$j]."<br>";
					else
					{
						switch($j)
						{
							case 3 : $btime = "0830"; $etime = "1000"; break;
							case 4 : $btime = "1010"; $etime = "1140"; break;
							case 5 : $btime = "1220"; $etime = "1350"; break;
							case 6 : $btime = "1400"; $etime = "1530"; break;
							case 7 : $btime = "1555"; $etime = "1725"; break;
							case 8 : $btime = "1735"; $etime = "1905"; break;
						}
						if ($ms[$j]!="")
						{
							$H_name = explode(",",$ms[$j]);
							if ($Headmaster_name=="")
							{
								fwrite($fl_rez,"BEGIN:VEVENT\n");
								fwrite($fl_rez,"DTSTART:".$date."T".$btime."00Z\n");
								fwrite($fl_rez,"DTEND:".$date."T".$etime."00Z\n");
								fwrite($fl_rez,"SUMMARY:".(iconv("WINDOWS-1251","UTF-8",$H_name[0].$H_name[1].$H_name[2]))."\n");
								fwrite($fl_rez,"LOCATION:".(iconv("WINDOWS-1251","UTF-8","Аудитория №".$H_name[3]))."\n");
								//$str.=$btime."-".$etime."  ";
								//$pr=true;
								//$str.=$ms[$j]."<br>";
								fwrite($fl_rez,"END:VEVENT\n");
							}
							else
							{
								if (strpos($H_name[1],$Headmaster_name)!==false)
								{
									fwrite($fl_rez,"BEGIN:VEVENT\n");
									fwrite($fl_rez,"DTSTART:".$date."T".$btime."00Z\n");
									fwrite($fl_rez,"DTEND:".$date."T".$etime."00Z\n");
									fwrite($fl_rez,"SUMMARY:".(iconv("WINDOWS-1251","UTF-8",$H_name[0].$H_name[1].$H_name[2]))."\n");
									fwrite($fl_rez,"LOCATION:".(iconv("WINDOWS-1251","UTF-8","Аудитория №".$H_name[3]))."\n");
									//$str.=$btime." - ".$etime."  ";
									//$pr=true;
									//$str.=$ms[$j]."<br>";
									fwrite($fl_rez,"END:VEVENT\n");
								}
							}
						}
					}
				}
				//if ($pr) echo $str."<br>";
			}	
		}
	}
	fwrite($fl_rez,"END:VCALENDAR\n");
	fclose($fl_rez);
	fclose($fl);
}
?>