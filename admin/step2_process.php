<?php

/* Insert from Step 2 data into SSW's table in database */
    if( $_POST['ssw_next_stage'] != '' && sanitize_key( $_POST['site_address'] ) != '' ) {
        /* sanitize_email sanitizes the value to allowed email address for passing in to a SQL query */
        $admin_email = sanitize_email( $_POST['admin_email'] );
        /* sanitize_key performs strict sanitization on the value admin_user_id before passing in to a SQL query */
        $admin_user_id = sanitize_key( $_POST['admin_user_id'] );
        $site_address_bucket = sanitize_key( $_POST['site_address_bucket'] );
        $site_address = sanitize_key( $_POST['site_address'] );
        /* Check if the bucket selected is from the list of all buckets that should be blank buckets */
        if( in_array($site_address_bucket, $site_address_bucket_none_value) != true && $site_address_bucket != '' ) {
            $path = $current_site->path.$site_address_bucket.'-'.$site_address;
        }
        else {
            $path = $current_site->path.$site_address ;
        }
        
        /* sanitize_title_for_query sanitizes the value to make it safe for passing in to a SQL query */
        $title = sanitize_text_field( $_POST['site_title'] );
        /* sanitize_key sanitizes the value to all right content required for the path for security */
        /* Multisite Privacy Plugin uses value -1, -2 and -3 hence we add 3 and then subtract 3 after sending it to sanitize values */
        $privacy = sanitize_title_for_query( $_POST['site_privacy'] ) - 3;
        $next_stage = sanitize_title_for_query( $_POST['ssw_next_stage'] );
        $endtime = current_time('mysql');
        
        $result = $wpdb->query(
            'UPDATE '.$ssw_main_table.' SET user_id = \''.$current_user_id.'\', admin_email = \''.$admin_email.'\', 
            admin_user_id = \''.$admin_user_id.'\', path = \''.$path.'\', title = \''.$title.'\', 
            privacy = \''.$privacy.'\', next_stage = \''.$next_stage.'\', endtime = \''.$endtime.'\' WHERE user_id = '.$current_user_id.' and site_created = false and wizard_completed = false'
        );
        if ( is_wp_error( $result ) ) {
           $error_string = $result->get_error_message();
           echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }    
    }
?>