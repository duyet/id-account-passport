<div class="sign-in">
<div class="signin-box">
  <h2>Đăng nhập <strong></strong></h2>
  <span style="font-weight:bold;color:red; margin-bottom: 16px;"><?= $yplitgroupError ?></span><br><br>
  <form id="gaia_loginform" action="index.php?do=login&amp;hash=<?= fetch_sessionhash() ?>" method="POST">
  <?php if( !empty( $param['return'] ) ) { ?>
  <input name="return" value="<?= ( !empty( $param['return'] ) ? urlencode( $param['return'] ) : '' ) ?>" type="hidden">
  <?php } ?>
  <input name="hl" id="hl" value="vi" type="hidden">
<label>
  <strong class="email-label">Username</strong>
  <input spellcheck="false" name="username" id="Email" type="text" value="<?= !empty( $_REQUEST['autousername'] ) ? htmlspecialchars_decode( base64_decode( $_REQUEST['autousername'] ) ) : '' ?>">
</label>
<label>
  <strong class="passwd-label">Mật khẩu</strong>
  <input name="password" id="Passwd" type="password" value="<?= !empty( $_REQUEST['autopassword'] ) ? htmlspecialchars_decode( base64_decode( $_REQUEST['autopassword'] ) ) : '' ?>">
</label>
  <input class="g-button g-button-submit" name="login" id="signIn" value="Đăng nhập" type="submit">
  	<label class="remember">
		<input type="checkbox" name="remember" id="PersistentCookie" value="yes" checked="checked">
		<strong class="remember-label">Duy trì trạng thái đăng nhập</strong>
	</label>
  </form>
	
</div>
  </div>

  
  <div class="product-info ">
<div class="product-headers">
  <h1 class="redtext">Tài khoản</h1>
</div>
<p>Lemon9x ID cung cấp các dịch vụ liên kết với nhau, hỗ trợ mở rộng
<p>Đăng nhập ở bên phải hoặc <a href="index.php?do=register&amp;return=<?= $param['return'] ?>"> tạo tài khoản mới miễn phí</a>.</p>
<p>Bạn có thể sử dụng tài khoản tại Forum để đăng nhập tất cả các dịch vụ của chúng tôi.</p>
<p>Bạn <a href="index.php?do=lostpass">không thể đăng nhập</a> hay <a href="index.php?do=lostpass">bạn quên mật khẩu?</a></p>
<ul class="features clearfix">
	<li>
		<p class="title"></p>
		
	</li>
</ul>
</div>