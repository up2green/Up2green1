<ul>
    <li<?php if ($pager->getPage() === 1) : ?> class="disabled"<?php endif; ?>>
        <?php echo link_to('&lt;&lt;', $url_for, array('page' => 1)) ?> 
    </li>
    <li<?php if ($pager->getPage() === $pager->getPreviousPage()) : ?> class="disabled"<?php endif; ?>>
        <?php echo link_to('&lt;', $url_for, array('page' => $pager->getPreviousPage())) ?> 
    </li>

    <?php foreach ($pager->getLinks() as $page): ?>
    <li<?php if ($pager->getPage() === $page) : ?> class="active"<?php endif; ?>>
        <?php echo link_to($page, $url_for, array('page' => $page)) ?> 
    </li>
    <?php endforeach; ?>

    <li<?php if ($pager->getPage() === $pager->getNextPage()) : ?> class="disabled"<?php endif; ?>>
        <?php echo link_to('&gt;', $url_for, array('page' => $pager->getNextPage())) ?> 
    </li>
    <li<?php if ($pager->getPage() === $pager->getLastPage()) : ?> class="disabled"<?php endif; ?>>
        <?php echo link_to('&gt;&gt;', $url_for, array('page' => $pager->getLastPage())) ?> 
    </li>
</ul>
