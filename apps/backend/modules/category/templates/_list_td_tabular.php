<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($category['id'], 'category_edit', $category) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_unique_name">
  <span class="<?php echo $category->getNode()->isLeaf() ? 'file' : 'folder' ?>">
    <?php echo $category['unique_name'] . " <span style='font-size:0.7em;font-style:italic;padding:0;'>(rank:" . $category['rank'] . ")</span>" ?>
  </span>
</td>

