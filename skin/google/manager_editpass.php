	<style type="text/css">
.main .form-left{width: 450px; float: left}
.main .form-right{ float: left; max-width:430px; margin-left: 40px; border-left: 1px solid black; padding-left:0;}
	</style>
	<div class="main">
	<?= !empty( $error_content ) ? '<div class="reg_error">' . $error_content . '</div>' : '' ?>
	<br /><br />
	<div class="form-left">
	<div class="product-headers">
		<h1 class="redtext" style="text-align:center">Đổi mật khẩu</h1>
	</div>
<form action="" method="POST">
<ul class="features editpass clearfix">
<li>
	<p>Nhập mật khẩu hiện tại: <input type="password" name="currentpassword" class="currentpassword" value=""></p>
</li>

<li>
	<p>Nhập mật khẩu mới:  <input type="password" name="newpassword" class="new_password" value=""></p>
</li>

<li>
	<p>Nhập lại mật khẩu:  <input type="password" name="newpasswordconfirm" class="newpasswordconfirm" value=""></p>
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
  <p>Khi thay đổi mật khẩu, do các ứng dụng tại Lemon9x chỉ sử dụng duy nhất một tài khoản, nên khi thay đổi mật khẩu đồng nghĩa tất cả mật khẩu tại ứng dụng sẽ thay đổi theo.
  </p>
  </li>
  
	<li>
  <p><b>Chú ý khi đặt mật khẩu: </b> <br />
   - Mật khẩu phải lớn hơn 3 kí tự. <br />
   - Đặt mật khẩu dễ nhớ nhưng phải mạnh, không được sử dụng tên của bạn, số điện thoại, số nhà, .... <br />
   - Mật khẩu có thể là tên một thứ gì đó bạn nhớ nhất, tên một từ trong bài hát, bài thơ, .... sau đó thay thế có kí tự (ví dụ thay <i>"A"</i> thành <i>"4"</i>, thay <i>"o"</i> thành số <i>"0"</i>, thay <i>"i"</i> thành <i>"!"</i> hoặc <i>"|"</i>, ...) sau đó bạn sẽ có một mật khẩu dễ nhớ nhưng khó đoán.
  </p>
  </li>
  
  </ul>
	</div>
	
	</div>