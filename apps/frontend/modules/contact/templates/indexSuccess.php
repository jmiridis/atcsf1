<?php slot('title');?>
Contact Us
<?php end_slot();?>

<?php slot('meta_description');?>
Please contact us if you have any question about your current reservation or would like to know more about our transportation offers.
<?php end_slot();?>

<div class="page_title">Contact Us</div>

<div class="text-box">Please choose among the following options to contact us:  </div>

<div class="section-box-half">
<div class="section-title">Postal Address / Phone / Email</div>
<table class="styled" cellpadding="0" cellspacing="0">
  <tbody>
  <tr>
    <th>Address</th>
    <td class="data">Av. Cumbres #15, SM 311, MZ 22<br />Col. Alamos, CP 77560 Cancun<br />Quintana Roo, Mexico</td>
  </tr>
  <tr>
    <th>Phone</th>
    <td class="data">+52 (998) 214-5918 or +52 (998) 201-1720</td>
  </tr>
  <tr>
    <th>Email</th>
    <td class="data"><a class="mailto" href="contact#americantransferscancun.com">contact#americantransferscancun.com</a></td>
  </tr>
  </tbody>
</table>
</div>

<?php echo form_tag('contact/create');?>
<?php echo $form->renderHiddenFields(false);?>
<div class="section-box">
<div class="section-title">Contact Form</div>

  <table class="styled" cellpadding="0" cellspacing="0" width="100%">
  <tbody>
  <?php echo $form->renderGlobalErrors() ?>
  <tr>
    <th nowrap style="width: 5%">Your e-mail</th>
    <td class="field"><?php echo $form['email_address']->renderError()?><?php echo $form['email_address']->render(array('style'=>'width: 99%'));?></td>
  </tr>
  <tr>
    <th nowrap>Your Message</th>
    <td class="field"><?php echo $form['message']->renderError()?><?php echo $form['message']->render(array('rows'=>'5','style'=>'width: 99%'));?></td>
  </tr>
  <tr>
    <td style="border: 0;"></td>
    <td align="left" style="border:0; padding: 8px;">
      <input class="button" type="submit" value="Send Message" onclick="submitForm(this)" />
    </td>
  </tr>
  </tbody>
</table>
</div>

</form>
<script>
function submitForm(e)
{
  e.disabled=true;
  e.form.submit();
  return false;
}

jQuery(function() {

  	$.fn.emailencode = function(options) {
  		var settings = jQuery.extend({
  			atsign: "#"
  		}, options);

  		return this.each(function() {
  			var address = $(this).attr("href");

  			var formatedAddress = address.replace(settings.atsign, "@");
  			if($(this).html() == address)
  			{
  			  $(this).html(formatedAddress)
  			}
  			$(this).attr("href", "mailto:" + formatedAddress);
  		});
  	};

   $('.mailto').emailencode();

   jQuery.support.borderRadius = false;
   jQuery.each(['BorderRadius','MozBorderRadius','WebkitBorderRadius','OBorderRadius','KhtmlBorderRadius'], function() {
      if(document.body.style[this] !== undefined) jQuery.support.borderRadius = true;
      return (!jQuery.support.borderRadius);
   });

   if(!$.support.borderRadius) {
      $('.button').each(function() {
         $(this).wrap('<div class="buttonwrap"></div>')
         .before('<div class="corner tl"></div><div class="corner tr"></div>')
         .after('<div class="corner bl"></div><div class="corner br"></div>');
      });
   }
});
</script>
