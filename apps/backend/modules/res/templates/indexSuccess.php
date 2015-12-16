<h1>Reservations List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Client</th>
      <th>Destination</th>
      <th>Uniqid</th>
      <th>Round trip</th>
      <th>No pax</th>
      <th>Hotel</th>
      <th>Arrival date</th>
      <th>Arrival flight no</th>
      <th>Departure date</th>
      <th>Departure flight no</th>
      <th>Price</th>
      <th>Comment</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($reservations as $reservation): ?>
    <tr>
      <td><a href="<?php echo url_for('res/edit?id='.$reservation->getId()) ?>"><?php echo $reservation->getId() ?></a></td>
      <td><?php echo $reservation->getClientId() ?></td>
      <td><?php echo $reservation->getDestinationId() ?></td>
      <td><?php echo $reservation->getUniqid() ?></td>
      <td><?php echo $reservation->getRoundTrip() ?></td>
      <td><?php echo $reservation->getNoPax() ?></td>
      <td><?php echo $reservation->getHotel() ?></td>
      <td><?php echo $reservation->getArrivalDate() ?></td>
      <td><?php echo $reservation->getArrivalFlightNo() ?></td>
      <td><?php echo $reservation->getDepartureDate() ?></td>
      <td><?php echo $reservation->getDepartureFlightNo() ?></td>
      <td><?php echo $reservation->getPrice() ?></td>
      <td><?php echo $reservation->getComment() ?></td>
      <td><?php echo $reservation->getCreatedAt() ?></td>
      <td><?php echo $reservation->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('res/new') ?>">New</a>
