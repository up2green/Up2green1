<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div class="general">
            <?php include_component('user', 'menu'); ?>
            
            <?php echo $sf_content ?>
            
            <div class="clear"></div>
			<!-- 
			<div id="footer_wrapper">
				<div id="footer_inner">
					<div class="onglet">
						<div class="left"></div>
						<div class="middle">en savoir plus</div>
						<div class="right"></div>
					</div>
					<div class="head">
						<ul>
							<li><a href="#">Pourquoi planter des arbres</a></li>
							<li><a href="#">Nos programmes reforestation</a></li>
							<li><a href="#">Qui sommes-nous ?</a></li>
							<li><a href="#">Offrir des arbres en cadeau</a></li>
							<li><a href="#">Partenaires entreprises et collectivités</a></li>
						</ul>
					</div>
					<div class="content_wrapper">
						<div class="content_inner">
							<?php /*include_component('lien', 'footerPanel');*/ ?>
						</div>
					</div>
					<div class="bottom"></div>
				</div>
			</div>
			-->
        </div>

		<?php if ($sf_user->hasFlash('notice') || $sf_user->hasFlash('error')): ?>
		<script type="text/javascript">
			$(document).ready(function(){
				<?php if ($sf_user->hasFlash('notice')): ?>
				$.gritter.add({
					title: 'Notice',
					class_name: 'flash_notice',
					image: '/images/icons/48x48/tick.png',
					text: "<?php echo $sf_user->getFlash('notice') ?>"
				});
				<?php endif ?>

				<?php if ($sf_user->hasFlash('error')): ?>
				$.gritter.add({
					title: 'Notice',
					class_name: 'flash_error',
					image: '/images/icons/48x48/error.png',
					text: "<?php echo $sf_user->getFlash('error') ?>"
				});
				<?php endif ?>
			});
		</script>
		<?php endif ?>
		
    </body>
</html>

