<div class="diaporama">
  <div class="nav">
    <a href="#" class="prevDiapo"><?php echo image_tag("blog/diaporama/btn_prev_diapo.png"); ?></a>
  </div>

  <?php
  foreach($programmes as $p) {
    echo '<div class="diapo">';
    echo '<table><tr><td>';
    echo '<h3>'.html_entity_decode($p->getTitle()).'</h3>';
    echo '<span class="accroche">';
    echo html_entity_decode($p->getAccroche());
    echo '</span></td><td>';
    // image
    if($p->getLogo() != '' && file_exists(sfConfig::get('sf_upload_dir').'/programme/'.$p->getLogo()))
    	echo '<img src="/uploads/programme/'.$p->getLogo().'" alt="Diapo Image">';
    echo '</td></tr></table>';
    echo '</div>';
  }
  ?>

  <div class="nav">
    <a href="#" class="nextDiapo"><?php echo image_tag("blog/diaporama/btn_next_diapo.png"); ?></a>
  </div>
</div>
