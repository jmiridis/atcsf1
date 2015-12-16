<h1>Messages List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Client</th>
      <th>Email address</th>
      <th>Message</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($messages as $message): ?>
    <tr>
      <td><a href="<?php echo url_for('message/edit?id='.$message->getId()) ?>"><?php echo $message->getId() ?></a></td>
      <td><?php echo $message->getClientId() ?></td>
      <td><?php echo $message->getEmailAddress() ?></td>
      <td><?php echo $message->getMessage() ?></td>
      <td><?php echo $message->getCreatedAt() ?></td>
      <td><?php echo $message->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('message/new') ?>">New</a>
