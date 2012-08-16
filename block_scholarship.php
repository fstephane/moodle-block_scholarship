<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
**************************************************************************
**                              Plugin Name                             **
**************************************************************************
* @package     block                                                    **
* @subpackage  Scholarship                                              **
* @name        Scholarship                                              **
* @copyright   oohoo.biz                                                **
* @link        http://oohoo.biz                                         **
* @author      Stephane                                                 **
* @author      Fagnan                                                   **
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
**************************************************************************
**************************************************************************/

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
	//Determine whether user can enter administrator or user version of the plugin
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