<div id="sf_admin_container">

  <h1>Send the newsletter "<?php echo $newsletter ?>" to an email</h1>
  
  <p>Keys and Values below are replaced in the email content.</p>

  <div id="sf_admin_content">
    <div class="sf_admin_form">
      <form action="<?php echo url_for('@newsletter_send_to_one?id='. $newsletter->getId()); ?>" method="POST">
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

