<fieldset>
  <legend><?php echo __("General") ?></legend>
  <h3><?php echo __("%number% trees planted", array('%number%' => $programme->countTrees())) ?></h3>
  <ul>
    <li><?php echo __("%number% trees planted using partner voucher", array('%number%' => $programme->countTreesVoucherPartner())) ?></li>
    <li><?php echo __("%number% trees planted using user voucher", array('%number%' => $programme->countTreesVoucherUser())) ?></li>
    <li><?php echo __("%number% trees planted using user account", array('%number%' => $programme->countTreesUser())) ?></li>
  </ul>
</fieldset>
<fieldset>
  <legend><?php echo __("Detail") ?></legend>
  <table>
    <thead>
      <tr>
        <th><?php echo __("Month") ?></th>
        <th><?php echo __("By partner voucher") ?></th>
        <th><?php echo __("By user voucher") ?></th>
        <th><?php echo __("By user account") ?></th>
        <th><?php echo __("Total") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($months as $month) : ?>
      <tr>
        <td><?php echo $month['date'] ?></td>
        <td><?php echo $month['byPartnerVoucher'] ?></td>
        <td><?php echo $month['byUserVoucher'] ?></td>
        <td><?php echo $month['byUserAccount'] ?></td>
        <td><?php echo $month['total'] ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</fieldset>