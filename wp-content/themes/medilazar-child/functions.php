<?php

/**
 * Enqueue script and styles for child theme
 */
function cm_child_enqueue_styles_and_scripts()
{
	wp_enqueue_style('child-styles', get_stylesheet_directory_uri() . '/style.css', false, time(), 'all');
	wp_enqueue_style('cm-elementor-styles', get_stylesheet_directory_uri() . '/css/cm-elementor.css', false, time(), 'all');
	wp_enqueue_script("si_script", get_stylesheet_directory_uri() . "/js/custom.js", '', time());
}
add_action('wp_enqueue_scripts', 'cm_child_enqueue_styles_and_scripts', 110000);

/**
 * Add category column to Woocommerce order details page in admin
 */
function cm_action_woocommerce_admin_order_item_headers()
{ ?>
	<th class="item sortable" colspan="2" data-sort="string-ins"><?php _e('Categoria', 'woocommerce'); ?></th>
<?php
};

function cm_action_woocommerce_admin_order_item_values($_product, $item, $item_id)
{ ?>
	<td class="name" colspan="2">
		<?php
		$category_names = [];
		if ($_product) {
			$termsp = get_the_terms($_product->get_id(), 'product_cat');
			if (!empty($termsp)) {
				foreach ($termsp as $term) {
					$_categoryid = $term->term_id;
					if ($term = get_term_by('id', $_categoryid, 'product_cat')) {
						$category_names[] = $term->name;
					}
				}
			}
		}
		echo implode(', ', $category_names)
		?>
	</td>
<?php
};

add_action('woocommerce_admin_order_item_values', 'cm_action_woocommerce_admin_order_item_values', 10, 3);
add_action('woocommerce_admin_order_item_headers', 'cm_action_woocommerce_admin_order_item_headers', 10, 0);


/**
 * Override osf_single_product_quantity_label with 
 */
remove_action('woocommerce_before_add_to_cart_quantity', 'osf_single_product_quantity_label', 10);
add_action('woocommerce_before_add_to_cart_quantity', 'cm_single_product_quantity_label', 10);
function cm_single_product_quantity_label() {
	global $product;
	$min_value = apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product);
	$max_value = apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product);
	if ($max_value && $min_value !== $max_value) {
	echo '<label class="quantity_label">' . __('Cantidad:', 'medilazar') . ' </label>';
	}
}

/**
 * Change add to cart button text on single page
 */
function cm_woocommerce_add_to_cart_button_text_single() {
    return __( 'Añadir a la cesta', 'woocommerce' ); 
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'cm_woocommerce_add_to_cart_button_text_single' ); 

/*
/////////////  Punchout XML Processing   ///////////////////////
*/


/**
 * Registers a custom REST API route for punchout login.
 *
 * Adds a new route to the WordPress REST API under the 'comercialmedica/v1' namespace. The route
 * '/punchout_login' accepts POST requests and uses the 'handle_xml_request' function as
 * its callback to process the request.
 */
add_action('rest_api_init', function () {
    register_rest_route('comercialmedica/v1', '/punchout_login', array(
        'methods' => 'POST',
        'callback' => 'handle_punchout_login_request',
    ));
});


