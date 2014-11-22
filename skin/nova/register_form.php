<div id="main">
	<div class="wrapper">
		<div id="content">
			<div id="page-title">
				<span class="title"><img src="skin/nova/img/usersplus32.png" border="0" title="Contacts" alt=""> Đăng kí</span>
				<span class="subtitle">Đăng kí tài khoản và tham gia cùng chúng tôi</span>
			</div>

<?php
if( isset( $yplitgroupRegisterError ) and !empty( $yplitgroupRegisterError ) ) { 
?>
<div class="error-box"><?= $yplitgroupRegisterError ?></div>
<?php } ?>


<form method="POST" id="contactForm" action="./index.php?do=register&amp;p=addmember" onSubmit="if( yplitgroupCheckAllFiels() == false ) { return false; } else { return true; }">
<div class="one-column">
	<fieldset>
	<input type="hidden" name="return" value="<?=  ( !empty( $param['return'] ) ? urlencode( $param['return'] ) : '' ) ?>">
		
		<div class="fiel">
			<label for="regusername"><?= $lang['register_username'] ?></label>
			<div class="rightcol"><input class="textbox" id="regusername" type="text" name="username" maxlength="25" value="<?= !empty( $_POST['username'] ) ? $_POST['username'] : '' ?>" onChange="yplitgroupCheckUser()" tabindex="1" />
			</div>
			<div class="rightcol statusbox">
				<div id="statusCheckUsername"></div>
				<div id="checkusernamestatusfail" style="display:none;"><?= $lang['username_is_exist'] ?></div>
				<div id="checkusernamestatusok" style="display:none"><?= $lang['username_is_not_exist'] ?></div>
			</div>
		</div>
		<div class="fiel">
			<label for="regpassword"><?= $lang['register_password'] ?></label>
			<div class="rightcol"><input class="textbox" id="regpassword" type="password" name="password" maxlength="25" value="" tabindex="1" /></div>
		</div>
		<div class="fiel">
			<label for="regpasswordconfirm"><?= $lang['register_passwordconfirm'] ?></label>
			<div class="rightcol"><input class="textbox" id="regpasswordconfirm" type="password" name="passwordconfirm" maxlength="25" value="" tabindex="1" onChange="yplitgroupCheckConfirmPassword();" />
			</div>
			<div class="rightcol statusbox">
				<div id="passwordconfirmstatusfail" style="display:none;"><?= $lang['fail'] ?></div>
				<div id="passwordconfirmstatusok" style="display:none"><?= $lang['ok'] ?></div>
			</div>
		</div>
		
		<div class="fiel">
			<label for="regemail"><?= $lang['register_email'] ?></label>
			<div class="rightcol"><input class="textbox" id="regemail" type="text" name="email" maxlength="25" value="<?= !empty( $_POST['email'] ) ? $_POST['email'] : '' ?>" onChange="yplitgroupCheckEmail()" tabindex="1" /></div>
			<div class="rightcol statusbox">
				<div id="emailstatusfail" style="display:none;"><?= $lang['fail'] ?></div>
				<div id="emailstatusok" style="display:none"><?= $lang['ok'] ?></div>
			</div>
		</div>
		<div class="fiel">
			<label for="regemailconfirm"><?= $lang['register_emailconfirm'] ?></label>
			<div class="rightcol"><input class="textbox" id="regemailconfirm" type="text" name="emailconfirm" maxlength="25" value="<?= !empty( $_POST['emailconfirm'] ) ? $_POST['emailconfirm'] : '' ?>" onChange="yplitgroupCheckConfirmEmail();" tabindex="1" /></div>
			<div class="rightcol statusbox">
				<div id="emailconfirmstatusfail" style="display:none;"><?= $lang['fail'] ?></div>
				<div id="emailconfirmstatusok" style="display:none"><?= $lang['ok'] ?></div>
			</div>
		</div>
		
		<div class="fiel">
		<label for="regdayofbirth"><?= $lang['register_dayofbirth'] ?></label>
		<div class="rightcol">
			<select name="day">
				<?php for( $i=1; $i<=31; $i++ ) { ?>
				<option value="<?= $i ?>" <?php ( ( isset( $_POST['day'] ) and $_POST['day'] == $i ) ? 'selected' : '' ) ?>><?= $lang['day'] . ' ' . $i ?></option>
				<?php } ?>
			</select>
			<select name="month">
				<?php for( $i=1; $i<=12; $i++ ) { ?>
				<option value="<?= $i ?>" <?php ( ( isset( $_POST['month'] ) and $_POST['month'] == $i ) ? 'selected' : '' ) ?>><?= $lang['month'] . ' ' . $i ?></option>
				<?php } ?>
			</select>
			<select name="year">
				<?php for( $i=2012; $i>=1920; $i-- ) { ?>
				<option value="<?= $i ?>" <?php ( ( isset( $_POST['year'] ) and $_POST['year'] == $i ) ? 'selected' : '' ) ?>><?= $i ?></option>
				<?php } ?>
			</select>
		</div>
		</div>
		
		<div class="fiel">
			<label for="reghumanverify">&nbsp;</label>
			<img src="./index.php?do=humanverify&hash=<?= fetch_sessionhash(); ?>">
			<div class="rightcol">&nbsp;</div>
		</div>
		<div class="fiel">
			<label for="reghumanverify"><?= $lang['register_humanverify'] ?></label>
			<div class="rightcol"><input class="textbox" id="reghumanverify" type="text" name="humanverify" maxlength="25" value="" tabindex="1" /></div>
		</div>
		
	</fieldset>
