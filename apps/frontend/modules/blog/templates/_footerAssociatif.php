<div class="blog_footer">
  <div class="module">
  	<div class="content">
			<ul class="footer_associatif">
				<li class="first">
					<p><?php echo __('footer_associatif_provide_trees'); ?></p>
					<?php echo link_to(__('footer_associatif_gift_cards'), '@blog', array('class' => 'button white')); ?>
				</li>
				<li>
					<p><?php echo __('footer_associatif_planting_trees'); ?></p>
					<?php echo link_to(__('footer_associatif_search_engine'), '@blog', array('class' => 'button white')); ?>
				</li>
				<li>
					<p><?php echo __('footer_associatif_become_an_actor'); ?></p>
					<?php echo link_to(__('footer_associatif_partnership'), '@blog', array('class' => 'button white')); ?>
				</li>
				<li>
					<p><?php echo __('footer_associatif_have_pass'); ?></p>
					<?php echo link_to(__('footer_associatif_use_my_pass'), '@blog', array('class' => 'button white')); ?>
				</li>
			</ul>
		</div>
		<?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
  </div>
</div>
