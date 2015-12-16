<?php echo form_tag('@paypal_ipn');?>
<input type="hidden" name="mc_gross" value="120.00" />
<input type="hidden" name="invoice" value="5YC2V" />
<input type="hidden" name="protection_eligibility" value="Ineligible" />
<input type="hidden" name="address_status" value="confirmed" />
<input type="hidden" name="payer_id" value="KS46K5Y4CFTSU" />
<input type="hidden" name="tax" value="0.00" />
<input type="hidden" name="address_street" value="1 Main St" />
<input type="hidden" name="payment_date" value="12:38:40 Feb 09, 2011 PST" />
<input type="hidden" name="payment_status" value="Pending" />
<input type="hidden" name="charset" value="windows-1252" />
<input type="hidden" name="address_zip" value="95131" />
<input type="hidden" name="first_name" value="Test" />
<input type="hidden" name="mc_fee" value="3.78" />
<input type="hidden" name="address_country_code" value="US" />
<input type="hidden" name="address_name" value="Test User" />
<input type="hidden" name="notify_version" value="3.0" />
<input type="hidden" name="custom" value="" />
<input type="hidden" name="payer_status" value="verified" />
<input type="hidden" name="business" value="sales_1296405385_biz@miridis.com" />
<input type="hidden" name="address_country" value="United States" />
<input type="hidden" name="address_city" value="San Jose" />
<input type="hidden" name="quantity" value="1" />
<input type="hidden" name="payer_email" value="client_1296406243_per@miridis.com" />
<input type="hidden" name="verify_sign" value="AdpjcWvsXaJXu93RFtzoivaboxWnAibSJ1B3CU5j.D1wx-fA-cumLVrD" />
<!-- input type="hidden" name="txn_id" value="70589593GK3056439" / -->
<input type="hidden" name="txn_id" value="<?php echo $txn_id;?>" />
<input type="hidden" name="payment_type" value="instant" />
<input type="hidden" name="last_name" value="User" />
<input type="hidden" name="address_state" value="CA" />
<input type="hidden" name="receiver_email" value="sales_1296405385_biz@miridis.com" />
<input type="hidden" name="payment_fee" value="3.78" />
<input type="hidden" name="pending_reason" value="paymentreview" />
<input type="hidden" name="receiver_id" value="YR8CZHW3SEXEW" />
<input type="hidden" name="txn_type" value="web_accept" />
<input type="hidden" name="item_name" value="Transfer Reservation 5YC2V" />
<input type="hidden" name="mc_currency" value="USD" />
<input type="hidden" name="item_number" value="" />
<input type="hidden" name="residence_country" value="US" />
<input type="hidden" name="test_ipn" value="1" />
<input type="hidden" name="transaction_subject" value="Transfer Reservation 5YC2V" />
<input type="hidden" name="handling_amount" value="0.00" />
<input type="hidden" name="payment_gross" value="120.00" />
<input type="hidden" name="shipping" value="0.00" />
<input type="hidden" name="merchant_return_link" value="Return to Jorgo Miridis's Test Store" />

<input type="submit"  name="submit" value="submit" />
</form>


