<?php //$Id: editadvanced_form.php,v 1.14.2.12 2009/05/13 05:35:37 jerome Exp $

require_once('../../../config.php');
require_login(1, true);

//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

if (has_capability('block/scholarship:guest',$context)) {
    //redirect users to email self registration
    redirect($CFG->wwwroot.'/login/signup.php',get_string('createaccount','block_scholarship'),10);
}

?>
