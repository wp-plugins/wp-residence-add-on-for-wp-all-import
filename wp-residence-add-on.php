<?php

/*
Plugin Name: WP All Import - WP Residence Add-On
Plugin URI: http://www.wpallimport.com/
Description: Supporting imports into the WP Residence theme.
Version: 1.0.2
Author: Soflyy
*/


include "rapid-addon.php";

$wpresidence_addon = new RapidAddon( 'WP Residence Add-On', 'realhomes_addon' );

$wpresidence_addon->disable_default_images();

$wpresidence_addon->import_images( 'property_images', 'Property Images' );

$wpresidence_addon->add_field( 'property_price', 'Price', 'text', null, 'Only digits, example: 435000' );

$wpresidence_addon->add_field( 'property_label', 'After Price Label', 'text', null, 'Example: Per Month' );

$wpresidence_addon->add_field( 'property_size', 'Size', 'text' );

$wpresidence_addon->add_field( 'property_lot_size', 'Lot Size', 'text' );

$wpresidence_addon->add_field( 'property_rooms', 'Rooms', 'text' );

$wpresidence_addon->add_field( 'property_bedrooms', 'Bedrooms', 'text' );

$wpresidence_addon->add_field( 'property_bathrooms', 'Bathrooms', 'text' );

$wpresidence_addon->add_field( 'property_features', 'Features and Amenities', 'text', null, 'Comma delimited list of features and amenities' );

$wpresidence_addon->add_title( 'Custom Property Details' );

$wpresidence_addon->add_text( 'To edit existing and add new custom property details go to Appearance > WP Residence Options > Listings Customs Fields. Make sure that the imported values conform to the requirements of the selected field type designated on the WP Residence options page.' );

// get all the custom details
$custom_details = get_option( 'wp_estate_custom_fields' );

// build the key array for the UI and the field array for the actual import
foreach ($custom_details as $custom_detail) {

	$key = $custom_detail[0];

	$key = str_replace( ' ', '-', $key );

	$label = $custom_detail[1] . ' (' . $custom_detail[2] . ')';

	$wpresidence_addon->add_field( '_custom_details_' . $key, $label, 'text' );

}

$wpresidence_addon->add_title( 'Property Video' );

$wpresidence_addon->add_field( 'embed_video_type', 'Video from:', 'radio', 
	array(
		'youtube' => 'YouTube',
		'vimeo' => 'Vimeo'
) );

$wpresidence_addon->add_field( 'embed_video_id', 'Embed Video ID', 'text', null, 'Embed ID from http://www.youtube.com/watch?v=dQw4w9WgXcQ would be: dQw4w9WgXcQ' );

$wpresidence_addon->add_title( 'Property Location' );

$wpresidence_addon->add_field( 'property_address', 'Address', 'text', null, 'Building number and street name, example: 1206 King St' );

$wpresidence_addon->add_field( 'property_zip', 'Zip', 'text' );

$wpresidence_addon->add_field( 'property_country', 'Country', 'text' );

$wpresidence_addon->add_field(
	'location_settings',
	'Map Location',
	'radio', 
	array(
		'search_by_address' => array(
			'Search by Address',
			$wpresidence_addon->add_options( 
				$wpresidence_addon->add_field(
					'_property_location_search',
					'Property Address',
					'text'
				),
				'Google Geocode API Settings', 
				array(
					$wpresidence_addon->add_field(
						'address_geocode',
						'Request Method',
						'radio',
						array(
							'address_no_key' => array(
								'No API Key',
								'Limited number of requests.'
							),
							'address_google_developers' => array(
								'Google Developers API Key - <a href="https://developers.google.com/maps/documentation/geocoding/#api_key">Get free API key</a>',
								$wpresidence_addon->add_field(
									'address_google_developers_api_key', 
									'API Key', 
									'text'
								),
								'Up to 2,500 requests per day and 5 requests per second.'
							),
							'address_google_for_work' => array(
								'Google for Work Client ID & Digital Signature - <a href="https://developers.google.com/maps/documentation/business">Sign up for Google for Work</a>',
								$wpresidence_addon->add_field(
									'address_google_for_work_client_id', 
									'Google for Work Client ID', 
									'text'
								), 
								$wpresidence_addon->add_field(
									'address_google_for_work_digital_signature', 
									'Google for Work Digital Signature', 
									'text'
								),
								'Up to 100,000 requests per day and 10 requests per second'
							)
						) // end Request Method options array
					) // end Request Method nested radio field 
				) // end Google Geocode API Settings fields
			) // end Google Gecode API Settings options panel
		), // end Search by Address radio field
		'search_by_coordinates' => array(
			'Enter Coordinates',
			$wpresidence_addon->add_field(
				'_property_latitude', 
				'Latitude', 
				'text', 
				null, 
				'Example: 34.0194543'
			),
			$wpresidence_addon->add_field(
				'_property_longitude',
				'Longitude',
				'text',
				null, 
				'Example: -118.4911912'
			) // end coordinates Option panel
		) // end Search by Coordinates radio field
	) // end Property Location radio field
);

