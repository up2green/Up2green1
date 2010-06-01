<h1>Inscription</h1>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'user/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['username']->renderLabel() ?></th>
        <td>
          <?php echo $form['username']->renderError() ?>
          <?php echo $form['username'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['password_bis']->renderLabel() ?></th>
        <td>
          <?php echo $form['password_bis']->renderError() ?>
          <?php echo $form['password_bis'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['UserProfile']['mail']->renderLabel() ?></th>
        <td>
          <?php echo $form['UserProfile']['mail']->renderError() ?>
          <?php echo $form['UserProfile']['mail'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
