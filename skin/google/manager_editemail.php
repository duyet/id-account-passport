	<style type="text/css">
.main .form-left{width: 450px; float: left}
.main .form-right{ float: left; max-width:430px; margin-left: 40px; border-left: 1px solid black; padding-left:0;}
	</style>
	<div class="main">
	<?= !empty( $error_content ) ? '<div class="reg_error">' . $error_content . '</div>' : '' ?>
	<br /><br />
	<div class="form-left">
	<div class="product-headers">
		<h1 class="redtext" style="text-align:center">Thay đổi Email</h1>
	</div>
<form action="" method="POST">
<ul class="features editpass clearfix">
<li>
	<p>Nhập mật khẩu hiện tại: <input type="password" name="currentpassword" class="currentpassword" value=""></p>
</li>

<li>
	<p>Nhập Email mới:  <input type="text" name="newemail" class="new_email" value="<?= !empty( $_POST['newemail'] ) ? $_POST['newemail'] : $info_user['email'] ?>"></p>
</li>

<li>
	<p>Một lần nữa:  <input type="text" name="newemailconfirm" class="newemailconfirm" value="<?= !empty( $_POST['newemailconfirm'] ) ? $_POST['newemailconfirm'] : $info_user['email'] ?>"></p>
</li>
  
<li>
	<p><span style="margin-left: 100px;"><input type="submit" name="submit" class="g-button g-button-submit" value="OK" accesskey="s"></span></p>
</li>
</ul>
</form>
	</div>
	<div class="form-right">
			<div class="product-headers">
			<h1 class="redtext" style="text-align:center">Chú ý</h1>
			</div>
		<ul class="features  clearfix">
  <li>
  <p>Vui lòng nhập lại Password trước khi thay đổi Email
  </p>
  </li>
  
	<li>
  <p>
    <br /><br /><br /><br /><br /><br /><br /><br /><br />
  </p>
  </li>
  
  </ul>
	</div>
	
	</div>