<tfoot class="pagination">
	<tr>
		<td colspan="4">
			<a href="<?php echo url_for($url_for) ?>?page=1">
				<img src="/sfDoctrinePlugin/images/first.png" alt="<?php echo __("Première page") ?>" />
			</a>

			<a href="<?php echo url_for($url_for) ?>?page=<?php echo $pager->getPreviousPage() ?>">
				<img src="/sfDoctrinePlugin/images/previous.png" alt="<?php echo __("Page précédente") ?>" />
			</a>

			<?php foreach ($pager->getLinks() as $page): ?>
				<?php if ($page == $pager->getPage()): ?>
					<?php echo $page ?>
				<?php else: ?>
					<a href="<?php echo url_for($url_for) ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
				<?php endif; ?>
			<?php endforeach; ?>

			<a href="<?php echo url_for($url_for) ?>?page=<?php echo $pager->getNextPage() ?>">
				<img src="/sfDoctrinePlugin/images/next.png" alt="<?php echo __("Page suivante") ?>" />
			</a>

			<a href="<?php echo url_for($url_for) ?>?page=<?php echo $pager->getLastPage() ?>">
				<img src="/sfDoctrinePlugin/images/last.png" alt="<?php echo __("Dernière page") ?>" />
			</a>
		</td>
	</tr>				
</tfoot>