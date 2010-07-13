<div class="diaporama">
  <div class="nav">
    <a href="#" class="prevDiapo"><?php echo image_tag("blog/diaporama/btn_prev_diapo.png"); ?></a>
  </div>

  <?php
  foreach($programmes as $p) {
    echo '<div class="diapo">';
    echo '<h3>'.$p->getTitle().'</h3>';
    echo '<div class="accroche">'.$p->getAccroche().'</div>';
    echo '</div>';
  }
  ?>

  <div class="diapo">
    <?php echo image_tag("blog/diaporama/img_diapo.png"); ?>
  </div>
  <div class="diapo">
    <?php echo image_tag("blog/diaporama/img_diapo.png"); ?>
  </div>
  <div class="diapo">
    <?php echo image_tag("blog/diaporama/img_diapo.png"); ?>
  </div>

  <div class="nav">
    <a href="#" class="nextDiapo"><?php echo image_tag("blog/diaporama/btn_next_diapo.png"); ?></a>
  </div>
</div>