<td>
  <input type="checkbox" name="ids[]" value="<?php echo $category->getPrimaryKey() ?>" class="sf_admin_batch_checkbox" />
  <input type="hidden" id="select_node-<?php echo $category->getPrimaryKey() ?>" name="newparent[<?php echo $category->getPrimaryKey() ?>]" />
</td>
