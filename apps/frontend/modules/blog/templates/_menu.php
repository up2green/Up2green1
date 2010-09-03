<div id="main-menu">
	<ul>
  	<?php
  		$first = true; 
  		foreach($elements as $element) :
  			echo '<li' . ($first ? ' class="first" ' : '') . '>';
  			if($element['classname'] == 'category') :
  				$first_of_category = true;
  				foreach($element['object']->getActiveLinks() as $link) :
						if($first_of_category) :
							echo '<a href="' . $link->getSrc() . '">' . $link->getTitle() . '</a>';
							echo '<div class="module"><div class="content"><ul>';
						else :
							echo '<li><a href="' . $link->getSrc() . '">' . $link->getTitle() . '</a></li>';
						endif;
						$first_of_category = false;
  				endforeach;
  				echo '</ul></div>';
					include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php');
					echo '</div>';
  			else :
  				// bidouille temporaire pour les programmes
  				echo '<a href="' . $element['object']->getSrc() . '">' . $element['object']->getTitle() . '</a>';
					if($element['object']->getSrc() == '/programme') :
						echo '<div class="module"><div class="content"><ul>';
						foreach($programms as $programm) :
							echo '<li><a href="/programme/' . $programm->getSlug() . '">' . $programm->getTitle() . '</a></li>';
						endforeach;
						echo '</ul></div>';
						include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php');
						echo '</div>';
					endif;
  			endif;
  			echo '</li>';
  			$first = false;
  		endforeach;
  	?>
  </ul>
</div>
