<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('myreservations/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('myreservations/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'myreservations/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['destination_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['destination_id']->renderError() ?>
          <?php echo $form['destination_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['round_trip']->renderLabel() ?></th>
        <td>
          <?php echo $form['round_trip']->renderError() ?>
          <?php echo $form['round_trip'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['no_pax']->renderLabel() ?></th>
        <td>
          <?php echo $form['no_pax']->renderError() ?>
          <?php echo $form['no_pax'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['hotel']->renderLabel() ?></th>
        <td>
          <?php echo $form['hotel']->renderError() ?>
          <?php echo $form['hotel'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['arrival_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['arrival_date']->renderError() ?>
          <?php echo $form['arrival_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['arrival_flight_no']->renderLabel() ?></th>
        <td>
          <?php echo $form['arrival_flight_no']->renderError() ?>
          <?php echo $form['arrival_flight_no'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['departure_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['departure_date']->renderError() ?>
          <?php echo $form['departure_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['departure_flight_no']->renderLabel() ?></th>
        <td>
          <?php echo $form['departure_flight_no']->renderError() ?>
          <?php echo $form['departure_flight_no'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['comment']->renderLabel() ?></th>
        <td>
          <?php echo $form['comment']->renderError() ?>
          <?php echo $form['comment'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
