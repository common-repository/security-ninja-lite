<?php
/*
 * Security Ninja Lite
 * (c) Web factory Ltd
 */

class snl_tests extends snl {
   static $security_tests = array('ver_check' => array('title' => 'Check if WordPress core is up to date.',
                                                         'msg_ok' => 'You are using the latest version of WordPress.',
                                                         'msg_bad' => 'You are not using the latest version of WordPress.'),
                                  'plugins_ver_check' => array('title' => 'Check if plugins are up to date.',
                                                               'msg_ok' => 'All plugins are up to date.',
                                                               'msg_bad' => 'Some plugins (%s) are outdated.'),
                                  'themes_ver_check' => array('title' => 'Check if themes are up to date.',
                                                              'msg_ok' => 'All themes are up to date.',
                                                              'msg_bad' => 'Some themes (%s) are outdated.'),
                                  'wp_header_meta' => array('title' => 'Check if full WordPress version info is revealed in page\'s meta data.',
                                                             'msg_ok' => 'Your site doesn\'t reveal full WordPress version info.',
                                                              'msg_warning' => 'Site homepage could not be fetched.',
                                                              'msg_bad' => 'Your site reveals full WordPress version info in meta tags.'),
                                  'readme_check' => array('title' => 'Check if <i>readme.html</i> file is accessible via HTTP on the default location.',
                                                           'msg_ok' => '<i>readme.html</i> is not accessible at the default location.',
                                                           'msg_warning' => 'Unable to determine status of <i>readme.html</i>.',
                                                           'msg_bad' => '<i>readme.html</i> is accessible via HTTP on the default location.'),
                                  'php_headers' => array('title' => 'Check if server response headers contain detailed PHP version info.',
                                                              'msg_ok' => 'Headers don\'t contain detailed PHP version info.',
                                                              'msg_bad' => 'Server response headers contain detailed PHP version info.'),
                                  'expose_php_check' => array('title' => 'Check if <i>expose_php</i> PHP directive is turned off.',
                                                                'msg_ok' => '<i>expose_php</i> PHP directive is turned off.',
                                                                'msg_bad' => '<i>expose_php</i> PHP directive is turned on.'),
                                  'user_exists' => array('title' => 'Check if user with username "admin" exists.',
                                                         'msg_ok' => 'User "admin" doesn\'t exist.',
                                                         'msg_bad' => 'User "admin" exists.'),
                                  'anyone_can_register' => array('title' => 'Check if "anyone can register" option is enabled.',
                                                                 'msg_ok' => '"Anyone can register" option is disabled.',
                                                                 'msg_bad' => '"Anyone can register" option is enabled.'),
                                  '_bruteforce_login' => array('title' => 'Check user\'s password strength with a brute-force attack.',
                                                               'msg_ok' => 'No users have one of the 600 most commonly used passwords.',
                                                               'msg_bad' => 'Following users have extremely weak passwords: %s.',
                                                               'msg_warning' => 'Test is disabled.'),
                                  'check_failed_login_info' => array('title' => 'Check for display of unnecessary information on failed login attempts.',
                                                                     'msg_ok' => 'No unnecessary info is shown on failed login attempts.',
                                                                     'msg_bad' => 'Unnecessary information is displayed on failed login attempts.'),
                                  'db_table_prefix_check' => array('title' => 'Check if database table prefix is the default one (<i>wp_</i>).',
                                                                   'msg_ok' => 'Database table prefix is not default.',
                                                                   'msg_bad' => 'Database table prefix is default.'),
                                  'salt_keys_check' => array('title' => 'Check if security keys and salts have proper values.',
                                                              'msg_ok' => 'All keys have proper values set.',
                                                              'msg_bad' => 'Following keys don\'t have proper values set: %s.'),
                                  'db_password_check' => array('title' => 'Test the strength of WordPress database password.',
                                                              'msg_ok' => 'Database password is strong enough.',
                                                              'msg_bad' => 'Database password is weak (%s).'),
                                  'debug_check' => array('title' => 'Check if general debug mode is enabled.',
                                                         'msg_ok' => 'General debug mode is disabled.',
                                                         'msg_bad' => 'General debug mode is enabled.'),
                                  'db_debug_check' => array('title' => 'Check if database debug mode is enabled.',
                                                            'msg_ok' => 'Database debug mode is disabled.',
                                                            'msg_bad' => 'Database debug mode is enabled.'),
                                  'script_debug_check' => array('title' => 'Check if JavaScript debug mode is enabled.',
                                                                 'msg_ok' => 'JavaScript debug mode is disabled.',
                                                                 'msg_bad' => 'JavaScript debug mode is enabled.'),
                                  'display_errors_check' => array('title' => 'Check if <i>display_errors</i> PHP directive is turned off.',
                                                                'msg_ok' => '<i>display_errors</i> PHP directive is turned off.',
                                                                'msg_bad' => '<i>display_errors</i> PHP directive is turned on.'),

                                  '_blog_site_url_check' => array('title' => 'Check if WordPress installation address is the same as the site address.',
                                                                 'msg_ok' => 'WordPress installation address is different from the site address.',
                                                                 'msg_bad' => 'WordPress installation address is the same as the site address.'),

                                  'config_chmod' => array('title' => 'Check if <i>wp-config.php</i> file has the right permissions (chmod) set.',
                                                           'msg_ok' => 'WordPress config file has the right chmod set.',
                                                           'msg_warning' => 'Unable to read chmod of <i>wp-config.php</i>.',
                                                           'msg_bad' => 'Current <i>wp-config.php</i> chmod (%s) is not ideal and other users on the server can access the file.'),
                                  'install_file_check' => array('title' => 'Check if <i>install.php</i> file is accessible via HTTP on the default location.',
                                                                'msg_ok' => '<i>install.php</i> is not accessible on the default location.',
                                                                'msg_warning' => 'Unable to determine status of <i>install.php</i> file.',
                                                                'msg_bad' => '<i>install.php</i> is accessible via HTTP on the default location.'),
                                 'upgrade_file_check' => array('title' => 'Check if <i>upgrade.php</i> file is accessible via HTTP on the default location.',
                                                                'msg_ok' => '<i>upgrade.php</i> is not accessible on the default location.',
                                                                'msg_warning' => 'Unable to determine status of <i>upgrade.php</i> file.',
                                                                'msg_bad' => '<i>upgrade.php</i> is accessible via HTTP on the default location.'),
                               'register_globals_check' => array('title' => 'Check if <i>register_globals</i> PHP directive is turned off.',
                                                                'msg_ok' => '<i>register_globals</i> PHP directive is turned off.',
                                                                'msg_bad' => '<i>register_globals</i> PHP directive is turned on.'),
                               '_safe_mode_check' => array('title' => 'Check if PHP safe mode is disabled.',
                                                          'msg_ok' => 'Safe mode is disabled.',
                                                          'msg_bad' => 'Safe mode is enabled.'),
                               '_allow_url_include_check' => array('title' => 'Check if <i>allow_url_include</i> PHP directive is turned off.',
                                                                'msg_ok' => '<i>allow_url_include</i> PHP directive is turned off.',
                                                                'msg_bad' => '<i>allow_url_include</i> PHP directive is turned on.'),
                               'file_editor' => array('title' => 'Check if plugins/themes file editor is enabled.',
                                                                'msg_ok' => 'File editor is disabled.',
                                                                'msg_bad' => 'File editor is enabled.'),
                               'uploads_browsable' => array('title' => 'Check if <i>uploads</i> folder is browsable by browsers.',
                                                            'msg_ok' => 'Uploads folder is not browsable.',
                                                            'msg_warning' => 'Unable to determine status of uploads folder.',
                                                            'msg_bad' => '<a href="%s" target="_blank">Uploads folder</a> is browsable.'),
                               'id1_user_check' => array('title' => 'Test if user with ID "1" exists.',
                                                         'msg_ok' => 'Such user does not exist.',
                                                         'msg_bad' => 'User with ID "1" exists.'),
                               '_wlw_meta' => array('title' => 'Check if Windows Live Writer link is present in pages\' header data.',
                                                         'msg_ok' => 'WLW link is not present in the header.',
                                                         'msg_warning' => 'Unable to perform test.',
                                                         'msg_bad' => 'WLW link is present in the header.'),
                               '_config_location' => array('title' => 'Check if <i>wp-config.php</i> is present on the default location.',
                                                         'msg_ok' => '<i>wp-config.php</i> is not present on the default location.',
                                                         'msg_bad' => '<i>wp-config.php</i> is present on the default location.'),
                               '_mysql_external' => array('title' => 'Check if MySQL server is connectable from outside with the WP user.',
                                                         'msg_ok' => 'No, you can only connect to the MySQL from localhost.',
                                                         'msg_warning' => 'Test results are not conclusive for MySQL user %s.',
                                                         'msg_bad' => 'You can connect to the MySQL server from any host.')); // $security_tests


