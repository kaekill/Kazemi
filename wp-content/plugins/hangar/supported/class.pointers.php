<?php

add_action( 'admin_enqueue_scripts', 'tdp_admin_pointers_header' );
function tdp_admin_pointers_header() {
   if ( tdp_admin_pointers_check() ) {
      add_action( 'admin_print_footer_scripts', 'tdp_admin_pointers_footer' );

      wp_enqueue_script( 'wp-pointer' );
      wp_enqueue_style( 'wp-pointer' );
   }
}

function tdp_admin_pointers_check() {
   $admin_pointers = tdp_admin_pointers();
   foreach ( $admin_pointers as $pointer => $array ) {
      if ( $array['active'] )
         return true;
   }
}

function tdp_admin_pointers_footer() {
   $admin_pointers = tdp_admin_pointers();
   ?>
<script type="text/javascript">
/* <![CDATA[ */
( function($) {
   <?php
   foreach ( $admin_pointers as $pointer => $array ) {
      if ( $array['active'] ) {
         ?>
         $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
            content: '<?php echo $array['content']; ?>',
            position: {
            edge: '<?php echo $array['edge']; ?>',
            align: '<?php echo $array['align']; ?>'
         },
            close: function() {
               $.post( ajaxurl, {
                  pointer: '<?php echo $pointer; ?>',
                  action: 'dismiss-wp-pointer'
               } );
            }
         } ).pointer( 'open' );
         <?php
      }
   }
   ?>
} )(jQuery);
/* ]]> */
</script>
   <?php
}

function tdp_admin_pointers() {
   $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
   $version = '1_2'; // replace all periods in 1.0 with an underscore
   $prefix = 'tdp_admin_pointers' . $version . '_';

   $hangar3 = '<h3>' . __( '1 Click Setup Tool ' ) . '</h3>';
   $hangar3 .= '<p>' . __( 'If you are new to wordpress or have problems creating posts or pages that look like the theme preview you can import dummy demo data posts and pages here that will definitely help to understand how those tasks are done. <br/><br/> If you wish to proceed with the 1 click demo setup please click here."' ) . '</p>';

   return array(
      
      $prefix . 'hangar_intro_popup_update' => array(
         'content' => $hangar3,
         'anchor_id' => '#wp-admin-bar-tdp-installer-link',
         'edge' => 'top',
         'align' => 'left',
         'active' => ( ! in_array( $prefix . 'hangar_intro_popup_update', $dismissed ) )
      ),

   );
}