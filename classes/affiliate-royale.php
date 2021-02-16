<?php
namespace MissJaimeOT\AffiliateRoyale;

class AffiliateRoyale_Controller {

    public function __construct() {
        add_action('wafp-process-signup', array($this, 'mjot_add_affiliate_as_member'), 10, 1);
        add_action( 'show_user_profile',  array($this,'mjot_show_user_affiliate_links') );
        add_action( 'edit_user_profile',  array($this, 'mjot_show_user_affiliate_links') );

        // add_filter( 'gettext', array($this,'mjot_change_af_text_strings'), 20, 3 );

        add_action( 'wafp-dashboard-links-page-li', array($this, 'mjot_show_all_affiliate_links'), 10, 1);
    }
    /**
     * Add affiliates as membership subscribers automatically
     */
    public function mjot_add_affiliate_as_member($user_id) {
        $txn = new \MeprTransaction();
        $txn->user_id = $user_id;
        $txn->product_id = 55;
        $txn->set_subtotal(0);
        $txn->gateway = 'manual';
        $txn->status = 'complete';
        $txn->tax_rate = 0.00;
        $txn->tax_amount = 0.00;
        $txn->expires_at = 0;
        $txn->store();
    }

    /**
     * Show the user affiliate links on the profile in the admin area
     */
    public function mjot_show_user_affiliate_links( $user ) {
        if(current_user_can('administrator')) {


        // global $wpdb;
        ?>
        <h2>Affiliate Links</h2>
        <style type="text/css">
            .wafp-nav-bar,
            .mjot-all-affiliate-links-desc {
                display: none;
            }
           
        </style>
        <table class="form-table">
            <tr>
            <td>
                <?php
                // echo \WafpDashboardController::display_links();

                echo $this->mjot_show_all_affiliate_links($user->ID);
                ?>
            </td>
            </tr>
        </table>
        <?php
        }
    }
    /**
     * Changes the dashboard strings when shown in the user profile
     * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
     */
    // public function mjot_change_af_text_strings( $translated_text, $text, $domain ) {

    //     if(is_admin()) {
    //         if($domain == 'affiliate-royale') {
    //             switch ( $translated_text ) {
    
    //                 case 'My Affiliate link:':
    //                     $translated_text = __( 'Main Affiliate link:', 'woocommerce' );
    //                     break;
    //                 case 'My Links &amp; Banners':
    //                     $translated_text = __( 'Affiliate Links &amp; Banners', 'woocommerce' );
    //                     break;
    //             }
    //         }
    //     }
    //     return $translated_text;
    // }
    /**
     * Shows a simple listing of the affiliate links
     */
    public function mjot_show_all_affiliate_links($affiliate_id) {
        $links = \WafpLink::get_all_objects('image, id');
        echo '<div class="mjot-all-affiliate-links"><h2>Simple List of All Affiliate Links</h2>';
        echo '<p class="mjot-all-affiliate-links-desc">These are the same as the links above but in an easier to copy format.</p>';
        foreach($links as $link) {
            
            $link_code = htmlentities($link->display_url($affiliate_id));
            echo '<p><strong>' . $link_code . '</strong></p>';
        }

        echo '</div>';
    }
    public function wl ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    } // end public function wl 
} // end class AffiliateRoyale_Controller

$missjaimeot_affiliate_royale_controller = new AffiliateRoyale_Controller();
