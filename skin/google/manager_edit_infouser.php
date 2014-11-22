<style>.info_fiel .disable{-webkit-user-select: none; -moz-user-select: none; user-select: none; cursor: default; background:#FFFFFF;color:red}
table.infousertable tr td.left table tr, table.infousertable tr td.right div.fiel {border-top:1px solid rgb(206, 223, 235);}

table.infousertable tr td. right .fiel{ padding:5px; }
table.infousertable tr td. left table tr { padding:5px; }
table.infousertable tr td{padding:10px}
</style>
<div class="manager">
<div class="product-headers">
  <h1 class="redtext"><?= $lang['edit_user_info'] ?>: <?= $info_user['username'] ?></h1>
</div>
<p>
<form action="" method="post">
<input type="hidden" name="userid" value="<?= USERID ?>">
	<table border="0" class="infousertable">
	<tr>
		<td class="left" valign="top" width="50%">
			<table border="0">
				<tr>
					<td>Username: </td>
					<td><input type="text" name="username" id="username" class="info_fiel disable" disabled="disabled" onClick="" value="<?= $info_user['username'] ?>" nofocus></td>
				</tr>
				
				<tr>
					<td>Password: </td>
					<td><a href="./index.php?do=manager&amp;page=editpassword">Edit Password</a></td>
				</tr>
				
				<tr>
					<td>Email: </td>
					<td>
						<input type="text" name="email" id="email" class="info_fiel"  onClick="" value="<?= $info_user['email'] ?>" nofocus>
						<br /><br /><a href="./index.php?do=manager&amp;page=editemail">Edit Email</a>
					</td>
				</tr>
				
				<tr>
					<td>Date of birth: </td>
					<td>
						<input type="text" name="email" id="email" class="info_fiel disable" disabled="disabled" onClick="" value="<?= $info_user['birthday'] ?>" nofocus>
						<br />
						<p style="font-size:75%;color:#8E8E8E;">Chỉ có Administrator mới có thể thay đổi ngày sinh của bạn. Hãy liên hệ với Administrator nếu có thay đổi.</p>
						<select name="showbirthday">
							<option value="0" <?= ( $info_user['showbirthday'] == 0 ) ? 'selected="selected"' : '' ?>>Ẩn tuổi và ngày sinh nhật</option>
							<option value="1" <?= ( $info_user['showbirthday'] == 1 ) ? 'selected="selected"' : '' ?>>Chỉ hiện tuổi</option>
							<option value="3" <?= ( $info_user['showbirthday'] == 3 ) ? 'selected="selected"' : '' ?>>Chỉ hiên ngày sinh và tháng sinh</option>
							<option value="2" <?= ( $info_user['showbirthday'] == 2 ) ? 'selected="selected"' : '' ?>>Hiển thị tuổi và ngày, tháng, năm sinh</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Trang chủ: 
					</td>
					<td>
						<input type="text" name="homepage" id="homepage" class="info_fiel" onClick="" value="<?= $info_user['homepage'] ?>"  maxlength="100" >
					</td>
				</tr>
				
				<tr>
					<td>
						Instant Messaging 
					</td>
					<td>
						ICQ Number: <br /><input type="text" name="icq" id="icq" class="info_fiel" onClick="" value="<?= $info_user['icq'] ?>"  maxlength="100"><br /><br />
						
						AIM Screen Name: <br /><input type="text" name="aim" id="aim" class="info_fiel" onClick="" value="<?= $info_user['aim'] ?>"  maxlength="100"><br /><br />
						
						MSN Messenger Handle: <br /><input type="text" name="msn" id="msn" class="info_fiel" onClick="" value="<?= $info_user['icq'] ?>"  maxlength="100"><br /><br />
						
						Nick Yahoo: <br /><input type="text" name="yahoo" id="yahoo" class="info_fiel" onClick="" value="<?= $info_user['icq'] ?>"  maxlength="100"><br /><br />
						
						Địa chỉ Skype: <br /><input type="text" name="skype" id="skype" class="info_fiel" onClick="" value="<?= $info_user['icq'] ?>"  maxlength="100"><br />
					</td>
				</tr>
				
				<tr>
					<td>
						
					</td>
				</tr>
			</table>
		</td>

		<td class="right">
			<table border="0">
				<?= $profile_variable ?>
			</table>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<center><input name="submit" type="submit" value="UPDATE" class="g-button g-button-submit"></center>
		</td>
	</tr>

	<! Manager Link !>
	<tr class="manager_link">
		<td colspan="2"><b><?= $lang['forum'] ?></b>: 
		<a href="<?= $config['forum_url'] ?>/member.php?userid=<?= USERID ?>"><?= $lang['manager_view_page'] ?></a> &middot; 
		<a href="<?= $config['forum_url'] ?>/usercp.php?do=editprofile"><?= $lang['manager_edit_info'] ?></a> &middot; 
		<a href="<?= $config['forum_url'] ?>/profile.php?do=editavatar"><?= $lang['manager_edit_avatar'] ?></a> 
		&middot; <a href="<?= $config['forum_url'] ?>/profile.php?do=editsignature"><?= $lang['manager_edit_signature'] ?></a>
		</td>
	</tr>

	<tr class="manager_link">
		<td colspan="2"><b><?= $lang['id'] ?></b>:
		<a href="./index.php?do=manager&amp;page=editemail"><?= $lang['manager_editemail'] ?></a> 
		</td>
	</tr>
	
	</table>
</form>
</p>
<br /><br /><br /><br />
</div>
