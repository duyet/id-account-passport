<div id="main">
	<div class="wrapper">
		<div id="content">
			<div id="page-title">
				<span class="title"><img src="skin/nova/img/contactbook32.png" border="0" title="Đổi mật khẩu" alt=""> Thay Đổi Email</span>
				<span class="subtitle"></span>
			</div>
	<?= !empty( $error_content ) ? '<div class="error-box">' . $error_content . '</div>' : '' ?>
	
	<div class="one-column">
			<form id="contactForm" action="" method="post">
				<fieldset>
					<div>
						<label>Nhập mật khẩu hiện tại</label>
						<input type="password" name="currentpassword" class="" value="">
					</div>
					
					<div>
						<label>Nhập Email mới</label>
						<input type="text" name="newemail" class="" value="<?= !empty( $_POST['newemail'] ) ? $_POST['newemail'] : $info_user['email'] ?>">
					</div>
					
					<div>
						<label>Một lần nữa</label>
						<input type="text" name="newemailconfirm" class="" value="<?= !empty( $_POST['newemailconfirm'] ) ? $_POST['newemailconfirm'] : $info_user['email'] ?>">
					</div>
					
					<p><input type="submit" name="submit" id="submit" value="OK" accesskey="s"></p>
				</fieldset>
			</form>
	</div>

	
	<div class="one-column">
		<br />
		<br />
		<!-- content -->
		<p>
			Vui lòng nhập lại Password trước khi thay đổi Email.
		</p>
		<p>
			Email mới phải chưa tồn tại trên hệ thống.
		</p>
		<!-- ENDS content -->
	</div>
	</div>
</div>

