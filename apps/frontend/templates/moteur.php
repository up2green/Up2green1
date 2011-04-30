<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
				<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
				<link title="up2green Search" type="application/opensearchdescription+xml" rel="Search" href="opensearch.xml" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>

		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-19664821-1']);
			_gaq.push(['_setDomainName', '.up2green.com']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();

		</script>
		
    </head>
    <body>
        <div class="general">
            <?php include_component('user', 'menu'); ?>

            <div class="header">
				<a href="/">
					<div class="logo"></div>
					<div class="slogan"><?php echo __("Plantez des arbres sur la Planète au fil de vos recherches") ?></div>
				</a>
            </div>
            
            <?php echo $sf_content ?>
            
            <div class="clear"></div>
			
        </div>

		<?php include_component('blog', 'footerLegal'); ?>
		<?php include_partial('html/flash'); ?>

    </body>
</html>

