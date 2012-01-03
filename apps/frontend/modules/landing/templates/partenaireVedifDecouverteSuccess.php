<?php
  $nbArbres = str_pad(($nbArbres - 180) , 5, "0", STR_PAD_LEFT);
  $partenaire->setTitle("Des programmes soutenus par le Service de l'eau du Sedif");
?>

<style>
  div.module div.content {width: auto;}
  div.module.purple p.title a {
    font-size: 15px;
    font-family: sans-serif;
    color: #2E005F;
  }
</style>

<div id="content" style="width:1050px;margin:30px auto 0;">

  <div id="content-left" style="width:25%;float:left;">
    
    <!-- module up2green -->
    <div class="module">
      <img class="title corner left" src="/images/module/green/icon/program.png" alt="" />
      <div class="content" style="text-align:center;">
        <a target="_blank" href="<?php echo sfConfig::get('app_url_moteur') ?>">
          <img style="z-index: 300000; position: relative; width: 140px;" src="/images/logo/200x200/earth-hand.png" alt="up2green" />
        </a>
        <div id="compteur" class="small"style="padding-left:70px">
          <div class="chiffre"><?php echo $nbArbres[0] ?></div>
          <div class="chiffre"><?php echo $nbArbres[1] ?></div>
          <div class="chiffre"><?php echo $nbArbres[2] ?></div>
          <div class="chiffre"><?php echo $nbArbres[3] ?></div>
          <div class="chiffre"><?php echo $nbArbres[4] ?></div>
        </div>
        <p style="font-size:12px;">arbres plantés</p>
        <div class="clear"></div>
      </div>
      <?php include_partial('global/border_and_corner') ?>
    </div>
    
    <br />
  
    <?php include_partial('plantation/formCoupon', array(
        'withHelp' => false,
        'fromUrl' => url_for('/landing/partenaire/vedif/decouverte'),
        'redirectUrl' => url_for('/landing/partenaire/vedif/decouverte'),
    )); ?>

    <br />
    
    <?php include_partial('partenaire/module', array(
			'moduleClass'	=> 'purple',
			'displayIcon'	=> true,
			'displayTitle'	=> true,
			'partenaire'	=> $partenaire,
      'withoutLink' => true
		)); ?>
    
  </div>
  
  <div id="content-inner" style="float: right; width: 73%; margin: 0">
    
    <!-- module GMap-->
    <div id="gmapWrapper" class="module" style="position:relative;" >
			<img class="title corner left" src="/images/module/green/icon/program.png" alt="" />
			<p class="title"><?php echo __("Découvrez les programmes de reforestation") ?></p>
      <div class="content">
        <?php include_partial('plantation/formGMap', array(
          'partenaire' => $partenaire
        )); ?>
        <div class="clear"></div>
      </div>
      <?php include_partial('global/border_and_corner') ?>
    </div>
    
    <p style="text-align:right;padding:5px">
      <?php echo link_to("page d'accueil", '/landing/plantation/vedif/special'); ?>
    </p>
    
  </div>
  
  <div class="clear"></div>
  
</div>
