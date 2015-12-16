<?php slot('title');?>
Frequent Questions and Answers
<?php end_slot();?>

<?php slot('meta_description');?>
These Questions and Answers will help you understand the details of your transportation experience with us.
<?php end_slot();?>


<div class="page_title">F.A.Q.</div>

<div class="text-box">The following questions & answers are the ones we have experienced to be the most common among our customers and hopefully will also be useful to you.
If you have any questions that are not answered here, feel free to <?php echo link_to('contact us', 'contact/index')?> directly and we will be glad to assist you personally.</div>

<div class="text-box">Click on each question to see the respective answer or click <a href="#" onclick="$('div.answer').toggle(true);$('a.view').addClass('view-minus');">here to view all answers</a></div>

<div class="question">Why should I book with AMERICAN TRANFERS CANCUN?</div>
<div class="answer">AMERICAN TRANSFERS CANCUN understand our customer needs, our goal is to do more for our customers all the time, seeking always to exceed their expectations, we have more than 10 years experience and our staff is highly trained and our vehicles are recent model with the best insurance policy in order to guarantee your safety at any moment.</div>

<div class="question">My flight is delayed, what should I do?</div>
<div class="answer">We have professional and trained staff at Cancun International Airport devoted exclusively to monitor your flight, to greet you and guide you to your vehicle. If your flight is delayed we will know it and we'll be waiting for you. If your flight is cancelled or for some reason you missed your flight, just let us know in order to provide us with the new information.</div>

<div class="question">Where I will be contacted upon arrival to Cancun Airport?</div>
<div class="answer">Having passed through customs and the baggage claim area, you will cross the automatically sliding doors and will be welcomed by the AMERICAN TRANFERS CANCUN Supervisor which will be holding a banner with our logo on it, he will escort you to your vehicle and help you with any other assistance you may need.</div>

<div class="question">I will need a car seat for my Baby.</div>
<div class="answer">We do have this service, from 1 month old to 4 years old, there is no extra charge but in order to guarantee the baby seat, this must be requested in advance. </div>

<div class="question">I need to cancel my reservation?</div>
<div class="answer">We understand your travel plans may change. With that in mind, ATC has a very simple process: regardless of whether you made your reservation online or via our OFFICEnumber, just contact us at reservation@americantranferscancun.com and remember to have you confirmation number with you.</div>

<div class="question">My driver speaks English?</div>
<div class="answer">All the AMERICAN TRANFERS CANCUN staff speaks English and they will be glad to assist you at anytime. </div>

<div class="question">Why prepay my service?</div>
<div class="answer">When you book your reservation online, you save the time and hassle of paying with credit card or cash on board the vehicle. Prepayment has become the industry standard for travel related reservations made online. Prepayment helps us reduce no-shows, reduce fraudulent reservations and keep costs down. In addition, prepayment is a much easier and more convenient way for our guests to use our service. Enjoy the convenience and peace of mind of having your reservation completed in advance by visiting our reservations page today!</div>

<script>
$(function(){
	$('div.answer').toggle(false);
//	$('div.question').each(function(i,e) { $(e).prepend($('<a class="view view-plus" href="#"></a>'));});
	$('div.question').contents().wrap('<a href="#" onclick="return false;" class="view view-plus"></a>');
  $('a.view').each(function(i,e) { e.onclick = function() {$(this).parent().next().toggle(); $(this).toggleClass('view-minus');}});
})
</script>