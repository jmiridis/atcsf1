<?php
/**
 * Application specific implementation of esPaypalHandler
 *
 *
 * @package
 * @author Jorgo Miridis <jorgo@miridis.com>
 * @copyright Copyright (c) 2011
 * @version $Id: esPaypalHandlerATC.class.php 41 2011-04-14 16:15:16Z jorgo $
 * @access public
 */
class esPaypalHandlerATC extends esPaypalHandler
{
  /**
   * This method implements the action to be taken when the Paypal server rejects the IPN '_notify-validate' response (returns a reponse other than 'VERIFIED').
   *
   * No action is implemented as the error will be logged nevertheless.
   *
   * @return void
   */
  protected function handleInvalid()
  {
  }

  /**
   * This method returns the enity related to the payment transaction.
   *
   * Returns the reservation identified by 'uniqid' which is stored in the
   * Paypal button in the field 'invoice'.
   *
   * @return mixed Doctrine Object - upon success, false - upon missing object and null - if not implemented.
   */
  protected function instanciateRelatedEntity()
  {
    return Doctrine::getTable('Reservation')->findOneByUniqid($this['invoice']);
  }

  /**
   * This implements the validation of the reservation that is related to the transaction.
   *
   * It verifies that the price of the reservation matches the field 'mc_gross'.
   *
   * @return boolean true if the related reservation exists and matches the correct price
   */
  protected function isEntityValid()
  {
    if(null === $reservation = $this->getRelatedEntity())
    {
      $this->setEntityError('Reservation not found.');
      return false;
    }

    if($this['mc_gross'] != $reservation->price)
    {
      $this->setEntityError(sprintf('Reservation price mismatch: %s vs. %s', $this['mc_gross'], $reservation->price));
      return false;
    }

    return true;
  }

  /**
   * This method performs the necessary operatios after a successful transaction.
   *
   * Currently only 'Completed' and 'Pending' are handled and both result in
   * the update of the reservation status.
   *
   * The following status values are (theoretically) possible:
   *  - Completed: The payment has been completed, and the funds have been added successfully to your account balance.
   *  - Canceled_Reversal: A reversal has been canceled. For example, you won a dispute with the customer, and the funds for the transaction that was reversed have been returned to you.
   *  - Created: A German ELV payment is made using Express Checkout.
   *  - Denied: You denied the payment. This happens only if the payment was previously pending because of possible reasons described for the pending_reason variable or the Fraud_Management_Filters_x variable.
   *  - Expired: This authorization has expired and cannot be captured.
   *  - Failed: The payment has failed. This happens only if the payment was made from your customer’s bank account.
   *  - Pending: The payment is pending. See pending_reason for more information.
   *  - Refunded: You refunded the payment.
   *  - Reversed: A payment was reversed due to a chargeback or other type of reversal. The funds have been removed from your account balance and returned to the buyer. The reason for the reversal is specified in the ReasonCode element.
   *  - Processed: A payment has been accepted.
   *  - Voided: This authorization has been voided.
   *
   * @param string $status status value returned by Paypal ('payment_status')
   * @param string $reason reason code why payment is pending (applies only when $status == 'Pending')
   * @return void
   */
  protected function handlePaymentStatus($status, $reason=null)
  {
    //--------------------------------------------------------------------------
    // this method only gets called when $status != 'Completed'
    // the only status currently known to happen is 'Pending'
    // all others are ignored; notification happens nonetheless
    //--------------------------------------------------------------------------
    if($status == 'Pending')
    {
      $reservation = $this->getRelatedEntity();
      $reservation->status = 'pending';
      $reservation->save();
    }
    if($status == 'Completed')
    {
      $reservation = $this->getRelatedEntity();
      $reservation->status = 'paid';
      $reservation->save();
    }
  }
}