/**
 * Handles XML requests for user login.
 *
 * Processes an XML request containing login information, authenticates the user, and
 * generates a session key if successful. The function returns an XML response with
 * the result of the login attempt, including a login URL with the session key and
 * additional parameters if authentication is successful.
 * 
 * for xml loginResponse  with application/type x-www-url-encoded
 * for xcml  PunchOutSetupRequest  with application/type text/xml
 *
 * @param WP_REST_Request $request The request object containing the XML data.
 * @return WP_REST_Response The XML response with the login result.
 */

 function handle_punchout_login_request(WP_REST_Request $request){

    // Determine the content type of the request
    $content_type = $request->get_content_type();

 
        
    if ($content_type && $content_type['value'] == 'application/x-www-form-urlencoded') {     

        if(empty($request->get_param('loginRequest'))){
            return  xml_error_response('E', ' No XML data provided');
        }
         
        // Handle XML request
        $body_params = $request->get_body_params();
        $xml_data = $request->get_param('loginRequest');
      
        
        libxml_use_internal_errors(true); // Use internal libxml errors
        $xml = simplexml_load_string($xml_data);
        
        // Check if XML is valid
        if (!$xml) {
            $errors = libxml_get_errors(); // Retrieve XML parse errors
            libxml_clear_errors(); // Clear libxml error buffer
            $errorMsg = "Invalid XML format. Errors: " . implode(', ', array_map(function($error) {
                return trim($error->message);
            }, $errors));
            return  xml_error_response('E',  $errorMsg);
        } else {
          // Process XML data
          return handle_xml_request($xml);
        }   
        
    } elseif ($content_type && $content_type['value'] == 'text/xml') {
        // Handle cXML request
        $body = $request->get_body();
  
        // Ensure cXML data is not null or empty before processing
        if (empty($body)) {
          throw new Exception('No XML data provided.');
        }
  
        libxml_use_internal_errors(true); // Use internal libxml errors to capture XML parse errors
        $cxml = simplexml_load_string($body);
        
        // Check if the cXML is well-formed
        if ($cxml === false) {
            $errors = libxml_get_errors(); // Retrieve XML parse errors
            libxml_clear_errors(); // Clear libxml error buffer
            $errorMsg = "Invalid XML format. Errors: " . implode(', ', array_map(function($error) {
                return trim($error->message);
            }, $errors));
            throw new Exception($errorMsg);
        } elseif (!isset($cxml->Request->PunchOutSetupRequest)) {
            throw new Exception('Missing PunchOutSetupRequest element.');
        } else {
            // Process cXML data
            return handle_cxml_request($body);
        }
    }
  }
  


/**
 * Handle request based on XML data 
 *
 *
 */
function handle_xml_request($xml) {
    global $wpdb; // Access the WordPress DB

    $returnCode = 'U';
    $response_message = 'An unexpected error occurred.';
    $loginURL = '';

    try {


        $username = (string)$xml->header->login->username;
        $password = (string)$xml->header->login->password;
        $userEmail = (string)$xml->body->loginInfo->userInfo->userContactInfo->userEmail; 
		$returnURL = (string)$xml->body->loginInfo->returnURL; 

        if (is_null($username) || is_null($password)) {
            $returnCode = 'E';
            $response_message = 'Username or password missing.';
        } elseif (!is_email($userEmail)) {
            $returnCode = 'E';
            $response_message = 'Invalid email address.';
        }elseif (empty($username) || empty($password)) { 
            $returnCode = 'A';
            $response_message = 'Username or password missing.';
        } elseif (!is_email($userEmail)) { // Check if the userEmail is valid
			$returnCode = 'E';
			$response_message = 'Invalid email address.';
        } elseif (empty($returnURL)) {
            $returnCode = 'E';
            $response_message = 'Return URL is missing.';
        } else {

			// Check if the user exists
			if (!username_exists($username)) {
				$returnCode = 'A';
				$response_message = 'User does not exist.';
			} else {
				$user = wp_authenticate($username, $password);

				if (!is_wp_error($user)) {
					wp_set_current_user($user->ID);
					wp_set_auth_cookie($user->ID);
	
					$returnCode = 'S';
	
					// Generate a unique session key
					$session_key = wp_generate_password(20, false);
	
					// Insert the session key and userEmail into the wp_cm_sessions table
					$wpdb->insert(
						$wpdb->prefix . 'cm_sessions', 
						[
							'user_id' => $user->ID,
							'session_key' => $session_key,
							'session_email' => $userEmail, 
							'created_at' => current_time('mysql'),
							'expires_at' => date('Y-m-d H:i:s', time() + 60 * 60 * 24)
						],
						[
							'%d', // user_id
							'%s', // session_key
							'%s', // session_email
							'%s', // created_at
							'%s'  // expires_at
						]
					);
	
					// Construct the login URL with the WordPress site's URL, session key, userEmail, and additional parameters
					$loginURL = add_query_arg(array(
						'sessionKey' => $session_key, 
						'userEmail' => $userEmail
					), home_url());
	
					$response_message = ''; // No message needed for success
				} else {
					$returnCode = 'A';
					$response_message = 'Authentication Failure';
				}
			}
        
        }
    } catch (Exception $e) {
        $response_message = $e->getMessage();
    }

    // Prepare response data
    $response_data = [
        'returnCode' => $returnCode,
        'message' => $response_message,
        'loginURL' => $loginURL,
    ];

    // Generate and return the XML response
    $response_xml = generate_xml_response($response_data);
    return new WP_REST_Response($response_xml, 200, ['Content-Type' => 'application/xml']);
}


