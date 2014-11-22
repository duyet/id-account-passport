	<div style="display: none;">
	<style>
		.alert{
			  -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
			  box-shadow: inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);
			  background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);
			  background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);
			  background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);
			  background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);
			  background-image: linear-gradient(top,#f5f5f5,#f1f1f1);
			  background: #fff;
			  border: 1px solid #ccc;
			  border: 1px solid rgba(0,0,0,.2);
			  width: 90%;
			  padding: 0;
			}
		.alert_header{
			font-weight:bold;
			color:white;
			text-align:left; 
			width:60%;
			height:25px;
			border:0px solid black;
			height: 35px;
			padding-top: 10px;
			background-image: -webkit-gradient(linear,left top,left bottom,from(#eee),to(#e0e0e0));
			background-image: -webkit-linear-gradient(top,#eee,#e0e0e0);
			background-image: -moz-linear-gradient(top,#eee,#e0e0e0);
			background-image: -ms-linear-gradient(top,#eee,#e0e0e0);
			background-image: -o-linear-gradient(top,#eee,#e0e0e0);
			background-image: linear-gradient(top,#eee,#e0e0e0);
			margin:0;
			color: #666;
			padding-top: 12px;
			line-height: 16px;
			width: 100%;
			-webkit-border-radius: 2px;
			-moz-border-radius: 2px;
			border-radius: 2px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
			-moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
			box-shadow: inset 0 1px 1px rgba(0,0,0,0.1);
			border-collapse: collapse;
			}
		.alert_icon img{
			height: 15px;
			width: 15px;
			padding-top: 2px;
		}
		.alert_content{
			border:0px solid black;
			min-height:100px;
			margin-top:10px;
			width:60%;
			background: ;
			color: #;
			text-align: left;
			width:90%;
			margin:0;
			padding-left: 10px;
			padding-right: 35px;
			color: #666;
			margin-right:0;
			margin-top: 10px;
			padding-top: 10px;
		}
			.alert_content .c{padding:4px;margin:4px;}
			.alert_content a{color: #F99468; text-decoration:none;}
	</style>
	</div>
	<center>
		<div class="alert">
			<div class="alert_header clearfix">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $lang['reg_notice'] ?>
			</div>
		<div class="alert_content">
			<div class="c">
				<?= $yplitgroupStatus ?>
			</div>
		</div>
	</div>
	</center>