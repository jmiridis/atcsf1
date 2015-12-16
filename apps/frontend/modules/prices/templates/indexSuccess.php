<?php slot('title');?>
Price Table Airport - Hotel and Tours
<?php end_slot();?>
<?php slot('meta_description');?>
>The following table lists the prices for the most common tranportation needs of our customers.
<?php end_slot();?>

<style>
table.prices {margin-left: 8px;}
table.prices  td {font-size: 8pt; font-family: Verdana; padding: 3px 5px;}
table.prices thead {font-weight: bold; color: #444;}
td.one-way {}
td.round-trip { padding-left: 50px;}

div.subtitle {background-color: #D2D3F0; margin: 0px 0px; padding: 2px 5px; font-size: 10pt; color: #2E3091;}

div.service-title { color: #C0070A; font-weight:bold; font-family: Verdana; padding: 15px 0px 0px 0px; }

table.tours {}
table.tours td { border-top: 1px solid #CCCCCC; }
table.tours td.image { background-color:#DDDDDD; padding: 8px;}
table.tours td.info { padding: 0 5px 0 8px;}
table.tours td .title { padding: 5px 0 0 0; color: #006FBF;  font-size: 10pt; font-weight: bold;  margin: 3px 0 8px 0; }
table.tours td .description {padding: 3px 5px 3px 0; }
table.tours td.price {background-color:#EEEEEE; font-weight: bold; font-size: 10pt; color: #444444; padding: 0 8px; white-space:nowrap; line-height1:86px; padding-top: 15px;}
span.fullday { color: #666; font-weight:normal; padding-left: 8px;}

table.tours .more { text-align:right; padding: 0; }
table.tours .details { margin: 8px 0; color: #C0070A;}

ul.info { margin: 0; }
ul.info li {  margin: 4px 0px; line-height: 1.15em;}


</style>
<div class="page_title">Transportation & Tour Rates</div>

<div class="service-title">Private Airport Transportation</div>

<div style="margin: 15px 0px; text-align: justify;">The following table lists the prices for the most common tranportation needs of our customers. If you require a non standard transportation, feel free to contact us through one of the options provided on our <?php echo link_to('Contact Page', 'contact/index')?> and we will be glad to send you a specific offer.</div>

<div style="text-align: left;margin: 15px 0px 8px 0px; color: #2E3091; font-weight: normal; " ><?php echo link_to('Make your reservation now >>>', 'reservation/new', array('style'=>'display:inline-block; line-height: 50px; padding-left: 50px; background: url(/images/booking.png) no-repeat 0px 0px transparent !important;'))?></div>


<?php include_partial('price_table', array('destinations'=>$destinations, 'prices'=>$prices)) ?>

<div style="margin: 20px 0 0 15px; color: #444444;font-weight: bold;">General Information:</div>

<ul class="info">
  <li>Amounts are in U.S. Dollars. </li>
  <li>We accept U.S. and Canadian Dollars (rate: 1 CAD = 1 USD). If you'd rather pay in Mexican Pesos, please check the current rate with your driver.</li>
</ul>




<div class="service-title" style="margin-top: 20px;">Private Tours</div>

<div style="margin: 15px 0px; text-align: justify;">We are offering a list of the tours we have experienced to have the most cultural and recreative value. During all of our tours, you will get to <span style="color:#C0070A; font-weight:bold;">visit two places for the price of one</span> .
<br />
<p>If you would like to make a reservation or just get more information on one of our tours, please contact us through one of the options provided on our <?php echo link_to('Contact Page', 'contact/index')?></p>
</div>

<table class="tours" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" class="image"><img src="/images/tour1.jpg" width="70" height="70" alt="" border="0" /></td>
    <td valign="top" class="info">
      <div class="title">Private Chichen Itza & Cenote Ik Kil</span></div>
      <div class="description">One of the new Seven Wonders of the World, the magic of the Mayan culture and the capital of the Mayan Empire. After visiting the Chichen-Itza ruins, relax, swim and have lunch at the Cenote Ik Kil.</div>
      <div class="details">Includes Cenote Swim. Don't Miss It!!!</div>
    </td>
    <td class="price" valign="top">$60 USD</td>
  </tr>


  <tr>
    <td valign="top" class="image"><img src="/images/tour2.jpg" width="70" height="70" alt="" border="0" /></td>
    <td valign="top" class="info">
      <div class="title">Private Chichen Itza & Valladolid Market and Cathedral</div>
      <div class="description">First stop, Chichen Itza ruins, the capital of the Mayan Empire and one of the new Seven Wonders of the World.</div>
      <div class="description">Second stop, the Valladolid Market, where we shop the typical Mayan handcrafts, try the Mayan cuisine and visit the famous Cathedral of Valladolid.</div>
      <div class="details">You'll Love It!!!</div>
     </td>
    <td class="price" valign="top">$60 USD </td>

  </tr>
  <tr>
    <td valign="top" class="image"><img src="/images/tour3.jpg" width="70" height="70" alt="" border="0" /></td>
    <td valign="top" class="info">
      <div class="title">Tulum Express</div>
      <div class="description">The only ruins found on the coast overlooking the ocean. It is believed to have been the largest port of the Mayans. Have a swim in the crystal-clear waters of Tulum.</div>
      <div class="description">After that, we visit the famous 5th Avenue in Playa del Carmen. Where you are able to relax, have lunch and do your shopping.</div>
      <div class="details">Relax and Enjoy!!!</div>
    </td>
    <td class="price" valign="top">$60 USD</td>
  </tr>

  <tr>
    <td valign="top" class="image"><img src="/images/tour4.jpg" width="70" height="70" alt="" border="0" /></td>
    <td valign="top" class="info">
      <div class="title">Cob&aacute; Great Cenotes</div>
      <div class="description">Coba are the second most important ruins in the Yucatan Peninsula. Visit its lagoons and enjoy the only ruins that you can still climb.</div>
      <div class="description">Second stop: We will visit the Coba Mayan Village where we will have lunch, rest and have the opportunity to buy the typical Mayan handcrafts.</div>
      <div class="details">You won't regret it!!!</div>
    </td>
    <td class="price" valign="top">$60 USD</td>
  </tr>

  <tr>
    <td valign="top" class="image"><img src="/images/tour5.jpg" width="70" height="70" alt="" border="0" /></td>
    <td valign="top" class="info">
      <div class="title">Jungle Tour with Speed Boats</div>
      <div class="description">Drive a speedboat through the beautiful lagoon and discover the underwater life in the world's 2nd largest reef with your own snorkel.</div>
      <div class="description">Second stop, shopping and lunch at one of the biggest malls in Cancun area.</div>
      <div class="details">So Much Fun!!!</div>
    </td>
    <td class="price" valign="top">$60 USD</td>
  </tr>

  <tr>
    <td valign="top" class="image"><img src="/images/tour6.jpg" width="70" height="70" alt="" border="0" /></td>
    <td valign="top" class="info">
      <div class="title">Isla Mujeres Catamaran</div>
      <div class="description">Enjoy a spectacular day on the water on board a catamaran sail boat from Cancun, Mexico. Snorkel on a wonderful Caribbean reef then go to the island of Isla Mujeres to explore, have lunch, shop...then try out the spinnaker on the way home.</div>
      <div class="details">You Have Never Seen Something Like This Before!!!</div>
    </td>
    <td class="price" valign="top">$60 USD</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
                                                                   .



<script>
$(function(){
  return;
  $("table.prices tbody tr:nth-child(odd)").children('td').addClass("striped");
	$('div.details').toggle(false);

  $('a.more').each(function(i,e) { e.onclick = function() {$(this).parent().next().toggle(); $(this).text($(this).parent().next().is(":visible")? 'less ...' : 'more ...'); return false;}});

});
</script>
