<div id="main">
	<div class="wrapper">
		<div id="content">
			<div id="page-title">
				<span class="title"><img src="skin/nova/img/shield32.png" border="0" title="Đổi mật khẩu" alt=""> Đổi mật khẩu</span>
				<span class="subtitle"></span>
			</div>
	<?= !empty( $error_content ) ? '<div class="error-box">' . $error_content . '</div>' : '' ?>
	
	<div class="one-column">
		<h2></h2>
			<form id="contactForm" action="" method="post">
				<fieldset>
					<div>
						<label>Nhập mật khẩu hiện tại</label>
						<input type="password" name="currentpassword" class="currentpassword" value="">
					</div>
					
					<div>
						<label>Nhập lại mật khẩu</label>
						<input type="password" name="newpasswordconfirm" class="newpasswordconfirm" value="">
					</div>
					
					<div>
						<label>Nhập mật khẩu mới</label>
						<input type="password" name="newpassword" class="new_password" value="">
					</div>
					
					<p><input type="submit" name="submit" id="submit" value="OK" accesskey="s"></p>
				</fieldset>
			</form>
	</div>

	
	<div class="one-column">
		<!-- content -->
		<p>
			Khi thay đổi mật khẩu, do các ứng dụng tại Lemon9x chỉ sử dụng duy nhất một tài khoản, nên khi thay đổi mật khẩu đồng nghĩa tất cả mật khẩu tại ứng dụng sẽ thay đổi theo.
		</p>
		<p><b>Chú ý khi đặt mật khẩu: </b> <br />
			- Mật khẩu phải lớn hơn 3 kí tự. <br />
			- Đặt mật khẩu dễ nhớ nhưng phải mạnh, không được sử dụng tên của bạn, số điện thoại, số nhà, .... <br />
			- Mật khẩu có thể là tên một thứ gì đó bạn nhớ nhất, tên một từ trong bài hát, bài thơ, .... sau đó thay thế có kí tự (ví dụ thay <i>"A"</i> thành <i>"4"</i>, thay <i>"o"</i> thành số <i>"0"</i>, thay <i>"i"</i> thành <i>"!"</i> hoặc <i>"|"</i>, ...) sau đó bạn sẽ có một mật khẩu dễ nhớ nhưng khó đoán.
		</p>
		<!-- ENDS content -->
	</div>
	</div>
</div>
