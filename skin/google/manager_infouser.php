<style>.info_fiel .disable{-webkit-user-select: none; -moz-user-select: none; user-select: none; cursor: default; background:#FFFFFF;color:red}</style>
<div class="manager">
<div class="product-headers">
  <h1 class="redtext"><?= $lang['user_info'] ?> <?= $user_info['username'] ?></h1>
</div>
<p>
	<table border="0" class="infousertable">
	<tr>
		<td class="left"><table border="0">
			<?php
				foreach( $data['left'] as $k => $v )
				{
					echo '<tr>';
					echo '<td class="key">' . $lang['manager_'.$k] . '</td>';
					echo '<td class="val"><input type="text" name="'. $k. '" id="'. $k .'" class="info_fiel disable" disabled="" onClick="$(this).removeClass(\'disable\')" value="'. htmlspecialchars((is_numeric($v)?date('d-m-Y',$v):$v)) .'" nofocus></td>';
					echo '</tr>';
				}
			?>
		</table></td>
		<td class="right"><table border="0">
			<?php
				foreach( $data['right'] as $k => $v )
				{
					echo '<tr>';
					echo '<td class="key">' . $lang['manager_'.$k] . '</td>';
					echo '<td class="val"><input type="text" name="'. $k. '" id="'. $k .'" disabled="" class="info_fiel disable" onClick="$(this).removeClass(\'disable\')" value="'. htmlspecialchars((is_numeric($v)?date('d-m-Y',$v):$v)) .'" nofocus></td>';
					echo '</tr>';
				}
			?>
		</table></td>
		</tr>
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
</p>
</div>
