<div id="sf_admin_container">

  <h1>Send the newsletter "<?php echo $newsletter ?>" to all users</h1>

  <?php if ($forced) : ?>
  <p>Warning: Sending an email when user specified he dt want to receive them is forbidden by the law</p>
  <?php endif ?>
  
  <p>Keys and Values below are replaced in the email content.</p>

  <div id="sf_admin_content">
    <div class="sf_admin_form">
      <?php if ($forced) : ?>
      <form action="<?php echo url_for('@newsletter_send_to_all_forced?id='.$newsletter->getId()); ?>" method="POST">
      <?php else : ?>
      <form action="<?php echo url_for('@newsletter_send_to_all?id='.$newsletter->getId()); ?>" method="POST">
      <?php endif; ?>
          <table>
              <?php echo $form ?>
              <tr>
                  <td colspan="2">
                      <a href="<?php echo url_for('@newsletter') ?>">Back</a> <input type="submit" />
                  </td>
              </tr>
          </table>
          <?php echo $form->renderHiddenFields() ?>
      </form>
    </div>
  </div>

</div>

