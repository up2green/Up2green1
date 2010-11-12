<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
				<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
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
            
            <?php echo $sf_content ?>
            
            <div class="clear"></div>
			<!-- 
			<div id="footer_wrapper">
				<div id="footer_inner">
					<div class="onglet">
						<div class="left"></div>
						<div class="middle">en savoir plus</div>
						<div class="right"></div>
					</div>
					<div class="head">
						<ul>
							<li><a href="#">Pourquoi planter des arbres</a></li>
							<li><a href="#">Nos programmes reforestation</a></li>
							<li><a href="#">Qui sommes-nous ?</a></li>
							<li><a href="#">Offrir des arbres en cadeau</a></li>
							<li><a href="#">Partenaires entreprises et collectivités</a></li>
						</ul>
					</div>
					<div class="content_wrapper">
						<div class="content_inner">
							<?php /*include_component('lien', 'footerPanel');*/ ?>
						</div>
					</div>
					<div class="bottom"></div>
				</div>
			</div>
			-->
        </div>
    </body>
</html>

