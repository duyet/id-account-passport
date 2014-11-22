	<div id="page-title">
		<span class="title"><img src="skin/nova/img/unlock32.png" border="0" title="Contacts" alt=""> Đăng nhập</span>
		<span class="subtitle">Đăng nhập vào hệ thống và sử dụng các dịch vụ</span>
	</div>

	<div class="one-column">
	<?php if( !empty( $yplitgroupError ) ) { ?>
		<p class="warning-box" style="width:260px"><?= $yplitgroupError ?></p>
	<?php } ?>
		<p id="error" class="warning" style="width:260px; display:none;">Message</p>
		<script type="text/javascript" src="js/form-validation.js"></script>
		<form id="contactForm" action="index.php?do=login&amp;hash=<?= fetch_sessionhash() ?>" method="POST">
			<?php if( !empty( $param['return'] ) ) { ?>
			<input name="return" value="<?= ( !empty( $param['return'] ) ? urlencode( $param['return'] ) : '' ) ?>" type="hidden">
			<?php } ?>
			<input name="hl" id="hl" value="vi" type="hidden">

			<fieldset>
				<div>
					<label>Username</label>
					<input spellcheck="false" name="username" id="Email" type="text" value="<?= !empty( $_REQUEST['autousername'] ) ? htmlspecialchars_decode( base64_decode( $_REQUEST['autousername'] ) ) : '' ?>" class="form-poshytip" title="Nhập Username">
				</div>
				<div>
					<label>Password</label>
					<input name="password" id="Passwd" type="password" value="<?= !empty( $_REQUEST['autopassword'] ) ? htmlspecialchars_decode( base64_decode( $_REQUEST['autopassword'] ) ) : '' ?>" class="form-poshytip" title="Nhập Mật khẩu">
				</div>
				
				<p><input name="login" id="submit" value="Đăng nhập" type="submit" /></p> &nbsp;&nbsp;
				<input type="checkbox" style="width:2px!important" name="remember" id="PersistentCookie" value="yes" checked="checked">
				<strong class="remember-label">Duy trì trạng thái đăng nhập</strong>
			</fieldset>
			
		</form>
	</div>

<!-- column (right)-->
	<div class="one-column">
	<!-- content -->
		<p><p>Đăng nhập ở bên trái hoặc <a href="index.php?do=register&amp;return=<?= $param['return'] ?>"> tạo tài khoản mới miễn phí</a>.</p></p>
		<p>Bạn có thể sử dụng tài khoản tại Forum để đăng nhập tất cả các dịch vụ của chúng tôi.</p>
		<p>Bạn <a href="index.php?do=lostpass">không thể đăng nhập</a> hay <a href="index.php?do=lostpass">bạn quên mật khẩu?</a></p>
	<!-- ENDS content -->
	</div>
<!-- ENDS column -->


