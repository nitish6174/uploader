<div class="wrapper" id="uploadWrapper">

<h3>Public repository</h3>

<?php

require '../database/dbconf.php';
if( @mysql_connect('localhost',$db_username,$db_password) && @mysql_select_db($db_name) )
{
	$query = "SELECT url FROM `public` WHERE 1;";
	$query_run_user = mysql_query($query);
	$nrows = mysql_num_rows($query_run_user);
	echo "<table class=\"table table-striped\">";
	echo "<thead>
		<tr>
        	<th  style=\"text-align:center\">Filename</th>
        	<th  style=\"text-align:center\">Url</th>
        	<th  style=\"text-align:center\">Uploaded by</th>
        	<th  style=\"text-align:center\">Actions</th>
    	</tr>
    	</thead>
    	<tbody  align=\"center\">";

	for($i=0;$i<$nrows;$i++)
	{
		$url = mysql_result($query_run_user,$i,'url');
		$query = "SELECT * FROM `uploads` WHERE `url`='$url';";
		$query_run_uploads = mysql_query($query);
		$uploadedby = mysql_result($query_run_uploads,0,'uploadedby');
		$name = mysql_result($query_run_uploads,0,'name');
		$password = mysql_result($query_run_uploads,0,'password');
		echo "<tr>";
		echo "<td>";
		echo "$name";
		echo "</td>";
		// echo "<td><span class=\"host\"></span>/u/$url</td>";
		echo "<td>10.0.2.26/uploader/u/$url</td>";
		echo "<td>";
		if($uploadedby=="public")
			echo "Anonymous";
		else
			echo "$uploadedby";
		echo "</td>";
		echo "<td>";
		echo "<a class=\"btn btn-primary btn-sm\" href=\"u/$url\">Download</a>";
		// echo "<button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"DownloadButton('$url')\">Download</button>";
		echo "</td>";
		
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}

else
	echo "Cannot connect to database\n\n";

?>


</div>


<link rel="stylesheet" type="text/css" href="css/views.css">
<script type="text/javascript" src="js/views.js"></script>

<script type="text/javascript">
	$('.host').each(function(){
		// $(this).html(location.host);
		$(this).html('localhost');
	});
</script>