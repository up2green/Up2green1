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

	<?php include_component('blog', 'topbar'); ?>

    <div class="fond_banner">
      <div class="banner">
        <a href="<?php echo sfConfig::get('app_url_blog'); ?>" class="logo">
			<?php echo image_tag("blog/logo_03.png"); ?>
		</a>
        <?php include_component('blog', 'diaporama'); ?>
      </div>
    </div>

    <div class="fond_banner_bottom"></div>

    <div class="corps">
      <div id="bg_corps">
        <div class="module">
          <div class="content">

            <?php include_component('blog', 'menu'); ?>

            <div class="principale">
              <?php echo $sf_content; ?>
            </div>

            <div class="clear"></div>
			
            <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
          </div>
        </div>
      </div>
    </div>
    
    <?php include_component('blog', 'footerLegal'); ?>
    
  </body>
</html>