/**
 * Generates an XML response from an array of response data.
 *
 * Creates an XML document with a specified structure based on the provided response data.
 * The XML document includes a header with a version attribute and a return element with
 * a returnCode attribute. Depending on the returnCode, the body of the response may include
 * a loginURL element with a CDATA section containing the URL.
 *
 */
function generate_xml_response($response_data) {
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $response = $dom->createElement('response');
    $dom->appendChild($response);

    $header = $dom->createElement('header');
    $header->setAttribute('version', '1.0');
    $response->appendChild($header);

    $return = $dom->createElement('return');
    $return->setAttribute('returnCode', $response_data['returnCode']);
    $header->appendChild($return);

    // Handling success differently
    if ($response_data['returnCode'] === 'S') {
        if (!empty($response_data['loginURL'])) {
            $body = $dom->createElement('body');
            $response->appendChild($body);

            $loginURL = $dom->createElement('loginURL');
            $cdata = $dom->createCDATASection($response_data['loginURL']);
            $loginURL->appendChild($cdata);
            $body->appendChild($loginURL);
        }
    } else {
        // Include returnMessage for non-success codes
        if (!empty($response_data['message'])) {
            $returnMessage = $dom->createElement('returnMessage');
            $cdata = $dom->createCDATASection($response_data['message']);
            $returnMessage->appendChild($cdata);
            $return->appendChild($returnMessage);
        }

        // Ensure an empty loginURL is added to the body for non-success responses
        $body = $dom->createElement('body');
        $response->appendChild($body);
        $loginURL = $dom->createElement('loginURL');
        $body->appendChild($loginURL);
    }

    return $dom->saveXML();
}

/**
 * Handle request based on cXML data 
 *
 *
 */
function handle_cxml_request($cxml_body) {
    global $wpdb; // Access the WordPress DB

    // Initialize response parameters
    $returnCode = 'Failure';
    $response_message = 'An unexpected error occurred.';
    $loginURL = '';

    try {
    
        // Load the cXML string as an object
        $cxml = new SimpleXMLElement($cxml_body);

        // Extract necessary information from the cXML
        $username = (string)$cxml->Header->Sender->Credential->Identity;
        $password = (string)$cxml->Header->Sender->Credential->SharedSecret;
        $userEmail = (string)$cxml->Request->PunchOutSetupRequest->Contact->Email;
        $returnURL = (string)$cxml->Request->PunchOutSetupRequest->BrowserFormPost->URL;
        $payloadID = (string)$cxml['payloadID'];

        if (empty($returnURL)) {
            $returnCode = '400';
            $response_message = 'Return URL is missing.';
        } else{
                /// Check if the user exists
                if(trim($username) === ''){
                    $returnCode = '400';
                    $response_message = 'username is empty.';
                }else if (!username_exists($username)) {
                    $returnCode = '400';
                    $response_message = 'User does not exist.';
                    } else {
                        $user = wp_authenticate($username, $password);

                            if (!is_wp_error($user)) {
                                wp_set_current_user($user->ID);
                                wp_set_auth_cookie($user->ID);

                                $returnCode = 'S';

                                // Generate a unique session key
                                $session_key = wp_generate_password(20, false);

                                // Insert the session key and userEmail into the wp_cm_sessions table
                                $wpdb->insert(
                                    $wpdb->prefix . 'cm_sessions', 
                                    [
                                        'user_id' => $user->ID,
                                        'session_key' => $session_key,
                                        'session_email' => $userEmail, 
                                        'created_at' => current_time('mysql'),
                                        'expires_at' => date('Y-m-d H:i:s', time() + 60 * 60 * 24)
                                    ],
                                    [
                                        '%d', // user_id
                                        '%s', // session_key
                                        '%s', // session_email
                                        '%s', // created_at
                                        '%s'  // expires_at
                                    ]
                                );

                                // Construct the login URL with the WordPress site's URL, session key, userEmail, and if there are other additional parameters
                                $loginURL = add_query_arg(array(
                                    'sessionKey' => $session_key, 
                                    'userEmail' => $userEmail
                                ), home_url());

                                $response_message = ''; // No message needed for success
                            } else {
                                $returnCode = '401';
                                $response_message = 'Authentication Failure';
                            }
                        }

        }
        
    } catch (Exception $e) {
        $response_message = $e->getMessage();
    }

    // Assuming you have a function to generate cXML responses
    $response_cxml = generate_cxml_response($returnCode, $response_message, html_entity_decode($loginURL),$payloadID);
    return new WP_REST_Response($response_cxml, $returnCode, ['Content-Type' => 'text/xml']);
}

