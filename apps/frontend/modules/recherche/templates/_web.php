<div class="result">
    <h3><?php echo html_entity_decode($result['title']) ?></h3>
    <?php if ($result['content'] != "") : ?><?php echo html_entity_decode($result['content']) ?><br /><?php endif; ?>
    <a href="<?php echo html_entity_decode($result['clickUrl'])?>"><?php echo html_entity_decode($result['displayUrl']) ?></a>
</div>