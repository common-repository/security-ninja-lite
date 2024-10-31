/*
 * Security Ninja Lite
 * (c) Web factory Ltd
 */


jQuery(document).ready(function($){
  // alternate table rows
  $('#snl-tests-help tr:odd, #security-ninja tr:odd').addClass('alternate');

  // init tabs
  // init tabs
  $("#tabs").tabs({
    activate: function( event, ui ) {
        $.cookie("snl_tabs_selected", $("#tabs").tabs("option", "active"));
    },
    active: $("#tabs").tabs({ active: $.cookie("snl_tabs_selected") })
  });

  // just to make sure the button is not stuck
  $('#run-tests').removeAttr('disabled');

  // run tests, via ajax
  $('#run-tests').click(function(){
    var data = {action: 'snl_run_tests'};

    $(this).attr('disabled', 'disabled')
           .val('Running tests, please wait!');
    $.blockUI({ message: 'Security Ninja Lite is analyzing your site.<br />Please wait, it can take a few minutes.' });

    $.post(ajaxurl, data, function(response) {
      if (response != '1') {
        alert('Undocumented error. Page will automatically reload.');
        window.location.reload();
      } else {
        window.location.reload();
      }
    });
  }); // run tests

  // hide upgrade tab
  $('#snl_hide_upgrade').click(function(){
    var data = {action: 'snl_hide_upgrade_tab'};

    $.post(ajaxurl, data, function(response) {
      if (response != '1') {
        alert('Undocumented error. Page will automatically reload.');
        window.location.reload();
      } else {
        window.location.reload();
      }
    });
  }); // run tests

  $('a.upgrade').click(function() {
    $("#tabs").tabs("option", "active", 1);
    return false;
  });
}); // on ready