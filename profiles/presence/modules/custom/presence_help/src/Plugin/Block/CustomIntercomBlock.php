<?php

namespace Drupal\presence_help\Plugin\Block;

use Drupal\user\Entity\User;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CustomIntercomBlock' block.
 *
 * @Block(
 *  id = "custom_intercom_block",
 *  admin_label = @Translation("Custom intercom block"),
 * )
 */
class CustomIntercomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $user = User::load(\Drupal::currentUser()->id());
    $email = $user->getEmail();
    $created = $user->getCreatedTime();
    $name = $user->get('name')->value;
    $app_id = "cfdcpr8p";
    $build['custom_intercom_block']['#markup'] = '<script>
		  window.intercomSettings = {
		    app_id: ' . $app_id . ',
		    name: ' . $name . ', // Full name
		    email: ' . $email . ', // Email address
		    created_at: ' . $created . ', // Signup date as a Unix timestamp
		  };
		</script>';
    $build['custom_intercom_block']['#markup'] .= "<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==='function'){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/cfdcpr8p';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>";
    return $build;
  }

}