/**
 * Generates an cXML response from an array of response data.
 *
 * Creates an cXML document with a specified structure based on the provided response data.
 *
 */
function generate_cxml_response($returnCode, $response_message, $loginURL, $payloadIDFromRequest) {
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $dom->preserveWhiteSpace = false; // Minimize the output format
    $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE cXML SYSTEM "http://xml.cxml.org/schemas/cXML/1.1.010/cXML.dtd">');

    // Create the root cXML element
    $cxml = $dom->createElement('cXML');
    $dom->appendChild($cxml);
    $cxml->setAttribute('version', '1.1.007');
    $cxml->setAttribute('xml:lang', 'en-US');
    $cxml->setAttribute('payloadID', $payloadIDFromRequest);
    $cxml->setAttribute('timestamp', date('c'));

    // Create and append the Response element
    $response = $dom->createElement('Response');
    $cxml->appendChild($response);

    // Set the Status element based on the returnCode
    $status = $dom->createElement('Status');
    $response->appendChild($status);
    $status->setAttribute('code', $returnCode === 'S' ? '200' : $returnCode);
    $status->setAttribute('text', $returnCode === 'S' ? 'OK' : $response_message);

    if ($returnCode === 'S') {
        // Include PunchOutSetupResponse for successful connections
        $punchOutSetupResponse = $dom->createElement('PunchOutSetupResponse');
        $response->appendChild($punchOutSetupResponse);

        $startPage = $dom->createElement('StartPage');
        $punchOutSetupResponse->appendChild($startPage);

        // Insert the login URL
        $urlElement = $dom->createElement('URL');
        $startPage->appendChild($urlElement);
        $cdata = $dom->createCDATASection($loginURL);
        $urlElement->appendChild($cdata);
    } else {
        // Optionally handle unsuccessful connection response modifications here
        // Include a detailed message if the connection is unsuccessful
        $messageElement = $dom->createElement('Message');
        $response->appendChild($messageElement);
        $cdataMessage = $dom->createCDATASection($response_message);
        $messageElement->appendChild($cdataMessage);
    }

    // Return the XML string
    return $dom->saveXML();
}

function cxml_failure_response($returnCode, $response_message, $loginURL, $payloadIDFromRequest){
    $response_cxml = generate_cxml_response($returnCode, $response_message, html_entity_decode($loginURL),$payloadID);
    return new WP_REST_Response($response_cxml, $returnCode, ['Content-Type' => 'text/xml']);
}

function xml_error_response($returnCode, $response_message){
    $response_data = [
        'returnCode' => $returnCode,
        'message' => $response_message,
        'loginURL' => '',
    ];


    $response_xml = generate_xml_response($response_data);
    return new WP_REST_Response($response_xml, 200, ['Content-Type' => 'application/xml']);
}