$wpresidence_addon->add_options( null, 'Advanced Options', array(

	$wpresidence_addon->add_field( 'property_agent', 'Agent Responsible', 'text', null, 'Match by Agent name. If no match found, a new Agent will be created.' ),

	$wpresidence_addon->add_field( 'property_user', 'Assign Property to User', 'text', null, 'Match by user ID, email, login, or slug' ),

	$wpresidence_addon->add_field( 'property_google_view', 'Enable Google Street View', 'radio', array(
		'1' => 'Yes',
		'' => 'No'
	) ),

	$wpresidence_addon->add_field( 'google_camera_angle', 'Google Street View Camera Angle', 'text'),

	$wpresidence_addon->add_field( 'page_custom_zoom', 'Zoom Level for map (1-20)', 'text'),

	$wpresidence_addon->add_field( 'property_status', 'Property Status', 'text' ),

	$wpresidence_addon->add_field( 'prop_featured', 'Featured Property', 'radio',
		array(
			'0' => 'No',
			'1' => 'Yes'
	) ),

	$wpresidence_addon->add_field( 'owner_notes', 'Owner/Agent Notes', 'text', null, 'Not visible on the front end' ),

	$wpresidence_addon->add_field( 'header_type', 'Header Type', 'radio', 	
		array(
			'0' => 'Global',
			'1' => 'None',
			'2' => array(
				'Image',
				$wpresidence_addon->add_field( 'page_custom_image', 'Header Image', 'image' )
			),
			'3' => 'Theme Slider',
			'4' => array(
				'Revolution Slider',
				$wpresidence_addon->add_field( 'rev_slider', 'Revolution Slider Name', 'text' ),
			),
			'5' => array(
				'Google Map',
				$wpresidence_addon->add_field( 'min_height', 'Map height when closed', 'text', null, 'In pixels, example: 200' ),
				$wpresidence_addon->add_field( 'max_height', 'Map height when open', 'text', null, 'In pixels, example: 600' ),
				$wpresidence_addon->add_field( 'keep_min', 'Force the map closed', 'radio', array(
					'no' => 'No',
					'yes' => 'Yes'	
				) )
	) ) ),

	$wpresidence_addon->add_field( 'header_transparent', 'Use transparent header?', 'radio', 
	array(
		'global' => 'Global',
		'no' => 'No',
		'yes' => 'Yes'
	) ),

	$wpresidence_addon->add_field( 'sidebar_agent_option', 'Show Agent in Sidebar', 'radio', 
	array(
		'global' => 'Global',
		'no' => 'No',
		'yes' => 'Yes'
	) ),

	$wpresidence_addon->add_field( 'local_pgpr_slider_type', 'Slider Type', 'radio', 
	array(
		'global' => 'Global',
		'vertical' => 'Vertical',
		'horizontal' => 'Horizontal'
	) ),

	$wpresidence_addon->add_field( 'local_pgpr_content_type', 'Show Content As', 'radio', 
	array(
		'global' => 'Global',
		'accordion' => 'Accordion',
		'tabs' => 'Tabs'
	) ),

	$wpresidence_addon->add_field( 'sidebar_option', 'Where to Show the Sidebar', 'radio', 
	array(
		'right' => 'Right',
		'left' => 'Left',
		'none' => 'None'
	) ),

	$wpresidence_addon->add_field( 'sidebar_select', 'Select the Sidebar', 'radio', 
	array(
		'primary-widget-area' => 'Primary Widget Area',
		'secondary-widget-area' => 'Secondary Widget Area',
		'first-footer-widget-area' => 'First Footer Widget Area',
		'second-footer-widget-area' => 'Second Footer Widget Area',
		'third-footer-widget-area' => 'Third Footer Widget Area',
		'fourth-footer-widget-area' => 'Fourth Footer Widget Area',
		'top-bar-left-widget-area' => 'Top Bar Left Widget Area',
		'top-bar-right-widget-area' => 'Top Bar Right Widget Area'
	) ),

	$wpresidence_addon->add_field( 'slide_template', 'RevSlider Slide Template', 'text', null, 'Meta ID of the desired slide template' )

) );

