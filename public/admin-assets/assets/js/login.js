function LoginAdminProcess (objectElement)
{
    $('#spinner').show();
    $('#loadername').html('Loading..');
    var status=0;
    var user_name =$('#user_gmail').val();
	if(user_name.trim()=='')
	{
	    $('#user_gmail').attr('style','border:1px solid red;height:45px; padding:15px;');
        $('#spinner').hide();
        $('#loadername').html('Sign In');
        status=1;
	}
	var password =$('#user_password').val();
	if(password.trim()=='')
	{
	$('#user_password').attr('style','border:1px solid red;height:45px; padding:15px;');
    $('#spinner').hide();
    $('#loadername').html('Sign In');
    status=1;
	}
	if(status==1)
	{
		return false;
	}
	var datastring =$('#login-form').serialize();
	$.post(base_url+"login/loginAdminProcess",datastring,function(response){
	  if(response.message=='ok')
	  {
	        $('#spinner').hide();
            $('#loadername').html('Sign In');
	        $('#login-error').hide();	
	        $('#login-success').show();
	        window.location=base_url+"dashboard";
	  }else{
	        $('#spinner').hide();
            $('#loadername').html('Sign In');
 	        $('#login-success').hide();
	        $('#login-error').show();	
      }
	});
}