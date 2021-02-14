<?php
namespace MissJaimeOT\AffiliateRoyale;

class AffiliateRoyale_Controller {

    public function __construct() {
        add_action('wafp-process-signup', array($this, 'mjot_add_affiliate_as_member'), 10, 1);
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
