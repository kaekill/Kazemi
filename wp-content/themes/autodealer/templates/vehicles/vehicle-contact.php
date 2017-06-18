<?php
/**
 * The Template for displaying vehicle vehicle contact form
 *
 * @package ThemesDepot Framework
 */


if (is_singular()) {
    		$author_id = get_queried_object()->post_author;
    		$author_email_address = get_the_author_meta('user_email', $author_id);
		}

		// Contact form processing
			$name_error = '';
			$email_error = '';
			$subject_error = '';
			$message_error = '';
			if (!isset($_REQUEST['c_submitted'])) 
			{
			//If not isset -> set with dumy value 
			$_REQUEST['c_submitted'] = ""; 
			$_REQUEST['c_name'] = "";
			$_REQUEST['c_email'] = "";
			$_REQUEST['c_message'] = "";
			}

			if($_REQUEST['c_submitted']){

				//check name
				if(trim($_REQUEST['c_name'] == "")){
					//it's empty
					
					$name_error = __('You forgot to fill in your name', 'framework');
					$error = true;
				}else{
					//its ok
					$c_name = trim($_REQUEST['c_name']);
				}

				//check email
				if(trim($_REQUEST['c_email'] === "")){
					//it's empty
					$email_error = __('Your forgot to fill in your email address', 'framework');
					$error = true;
				}else if(!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_REQUEST['c_email']))){
					//it's wrong format
					$email_error = __('Wrong email format', 'framework');
					$error = true;
				}else{
					//it's ok
					$c_email = trim($_REQUEST['c_email']);
				}


				//check name
				if(trim($_REQUEST['c_message'] === "")){
					//it's empty
					$message_error = __('You forgot to fill in your message', 'framework');
					$error = true;
				}else{
					//it's ok
					$c_message = trim($_REQUEST['c_message']);
				}

				if(trim($_REQUEST['c_submitted_honeypot'] !== "")){
					$message_error = __('Cheating?', 'framework');
					$error = true;
				}

				//if no errors occured
				if($error != true) {

					$email_to =  $author_email_address;
					if (!isset($email_to) || ($email_to == '') ){
						$email_to = get_option('admin_email');
					}
					$c_subject = __('Message from ', 'framework') . get_bloginfo('name') . ' - Listing: ' . get_the_title();
					$message_body = "Name: $c_name \n\nEmail: $c_email \n\nComments: $c_message";
					$headers = 'From: '.get_bloginfo('name').' <'.$c_email.'>';

					wp_mail($email_to, $c_subject, $message_body, $headers);

					$email_sent = true;
				}

			}

			if(isset($email_sent) && $email_sent == true){

				add_query_arg();

			}

		?>

		<script type="text/javascript">
				(function($){
				$.fn.validettaLanguage = function(){	
				}
				$.validettaLanguage = {
					init : function(){
						$.validettaLanguage.messages = {
					empty 		: '<?php _e("All the fields must be completed.","framework");?>',
			        email   	: '<?php _e("Please check your email address is in a valid format.","framework");?>'
						};
					}
				}
				$.validettaLanguage.init();
			})(jQuery);

		</script>
		
		<?php if(isset($email_sent) && $email_sent == true && $_GET['message'] == 'sent' ){ ?>
			
			<div class="alert-box success">
				<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
				<div class="alert-content"><?php _e('Message Successfully Sent','framework');?></div>
			</div>

		<?php } ?>

		<div id="contact-form">
								            
			<form action="<?php echo add_query_arg( 'message', 'sent#tabs-3' ); ?>" id="contactform" method="post" class="contactsubmit">
								                
				<div class="one_half">

					<input type="text" name="c_name" id="c_name" size="22" tabindex="1" class="required" data-validetta="required" placeholder="<?php _e('Name', 'framework'); ?>" />
					<?php if($name_error != '') { ?>
						<p><?php echo $name_error;?></p>
					<?php } ?>

					<input type="text" name="c_email" id="c_email" size="22" tabindex="1" class="required email" data-validetta="required,email" placeholder="<?php _e('Email', 'framework');?>" />
					<?php if($email_error != '') { ?>
							<p><?php echo $email_error;?></p>
					<?php } ?>

					<label for="c_submit"></label>
					<input type="hidden" name="c_submitted_honeypot" id="c_submitted_honeypot" value="" />
					<input type="submit" name="c_submit" id="c_submit" class="button medium black" value="<?php _e('Send Message', 'framework'); ?>"/>
					<input type="hidden" name="c_submitted" id="c_submitted" value="true" />

				</div>

				<div class="one_half last">

					<textarea name="c_message" id="c_message" rows="8" tabindex="3" data-validetta="required" class="required" placeholder="<?php _e('Enter Your Message','framework');?>"></textarea>
					<?php if($message_error != '') { ?>
						<p><?php echo $message_error;?></p>
					<?php } ?>

				</div>

				<div class="clear"></div>

				
								                			                
			</form>

		</div>