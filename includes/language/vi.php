<?php
/**
* @ Project: ID Account System 1.5.0
* @ Author: Yplitgroup (c)2012
* @ Email: yplitgroup@gmail.com
* @ Website: http://lemon9x.com 
* @ Phone: 0166.26.26.009
* @ Project ID: 876609683c4c7e392848e94d9f62e149
**/

// ############### CHECK ##############
if( !defined('IS_MAIN') ) die(" Stop!!! ");
$lang = array(
	'login_incorrect' => 'Đăng nhập thất bại!',
	'login_not_active' => 'Tài khoản của bạn chưa được kích hoạt!',
	'page_title' => 'ID Accounts',
	'header_title' => 'ID Accounts System',
	'login' => 'Đăng nhập',
	'homepage' => 'Trang chủ',
	'help' => 'Trợ giúp',
	'private' => 'Chính sách bảo mật',
	'user_info' => 'Thông tin cá nhân',
	'manager_username' => 'Tên đăng nhập',
	'manager_passworddate' => 'Đổi password lần cuối',
	'manager_email' => 'Email',
	'manager_homepage' => 'Trang chủ',
	'manager_yahoo' => 'Nick yahoo',
	'manager_groupname' => 'Thành viên nhóm',
	'manager_joindate' => 'Thời gian gia nhập',
	'manager_lastvisit' => 'Đăng nhập trước',
	'manager_lastpost' => 'Bài viết cuối',
	'manager_posts' => 'Bài viết cuối',
	'manager_birthday' => 'Sinh nhật',
	'manager_ipaddress' => 'IP',
	'error_update_users_info' => 'Lỗi khi cập nhật thông tin thành viên.',
	'newpassword_must_sample_newpasswordconfirm' => 'Bạn nhập lại mật khẩu chưa chính xác',
	'newpassword_must_differnt_currentpassword' => 'Password mới phải khác với mật khẩu hiện tại',
	'strlen_newpassword_incorrect' => 'Mật khẩu phải có độ dài phù hợp',
	'current_password_incorrect' => 'Sai mật khẩu',
	'register_username' => 'Tài khoản',
	'register_password' => 'Mật khẩu',
	'register_passwordconfirm' => 'Biết rồi còn hỏi',
	'register_email' => 'Nhập email',
	'register_emailconfirm' => 'Như trên',
	'register_humanverify' => 'Nhập các kí tự trong hình',
	'fail' => 'Sai rồi',
	'ok' => 'Chính xác',
	'register_button' => 'Đăng kí',
	'reset_button' => 'Nhập lại',
	'hello' => 'Xin chào, ',
	'logout' => 'Thoát',
	'javascript_please_fill_all_fiels' => 'Vui lòng điền hết thông tin',
	'javascript_confirm_password_fail' => 'Nhập lại mật khẩu không khớp',
	'javascrpt_confirm_email_fail' => 'Nhập lại email không khớp',
	'fieldmissing' => 'Vui lòng điền tất cả các ô',
	'passwordmismatch' => 'Nhập lại mật khẩu không khớp',
	'emailmismatch' => 'Nhập lại email không khớp',
	'humanverifyfail' => 'Mã bảo mật không chính xác',
	'day_of_birth_fail' => 'Ngày tháng năm sinh không chính xác',
	'email_is_incorrect' => 'Email không đúng, vui lòng nhập lại',
	'email_is_exist' => 'Email đã tồn tại trên hệ thống, nếu bạn quên mật khẩu vui lòng click <a href="./index.php?do=lostpass">vào đây</a>.',
	'register_successfull_email' => 'Bạn đã đăng kí thành công tài khoản. Nhưng bạn cần phải xác nhận email mà bạn đã đăng kí. Bạn vào ngay hộp thư của mình và Click vào link xác nhận để hoàn thành việc đăng kí. Nếu không tìm thấy email, bạn nên kiểm tra trong Spam hoặc liên hệ Administrator.',
	'register_successfull' => 'Chào mừng <b>$username</b>, bạn đã đăng kí thành công tài khoản. Bây giờ bạn hãy đăng nhập và vào diễn đàn để hoàn thành các thông tin cá nhân cần thiết khác.<br><br>Đăng nhập <b><a href=\"./index.php?do=login&amp;autousername=$autousername&amp;autopassword=$autopassword\&amp;return=$return\">tại đây</a></b> &middot; Vào Forum <b><a href=\"$config[forum_url]\">tại đây</a></b>',
	'register_error' => 'Hệ thống đã xảy ra lỗi khi đăng kí. Vui lòng thử lại hoặc liên hệ Administrators',
	'register_is_disable' => 'Xin lỗi, chức năng đăng kí hiện đã bị vô hiệu hóa, nhưng bạn vẫn có thể đăng kí tại Forum <a href=\"$config[forum_url]/register.php\">tại đây</a>',
	'length_password_too_short' => 'Mật khẩu quá ngắn',
	'length_password_too_long' => 'Mật khẩu quá dài',
	'length_username_too_short' => 'Tên tài khoản quá ngắn',
	'length_username_too_long' => 'Tên tài khoản quá dài',
	'username_is_exist' => 'Tài khoản đã tồn tại. Nếu bạn quên mật khẩu click <a href="./index.php?do=lostpassword">vào đây</a>',
	'register_page_title' => 'Đăng kí thành viên',
	'username_is_exist' => 'Tên tài khoản đã tồn tại',
	'please_require_all_custom_fiels' => 'Vui lòng điền hết tất cả thông tin có dấu (*)',
	'username_is_not_exist' => 'Bạn có thể đăng kí tài khoản này',
	'forum' => 'Diễn đàn',
	'manager_edit_info' => 'Sửa thông tin cá nhân',
	'manager_view_info' => 'Xem thông tin chi tiết',
	'manager_edit_signature' => 'Sửa chữ kí',
	'register_dayofbirth' => 'Ngày tháng năm sinh',
	'day' => 'Ngày',
	'month' => 'Tháng',
	'lostpass_page_title' => 'Quên mật khẩu',
	'lostpass_button' => 'Request Username / Password Now',
	'lostpass_text' => 'If you have forgotten your username or password, you can request to have your username emailed to you and to reset your password. When you fill in your registered email address, you will be sent instructions on how to reset your password.',
	'lostpass_lefttext_email' => 'Địa chỉ Email: ',
	'lostpass_lefttext_username' => 'Hoặc nhập Username của bạn: ',
	'email_is_not_found' => 'Xin lỗi, không tìm thấy email này trên hệ thống. Vui lòng nhập lại.<br><br><a href="./index.php?do=lostpass">Quay lại</a>',
	'username_is_not_found' => 'Xin lỗi, không tìm thấy tài khoản này trên hệ thống. Vui lòng nhập lại.<br><br><a href="./index.php?do=lostpass">Quay lại</a>',
	'error_notice' => 'Thông báo lỗi từ hệ thống',
	'reg_notice' => 'Tin nhắn từ hệ thống',
	'lostpass_email_subject' => '[ID Accounts System] - Yêu cầu khôi phục mật khẩu',
	'lostpass_email_body' => '<br />Chào <b>$username</b>,<br />Bạn đã yêu cầu khôi phục mật khẩu tại <b>$forum_title</b>. Để tiếp tục quá trình khôi phục mật khẩu, bạn vui lòng Click vào link sau: <a href=\"$link\">$link</a>
<br />Sau khi click vào link trên, hệ thống sẽ gửi mật khẩu mới tới email của bạn.<br />
<br />Nếu bạn không hề yêu cầu khôi phục mật khẩu, xin hãy bỏ qua email này.<br /><br />
Chào <br />
<b>$forum_title</b><br />',
	'lostpass_successfull_pagetitle' => 'Gửi email thành công',
	'lostpass_successfully_message' => 'Một email vừa được gửi vào email của bạn. Vui lòng Click vào liên kết bên trong email để lấy lại mật khẩu.<br><br>Nếu bạn không thấy email vui lòng kiểm tra trong Spam.<br><br><a href="./index.php">Đến trang chủ</a>',
	'please_enter_username_or_password' => 'Vui lòng nhập Tên tài khoản hoặc Email. <br><br><a href="./index.php?do=lostpass">Quay lại</a>',
	'404_notfound' => 'Không tìm thấy trang bạn yêu cầu',
	'your_active_code_older_than_48h' => 'Mã xác nhận của bạn đã hơn 48h nên đã hết hiệu lực. Bạn vui lòng quay lại trang trang chủ và sử dụng chức năng "Quên mật khẩu"<br><br><b><a href="./index.php">Quay lại trang chủ</a> &middot; <a href="./index.php?do=lostpass">Quên mật khẩu</a> </b>',
	'your_active_code_error' => 'Mã xác nhận của bạn không chính xác. Bạn vui lòng quay lại trang trang chủ và sử dụng chức năng "Quên mật khẩu"<br><br><b><a href="./index.php">Quay lại trang chủ</a> &middot; <a href="./index.php?do=lostpass">Quên mật khẩu</a> </b>',
	'lostpass_email_subject_ok' => '[ID Accounts System] - Mật khẩu mới',
	'lostpass_email_body_ok' => '<br />Chào <b>$username</b>,
<br /><br />
Theo yêu cầu của bạn, password của bạn đã được reset. Đây là thông tin tài khoản của bạn:<br />
Username: <b>$username</b><br />
Password: <b>$password</b><br />
<br />
Để thay đổi mật khẩu, truy cập: <a href=\"$link\">$link</a><br />
<br />
Chào bạn<br />
<b>$forum_title</b><br />',
	'your_password_have_been_reset' => 'Mật khẩu của bạn vừa được reset và gửi cho bạn qua email. Hãy kiểm tra email và thay đổi mật khẩu. <br><br><b><a href="./index.php">Quay lại trang chủ</a></b>',
	'contact_name_empty' => 'Vui lòng nhập tên của bạn.',
	'contact_content' => 'Nội dung',
	'contact_humanverify' => 'Mã xác nhận',
	'contact_humanverify_empty' => 'Vui lòng nhập mã bảo mật.',
	'contact_humanverify_fail' => 'Mã bảo mật không chính xác.',
	'contact_email_empty' => 'Bạn chưa nhập Email',
	'contact_email_fail' => 'Email của bạn không chính xác',
	'contact_content_empty' => 'Vui lòng nhập nội dung bạn muốn liên hệ.',
	'contact_email_subject' => '[ID Accounts System] - Contact from Member',
	'contact_email_message' => '<br />Chào Admin,<br /> 
Có người vừa liên hệ với bạn thông qua form tại $forum:<br />
<br />
Tên người liên hệ: <b>$name</b>.<br />
Email người liên hệ: <b>$email</b><br />
Nội dung:<br />
--------------------------------------------<br />
$content<br />
--------------------------------------------<br />
<br />
::[ID Accounts System]::<br />
Yplitgroup<br />
<br />
',
	'contact_submit_successfully' => 'Cảm ơn bạn đã liên hệ với chúng tôi. Hệ thống sẽ gửi thông tin đến Administrators và sẽ liên hệ với bạn sau. Chúc vui.<br><br><a href="./index.php"><b>Quay lại trang chủ</b></a>',
	'contact_name' => 'Tên của bạn',
	'contact_email' => 'Nhập Email của bạn',
	'contact_submit' => 'Submit',
	'contact_form_righttext' => 'Để liên hệ với chúng tôi, bạn vui lòng điền đầy đủ các nội dung bên cạnh, nhập mã bảo mật sau đó nhấn Submit',
	'manager_view_page' => 'Trang cá nhân',
	'manager_edit_avatar' => 'Sửa Avatar',
	'id' => 'ID',
	'manager_editemail' => 'Sửa Email',
	'editemail_current_password_fail' => 'Password không chính xác',
	'editemail_newemail_not_sample' => 'Nhập lại Email không chính xác',
	'editemail_newemail_fail' => 'Email không hợp lệ, vui lòng nhập lại',
	'editemail_newemail_is_exists' => 'Email đã tồn tại trên hệ thống.',
	'system_error' => 'Xin lỗi, hệ thống bị lỗi và không thể thực hiện được yêu cầu của bạn. <br /><br />Vui lòng thử lại hoặc liên hệ với Administrator để được hỗ trợ.',
	'edit_user_info' => 'Sửa thông tin cá nhân',
	'account' => 'Tài khoản',
	'lostpass' => 'Quên mật khẩu',
	'register' => 'Đăng kí',
	'manager_editpass' => 'Đổi mật khẩu',
	);
?>