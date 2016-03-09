<div class="wrapper" id="uploadWrapper">

<h3>Files uploaded by you</h3>

<?php

session_start();
if(isset($_SESSION['username']) && !empty($_SESSION['username']))
	$user = $_SESSION['username'];
else
	$user = "public";

require '../database/dbconf.php';
if( @mysql_connect('localhost',$db_username,$db_password) && @mysql_select_db($db_name) )
{
	$query = "SELECT * FROM `uploads` WHERE `uploadedby`='$user';";
	$query_run = mysql_query($query);
	$nrows = mysql_num_rows($query_run);
	echo "<table class=\"table table-striped\">";
	echo "<thead>
		<tr>
        	<th  style=\"text-align:center\">Filename</th>
        	<th  style=\"text-align:center\">Url</th>
        	
        	<th  style=\"text-align:center\">Actions</th>
    	</tr>
    	</thead>
    	<tbody  align=\"center\">";
	for($i=0;$i<$nrows;$i++)
	{
		$url = mysql_result($query_run,$i,'url');
		$name = mysql_result($query_run,$i,'name');
		echo "<tr>";
		echo "<td>$name</td>";
		// echo "<td><span class=\"host\"></span>/u/$url</td>";
		echo "<td>localhost/u/$url</td>";
		echo "<td><a class=\"btn btn-primary btn-sm\" href=\"u/$url\">Download</a> ";		
		echo " <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteUpload('$url');\">Delete</button></td>";
		echo "</tr>";
	}
}
else
	echo "Cannot connect to database\n\n";

?>


</div>


<link rel="stylesheet" type="text/css" href="css/views.css">
<script type="text/javascript" src="js/views.js"></script>

<script type="text/javascript">
	$('.host').each(function(){
		$(this).html(location.host);
	});
	function deleteUpload(url)
	{
		var response = confirm("Are you sure you want to delete this file?");
		if(response==true)
		{			
			$.post("../ajax/delete.php",{url:url},function(data,status){
				console.log($('response',data).html());
			});
		}
	}
</script>