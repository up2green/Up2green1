<div class="diaporama">
  <div class="nav">
    <a href="#" class="prevDiapo"><?php echo image_tag("blog/diaporama/btn_prev_diapo.png"); ?></a>
  </div>

  <?php
  foreach($programmes as $p) {
    echo '<div class="diapo">';
    
    // image
    if($p->getLogo() != '' && file_exists(sfConfig::get('sf_upload_dir').'/programme/'.$p->getLogo()))
    {
    	echo '<div class="img-wrapper">';
    	echo '<div class="img-inner">';
    	echo '<img src="/uploads/programme/'.$p->getLogo().'" alt="Diapo Image">';
    	echo '</div>';
    	echo '</div>';
    }
    
    echo '<h3>'.html_entity_decode($p->getTitle()).'</h3>';
    echo '<p class="accroche">'.html_entity_decode($p->getAccroche()).'</p>';
    echo '</div>';
  }
  ?>

  <div class="nav">
    <a href="#" class="nextDiapo"><?php echo image_tag("blog/diaporama/btn_next_diapo.png"); ?></a>
  </div>
</div>
