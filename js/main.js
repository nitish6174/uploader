// Nav bar highlighting
$('#menuBar li').click(function(e){
	$('#navbar li.active').attr('class','');	
	$(this).attr('class','active');
});
// Error message of modal 
$('#loginAlert').hide();
$('#signupAlert').hide();


render('upload');
function render(viewpage)
{
	switch(viewpage)
	{
		case 'upload': $('#page').load('views/upload.php'); break;
		case 'repository': $('#page').load('views/repository.php'); break;
	}
}

function login()
{
	var usernameField = document.querySelector('#loginUsername');
	var passwordField = document.querySelector('#loginPassword');

	if(usernameField.value=="" || passwordField.value=="")
	{
		$('#loginAlert .msg').text('Both fields are required');
		$('#loginAlert').show();
	}
	else
	{
		$.post('session/login.php',
		{
			username: usernameField.value,
			password: passwordField.value
		},
		function(data,status)
		{
			var responseMsg = $('response',data).text();
			if(responseMsg=='OK')
			{
				$('#loginAlert').hide();
				$('#loginModal').modal('hide');
				window.location = 'dashboard.php';
			}
			else
			{
				$('#loginAlert .msg').text(responseMsg);
				$('#loginAlert').show();
			}
		}
		);
	}
	return false;
}

function signup()
{
	var usernameField = document.querySelector('#signupUsername');
	var passwordField = document.querySelector('#signupPassword');
	var passwordReField = document.querySelector('#signupPasswordRe');

	if(usernameField.value=="" || passwordField.value=="" || passwordReField.value=="")
	{
		$('#signupAlert .msg').text('All fields are required');
		$('#signupAlert').show();
	}
	else if(passwordField.value!=passwordReField.value)
	{
		$('#signupAlert .msg').text('Passwords do not match');
		$('#signupAlert').show();
	}
	else
	{
		$.post('session/signup.php',
			{
				username: usernameField.value,
				password: passwordField.value
			},
			function(data,status)
			{
				var responseMsg = $('response',data).text();
				if(responseMsg=='OK')
				{
					$('#signupAlert').hide();
					$('#signupModal').modal('hide');
					var response = confirm('Your account created successfully! Want to login now?');
					if(response==true)
					{
						$.post('session/login.php',
							{
								username: usernameField.value,
								password: passwordField.value
							},
							function(data,status)
							{
								window.location = 'dashboard.php';
							}
						);
					}
				}
				else
				{
					$('#signupAlert .msg').text(responseMsg);
					$('#signupAlert').show();
				}                
			}
		);
	}
	return false;
}