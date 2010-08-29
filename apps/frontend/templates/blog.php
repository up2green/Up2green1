<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <?php /* include_partial('blog/menuSocial'); */ ?>

    <div class="top_bar">
      <div id="deja_planter"><?php echo image_tag("icons/mini-tree_30x30.png"); ?><a href="">Deja 6543 arbres plantés ensemble</a></div>
      <div id="tool_box"><div class="fltr"><?php echo image_tag("icons/mini-sound_20x20.png"); ?></div><div class="button white medium fltr">Francais</div></div>
    </div>

    <div class="fond_banner">
      <div class="banner">
        <p class="logo"><?php echo image_tag("blog/logo_03.png"); ?></p>
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
            <?php include_component('blog', 'footer'); ?>
            <div class="clear"></div>
            <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
          </div>
        </div>
      </div>
    </div>
    
    <?php include_component('blog', 'footerLegal'); ?>
    
  </body>
</html>
