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

defined('MOODLE_INTERNAL') || die();

        // The current plugin version (Date: YYYYMMDDXX)
$plugin->version   = 2012081601;
$plugin->requires = 2010112400; //Moodle 2.0 = 2010112400; Moodle 2.1 = 2011070100; Moodle 2.2 = 2011120100; Moodle 2.3 = 2012062500
$plugin->maturity = MATURITY_BETA; // Change the maturity in function of the plugin. MATURITY_ALPHA / MATURITY_BETA / MATURITY_RC / MATURITY_STABLE
$plugin->release = '0.9.0 (Build: 2012081601)'; //Replace 0.0.0 with the actual version of your plugin. Replace the YYYYMMDDVV with the version of the plugin
$plugin->component = 'block_scholarship'; //Replace the value with the right name of the plugin