/**
 * Logs in a user based on session key and email passed via URL parameters.
 *
 * Checks for 'sessionKey' and 'userEmail' GET parameters, validates them, and logs in the
 * corresponding user if the session is valid. If the session is invalid, the user is logged out.
 * After the login or logout action, the user is redirected to the home page.
 */
function cm_login_user_with_url_session_key() {
    if (!isset($_GET['sessionKey']) && !isset($_GET['userEmail'])) {
        return;
    }

	$session_key = sanitize_text_field($_GET['sessionKey']);
	$session_email = sanitize_email($_GET['userEmail']);

    $user_id = validate_session_key($session_key, $session_email);

    if ($user_id) {
        // The session key is valid, and we have a user ID, so log the user in
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);

        // Redirect to the homepage on Login Success
        wp_redirect(home_url());
        exit;
    } else {
		wp_logout();
		// Redirect to the WordPress main URL
		wp_redirect(home_url());
		exit;
    }
}

add_action('init', 'cm_login_user_with_url_session_key');

/**
 * Adds custom error messages to the login page.
 *
 * Appends custom error messages to the default login message based on the 'login_error' GET parameter.
 * 
 * Currently handles 'invalid_session'
 * @return string The modified login message with custom error messages appended.
 */
function cm_login_error_message($message) {
    if (isset($_GET['login_error'])) {
        $error_code = sanitize_text_field($_GET['login_error']);
        if ('invalid_session' === $error_code) {
            $message .= '<div class="error"><p>Invalid session key. Please try again.</p></div>';
        } 
    }
    return $message;
}
add_filter('login_message', 'cm_login_error_message');


/**
* CM Session Table Creation Define Versioning 
**/
define('CM_SESSION_TABLE_VERSION', '1.0');
define('CM_SESSION_TABLE_VERSION_OPTION', 'cm_session_table_version');


/**
 * Creates the cm_sessions table in the database if it doesn't exist or updates it if the version has changed.
 *
 * This function checks if the cm_sessions table exists in the database. If it does not, or if the
 * version of the table has changed, it creates or updates the table accordingly. The table is used to
 * store session information for users, including the session ID, user ID, session key, session email,
 * creation time, and expiration time. The user ID is a foreign key that references the ID in the users table.
 *
 */
function create_cm_session_table() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'cm_sessions';
    
    // Check if the table already exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") == $table_name;

    // Retrieve the currently installed version of the table, if any
    $installed_ver = get_option(CM_SESSION_TABLE_VERSION_OPTION);

    // Proceed if the table does not exist or if the version has changed
    if (!$table_exists || $installed_ver != CM_SESSION_TABLE_VERSION) {
        $sql = "CREATE TABLE $table_name (
          session_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          user_id BIGINT UNSIGNED NOT NULL,
          session_key VARCHAR(255) NOT NULL,
          session_email VARCHAR(255) NOT NULL,
          created_at DATETIME NOT NULL,
          expires_at DATETIME NOT NULL,
          FOREIGN KEY (user_id) REFERENCES {$wpdb->prefix}users(ID) ON DELETE CASCADE
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Update the version in the database
        update_option(CM_SESSION_TABLE_VERSION_OPTION, CM_SESSION_TABLE_VERSION);
    }
}

add_action('after_setup_theme', 'create_cm_session_table');

/**
 * Validates a session key and email combination.
 *
 * Checks if the given session key and email correspond to a valid session in the database
 * that has not yet expired. If the session is valid, it returns the user ID associated with
 * the session. Otherwise, it returns false.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param string $session_key   The session key to validate.
 * @param string $session_email The email associated with the session key.
 * @return int|false The user ID associated with the session if valid, otherwise false.
 */

function validate_session_key($session_key, $session_email) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cm_sessions';
    $current_time = current_time('mysql');

    $session = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE session_key = %s AND session_email = %s AND expires_at > %s",
        $session_key,
        $session_email,
        $current_time
    ));

    if (null !== $session) {
        // Session is valid
        return $session->user_id;
    }

    // Invalid session
    return false;
}