   // check if register_globals is off
   static function register_globals_check() {
    $return = array();

    $check = (bool) ini_get('register_globals');
    if ($check) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
   } // register_globals_check


   // check if display_errors is off
   static function display_errors_check() {
    $return = array();

    $check = (bool) ini_get('display_errors');
    if ($check) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
   } // display_errors_check


   // is theme/plugin editor disabled?
   static function file_editor() {
    $return = array();

    if (defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT) {
      $return['status'] = 10;
    } else {
      $return['status'] = 0;
    }

    return $return;
   } // file_editor


   // check if anyone can register on the site
   static function anyone_can_register() {
     $return = array();
     $test = get_option('users_can_register');

     if ($test) {
       $return['status'] = 0;
     } else {
       $return['status'] = 10;
     }

     return $return;
   } // anyone_can_register


  // check WP version
  static function ver_check() {
    $return = array();

    if (!function_exists('get_preferred_from_update_core') ) {
      require_once(ABSPATH . 'wp-admin/includes/update.php');
    }

    // get version
    wp_version_check();
    $latest_core_update = get_preferred_from_update_core();

    if (isset($latest_core_update->response) && ($latest_core_update->response == 'upgrade') ){
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // ver_check


  // check if certain username exists
  static function user_exists($username = 'admin') {
    $return = array();

    if (username_exists($username) ) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // user_exists


  // check database password
  static function db_password_check() {
    $return = array();
    $password = DB_PASSWORD;

    if (empty($password)) {
      $return['status'] = 0;
      $return['msg'] = 'password is empty';
    } elseif (self::dictionary_attack($password)) {
      $return['status'] = 0;
      $return['msg'] = 'password is a simple word from the dictionary';
    } elseif (strlen($password) < 6) {
      $return['status'] = 0;
      $return['msg'] = 'password length is only ' . strlen($password) . ' chars';
    } elseif (sizeof(count_chars($password, 1)) < 5) {
      $return['status'] = 0;
      $return['msg'] = 'password is too simple';
    } else {
      $return['status'] = 10;
      $return['msg'] = 'password is ok';
    }

    return $return;
  } // db_password_check


  // check if user with DB ID 1 exists
  static function id1_user_check() {
    $return = array();

    $check = get_userdata(1);
    if ($check) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // id1_user_check


  // check if plugins are up to date
  static function plugins_ver_check() {
    $return = array();

    //Get the current update info
    $current = get_site_transient('update_plugins');

    if (!is_object($current)) {
      $current = new stdClass;
    }

    set_site_transient('update_plugins', $current);

    // run the internal plugin update check
    wp_update_plugins();

    $current = get_site_transient('update_plugins');

    if (isset($current->response) && is_array($current->response) ) {
      $plugin_update_cnt = count($current->response);
    } else {
      $plugin_update_cnt = 0;
    }

    if($plugin_update_cnt > 0){
      $return['status'] = 0;
      $return['msg'] = sizeof($current->response);
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // plugins_vec_check


  // check themes versions
  static function themes_ver_check() {
    $return = array();

    $current = get_site_transient('update_themes');

    if (!is_object($current)){
      $current = new stdClass;
    }

    set_site_transient('update_themes', $current);
    wp_update_themes();

    $current = get_site_transient('update_themes');

    if (isset($current->response) && is_array($current->response)) {
      $theme_update_cnt = count($current->response);
    } else {
      $theme_update_cnt = 0;
    }

    if($theme_update_cnt > 0){
      $return['status'] = 0;
      $return['msg'] = sizeof($current->response);
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // themes_ver_check


  // check DB table prefix
  static function db_table_prefix_check() {
    global $wpdb;
    $return = array();

    if ($wpdb->prefix == 'wp_' || $wpdb->prefix == 'wordpress_' || $wpdb->prefix == 'wp3_') {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // db_table_prefix_check


  // check if global WP debugging is enabled
  static function debug_check() {
    $return = array();

    if (defined('WP_DEBUG') && WP_DEBUG) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // debug_check


  // does readme.html exist?
  static function readme_check() {
    $return = array();
    $url = get_bloginfo('wpurl') . '/readme.html?rnd=' . rand();
    $response = wp_remote_get($url);

    if(is_wp_error($response)) {
      $return['status'] = 5;
    } elseif ($response['response']['code'] == 200) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // readme_check


  // does WP install.php file exist?
  static function install_file_check() {
    $return = array();
    $url = get_bloginfo('wpurl') . '/wp-admin/install.php?rnd=' . rand();
    $response = wp_remote_get($url);

    if(is_wp_error($response)) {
      $return['status'] = 5;
    } elseif ($response['response']['code'] == 200) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // install_file_check


  // does WP install.php file exist?
  static function upgrade_file_check() {
    $return = array();
    $url = get_bloginfo('wpurl') . '/wp-admin/upgrade.php?rnd=' . rand();
    $response = wp_remote_get($url);

    if(is_wp_error($response)) {
      $return['status'] = 5;
    } elseif ($response['response']['code'] == 200) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // upgrade_file_check


  // check if wp-config.php has the right chmod
  static function config_chmod() {
    $return = array();

    if (file_exists(ABSPATH . '/wp-config.php')) {
      $mode = substr(sprintf('%o', @fileperms(ABSPATH . '/wp-config.php')), -4);
    } else {
      $mode = substr(sprintf('%o', @fileperms(ABSPATH . '/../wp-config.php')), -4);
    }

    if (!$mode) {
      $return['status'] = 5;
    } elseif (substr($mode, -1) != 0) {
      $return['status'] = 0;
      $return['msg'] = $mode;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // config_chmod


  // check for unnecessary information on failed login
  static function check_failed_login_info() {
    $return = array();

    $params = array('log' => 'sn-test_3453344355',
                    'pwd' => 'sn-test_2344323335');

    if (!class_exists('WP_Http')) {
      require( ABSPATH . WPINC . '/class-http.php' );
    }

    $http = new WP_Http();
    $response = (array) $http->request(get_bloginfo('wpurl') . '/wp-login.php', array('method' => 'POST', 'body' => $params));

    if (stripos($response['body'], 'invalid username') !== false){
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // check_failed_login_info

  static function try_login($username, $password) {
    $user = apply_filters('authenticate', null, $username, $password);

    if (isset($user->ID) && !empty($user->ID)) {
      return true;
    } else {
      return false;
    }
  } // try_login


  // check for WP version in meta tags
  static function wp_header_meta() {
    $return = array();

    if (!class_exists('WP_Http')) {
      require( ABSPATH . WPINC . '/class-http.php' );
    }

    $http = new WP_Http();
    $response = (array) $http->request(get_bloginfo('wpurl'));
    $html = $response['body'];

    if ($html) {
      $return['status'] = 10;
      // extract content in <head> tags
      $start = strpos($html, '<head');
      $len = strpos($html, 'head>', $start + strlen('<head'));
      $html = substr($html, $start, $len - $start + strlen('head>'));
      // find all Meta Tags
      preg_match_all('#<meta([^>]*)>#si', $html, $matches);
      $meta_tags = $matches[0];

      foreach ($meta_tags as $meta_tag) {
        if (stripos($meta_tag, 'generator') !== false &&
            stripos($meta_tag, get_bloginfo('version')) !== false) {
          $return['status'] = 0;
          break;
        }
      }
    } else {
      // error
      $return['status'] = 5;
    }

    return $return;
  } // wp_header_meta


  // brute force attack on password
  static function dictionary_attack($password) {
    $dictionary = file(WF_SN_DIC, FILE_IGNORE_NEW_LINES);

    if (in_array($password, $dictionary)) {
      return true;
    } else {
      return false;
    }
  } // dictionary_attack


  // unique config keys check
  static function salt_keys_check() {
    $return = array();
    $ok = true;
    $keys = array('AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY',
                  'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT');

    foreach ($keys as $key) {
      $constant = @constant($key);
      if (empty($constant) || trim($constant) == 'put your unique phrase here' || strlen($constant) < 50) {
        $bad_keys[] = $key;
        $ok = false;
      }
    } // foreach

    if ($ok == true) {
      $return['status'] = 10;
    } else {
      $return['status'] = 0;
      $return['msg'] = implode(', ', $bad_keys);
    }

    return $return;
  } // salt_keys_check


  static function uploads_browsable() {
    $return = array();
    $upload_dir = wp_upload_dir();

    $args = array('method' => 'GET', 'timeout' => 5, 'redirection' => 0,
                  'httpversion' => 1.0, 'blocking' => true, 'headers' => array(), 'body' => null, 'cookies' => array());
    $response = wp_remote_get(rtrim($upload_dir['baseurl'], '/') . '/?nocache=' . rand(), $args);

    if (is_wp_error($response)) {
      $return['status'] = 5;
      $return['msg'] = $upload_dir['baseurl'] . '/';
    } elseif ($response['response']['code'] == '200' && stripos($response['body'], 'index') !== false) {
      $return['status'] = 0;
      $return['msg'] = $upload_dir['baseurl'] . '/';
    } else {
      $return['status'] = 10;
    }

    return $return;
  }

  // check if php headers contain php version
  static function php_headers() {
    $return = array();

    if (!class_exists('WP_Http')) {
      require( ABSPATH . WPINC . '/class-http.php' );
    }

    $http = new WP_Http();
    $response = (array) $http->request(home_url());

    if((isset($response['headers']['server']) && stripos($response['headers']['server'], phpversion()) !== false) || (isset($response['headers']['x-powered-by']) && stripos($response['headers']['x-powered-by'], phpversion()) !== false)) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
      $return['msg'] = self::$security_tests[__FUNCTION__]['msg_ok'];
    }

    return $return;
  } // php_headers

  // check if expose_php is off
   static function expose_php_check() {
    $return = array();

    $check = (bool) ini_get('expose_php');
    if ($check) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
   } // expose_php_check

  // check if DB debugging is enabled
  static function db_debug_check() {
    global $wpdb;
    $return = array();

    if ($wpdb->show_errors == true) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // db_debug_check

  // check if global WP JS debugging is enabled
  static function script_debug_check() {
    $return = array();

    if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) {
      $return['status'] = 0;
    } else {
      $return['status'] = 10;
    }

    return $return;
  } // script_debug_check
} // class wf_sn_tests