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
    </head>
    <body>
        <div class="general">
            <?php include_component('user', 'menu'); ?>
            
            <?php echo $sf_content ?>
            
            <div class="clear"></div>
			
        </div>

		<?php include_partial('html/flash'); ?>
		
    </body>
</html>