$wpresidence_addon->set_import_function( 'wpresidence_addon_import' );

$wpresidence_addon->admin_notice();

$wpresidence_addon->run(
	array(
		"post_types" => array( "estate_property" )
	)
);

function wpresidence_addon_import( $post_id, $data, $import_options ) {
    
    global $wpresidence_addon;

    // all fields except for slider and image fields
    $fields = array(
		'property_price',
		'property_label',
		'property_size',
		'property_lot_size',
		'property_rooms',
		'property_bedrooms',
		'property_bathrooms',
		'embed_video_type',
		'embed_video_id',
		'property_address',
		'property_zip',
		'property_country',
		'property_google_view',
		'google_camera_angle',
		'prop_featured',
		'owner_notes',
		'header_type',
		'header_transparent',
		'rev_slider',
		'min_height',
		'max_height',
		'keep_min',
		'sidebar_agent_option',
		'local_pgpr_slider_type',
		'local_pgpr_content_type',
		'sidebar_option',
		'sidebar_select',
		'slide_template'
    );
    
    // image fields
    $image_fields = array(
        'page_custom_image' 
    );

	// get all the custom details
	$custom_details = get_option( 'wp_estate_custom_fields' );

	// an array for custom detail field postmeta keys
	$custom_details_fields = array();

	// build the key array for the UI and the field array for the actual import
	foreach ($custom_details as $custom_detail) {

		$key = $custom_detail[0];

		$key = str_replace( ' ', '-', $key );
		
		$custom_details_fields[] = '_custom_details_' . $key;

	}
    
    $fields = array_merge( $fields, $custom_details_fields, $image_fields );

    // update everything in fields arrays
    foreach ( $fields as $field ) {

        if ( $wpresidence_addon->can_update_meta( $field, $import_options ) ) {

            if ( in_array( $field, $image_fields ) ) {

                if ( $wpresidence_addon->can_update_image( $import_options ) ) {

                    $id = $data[$field]['attachment_id'];

                    $url = wp_get_attachment_url( $id );

                    update_post_meta( $post_id, $field, $url );

                }

            } elseif ( in_array( $field, $custom_details_fields ) ) {

            	$key = substr( $field, 16 );

            	update_post_meta( $post_id, $key, $data[$field] );

            } else {

                update_post_meta( $post_id, $field, $data[$field] );

            }
        }
    }

    // set map zoom
    $field = 'page_custom_zoom';

    if ( $wpresidence_addon->can_update_meta( $field, $import_options ) ) {

    	$zoom = ( empty( $data[$field] ) ? 15 : $data[$field] );

        update_post_meta( $post_id, $field, $zoom );

    }

    // clear image fields to override import settings
    $fields = array(
    	'page_custom_image'
    );

    if ( $wpresidence_addon->can_update_image( $import_options ) ) {

    	foreach ($fields as $field) {

	    	delete_post_meta($post_id, $field);

	    }

    }

    // do not support floor plans
    $field = 'use_floor_plans';

    if ( $wpresidence_addon->can_update_meta( $field, $import_options ) ) {

        update_post_meta( $post_id, $field, 0 );

    }

    // add empty features
    $fields = explode(',',get_option( 'wp_estate_feature_list' ));
    
    $features = array();

    foreach ($fields as $field) {

    	if ( !empty( $field ) ) {
	    
	    	$field = trim($field);

	    	$features[] = $field;

	    	$field = sanitize_key(str_replace(' ', '_', $field));

	    	if ( $wpresidence_addon->can_update_meta( $field, $import_options ) ) {

	            update_post_meta( $post_id, $field );

	        }
	    }
    }

    // add imported features
	$fields = explode(',', $data['property_features']);

    $wpresidence_addon->log( 'Updating Features and Amenities' );

    foreach ($fields as $field) {

    	$field = trim($field);

    	$field_ = sanitize_key(str_replace(' ', '_', $field));

    	if ( $wpresidence_addon->can_update_meta( $field_, $import_options ) ) {

            update_post_meta( $post_id, $field_, 1 );

            // add new features to features list
            if ( !in_array( $field, $features ) ) {

			    $wpresidence_addon->log( '- <b>WARNING:</b> Existing feature "' . $field . '" not found, adding to database and assigning to property' );

            	$features[] = $field;

            }
        }
    }

    // replace wp_estate_feature_list option with features list
    $features = implode(', ', $features);

    update_option( 'wp_estate_feature_list', $features );

    // update property status
    $field = 'property_status';

	if ( $wpresidence_addon->can_update_meta( $field, $import_options ) ) {

	    $wpresidence_addon->log( 'Updating Property Status' );

	    $statuses = explode( ',', get_option( 'wp_estate_status_list' ) );

	    $trimmed_statuses = array();

	    foreach ( $statuses as $status ) {

	    	$status = trim($status);

	    	$trimmed_statuses[] = $status;

	    }

	    $statuses = $trimmed_statuses;

	    if ( in_array( $data[$field], $statuses ) ) {

		    $wpresidence_addon->log( '- Existing property status found, setting property status to "' . $data[$field] . '"' );

	        update_post_meta( $post_id, $field, $data[$field] );

	    } else {

		    $wpresidence_addon->log( '- <b>WARNING:</b> Existing property status not found, adding new status "' . $data[$field] . '" and assigning to property' );

	        update_post_meta( $post_id, $field, $data[$field] );

	        $statuses[] = $data[$field];

	        $statuses = implode( ', ', $statuses );

		    update_option( 'wp_estate_status_list', $statuses );

	    }

	}

	// update agent, create a new one if not found
	$field = 'property_agent';
	$post_type = 'estate_agent';

	if ( $wpresidence_addon->can_update_meta( $field, $import_options ) ) {
	
	    $wpresidence_addon->log( 'Assign Property to Responsible Agent' );

		$post = get_page_by_title( $data[$field], 'OBJECT', $post_type );

		if ( !empty( $post ) ) {

		    $wpresidence_addon->log( '- Existing agent found. ' . $data[$field] . ' is now responsible for this property.' );

			update_post_meta( $post_id, $field, $post->ID );

		} else {

			// insert title and attach to property
			$postarr = array(
			  'post_content'   => '',
			  'post_name'      => $data[$field],
			  'post_title'     => $data[$field],
			  'post_type'      => $post_type,
			  'post_status'    => 'publish',
			  'post_excerpt'   => ''
			);

			wp_insert_post( $postarr );

			$post = get_page_by_title( $data[$field], 'OBJECT', $post_type );

		    $wpresidence_addon->log( '- <b>WARNING:</b> Existing agent not found. Agent ' . $data[$field] . ' added and is now responsible for this property.' );

			update_post_meta( $post_id, $field, $post->ID );

		}
	}

	// assign property to user
    $field = 'property_user';

	$wpresidence_addon->log( 'Assign Property to User' );

	if ( $wpresidence_addon->can_update_meta( $field, $import_options ) ) {

		$user = get_user_by( 'id', $data[$field] );

		if ( $user === false ) {

			$user = get_user_by( 'slug', $data[$field] );

		}

		if ( $user === false ) {

			$user = get_user_by( 'email', $data[$field] );

		}

		if ( $user === false ) {

			$user = get_user_by( 'login', $data[$field] );

		}

		if ( $user != false ) {

			$id = $user->data->id;

		    $wpresidence_addon->log( '- User found, assigning property to ' . $user->data->user_nicename );

            update_post_meta( $post_id, $field, $data[$field] );

		} else {

			$users = get_super_admins();

			$user = get_user_by( 'login', $users[0] );

			$id = $user->data->id;

		    $wpresidence_addon->log( '- <b>WARNING:</b> No user found searching for "'. $data[$field] . '", assigning property to ' . $user->data->user_nicename );

            update_post_meta( $post_id, $field, $id );

		}

        // change author to property_user
        // in this case $id refers to the property_user $id from above
        $current_id = wpsestate_get_author( $post_id );
        
        if( $current_id != $id ){

            $post = array(
                'ID'            => $post_id,
                'post_author'   => $id
            );

            wp_update_post( $post ); 
        }

	}



    // update property location
    $wpresidence_addon->log( 'Updating Map Location' );

    $field   = '_property_location_search';

    $address = $data[$field];

    $lat  = $data['property_latitude'];

    $long = $data['property_longitude'];
    
    //  build search query
    if ( $data['location_settings'] == 'search_by_address' ) {

    	$search = ( !empty( $address ) ? 'address=' . rawurlencode( $address ) : null );

    } else {

    	$search = ( !empty( $lat ) && !empty( $long ) ? 'latlng=' . rawurlencode( $lat . ',' . $long ) : null );

    }

    // build api key
    if ( $data['location_settings'] == 'search_by_address' ) {
    
    	if ( $data['address_geocode'] == 'address_google_developers' && !empty( $data['address_google_developers_api_key'] ) ) {
        
	        $api_key = '&key=' . $data['address_google_developers_api_key'];
	    
	    } elseif ( $data['address_geocode'] == 'address_google_for_work' && !empty( $data['address_google_for_work_client_id'] ) && !empty( $data['address_google_for_work_signature'] ) ) {
	        
	        $api_key = '&client=' . $data['address_google_for_work_client_id'] . '&signature=' . $data['address_google_for_work_signature'];

	    }

    }

    // if all fields are updateable and $search has a value
    if ( $wpresidence_addon->can_update_meta( $field, $import_options ) && $wpresidence_addon->can_update_meta( 'property_latitude', $import_options ) && $wpresidence_addon->can_update_meta( 'property_longitude', $import_options ) && !empty ( $search ) ) {
        
        // build $request_url for api call
        $request_url = 'https://maps.googleapis.com/maps/api/geocode/json?' . $search . $api_key;

        $curl = curl_init();

        curl_setopt( $curl, CURLOPT_URL, $request_url );

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

        $wpresidence_addon->log( '- Getting location data from Geocoding API: ' . $request_url );

        $json = curl_exec( $curl );

        curl_close( $curl );
        
        // parse api response
        if ( !empty( $json ) ) {

            $details = json_decode( $json, true );

            if ( $data['location_settings'] == 'search_by_address' ) {

	            $lat  = $details[results][0][geometry][location][lat];

	            $long = $details[results][0][geometry][location][lng];

	        } else {

	        	$address = $details[results][0][formatted_address];

	        }

        }
        
    }
    
    // update location fields
    $fields = array(
        'property_latitude' => $lat,
        'property_longitude' => $long,
    );

    $wpresidence_addon->log( '- Updating latitude and longitude' );
    
    foreach ( $fields as $key => $value ) {
        
        if ( $wpresidence_addon->can_update_meta( $key, $import_options ) ) {
            
            update_post_meta( $post_id, $key, $value );
        
        }
    }
}

add_action('pmxi_saved_post', 'estate_save_postdata', 1, 1);



