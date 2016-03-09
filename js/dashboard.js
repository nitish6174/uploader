// Nav bar highlighting
$('#menuBar li').click(function(e){
	$('#navbar li.active').attr('class','');	
	$(this).attr('class','active');
});

render('upload');
function render(viewpage)
{
	switch(viewpage)
	{
		case 'upload': $('#page').load('views/upload.php'); break;
		case 'repository': $('#page').load('views/repository.php'); break;
		case 'uploaded': $('#page').load('views/uploaded.php'); break;
		case 'shared': $('#page').load('views/shared.php'); break;
	}
}


function logout()
{
	window.location = 'session/logout.php';
}