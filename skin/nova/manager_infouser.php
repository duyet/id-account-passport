<style>.info_fiel .disable{-webkit-user-select: none; -moz-user-select: none; user-select: none; cursor: default; background:#FFFFFF;color:red}</style>
<div id="main">
	<div class="wrapper">
		<div id="content">
			<div id="page-title">
				<span class="title"><img src="skin/nova/img/user32.png" border="0" title="<?= $lang['user_info'] ?>" alt=""> <?= $lang['user_info'] ?></span>
				<span class="subtitle"><?= $lang['user_info'] ?> <?= $user_info['username'] ?></span>
			</div>

<ul class="infouser two-cols" id="contactForm">

			<?php
				foreach( $data['left'] as $k => $v )
				{
					echo '<li><div style="width:260px!important"><label>' . $lang['manager_'.$k] . '</label> &nbsp;';
					echo '<input type="text" name="'. $k. '" id="'. $k .'" class=" " disabled="" value="'. $v .'" nofocus></div></li>';
				}
			?>

			<?php
				foreach( $data['right'] as $k => $v )
				{
					echo '<li><div><label>' . $lang['manager_'.$k] . '</label> &nbsp;';
					echo '<input type="text" name="'. $k. '" id="'. $k .'" disabled="" class=" " value="'. $v .'" nofocus></div></li>';
				}
			?>

</ul>



<div>
		<h6><b><?= $lang['forum'] ?></b></h6> 
		<span><a href="<?= $config['forum_url'] ?>/member.php?userid=<?= USERID ?>"><?= $lang['manager_view_page'] ?></a> &middot; 
		<a href="<?= $config['forum_url'] ?>/usercp.php?do=editprofile"><?= $lang['manager_edit_info'] ?></a> &middot; 
		<a href="<?= $config['forum_url'] ?>/profile.php?do=editavatar"><?= $lang['manager_edit_avatar'] ?></a> 
		&middot; <a href="<?= $config['forum_url'] ?>/profile.php?do=editsignature"><?= $lang['manager_edit_signature'] ?></a></span>

		<br /><br />


		<h6><b><?= $lang['id'] ?></b></h6>
		<span>
			<a href="./index.php?do=manager&amp;page=editemail"><?= $lang['manager_editemail'] ?></a> &middot;
			<a href="./index.php?do=manager&smp;page=editpass"><?= $lang['manager_editpass'] ?></a>
		</span>



</p>
</div>
</div>
