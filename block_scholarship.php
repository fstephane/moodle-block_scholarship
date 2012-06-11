<?php
require_login();
class block_scholarship extends block_base {
  function init() {
    $this->title   = get_string('scholarship', 'block_scholarship');
    $this->version = 200911160;
  }
  
  function get_content() {
	 global $USER, $CFG;
	  if($this->content !== NULL) {
            return $this->content;
        }
	$context = get_context_instance(CONTEXT_USER, $USER->id);
        $this->content =  new stdClass;
	
    if (has_capability('block/scholarship:manage',$context)) {
	
        $this->content->text   = '<a id="button" href="'.$CFG->wwwroot.'/blocks/scholarship/admin/adminview.php">'.get_string('manage', 'block_scholarship').'</a>';
    } else if (has_capability('block/scholarship:user',$context)) {
	
        $this->content->text   = '<a href="'.$CFG->wwwroot.'/blocks/scholarship/user/userview.php?userid='.$USER->id.'">'.get_string('userview','block_scholarship').'</a>';
    }

	$this->content->footer = '';
 
    return $this->content;
  }

}
?>