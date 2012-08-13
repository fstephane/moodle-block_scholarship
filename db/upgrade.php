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
 * Label module upgrade
 *
 * @package    mod
 * @subpackage label
 * @copyright  2006 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// This file keeps track of upgrades to
// the label module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the methods of database_manager class
//
// Please do not forget to use upgrade_set_timeout()
// before any action that may take longer time to finish.

defined('MOODLE_INTERNAL') || die;

function xmldb_block_scholarship_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2012071000) {

        // Define table block_scholarship to be created
        $table = new xmldb_table('block_scholarship');

        // Adding fields to table block_scholarship
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);
        $table->add_field('description', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('opendate', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('enddate', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('amount', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('scholarshiptype', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('value', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table block_scholarship
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // scholarship savepoint reached
        upgrade_block_savepoint(true, 2012071000, 'scholarship');
    }


    if ($oldversion < 2012071001) {

        // Define table block_scholarship_courselist to be created
        $table = new xmldb_table('block_scholarship_courselist');

        // Adding fields to table block_scholarship_courselist
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('coursename', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table block_scholarship_courselist
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_courselist
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table block_scholarship_courses to be created
        $table = new xmldb_table('block_scholarship_courses');

        // Adding fields to table block_scholarship_courses
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('scholarshipid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('yearid', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_scholarship_courses
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_courses
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table block_scholarship_doc to be created
        $table = new xmldb_table('block_scholarship_doc');

        // Adding fields to table block_scholarship_doc
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('scholarshipid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('documentid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_scholarship_doc
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_doc
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table block_scholarship_doc to be created
        $table = new xmldb_table('block_scholarship_doc');

        // Adding fields to table block_scholarship_doc
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('scholarshipid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('documentid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_scholarship_doc
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_doc
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        // Define table block_scholarship_doc_upload to be created
        $table = new xmldb_table('block_scholarship_doc_upload');

        // Adding fields to table block_scholarship_doc_upload
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('docid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('scholarshipid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('filename', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('folder', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table block_scholarship_doc_upload
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_doc_upload
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table block_scholarship_document to be created
        $table = new xmldb_table('block_scholarship_document');

        // Adding fields to table block_scholarship_document
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);
        $table->add_field('description', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table block_scholarship_document
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_document
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table block_scholarship_notice to be created
        $table = new xmldb_table('block_scholarship_notice');

        // Adding fields to table block_scholarship_notice
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('notice', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table block_scholarship_notice
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_notice
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table block_scholarship_selected to be created
        $table = new xmldb_table('block_scholarship_selected');

        // Adding fields to table block_scholarship_selected
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('scholarshipid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_scholarship_selected
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_selected
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table block_scholarship_users to be created
        $table = new xmldb_table('block_scholarship_users');

        // Adding fields to table block_scholarship_users
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('scholarshipid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('opendate', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('enddate', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('scholarshipname', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('scholarshiptype', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('mail', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('received', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_scholarship_users
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_scholarship_users
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // scholarship savepoint reached
        upgrade_block_savepoint(true, 2012071001, 'scholarship');
    }


    return true;
}

