<?php
/*
Plugin Name: Security Ninja Lite
Plugin URI: http://security-ninja.webfactoryltd.com/
Description: Check your site for <strong>security vulnerabilities</strong> and get info on passwords, user accounts, file permissions, database security, version hiding, plugins, themes and other security aspects. This is the lite version; you can <a target="_blank" href="http://security-ninja.webfactoryltd.com/upgrade/">upgrade</a> it.
Author: Web factory Ltd
Author URI: http://www.webfactoryltd.com/
Version: 1.30
*/


if (!function_exists('add_action')) {
  die('Please don\'t open this file directly!');
}


// constants
define('SNL_VER', '1.30');
define('SNL_OPTIONS_KEY', 'snl_results');


class snl {
  // init plugin
  static function init() {
    // does the user have enough privilages to use the plugin?
    if (is_admin() && current_user_can('administrator')) {
      // this plugin requires WP v3.3
      if (!version_compare(get_bloginfo('version'), '3.3',  '>=')) {
        add_action('admin_notices', array(__CLASS__, 'min_version_error'));
      } else {
        // add menu item to tools
        add_action('admin_menu', array(__CLASS__, 'admin_menu'));

        // aditional links in plugin description
        add_filter('plugin_action_links_' . basename(dirname(__FILE__)) . '/' . basename(__FILE__),
                   array(__CLASS__, 'plugin_action_links'));
        add_filter('plugin_row_meta', array(__CLASS__, 'plugin_meta_links'), 10, 2);

        // enqueue scripts
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));

        // register ajax endpoints
        add_action('wp_ajax_snl_run_tests', array(__CLASS__, 'run_tests'));
        add_action('wp_ajax_snl_hide_upgrade_tab', array(__CLASS__, 'hide_upgrade_tab'));

        // warn if tests were not run
        add_action('admin_footer', array(__CLASS__, 'install_sn'));

        // warn if Wordfence is active
        //add_action('admin_notices', array(__CLASS__, 'wordfence_warning'));
      } // ver ok
    } // if
  } // init


  // add links to plugin's description in plugins table
  static function plugin_meta_links($links, $file) {
    $support_link = '<a target="_blank" href="http://wordpress.org/support/plugin/security-ninja-lite" title="Visit support forum">Support</a>';
    $pro_link = '<a target="_blank" href="http://security-ninja.webfactoryltd.com/upgrade/" title="Upgrade Security Ninja">Upgrade to full version</a>';

    if ($file == plugin_basename(__FILE__)) {
      $links[] = $support_link;
      $links[] = $pro_link;
    }

    return $links;
  } // plugin_meta_links


  // add settings link to plugins page
  static function plugin_action_links($links) {
    $settings_link = '<a href="' . admin_url('tools.php?page=snl') . '" title="Security Ninja Lite">Analyze site</a>';
    array_unshift($links, $settings_link);

    return $links;
  } // plugin_action_links


  // test if plugin's page is visible
  static function is_plugin_page() {
    $current_screen = get_current_screen();

    if ($current_screen->id == 'tools_page_snl') {
      return true;
    } else {
      return false;
    }
  } // is_plugin_page


  // hide the upgrade ad tab
  static function hide_upgrade_tab() {
    $tmp = (int) set_transient('snl_hide_upgrade_tab', true, 60*60*24*1000);

    die("$tmp");
  } // hide_upgrade_tab


  // enqueue CSS and JS scripts on plugin's pages
  static function enqueue_scripts() {
    if (self::is_plugin_page()) {
      wp_enqueue_script('jquery-ui-tabs');
      wp_enqueue_script('snl-jquery-plugins', plugins_url('js/snl-jquery-plugins.js', __FILE__), array('jquery'), SNL_VER, true);
      wp_enqueue_script('snl-backend', plugins_url('js/snl-backend.js', __FILE__), array('jquery'), SNL_VER, true);
      wp_enqueue_style('snl-backend', plugins_url('css/snl-backend.css', __FILE__), array(), SNL_VER);
    } // if
  } // enqueue_scripts


  // add entry to admin menu
  static function admin_menu() {
    add_management_page('Security Ninja Lite', 'Security Ninja Lite', 'administrator', 'snl', array(__CLASS__, 'show_gui'));
  } // admin_menu


  // display warning if test were never run
  static function install_sn() {
      //echo '<div id="message" class="error"><p style="padding: 15px;"><strong style="font-weight: bold;">Full version of Security Ninja with 40+ test is available for free on wordpress.org <a href="' . admin_url('plugin-install.php?s=%22security+ninja%22&tab=search&type=term') . '">install it NOW</a>.</strong> Security Ninja Lite is no longer maintained and should be removed from your site.</p></div>';
      
      $current_screen = get_current_screen();
      //var_dump($current_screen); die();
      if ($current_screen->base == 'plugin-install' || $current_screen->base == 'plugins') {
        return;
      }
      
      echo '<style> #sn-lite-warning {    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 99999;
    top: 0;
    bottom: 0;
    background-color: #eeeeee;
    opacity: 0.95;
    text-align: center;
    }
    #sn-lite-content {
    max-width: 650px;
    margin: 200px auto;
    }
    #sn-lite-content h1 {
    font-weight: bolder;
    font-size: 3em;
    }
    #sn-lite-content p {
    font-size: 1.5em;
    }
    </style>';
      
      //echo '<script> jQuery();</script> ';
      
      echo '<div id="sn-lite-warning"><div id="sn-lite-content"><h1>Important! Please do not ignore!<br><br></h1><p><b>Security Ninja Lite</b> plugin that you are using is no longer being actively developed and supported. It needs to be removed from your site. Please install <a href="' . admin_url('plugin-install.php?s=%22security+ninja%22&tab=search&type=term') . '">Security Ninja</a> and then remove the lite version. The new plugin is 100% free, has over 40 security tests &amp; will help you protect your site.</a></p></div></div>';
  } // install_sn


  // display warning if Wordfence plugin is active
  static function wordfence_warning() {
    if (defined('WORDFENCE_VERSION') && WORDFENCE_VERSION) {
      echo '<div id="message" class="error"><p>Please <strong>deactivate Wordfence plugin</strong> before running Security Ninja Lite tests. Some tests are detected as site attacks by Wordfence and hence can\'t be performed properly. Activate Wordfence once you\'re done testing.</p></div>';
    }
  } // wordfence_warning


  // display warning if test were never run
  static function min_version_error() {
    echo '<div id="message" class="error"><p>Security Ninja Lite <strong>requires WordPress version 3.1</strong> or higher to function properly. You\'re using WordPress version ' . get_bloginfo('version') . '. Please <a href="' . admin_url('update-core.php') . '" title="Update WP core">update</a>.</p></div>';
  } // min_version_error


  // advertisment for pro version
  static function upgrade_page() {
    echo '<p><strong>Security Ninja</strong> helps thousands of webmasters each day to keep their WordPress sites safe. By providing more than 30 complex security tests it combines years of industry\'s best practices in one, easy to use plugin.<br>Full version of Security Ninja provides the following functionality;</p>';
    echo '<ul class="snl-list">
<li><strong>36+ security tests</strong> performed with one click</li>
<li>specialized, professional tests like <strong>brute-force</strong> password attacks</li>
<li><strong>detailed description</strong> for each test</li>
<li><strong>instructions on how to fix</strong> each problem with copy/paste <strong>code snippets</strong></li>
<li><strong>dedicated support</strong></li>
<li>continuous plugin <strong>upgrades</strong></li>
<li>add-ons: <strong>Core Scanner</strong>, <b>Scheduled Scanner</b> and <b>Events Logger</b> are available to further strengthen your WP site</li>
</ul>';

    echo '<p><br /><br /><a target="_blank" href="http://security-ninja.webfactoryltd.com/upgrade/" class="button-primary">Upgrade Security Ninja for only $11</a>&nbsp; or &nbsp;<a target="_blank" href="http://security-ninja.webfactoryltd.com/test/" class="button-primary">Test the full version and see what you\'ll get</a>&nbsp; or &nbsp;<a target="_blank" href="http://security-ninja.webfactoryltd.com/" class="button-secondary">Visits plugin\'s website</a>
  <br /><br /><a id="snl_hide_upgrade" href="#" title="Hide this tab"><i>No thank you, I\'m not interested (hide this tab)</i></a></p>';
  } // upgrade_page


  // whole plugin page
  static function show_gui() {
    // does the user have enough privilages to access this page?
    if (!current_user_can('administrator'))  {
      echo 'You do not have sufficient permissions to access this page.';
      return;
    }


    echo '<div class="wrap">' . get_screen_icon('snl-lock');
    echo '<h2>Security Ninja Lite Site Analysis</h2>';

    //echo '<p>Upgrade</p>';
    
    
    
    echo '<div id="tabs">';
    
       
    echo '<div style="max-width: 600px; font-size: 14px; border: 1px solid #e2e2e2; padding: 15px; margin: 0;">';
    echo '<h2 style="font-weight: bold;">Security Ninja full version is now available for free!</h2>';
    echo '<p>After five years of development as a paid plugin, we decided to make Security Ninja free and available for everyone to use.
    With over 40 tests it will analyze your site in every detail and provide the best advice on how to make it as secure as possible.<br><br><a style="font-weight: bold;" href="' . admin_url('plugin-install.php?s=
    %22security+ninja%22&tab=search&type=term') . '">Install the full version of Security Ninja NOW</a> and remove the Lite version after that.</p>';
    echo '</div>';
    
    
    echo '</div>'; // tabs
    echo '</div>'; // wrap
  } // options_page


  // display tests table
  static function tests_table() {
    require_once 'snl-tests.php';
    // get test results from cache
    $tests = get_option(SNL_OPTIONS_KEY);

    echo '<p class="submit"><input type="submit" value=" Run tests " id="run-tests" class="button-primary" name="Submit" />&nbsp;&nbsp;';

    if ($tests['last_run']) {
      echo '<span class="snl-notice">Tests were last run on: ' . date(get_option('date_format') . ' @ ' . get_option('time_format'), $tests['last_run']) . '.</span>';
    }

    echo '</p>';

    if (!get_transient('snl_hide_upgrade_tab')) {
      echo '<p><strong>Please read!</strong> These tests only serve as suggestions! Although they cover years of best practices getting all test <i>green</i> will not guarantee your site will not get hacked. Likewise, getting them all <i>red</i> doesn\'t mean you\'ll certainly get hacked. Please read each test\'s detailed information to see if it represents a real security issue for your site. Suggestions and test results apply to public, production sites, not local, development ones. <br /> If you need an in-depth security analysis please hire a security expert or <a href="#snl_upgrade" class="upgrade">upgrade</a> Security Ninja to get more tests, suggestions, fixes and premium support.</p><br />';
    } else {
      echo '<p><strong>Please read!</strong> These tests only serve as suggestions! Although they cover years of best practices getting all test <i>green</i> will not guarantee your site will not get hacked. Likewise, getting them all <i>red</i> doesn\'t mean you\'ll certainly get hacked. Please read each test\'s detailed information to see if it represents a real security issue for your site. Suggestions and test results apply to pubic, production sites, not local, development ones. <br /> If you need an in-depth security analysis please hire a security expert or <a target="_blank" href="http://security-ninja.webfactoryltd.com/upgrade/">upgrade</a> Security Ninja to get more tests, suggestions, fixes and premium support.</p><br />';
    }


    if ($tests['last_run']) {
      echo '<table class="wp-list-table widefat" id="security-ninja">';
      echo '<thead><tr>';
      echo '<th class="snl-status">Status</th>';
      echo '<th>Test description</th>';
      echo '<th>Test results</th>';
      echo '</tr></thead>';
      echo '<tbody>';

      if (is_array($tests['test'])) {
        // test Results
        foreach($tests['test'] as $test_name => $details) {
          echo '<tr>
                  <td class="sn-status">' . self::status($details['status']) . '</td>
                  <td>' . $details['title'] . '</td>
                  <td>' . $details['msg'] . '</td>
                </tr>';
        } // foreach ($tests)
      } else { // no test results
        echo '<tr>
                <td colspan="4">No test results are available. Click "Run tests" to run tests now.</td>
              </tr>';
      } // if tests

      echo '</tbody>';
      echo '<tfoot><tr>';
      echo '<th class="snl-status">Status</th>';
      echo '<th>Test description</th>';
      echo '<th>Test results</th>';
      echo '</tr></tfoot>';
      echo '</table>';

      if (!get_transient('snl_hide_upgrade_tab')) {
        echo '<p><a class="upgrade" href="#snl_upgrade">Upgrade</a> Security Ninja to get <strong>more tests, detailed help, fixes and premium support</strong>.</p>';
      } else {
        echo '<p><a target="_blank" href="http://security-ninja.webfactoryltd.com/upgrade/">Upgrade</a> Security Ninja to get <strong>more tests, detailed help, fixes and premium support</strong>.</p>';
      }

    } // if $results
  } // tests_table


  // run all tests; via AJAX
  static function run_tests() {
    require_once 'snl-tests.php';

    @set_time_limit(SNL_MAX_EXEC_SEC);
    $test_count = 0;
    $test_description = array('last_run' => current_time('timestamp'));

    foreach(snl_tests::$security_tests as $test_name => $test){
      if ($test_name[0] == '_') {
        continue;
      }
      $response = snl_tests::$test_name();

      $test_description['test'][$test_name]['title'] = $test['title'];
      $test_description['test'][$test_name]['status'] = $response['status'];

      if (!isset($response['msg'])) {
        $response['msg'] = '';
      }

      if ($response['status'] == 10) {
        $test_description['test'][$test_name]['msg'] = sprintf($test['msg_ok'], $response['msg']);
      } elseif ($response['status'] == 0) {
        $test_description['test'][$test_name]['msg'] = sprintf($test['msg_bad'], $response['msg']);
      } else {
        $test_description['test'][$test_name]['msg'] = sprintf($test['msg_warning'], $response['msg']);
      }
      $test_count++;
    } // foreach

    update_option(SNL_OPTIONS_KEY, $test_description);

    die('1');
  } // run_test


  // convert status integer to button
  static function status($int) {
    if ($int == 0) {
      $string = '<span class="snl-error">Bad</span>';
    } elseif ($int == 10) {
      $string = '<span class="snl-success">OK</span>';
    } else {
      $string = '<span class="snl-warning">Warning</span>';
    }

    return $string;
  } // status


  // clean-up when deactivated
  static function deactivate() {
    delete_option(SNL_OPTIONS_KEY);
    delete_transient('snl_hide_upgrade_tab');
  } // deactivate
} // snl class


// hook everything up
add_action('init', array('snl', 'init'));

// when deativated clean up
register_deactivation_hook( __FILE__, array('snl', 'deactivate'));