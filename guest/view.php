<?php //$Id: editadvanced_form.php,v 1.14.2.12 2009/05/13 05:35:37 jerome Exp $

require_once('../../../config.php');
require_once('../lib.php');
require_login(1, true);

print_header();
//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

if (has_capability('block/scholarship:guest',$context)) {
    //redirect users to email self registration
     $message = get_string('createaccount','block_scholarship');
     $linkyes = $CFG->wwwroot.'/login/signup.php';
     $linkno = $CFG->wwwroot;
     $OUTPUT->confirm($message, $linkyes, $linkno);
}
$OUTPUT->footer();
?>
