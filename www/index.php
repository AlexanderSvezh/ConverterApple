<?php
include "parser.php";
if( isset($_POST['posted']) )
{
	if( empty($_FILES['file']) )
	{
		echo "select a file";
		exit;
	}
 
	$f_name =$_FILES['file']['name'];
	$f_tmp  =$_FILES['file']['tmp_name'];
	//echo $file_tmp."<br>";
	//echo "<b>name:</b> $file_name<br />";
	//echo $_POST['file'];
	//convert_csv_to_ics($_FILES['file'],$_POST['Headm']);
	if( !move_uploaded_file("$f_tmp", "$f_name") )
	{
		//echo "copping failed";
		exit;
	} 
	else 
	{
		convert_csv_to_ics($f_name,$_POST['Headm']);
		$f_name_mas = explode(".",$f_name);
		unlink($f_name);
		$myurl = $f_name_mas[0];
		if ($_POST['Headm']!="") $myurl.="(".$_POST['Headm'].")";
		header("Location:".iconv("WINDOWS-1251","UTF-8",$myurl).".ics");
		$myurl = iconv("WINDOWS-1251","UTF-8",$myurl).".ics";
		unlink($myurl);
	}
}
?> 
<form action ="<?php echo $_SERVER['PHP_SELF']; ?>" method ='POST' enctype ='multipart/form-data'>
	<body style='background: url("img/1.jpg") '></body>
	<input type = 'hidden' name = 'posted' value = 'true'>
	<input type = 'file' name = 'file'><br />
	<br />
	Имя преподавателя:
	<input type = 'text' name = 'Headm'><br />
	<input type = 'submit' value ='upload'><br /> 
	<br />
	<a href="manual.html">Инструкция по использованию:</a> <br />
</form> 