</div>
		
		<?php if( !empty( $profile_variable ) and ( $options['yplitgroup_passport_require_custom_fields_register'] == 1 ) ) { ?>
			<div class="one-column">
				<fieldset>
					<span class="profile_variable"><?= $profile_variable ?></span>
				</fieldset>
			</div>
			
		<?php } ?>
		
		<div class="rightcol">
			<center><p><input type="submit" id="submit" name="submit" value="<?= $lang['register_button'] ?>"/></p></center>
		</div>
	</form>
</div>
<script>
function yplitgroupCheckConfirmPassword()
{
	var $password = document.getElementById('regpassword').value;
	var $regpasswordconfirm = document.getElementById('regpasswordconfirm').value;
	document.getElementById('passwordconfirmstatusfail').style.display = 'none';
	document.getElementById('passwordconfirmstatusok').style.display = 'none';
	if( $password != $regpasswordconfirm )
	{
		document.getElementById('passwordconfirmstatusok').style.display = 'none';
		document.getElementById('passwordconfirmstatusfail').style.display = 'block';
	}
	else
	{
		document.getElementById('passwordconfirmstatusok').style.display = 'block';
		document.getElementById('passwordconfirmstatusfail').style.display = 'none';
	}
	if( $regpasswordconfirm == '' )
	{
		document.getElementById('passwordconfirmstatusfail').style.display = 'none';
		document.getElementById('passwordconfirmstatusok').style.display = 'none';
	}
}
function yplitgroupCheckConfirmEmail()
{
	var $email = document.getElementById('regemail').value;
	var $emailconfirm = document.getElementById('regemailconfirm').value;
	document.getElementById('emailconfirmstatusfail').style.display = 'none';
	document.getElementById('emailconfirmstatusok').style.display = 'none';
	if( $emailconfirm != $email )
	{
		document.getElementById('emailconfirmstatusok').style.display = 'none';
		document.getElementById('emailconfirmstatusfail').style.display = 'block';
	}
	else
	{
		document.getElementById('emailconfirmstatusok').style.display = 'block';
		document.getElementById('emailconfirmstatusfail').style.display = 'none';
	}
	if( $emailconfirm == '' )
	{
		document.getElementById('emailconfirmstatusfail').style.display = 'none';
		document.getElementById('emailconfirmstatusok').style.display = 'none';
	}
}
function yplitgroupCheckAllFiels()
{
	var $username = document.getElementById('regusername').value;
	var $password = document.getElementById('regpassword').value;
	var $passwordconfirm = document.getElementById('regpasswordconfirm').value;
	var $email = document.getElementById('regemail').value;
	var $emailconfirm = document.getElementById('regemailconfirm').value;
	var $humanverify = document.getElementById('reghumanverify').value;
	var $check_userfields = true;
	/*
	var $userfields = new array();
	<?php 
	for( $i=0,$c=count($js_require); $i<$c; $i++ ){ echo "\$userfields[] = '$js_require[$i]';\n"; }
	?>
	for( var i=1; i<=$userfields.length; i++)
	{
		if( document.getElementById($userfields[i]).value == '' )
		{
			$check_userfields = false;
		}
	}
	*/
	if( $username == '' || $password == '' || $passwordconfirm == '' || $email == '' || $emailconfirm == '' || $humanverify == '' || $check_userfields == false )
	{
		alert("<?= $lang['javascript_please_fill_all_fiels'] ?>");
		return false;
	}
	if( $password != $passwordconfirm )
	{
		alert("<?= $lang['javascript_confirm_password_fail'] ?>");
		return false;
	}
	if( $email != $emailconfirm )
	{
		alert("<?= $lang['javascrpt_confirm_email_fail'] ?>");
		return false;
	}
}
function yplitgroupCheckEmail( )
{
	var $email = document.getElementById('regemail').value;
	document.getElementById('emailstatusfail').style.display = 'none';
	document.getElementById('emailstatusok').style.display = 'none';
	if( !$email.match('/(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))/') )
	{
	document.getElementById('emailstatusfail').style.display = 'block';
	document.getElementById('emailstatusok').style.display = 'none';
	}
	else
	{
		document.getElementById('emailstatusfail').style.display = 'none';
		document.getElementById('emailstatusok').style.display = 'block';
	}
}
function yplitgroupcreateObject()
{
	var request_type;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		request_type = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		request_type = new XMLHttpRequest();
	}
	return request_type;
}
var http = yplitgroupcreateObject();
var check = 0;
function yplitgroupCheckUser()
{
	var $username = encodeURIComponent(document.getElementById('regusername').value);
	var check = Math.random();
	var post = 'username='+$username;
	if( $username == '' )
	{
		document.getElementById('statusCheckUsername').innerHTML = '';
		document.getElementById('checkusernamestatusfail').style.display = 'none';
		document.getElementById('checkusernamestatusok').style.display = 'none';
	}
	var url = 'index.php?do=verifyusername'+'&hash='+check;
	http.open('POST', url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.onreadystatechange = yplitgroupCheckUsernameStatus;
	http.send(post);
}
function yplitgroupCheckUsernameStatus()
{
	document.getElementById('checkusernamestatusfail').style.display = 'none';
	document.getElementById('checkusernamestatusok').style.display = 'none';
	document.getElementById('statusCheckUsername').innerHTML = '';
	if( http.readyState == 4 )
	{
		var response = http.responseText;
		document.getElementById('statusCheckUsername').innerHTML = 'Loading...';
		if( response == 'username_is_exist' )
		{
			document.getElementById('statusCheckUsername').innerHTML = '';
			document.getElementById('checkusernamestatusfail').style.display = 'block';
			document.getElementById('checkusernamestatusok').style.display = 'none';
		}
		else
		{
			document.getElementById('statusCheckUsername').innerHTML = '';
			document.getElementById('checkusernamestatusfail').style.display = 'none';
			document.getElementById('checkusernamestatusok').style.display = 'block';
		}
	}
}
</script>