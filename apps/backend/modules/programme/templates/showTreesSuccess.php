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
      <?php foreach ($months as $key => $values) : ?>
      <tr>
        <td><?php echo $key ?></td>
        <td><?php echo ($partnerVoucherCount = isset($values['partnerVoucherCount']) ? $values['partnerVoucherCount'] : 0) ?></td>
        <td><?php echo ($userVoucherCount = isset($values['userVoucherCount']) ? $values['userVoucherCount'] : 0) ?></td>
        <td><?php echo ($userAccountCount =  isset($values['userAccountCount']) ? $values['userAccountCount'] : 0) ?></td>
        <td><?php echo $partnerVoucherCount + $userVoucherCount + $userAccountCount ?></td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</fieldset>