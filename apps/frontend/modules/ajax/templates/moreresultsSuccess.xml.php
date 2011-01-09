<root>
	<?php if(sizeof($affiliateResults)) : ?>
	<affiliateResults>
		<?php foreach ($affiliateResults as $result): ?>
		<?php include_partial('recherche/shop', array('result' => $result)); ?>
		<?php endforeach ; ?>
	</affiliateResults>
	<?php endif; ?>
	<?php if(sizeof($pubResults)) : ?>
	<pubResults>
		<?php foreach ($pubResults as $result): ?>
		<?php include_partial('recherche/pub', array('result' => $result)); ?>
		<?php endforeach ; ?>
	</pubResults>
	<?php endif; ?>
	<?php foreach ($results as $result): ?>
	<result>
		<?php foreach ($result as $key => $item): ?>
        <<?php echo $key; ?>><?php echo $item; ?></<?php echo $key; ?>>
        <?php endforeach; ?>
    </result>
    <?php endforeach ; ?>
</root>
