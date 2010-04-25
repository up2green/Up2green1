<h1>Programmes List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Organisme</th>
      <th>Latitude</th>
      <th>Longitude</th>
      <th>Geoloc</th>
      <th>Is active</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($programmes as $programme): ?>
    <tr>
      <td><a href="<?php echo url_for('programme/show?id='.$programme->getId()) ?>"><?php echo $programme->getId() ?></a></td>
      <td><?php echo $programme->getOrganismeId() ?></td>
      <td><?php echo $programme->getLatitude() ?></td>
      <td><?php echo $programme->getLongitude() ?></td>
      <td><?php echo $programme->getGeoloc() ?></td>
      <td><?php echo $programme->getIsActive() ?></td>
      <td><?php echo $programme->getCreatedAt() ?></td>
      <td><?php echo $programme->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('programme/new') ?>">New</a>
