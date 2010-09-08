<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1>
          <a href="<?php echo url_for('homepage') ?>">
            Administration
          </a>
        </h1>
      </div>
 
      <div id="menu">
        <ul>
			<li><a href="<?php echo url_for('@category')?>">Categories</a></li>
			<li><a href="<?php echo url_for('@lien') ?>">Liens</a></li>
			<li><a href="<?php echo url_for('@article') ?>">Articles</a></li>
			<li><a href="<?php echo url_for('@newsletter') ?>">Newsletters</a></li>
			<li><a href="<?php echo url_for('@programme') ?>">Programmes</a></li>
			<li><a href="<?php echo url_for('@organisme') ?>">Organismes</a></li>
			<li><a href="<?php echo url_for('@coupon') ?>">Coupons</a></li>
                        <li><a href="<?php echo url_for('@sf_guard_user') ?>">Users</a></li>
                        <li><a href="<?php echo url_for('@partenaire') ?>">Partenaires</a></li>
                        <li><a href="<?php echo url_for('@sf_guard_group') ?>">Groupes</a></li>
                        <li><a href="<?php echo url_for('@sf_guard_permission') ?>">Permissions</a></li>

		</ul>
      </div>
 
      <div id="content">
        <?php echo $sf_content ?>
      </div>
 
      <div id="footer">
        powered by smartIT
      </div>
    </div>
  </body>

</html>
