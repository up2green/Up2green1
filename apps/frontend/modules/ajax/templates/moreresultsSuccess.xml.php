<root>
    <?php foreach ($results as $result): ?>
    <result>
		<?php foreach ($result as $key => $item): ?>
        <<?php echo $key; ?>><?php echo $item; ?></<?php echo $key; ?>>
        <?php endforeach; ?>
    </result>
    <?php endforeach ; ?>
</root>
