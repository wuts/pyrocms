<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- Meta information -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Stylesheets -->
		<?php echo css('reset.css', '_theme_');?>
		<?php echo css('style.css', '_theme_');?>
		
		<title>PyroCMS | Welcome</title>
	</head>
	<body>
		<!-- Global wrapper -->
		<div id="wrapper">
			<!-- The logo -->
			<div id="logo">
				<h1>
					<img src="<?php echo image_path('logo.png', '_theme_') ?>" width="200" height="76" alt="PyroCMS" />
				</h1>
			</div>
			<!-- The header -->
			<div id="header">
				<!-- Widget area : Header -->	
				<ul class="widget_area header">
					<!-- Navigation widget -->
					<li class="widget navigation">
						<ul>
							<li><a href="#" title="Home" id="current">Home</a></li>
							<li><a href="#" title="About">About</a></li>
							<li><a href="#" title="Demo">Demo</a></li>
							<li><a href="#" title="Download">Download</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="extra_wrapper">
				<!-- The content -->
				<div id="content">
					<?php echo $page_output; ?>
				</div>
				<!-- The sidebar -->
				<div id="sidebar">
					<!-- Widget area : Sidebar -->
					<?php $this->widgets->area('sidebar'); ?>
				</div> 
				<div class="clear"></div>
			</div> 
			<!-- The footer -->
			<div id="footer">
				<p>Copyright PyroCMS 2009, all rights reserved.</p>
			</div>
		</div>
	</body>
</html>