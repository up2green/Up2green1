<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $programme->getId() ?></td>
    </tr>
    <tr>
      <th>Organisme:</th>
      <td><?php echo $programme->getOrganismeId() ?></td>
    </tr>
    <tr>
      <th>Latitude:</th>
      <td><?php echo $programme->getLatitude() ?></td>
    </tr>
    <tr>
      <th>Longitude:</th>
      <td><?php echo $programme->getLongitude() ?></td>
    </tr>
    <tr>
      <th>Geoloc:</th>
      <td><?php echo $programme->getGeoloc() ?></td>
    </tr>
    <tr>
      <th>Is active:</th>
      <td><?php echo $programme->getIsActive() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $programme->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $programme->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('programme/edit?id='.$programme->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('programme/index') ?>">List</a>
