<h1 style="font-size: 18px; color:#2F8D00; margin: 15px;" class="center">
  <?php echo $gallery->getTitle(); ?>
</h1>

<div class="center"><?php echo $gallery->getDescription(); ?></div>

<ul id="gallery">
  <?php foreach ($gallery->getPictures() as $picture) : ?>
    <li>
        <?php echo image_tag('/uploads/gallery/' . $picture->getSrc(), array('data-frame'=>'/uploads/gallery/thumbnail/' . $picture->getSrc())) ?>
    </li>
  <?php endforeach ?>

</ul>

<script>
  jQuery(document).ready(function($) {
      $('#gallery').galleryView({
        filmstrip_style: 'showall',
        filmstrip_position: 'bottom',
        frame_height: 50,
        frame_width: 50,
        panel_width: 1024,
        panel_height: 500,
        panel_scale: 'fit'
      });
  });
</script>
