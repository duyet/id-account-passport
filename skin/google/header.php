<!--[if IE 6]>
<html id="ie6" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" dir="ltr" lang="en-US">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="en-US">
<!--<![endif]-->
<html lang="vi">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title><?= $yplitgroupPageTitle ?></title>
  <link rel="stylesheet" type="text/css" href="./skin/<?= SKINDIR ?>/style.php" />
  <!--[if IE 8]>
  <link rel="stylesheet" type="text/css" href="./skin/<?= SKINDIR ?>/style.php?id=ie8" />
  <![endif]-->

  </head>
  <body>
  <div class="wrapper">
  <div class="google-header-bar">
  <div class="header content clearfix">
  <!--<img class="logo" src="header_files/google_logo_41.png" alt="Google">-->
  <div class="ID_port"><span class="title"><?= $yplitgroupHeaderTitle ?></span><?php if( !empty( $yplitgroupRightText ) ) { ?><span class="text"><?= $yplitgroupRightText ?></span><?php } ?></div>
  <?php
  if( isset( $text_top ) AND !empty( $text_top ) )
	echo $text_top;
	?>
  </div>
  </div>
  <div class="main content clearfix">

