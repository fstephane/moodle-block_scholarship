<?php

require_once('../../../config.php');

$PAGE->requires->js('/blocks/scholarship/jquery.js');
$PAGE->requires->js('/blocks/scholarship/jquery.min.js');
$PAGE->requires->js('/blocks/scholarship/admin/request.js');
$PAGE->requires->css('/blocks/scholarship/admin/scrollmenu.css');

global $DB;

$coursename = optional_param('coursename', '0', PARAM_TEXT);    //Creating new course
$name = optional_param('name', '0', PARAM_TEXT);                ////////////////////////////
$amount = optional_param('amount', '0', PARAM_INT);             //
$value = optional_param('value', '0', PARAM_TEXT);              //
$open = optional_param('open', '0', PARAM_TEXT);                //Creating Scholarship
$close = optional_param('close', '0', PARAM_TEXT);              //
$type = optional_param('type', '0', PARAM_INT);                 //
$desc = optional_param('desc', '0', PARAM_TEXT);                //
$courses = optional_param('courses', '-1', PARAM_TEXT);         ////////////////////////////
$check = optional_param('check', '0', PARAM_TEXT);              //Checks if scholarship/course name is already taken
$delete = optional_param('deletedcourses', '0', PARAM_TEXT);    //Deleting courses
$message = optional_param('deletemessage', '0', PARAM_TEXT);    //generates message for deleted courses
$list = optional_param('list', '-1', PARAM_INT);                //Listing scholarships by program
$info = optional_param('info', '0', PARAM_INT);                 //Show Scholarship information
$edit = optional_param('edit', '0', PARAM_INT);                 //Edit scholarship info (not courses and documents)
$year = optional_param('year', '0', PARAM_INT);                 //indicates year of study
$change = optional_param('change', '0', PARAM_TEXT);            //indicates if scholarship is being created or edited
$sid = optional_param('id', '0', PARAM_INT);                    //Scholarship id
$cc = optional_param('cc', '0', PARAM_INT);                     //Change courses
$remove = optional_param('remove', '0', PARAM_INT);             //Deleting scholarship
$deleteall = optional_param('deleteall', '0', PARAM_TEXT);      //End of year tool - Deleting info
$doc = optional_param('doc', '0', PARAM_TEXT);                  //Adding doc when creating scholarship
$editdocs = optional_param('editdocs', '0', PARAM_INT);         //Editing docs - Lists Documents
$deldoc = optional_param('deldoc', '0', PARAM_INT);             //Deleting docs
$editd = optional_param('editd', '0', PARAM_TEXT);              //Editing docs - Changes doc info
$check2 = optional_param('check2', '0', PARAM_TEXT);            //Checks if Document name is already taken
$student = optional_param('student', '0', PARAM_INT);           //Lists students alphabetically on front page
$sbys = optional_param('sbys', '0', PARAM_INT);                 //Lists students by scholarship when a scholarship is selected
$fid = optional_param('fid', '0', PARAM_INT);                   //Shows a student's uploaded file
$fullname = optional_param('fullname', '0', PARAM_TEXT);        //Indicates a student's name
$scholarshipid = optional_param('scholarshipid', '0', PARAM_INT);   //Scholarship id for finding a file
$userid = optional_param('userid', '0', PARAM_INT);             //Userid for finding a file
$file = optional_param('file', '0', PARAM_TEXT);                //File name
$showdocs = optional_param('showdocs', '0', PARAM_TEXT);        //Shows a student's uploaded documents
$scid = optional_param('scid', '0', PARAM_TEXT);                //scholarship id (for some reason sid wasn't working for show_docs())
$dapp = optional_param('dapp', '0', PARAM_INT);                 //Delete's application information for a single student's scholarship
$dd = optional_param('dd', '0', PARAM_INT);                     //Delete application info for entire scholarship
$note = optional_param('note', '0', PARAM_TEXT);                //Saves note and displays on student view
$email = optional_param('email', '0', PARAM_TEXT);              //Stores user's email address
$smail = optional_param('smail', '0', PARAM_INT);               //Displays scholarships for mailing tool
$dmail = optional_param('dmail', '0', PARAM_INT);               //Displays documents for mailing tool
$cmail = optional_param('cmail', '0', PARAM_INT);               //Confirms that a student has mailed the required documents
$received = optional_param('received', '0', PARAM_INT);         //Records indication that student's documents have been received
$rid = optional_param('rid', '0', PARAM_INT);                   //scholarship id for mail tool


//Records indication that student's documents have been received
if ($received !== '0') {
    $app = $DB->get_record('block_scholarship_users', array("userid" => $received, "scholarshipid" => $rid));
    $record = new stdClass();
    $record->id = $app->id;
    $record->firstname = $app->firstname;
    $record->lastname = $app->lastname;
    $record->scholarshipname = $app->scholarshipname;
    $record->scholarshipid = $rid;
    $record->scholarshiptype = $app->scholarshiptype;
    $record->opendate = $app->opendate;
    $record->enddate = $app->enddate;
    $record->userid = $received;
    $record->mail = 1;
    $record->received = 1;
    $DB->update_record('block_scholarship_users', $record);
}


//Displays documents for mailing tool
if ($dmail !== '0') {
    echo '<p style="color:white;font-weight:bold;padding:5px;">' . get_string('verify', 'block_scholarship') . '</p>';
    echo '<input type="button" disabled="disabled" id="verify" onclick="mail_received(' . $userid . ', ' . $dmail . ')" style="width:180px;font-size:18px;font-family:Verdana,sans-serif;font-weight:bold;color:#FFFFFF;height:30px;background-color:darkslategrey;border-style:outset;border-color:#AAAAAA;" value="' . get_string('continue', 'block_scholarship') . '"></input>';
    echo '<label class="checkbox" style="color:black;background-color:darkgrey;"><input type="checkbox" class="checkbox10"/><b style="padding-left:5px;">' . get_string('unofficial', 'block_scholarship') . '</b><br/></label>';

    if ($DB->get_records('block_scholarship_doc', array("scholarshipid" => $dmail))) {
        $rdoc = $DB->get_records_sql('SELECT d.name 
                                FROM mdl_block_scholarship_document AS d
                                JOIN mdl_block_scholarship_doc AS doc ON d.id=doc.documentid
                                WHERE doc.scholarshipid=' . $dmail);
        $i = 1;
        foreach ($rdoc as $r) {
            $color = '';
            if (($i % 2) == 0)
                $color = 'darkgrey';
            else
                $color = 'lightgray';
            echo '<label class="checkbox" style="color:black;background-color:' . $color . '"><input type="checkbox" class="checkbox10"/><b style="padding-left:5px;">' . $r->name . '</b><br/></label>';
            $i++;
        }
    }
}


//Displays scholarships for mailing tool
if ($smail !== '0') {
    $selected = $DB->get_records_sql('SELECT s.id, s.name
                                    FROM mdl_block_scholarship_users AS u
                                    JOIN mdl_block_scholarship AS s ON u.scholarshipid=s.id
                                    WHERE u.userid=' . $smail . ' AND u.received=0
                                    ORDER BY s.name');
    $i = 1;
    foreach ($selected as $s) {
        if (($i % 2) == 0)
            $color = 'darkgrey';
        else
            $color = 'lightgray';
        echo '<label class="checkbox" style="color:black;background-color:' . $color . '"><input type="checkbox" id="' . $smail . '" class="checkbox9" value="' . $s->id . '"/><b style="padding-left:5px;">' . $s->name . '</b><br/></label>';
        $i++;
    }
}

//Saves note and displays on student view
if ($note !== '0') {
    $DB->delete_records('block_scholarship_notice', array());
    $notice = urldecode($note);
    $record = new stdClass();
    $record->notice = $notice;
    $DB->insert_record('block_scholarship_notice', $record);
}

//Delete application info for entire scholarship
if ($dd !== '0') {
    $docfiles = $DB->get_records('block_scholarship_doc_upload', array("scholarshipid" => $dd));

    foreach ($docfiles as $df) {
        $dfile = get_file_storage();
        // Prepare file record object
        $dfileinfo = array(
            'component' => 'block_scholarship', // usually = table name
            'filearea' => 'block_scholarship_doc_upload', // usually = table name
            'itemid' => 1, // usually = ID of row in table
            'contextid' => 1, // ID of context
            'filepath' => '/' . $dd . 'scholarship' . $df->userid . '/', // any path beginning and ending in /
            'filename' => $df->filename); // any filename
        $dfiledelete = $dfile->get_file($dfileinfo['contextid'], $dfileinfo['component'], $dfileinfo['filearea'], $dfileinfo['itemid'], $dfileinfo['filepath'], $dfileinfo['filename']);

        if ($dfiledelete) {
            $dfiledelete->delete();
        }
    }

    $DB->delete_records('block_scholarship_doc_upload', array("scholarshipid" => $dd));
    $DB->delete_records('block_scholarship_users', array("scholarshipid" => $dd));
    $sname = $DB->get_record('block_scholarship', array("id" => $dd));

    echo '<p style="padding-left:5px;">' . get_string('docdeleted', 'block_scholarship') . '</p>';
    echo '<pre style="padding-left:5px;">' . $sname->name . '</pre>';
    echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">' . get_string('refreshpage', 'block_scholarship') . '</p>';
    echo '<input type="button" class="newbutton" onclick="window.location.reload()" style="margin-left:-10px;margin-top:15px;width:299px;" value="' . get_string('refresh', 'block_scholarship') . '" /><br/><br/>';
}

//Delete's application information for a single student's scholarship
if ($dapp !== '0') {
    $files = $DB->get_records('block_scholarship_doc_upload', array("userid" => $userid, "scholarshipid" => $dapp));

    foreach ($files as $f) {
        $fs = get_file_storage();
        // Prepare file record object
        $fileinfo = array(
            'component' => 'block_scholarship', // usually = table name
            'filearea' => 'block_scholarship_doc_upload', // usually = table name
            'itemid' => 1, // usually = ID of row in table
            'contextid' => 1, // ID of context
            'filepath' => '/' . $dapp . 'scholarship' . $userid . '/', // any path beginning and ending in /
            'filename' => $f->filename); // any filename
        $filedelete = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);

        if ($filedelete) {
            $filedelete->delete();
        }
    }

    $DB->delete_records('block_scholarship_doc_upload', array("userid" => $userid, "scholarshipid" => $dapp));
    $DB->delete_records('block_scholarship_users', array("userid" => $userid, "scholarshipid" => $dapp));
}

//Shows a student's uploaded documents
if ($showdocs !== '0') {
    $sbysinfo = Array();
    $scholar = $DB->get_record('block_scholarship', array("id" => $scid));
    $sbysname = $DB->get_record('user', array("id" => $userid));
    if ($DB->get_record('block_scholarship_users', array("scholarshipid" => $scid, "userid" => $userid, "mail" => 0))) {
        echo '<div align="center" style="height:65px;width:282px;background-color:dimgray;border:1px black solid;margin-left:-11px;margin-top:-11px;"><b style="font-size:25px;color:white;font-variant:small-caps;">' . $sbysname->firstname . ' ' . $sbysname->lastname . '<br/><font style="font-size:15px;font-variant:normal;">(' . urldecode($email) . ')</font></b></div>';
        if ($DB->get_records('block_scholarship_doc', array("scholarshipid" => $scid))) {
            $sbysinfo = $DB->get_records_sql('SELECT doc.name, doc.id, d.scholarshipid, s.name AS sname, s.opendate, s.enddate
                                                                FROM mdl_block_scholarship_document AS doc
                                                                JOIN mdl_block_scholarship_doc AS d ON d.documentid=doc.id
                                                                JOIN mdl_block_scholarship AS s ON d.scholarshipid=s.id
                                                                JOIN mdl_block_scholarship_doc_upload AS du ON du.docid=doc.id
                                                                JOIN mdl_block_scholarship_users AS u ON u.scholarshipid=s.id
                                                                WHERE d.scholarshipid=' . $scid . ' AND du.userid=' . $userid . ' AND u.mail=0');

            $unlink = $DB->get_record('block_scholarship_doc_upload', array("docid" => 0, "scholarshipid" => $scid, "userid" => $userid));
            echo '<br/><b style="padding-left:10px;text-decoration:underline;color:black;font-size:20px;">' . $scholar->name . '</b><p style="font-weight:normal;padding-bottom:0px;padding-left:20px;color:orangered;">(' . date("F j, Y", $scholar->opendate) . ' - ' . date("F j, Y", $scholar->enddate) . ')</p>';
            echo '<p style="padding-left:10px;margin-bottom:0px;font-family:verdana;color:black;font-weight:normal;width:260px;">-' . get_string('unofficial', 'block_scholarship') . '</p>';
            echo '<a href="#" id="' . $unlink->id . '" onclick="read_file(this.id, ' . $scid . ', ' . $userid . ', this.innerHTML)" style="display:inline;padding:0px;margin:0px;margin-left:30px;padding-top:3px;background-color:transparent;color:blue;border:none;font-size:15px;height:20px;text-align:left;"><img src="down.gif" />' . $unlink->filename . '</a><p style="margin-bottom:10px;"/>';
            foreach ($sbysinfo as $s) {
                $doclink = $DB->get_record('block_scholarship_doc_upload', array("docid" => $s->id, "scholarshipid" => $scid, "userid" => $userid));
                echo '<p style="padding-left:10px;margin-bottom:0px;font-family:verdana;color:black;font-weight:normal;width:260px;">-' . $s->name . '</p>';
                echo '<a href="#" id="' . $s->id . '" onclick="read_file(this.id, ' . $scid . ', ' . $userid . ', this.innerHTML)" style="display:inline;padding:0px;margin:0px;margin-left:30px;padding-top:3px;background-color:transparent;color:blue;border:none;font-size:15px;height:20px;text-align:left;"><img src="down.gif" />' . $doclink->filename . '</a><p style="margin-bottom:10px;"/>';
            }
            echo '<hr/>';
        } else {
            $sbysinfo = $DB->get_records('block_scholarship', array("id" => $scid));

            foreach ($sbysinfo as $s) {
                $unlink = $DB->get_record('block_scholarship_doc_upload', array("docid" => 0, "scholarshipid" => $scid, "userid" => $userid));
                echo '<br/><b style="padding-left:10px;text-decoration:underline;color:black;font-size:20px;">' . $scholar->name . '</b><p style="font-weight:normal;padding-bottom:0px;padding-left:20px;color:orangered;">(' . date("F j, Y", $scholar->opendate) . ' - ' . date("F j, Y", $scholar->enddate) . ')</p>';
                echo '<p style="padding-left:10px;margin-bottom:0px;font-family:verdana;color:black;font-weight:normal;width:260px;">-' . get_string('unofficial', 'block_scholarship') . '</p>';
                echo '<a href="#" id="' . $unlink->id . '" onclick="read_file(this.id, ' . $scid . ', ' . $userid . ', this.innerHTML)" style="display:inline;padding:0px;margin:0px;margin-left:30px;padding-top:3px;background-color:transparent;color:blue;border:none;font-size:15px;height:20px;text-align:left;"><img src="down.gif" />' . $unlink->filename . '</a><p style="margin-bottom:10px;"/>';
                echo '<hr/>';
            }
        }
    } else {
        echo '<div align="center" style="height:65px;width:282px;background-color:dimgray;border:1px black solid;margin-left:-11px;margin-top:-11px;"><b style="font-size:25px;color:white;font-variant:small-caps;">' . $sbysname->firstname . ' ' . $sbysname->lastname . '<br/><font style="font-size:15px;font-variant:normal;">(' . urldecode($email) . ')</font></b></div>';
        $maildocs = $DB->get_record('block_scholarship_users', array("userid" => $userid, "mail" => 1, "scholarshipid" => $scid));

            if ($maildocs->received == 1) {
                echo '<br/><b style="padding-left:10px;text-decoration:underline;color:black;font-size:18px;">' . $maildocs->scholarshipname . '</b>';
                echo '<p style="color:midnightblue;margin-left:10px;">' . get_string('mailed', 'block_scholarship') . '</p>';
                echo '<hr/>';
            } else {
                echo '<br/><b style="padding-left:10px;text-decoration:underline;color:black;font-size:18px;">' . $maildocs->scholarshipname . '</b>';
                echo '<p style="color:midnightblue;margin-left:10px;">' . get_string('notcon', 'block_scholarship') . '</p>';
                echo '<hr/>';
            }
    }
    echo '<br/><div align="center">';
    echo '<a style="height:20px;font-size:15px;background-color:transparent;padding:0px;margin:0px;display:inline;color:black;border:1px black solid;" href="#" onclick="app_confirm2(' . $scid . ', ' . $userid . ')">' . get_string('deleteapplication', 'block_scholarship') . '<img src="delete.gif" /></a><br/><br/>';
    echo '<div><hr/>';
    echo '<input type="button" onclick="bts()" class="newbutton" style="margin-left:-10px;margin-top:15px;width:283px;font-size:16px;" value="' . get_string('backtostudents', 'block_scholarship') . '" />';
}


//Shows a student's uploaded file
if ($fid !== '0') {
    $fs = get_file_storage();
    $filename = urldecode($file);
    // Prepare file record object
    $fileinfo = array(
        'component' => 'block_scholarship', // usually = table name
        'filearea' => 'block_scholarship_doc_upload', // usually = table name
        'itemid' => 1, // usually = ID of row in table
        'contextid' => 1, // ID of context
        'filepath' => '/' . $scholarshipid . 'scholarship' . $userid . '/', // any path beginning and ending in /
        'filename' => $filename); // any filename
    // Get file
    $fileread = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);

    $file_address = $CFG->wwwroot . '/pluginfile.php/' . $fileread->get_contextid()
            . '/' . $fileread->get_component() . '/' . $fileread->get_filearea()
            . '/' . $fileread->get_filepath() . $fileread->get_itemid()
            . '/' . $fileread->get_filename();

    header('location: ' . $file_address);
}


//Lists students by scholarship when a scholarship is selected
if ($sbys !== '0') {
    if ($DB->get_records('block_scholarship_users', array("scholarshipid" => $sbys), '', 'userid, firstname, lastname')) {
        $applied = $DB->get_records('block_scholarship_users', array("scholarshipid" => $sbys), '', 'userid, firstname, lastname');
        foreach ($applied as $ap) {
            $mail = $DB->get_record('user', array("id" => $ap->userid), 'email');
            echo '<hr/><p style="color:black;font-size:15px;text-decoration:underline;padding-top:5px;">-' . $ap->firstname . ' ' . $ap->lastname . '</p>';
            echo '   <a href="#" name="' . $mail->email . '" onclick="show_docs(' . $ap->userid . ', ' . $sbys . ', this.name)" style="background-color:transparent;border:none;padding:0px;margin:0px;margin-left:-40px;margin-top:-15px;color:blue;font-size:15px;height:20px;">' . get_string('submitted', 'block_scholarship') . '</a>';
        }
    }
    else
        echo '<hr/><br/><p style="color:orangered;font-size:16px;">' . get_string('nobody', 'block_scholarship') . '</p>';

    echo '<hr/><hr/><br/><br/><p style="color:midnightblue;font-size:18px;margin-top:-5px;">' . get_string('selected', 'block_scholarship') . '</p>';
    if ($DB->get_records_sql("SELECT s.userid, u.firstname, u.lastname, u.email FROM mdl_block_scholarship_selected AS s JOIN mdl_user AS u ON s.userid=u.id WHERE scholarshipid=" . $sbys . " ORDER BY u.lastname, u.firstname")) {
        $select = $DB->get_records_sql("SELECT s.userid, u.firstname, u.lastname, u.email
                                        FROM mdl_block_scholarship_selected AS s
                                        JOIN mdl_user AS u ON s.userid=u.id
                                        WHERE scholarshipid=" . $sbys . "
                                        ORDER BY u.lastname, u.firstname");
        foreach ($select as $s) {
            echo '<hr/><p style="color:black;font-size:15px;text-decoration:underline;padding-top:5px;">-' . $s->firstname . ' ' . $s->lastname . '</p>';
            echo '<pre style="color:black;margin-top:-10px;">' . $s->email . '</pre>';
        }
    }
    else
        echo '<hr/><br/><p style="color:orangered;font-size:16px;">' . get_string('nobodyselected', 'block_scholarship') . '</p>';
}


//Lists students alphabetically on front page
if ($student !== '0') {
    $stinfo = Array();
    $schol = $DB->get_records('block_scholarship_users', array("userid" => $student, "mail" => 0), '', 'scholarshipid, scholarshipname, opendate, enddate');

    echo '<div align="center" style="height:28px;width:531px;background-color:dimgray;border:1px black solid;margin-left:-1px;margin-top:-1px;"><b style="font-size:25px;color:white;font-variant:small-caps;">' . urldecode($fullname) . ' <font style="font-size:16px;font-variant:normal;">(' . urldecode($email) . ')</font></b><br/></div>';
    foreach ($schol as $sc) {
        if (($DB->get_records('block_scholarship_doc', array("scholarshipid" => $sc->scholarshipid)))) {
            $schid = $sc->scholarshipid;
            $stinfo = $DB->get_records_sql('SELECT doc.name, doc.id, d.scholarshipid, s.name AS sname, s.opendate, s.enddate
                                                                FROM mdl_block_scholarship_document AS doc
                                                                JOIN mdl_block_scholarship_doc AS d ON d.documentid=doc.id
                                                                JOIN mdl_block_scholarship AS s ON d.scholarshipid=s.id
                                                                JOIN mdl_block_scholarship_doc_upload AS du ON du.docid=doc.id
                                                                WHERE d.scholarshipid=' . $schid . ' AND du.userid=' . $student);

            
            $ulink = $DB->get_record('block_scholarship_doc_upload', array("docid" => 0, "scholarshipid" => $schid, "userid" => $student));
            echo '<br/><b style="padding-left:10px;text-decoration:underline;">' . $sc->scholarshipname . '</b><a style="background-color:transparent;padding:0px;margin:0px;margin-right:20px;float:right;display:inline;color:black;border:1px black solid;" href="#" onclick="app_confirm(' . $schid . ', ' . $student . ')">' . get_string('deleteapplication', 'block_scholarship') . '<img src="delete.gif" /></a><p style="padding-bottom:0px;padding-left:20px;color:orangered;">(' . date("F j, Y", $sc->opendate) . ' - ' . date("F j, Y", $sc->enddate) . ')</p>';
            echo '<pre style="padding-left:10px;margin-bottom:0px;font-family:verdana;">-' . get_string('unofficial', 'block_scholarship') . '</pre>';
            echo '<a href="#" id="' . $ulink->id . '" onclick="read_file(this.id, ' . $schid . ', ' . $student . ', this.innerHTML)" style="margin-left:60px;"><img src="down.gif" />' . $ulink->filename . '</a><p style="margin-bottom:10px;"/>';
            foreach ($stinfo as $s) {
                $dlink = $DB->get_record('block_scholarship_doc_upload', array("docid" => $s->id, "scholarshipid" => $schid, "userid" => $student));
                echo '<pre style="padding-left:10px;margin-bottom:0px;font-family:verdana;">-' . $s->sname . '</pre>';
                echo '<a href="#" id="' . $s->id . '" onclick="read_file(this.id, ' . $schid . ', ' . $student . ', this.innerHTML)" style="margin-left:60px;"><img src="down.gif" />' . $dlink->filename . '</a><p style="margin-bottom:10px;"/>';
            }
            echo '<hr/>';
        } else {
            $schid = $sc->scholarshipid;
            $stinfo = $DB->get_records('block_scholarship', array("id" => $sc->scholarshipid));

            foreach ($stinfo as $s) {
                $ulink = $DB->get_record('block_scholarship_doc_upload', array("docid" => 0, "scholarshipid" => $schid, "userid" => $student));
                echo '<br/><b style="padding-left:10px;text-decoration:underline;">' . $sc->scholarshipname . '</b><a style="background-color:transparent;padding:0px;margin:0px;margin-right:20px;float:right;display:inline;color:black;border:1px black solid;" href="#" onclick="app_confirm(' . $schid . ', ' . $student . ')">' . get_string('deleteapplication', 'block_scholarship') . '<img src="delete.gif" /></a><p style="padding-bottom:0px;padding-left:20px;color:orangered;">(' . date("F j, Y", $s->opendate) . ' - ' . date("F j, Y", $s->enddate) . ')</p>';
                echo '<pre style="padding-left:10px;margin-bottom:0px;font-family:verdana;">-' . get_string('unofficial', 'block_scholarship') . '</pre>';
                echo '<a href="#" id="' . $ulink->id . '" onclick="read_file(this.id, ' . $schid . ', ' . $student . ', this.innerHTML)" style="margin-left:60px;"><img src="down.gif" />' . $ulink->filename . '</a><p style="margin-bottom:10px;"/>';
                echo '<hr/>';
            }
        }
    }
    $mailinfo = $DB->get_records('block_scholarship_users', array("userid" => $student, "mail" => 1), '', 'scholarshipid, scholarshipname, opendate, enddate, received');

    foreach ($mailinfo as $m) {
        if ($m->received == 1) {
            echo '<br/><b style="padding-left:10px;text-decoration:underline;">' . $m->scholarshipname . '</b><a style="background-color:transparent;padding:0px;margin:0px;margin-right:20px;float:right;display:inline;color:black;border:1px black solid;" href="#" onclick="app_confirm(' . $m->scholarshipid . ', ' . $student . ')">' . get_string('deleteapplication', 'block_scholarship') . '<img src="delete.gif" /></a><p style="padding-bottom:0px;padding-left:20px;color:orangered;">(' . date("F j, Y", $m->opendate) . ' - ' . date("F j, Y", $m->enddate) . ')</p>';
            echo '<p style="color:midnightblue;margin-left:10px;">' . get_string('mailed', 'block_scholarship') . '</p>';
            echo '<hr/>';
        } else {
            echo '<br/><b style="padding-left:10px;text-decoration:underline;">' . $m->scholarshipname . '</b><a style="background-color:transparent;padding:0px;margin:0px;margin-right:20px;float:right;display:inline;color:black;border:1px black solid;" href="#" onclick="app_confirm(' . $m->scholarshipid . ', ' . $student . ')">' . get_string('deleteapplication', 'block_scholarship') . '<img src="delete.gif" /></a><p style="padding-bottom:0px;padding-left:20px;color:orangered;">(' . date("F j, Y", $m->opendate) . ' - ' . date("F j, Y", $m->enddate) . ')</p>';
            echo '<p style="color:midnightblue;margin-left:10px;">' . get_string('notconfirmed', 'block_scholarship') . '</p>';
            echo '<hr/>';
        }
    }
}


//Checks if Document name is already taken
if ($check2 !== '0') {
    if (is_object($DB->get_record('block_scholarship_document', array('name' => $check2))))
        echo get_string('docnametaken', 'block_scholarship');
    else
        echo 'Good';
}


//Editing docs - Changes doc info
if ($editd !== '0') {
    $newedit = urldecode($editd);
    $array = array();
    $array = explode("*", $newedit, -1);
    $inc = 0;
    $darray = array();
    $docarray = array();
    foreach ($array as $a) {
        $darray[$inc] = explode("^", $a);
        $inc++;
    }
    $inc = 0;
    foreach ($darray as $d) {
        $docarray[$inc] = explode("@", $d[1]);
        $docarray[$inc][2] = $d[0];
        $inc++;
    }
    $record = new stdClass();
    foreach ($docarray as $d) {
        $record->id = $d[2];
        $record->name = $d[0];
        $record->description = $d[1];
        $record->timemodified = time();
        $DB->update_record('block_scholarship_document', $record);
    }
    echo get_string('changesmade', 'block_scholarship');
}


//Editing docs - Lists Documents
if ($editdocs !== '0') {
    $doclist = $DB->get_records_sql('SELECT doc.name, doc.description, doc.id
                                    FROM mdl_block_scholarship_document as doc
                                    JOIN mdl_block_scholarship_doc as ds ON doc.id=ds.documentid
                                    WHERE ds.scholarshipid=' . $editdocs);
    echo '<div style="padding-left:10px;color:black;">';
    $in = 1;
    foreach ($doclist as $dlist) {
        echo '<p id="docnum" style="font-size:25px;text-decoration:underline;">Document ' . $in . '<a title="' . get_string('remove', 'block_scholarship') . '" onclick="remove_document(' . $dlist->id . ')" style="background-color:transparent;width:10px;height:10px;border:none;float:up;margin-left:160px;margin-top:-38px;" href="#"><img src="delete.gif" /></a></p>';
        echo get_string('name', 'block_scholarship') . ':<br/><input type="text" name="docname" id="' . $dlist->id . '" value="' . $dlist->name . '"></input><br/><br/>';
        echo get_string('description', 'block_scholarship') . ':<br/><textarea rows="10" cols="33" id="' . $dlist->id . '" name="docdesc" style="resize:none;">' . $dlist->description . '</textarea><br/><br/>';
        $in++;
    }
    echo '</div>';
}


//Deleting docs
if ($deldoc !== '0') {
    $DB->delete_records('block_scholarship_document', array("id" => $deldoc));
    $DB->delete_records('block_scholarship_doc', array("documentid" => $deldoc));
}


//Adding doc when creating scholarship
if (($doc !== '0') && ($name == '0')) {
    $record = new stdClass();
    $insert = new stdClass();

    $edocstring = explode(".", $doc, -1);
    $eind = 0;
    foreach ($edocstring as $ds) {
        $edocuments->$eind = explode(",", $ds);
        $eind++;
    }
    $edocname = '';
    $edocdesc = '';
    foreach ($edocuments as $docs) {
        $edocname = $docs[0];
        $edocdesc = $docs[1];

        $record->name = $edocname;
        $record->description = $edocdesc;
        $record->timemodified = time();
        $DB->insert_record('block_scholarship_document', $record);
        $edid = $DB->get_record('block_scholarship_document', array('name' => $edocname), 'id');

        $insert->scholarshipid = $sid;
        $insert->documentid = $edid->id;
        $insert->timemodified = time();
        $DB->insert_record('block_scholarship_doc', $insert);
    }

    echo get_string('changesmade', 'block_scholarship');
}


//End of year tool - Deleting all scholarships
if ($deleteall !== '0') {
    switch ($deleteall) {
        case 1:
            $endfiles = $DB->get_records('block_scholarship_doc_upload');

            foreach ($endfiles as $df) {
                $endfile = get_file_storage();
                // Prepare file record object
                $endfileinfo = array(
                    'component' => 'block_scholarship', // usually = table name
                    'filearea' => 'block_scholarship_doc_upload', // usually = table name
                    'itemid' => 1, // usually = ID of row in table
                    'contextid' => 1, // ID of context
                    'filepath' => '/' . $df->scholarshipid . 'scholarship' . $df->userid . '/', // any path beginning and ending in /
                    'filename' => $df->filename); // any filename
                $endfiledelete = $endfile->get_file($endfileinfo['contextid'], $endfileinfo['component'], $endfileinfo['filearea'], $endfileinfo['itemid'], $endfileinfo['filepath'], $endfileinfo['filename']);

                if ($endfiledelete) {
                    $endfiledelete->delete();
                }
            }
            $DB->delete_records('block_scholarship_doc_upload', array());
            $DB->delete_records('block_scholarship_selected', array());
            $DB->delete_records('block_scholarship_users', array());
            break;
        case 2:
            $endfiles = $DB->get_records('block_scholarship_doc_upload');

            foreach ($endfiles as $df) {
                $endfile = get_file_storage();
                // Prepare file record object
                $endfileinfo = array(
                    'component' => 'block_scholarship', // usually = table name
                    'filearea' => 'block_scholarship_doc_upload', // usually = table name
                    'itemid' => 1, // usually = ID of row in table
                    'contextid' => 1, // ID of context
                    'filepath' => '/' . $df->scholarshipid . 'scholarship' . $df->userid . '/', // any path beginning and ending in /
                    'filename' => $df->filename); // any filename
                $endfiledelete = $endfile->get_file($endfileinfo['contextid'], $endfileinfo['component'], $endfileinfo['filearea'], $endfileinfo['itemid'], $endfileinfo['filepath'], $endfileinfo['filename']);

                if ($endfiledelete) {
                    $endfiledelete->delete();
                }
            }
            $DB->delete_records('block_scholarship_doc_upload', array());
            $DB->delete_records('block_scholarship_selected', array());
            $DB->delete_records('block_scholarship_users', array());
            $DB->delete_records('block_scholarship', array());
            $DB->delete_records('block_scholarship_courses', array());
            $DB->get_records_sql('DELETE FROM mdl_block_scholarship_document');
            $DB->delete_records('block_scholarship_doc', array());
            break;
        case 3:
            $endfiles = $DB->get_records('block_scholarship_doc_upload');

            foreach ($endfiles as $df) {
                $endfile = get_file_storage();
                // Prepare file record object
                $endfileinfo = array(
                    'component' => 'block_scholarship', // usually = table name
                    'filearea' => 'block_scholarship_doc_upload', // usually = table name
                    'itemid' => 1, // usually = ID of row in table
                    'contextid' => 1, // ID of context
                    'filepath' => '/' . $df->scholarshipid . 'scholarship' . $df->userid . '/', // any path beginning and ending in /
                    'filename' => $df->filename); // any filename
                $endfiledelete = $endfile->get_file($endfileinfo['contextid'], $endfileinfo['component'], $endfileinfo['filearea'], $endfileinfo['itemid'], $endfileinfo['filepath'], $endfileinfo['filename']);

                if ($endfiledelete) {
                    $endfiledelete->delete();
                }
            }
            $DB->delete_records('block_scholarship_doc_upload', array());
            $DB->delete_records('block_scholarship_selected', array());
            $DB->delete_records('block_scholarship_users', array());
            $DB->delete_records('block_scholarship', array());
            $DB->get_records_sql('DELETE FROM mdl_block_scholarship_document');
            $DB->delete_records('block_scholarship_courses', array());
            $DB->delete_records('block_scholarship_doc', array());
            $DB->delete_records('block_scholarship_courselist', array());
            break;
    }
    echo '<p style="font-size:25px;margin-top:200px;width:650px;">' . get_string('infodeleted', 'block_scholarship') . '</p>';
    echo '<div id="toolrefresh" onclick="window.location.reload()" align="center" style="position:absolute;top:300px;left:300px;color:white;font-size:20px;padding-top:8px;border: 1px grey solid;border-radius:30px 30px;height:40px;width:300px;margin-left:150px;">' . get_string('refresh', 'block_scholarship') . '</div>';
}


//Deleting scholarship
if ($remove !== '0') {
    $scholname = $DB->get_record('block_scholarship', array("id" => $remove));

    echo get_string('scholarshiperased', 'block_scholarship');
    echo '<br/><br/>';
    echo '<pre style="color:white;margin-left:10px;margin-bottom:10px;">';
    echo '-' . $scholname->name;
    echo '</pre>';
    echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">' . get_string('refreshpage', 'block_scholarship') . '</p>';
    echo '<input type="button" class="newbutton" onclick="window.location.reload()" style="margin-left:-10px;margin-top:15px;width:299px;" value="' . get_string('refresh', 'block_scholarship') . '" />';

    $DB->delete_records('block_scholarship', array("id" => $remove));
    $DB->delete_records('block_scholarship_courses', array("scholarshipid" => $remove));
    $removedocs = $DB->get_records('block_scholarship_doc', array("scholarshipid" => $remove));
    foreach ($removedocs as $rd)
        $DB->delete_records('block_scholarship_document', array("id" => $rd->documentid));

    $DB->delete_records('block_scholarship_doc', array("scholarshipid" => $remove));

    $sfiles = $DB->get_records('block_scholarship_doc_upload', array("scholarshipid" => $remove));

    foreach ($sfiles as $df) {
        $sfile = get_file_storage();
        // Prepare file record object
        $sfileinfo = array(
            'component' => 'block_scholarship', // usually = table name
            'filearea' => 'block_scholarship_doc_upload', // usually = table name
            'itemid' => 1, // usually = ID of row in table
            'contextid' => 1, // ID of context
            'filepath' => '/' . $remove . 'scholarship' . $df->userid . '/', // any path beginning and ending in /
            'filename' => $df->filename); // any filename
        $sfiledelete = $sfile->get_file($sfileinfo['contextid'], $sfileinfo['component'], $sfileinfo['filearea'], $sfileinfo['itemid'], $sfileinfo['filepath'], $sfileinfo['filename']);

        if ($sfiledelete) {
            $sfiledelete->delete();
        }
    }
    $DB->delete_records('block_scholarship_doc_upload', array("scholarshipid" => $remove));
    $DB->delete_records('block_scholarship_users', array("scholarshipid" => $remove));
}


//Change courses - builds a list of courses that include the scholarship in order to fill appropriate checkboxes
if (($cc !== '0') && ($courses == '-1')) {
    $checked = $DB->get_records('block_scholarship_courses', array("scholarshipid" => $cc));
    foreach ($checked as $ch)
        echo $ch->courseid . ',';
}


//Change courses
if (($cc !== '0') && ($courses !== '-1')) {
    $getyear = $DB->get_record('block_scholarship', array("id" => $cc));
    $DB->delete_records('block_scholarship_courses', array("scholarshipid" => $cc));
    $record = new stdClass();
    if ($courses == '0') {
        $record->scholarshipid = $cc;
        $record->yearid = $getyear->scholarshiptype;
        $record->courseid = 0;
        $DB->insert_record('block_scholarship_courses', $record);
        echo get_string('scholarshipadded', 'block_scholarship');
        echo '<br/><br/><pre>-' . get_string('allcourses', 'block_scholarship') . '</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">' . get_string('refreshpage', 'block_scholarship') . '</p>';
        echo '<input type="button" class="newbutton" onclick="window.location.reload()" style="margin-left:-10px;margin-top:15px;width:283px;" value="' . get_string('refresh', 'block_scholarship') . '" />';
    } else {
        $arraycourse = explode(",", $courses, -1);
        foreach ($arraycourse as $ac) {
            $record->scholarshipid = $cc;
            $record->yearid = $getyear->scholarshiptype;
            $record->courseid = $ac;
            $DB->insert_record('block_scholarship_courses', $record);
        }
        echo get_string('scholarshipadded', 'block_scholarship');
        echo '<pre>';
        foreach ($arraycourse as $ac) {
            $acname = $DB->get_record('block_scholarship_courselist', array("id" => $ac), 'coursename');
            echo "<br/>-" . $acname->coursename;
        }
        echo '</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">' . get_string('refreshpage', 'block_scholarship') . '</p>';
        echo '<input type="button" class="newbutton" onclick="window.location.reload()" style="margin-left:-10px;margin-top:15px;width:282px;" value="' . get_string('refresh', 'block_scholarship') . '" />';
    }
}


//Creating new course
if ($coursename !== '0') {
    $decode = urldecode($coursename);
    if ($coursename == '') {
        echo get_string('errorempty', 'block_scholarship');
    } else if (is_object($DB->get_record('block_scholarship_courselist', array('coursename' => $decode)))) {
        echo get_string('coursenametaken', 'block_scholarship');
    } else if (($coursename !== '0') && isset($decode)) {
        $record = new stdClass();
        $record->coursename = $decode;
        $DB->insert_record('block_scholarship_courselist', $record);
        echo get_string('courseadded', 'block_scholarship');
    }
}


//generates message for deleted courses
if ($message !== '0') {
    $dmessage = explode(",", $message, -1);

    foreach ($dmessage as $m) {
        $dname = $DB->get_record('block_scholarship_courselist', array("id" => $m), 'coursename');
        echo "-" . $dname->coursename . "<br/>";
    }
}


//Deleting courses
if ($delete !== '0') {
    $deletearray = explode(",", $delete, -1);

    echo get_string('coursesdeleted', 'block_scholarship');
    echo '<br/><br/>';
    echo '<pre style="color:white;margin-left:10px;margin-bottom:10px;">';
    foreach ($deletearray as $d) {
        $delname = $DB->get_record('block_scholarship_courselist', array("id" => $d), 'coursename');
        echo "-" . $delname->coursename . "<br/>";
    }
    echo '</pre>';
    echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">' . get_string('refreshpage', 'block_scholarship') . '</p>';
    echo '<input type="button" id="refresh" class="newbutton" onclick="window.location.reload()" style="width:283px;margin-left:-10px;margin-top:3px;" value="' . get_string('refresh', 'block_scholarship') . '" />';

    foreach ($deletearray as $del)
        $DB->delete_records('block_scholarship_courselist', array("id" => $del));

    foreach ($deletearray as $del)
        $DB->delete_records('block_scholarship_courses', array("courseid" => $del));
}


//Checks if scholarship/course name is already taken
if ($check !== '0') {
    if (is_object($DB->get_record('block_scholarship', array('name' => $check))))
        echo get_string('nametaken', 'block_scholarship');
    else
        echo 'Good';
}


//Listing scholarships by program
if ($list !== '-1') {
    echo '<div style="height:13px;"></div><b style="text-decoration:underline;font-size:25px;margin-left:15px;color:black;">' . get_string('pluginname', 'block_scholarship') . '</b><br/><br/>';
    if ($year != 3) {
        if ($list == '0') {
            echo '<p style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">' . get_string('allcourses', 'block_scholarship') . ':</p>';
            $slist = $DB->get_records_sql('SELECT * FROM mdl_block_scholarship
                                            WHERE scholarshiptype IN (' . $year . ', 3)
                                            ORDER BY name');
            foreach ($slist as $s) {
                echo '<a class="list" onclick="show_info($(this))" href="#" value="' . $s->id . '">- ' . $s->name . '</a>';
            }
        } else {
            $coname = $DB->get_record('block_scholarship_courselist', array("id" => $list));
            echo '<p id="coursename" style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">' . $coname->coursename . ':</p>';
            $slist = $DB->get_records_sql('SELECT DISTINCT scholarship.name, scholarship.id, scholarship.opendate, scholarship.enddate 
                                           FROM mdl_block_scholarship as scholarship
                                           JOIN mdl_block_scholarship_courses as courses ON scholarship.id=courses.scholarshipid
                                           WHERE courses.courseid IN (' . $list . ', 0) AND courses.yearid IN (' . $year . ', 3) 
                                           ORDER BY scholarship.name');
            foreach ($slist as $s) {
                echo '<a class="list" onclick="show_info($(this))" href="#" value="' . $s->id . '">- ' . $s->name . '</a>';
            }
        }
    } else {
        if ($list == '0') {
            echo '<p style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">' . get_string('allcourses', 'block_scholarship') . ':</p>';
            $slist = $DB->get_records('block_scholarship', array(), 'name');
            foreach ($slist as $s) {
                echo '<a class="list" onclick="show_info($(this))" href="#" value="' . $s->id . '">- ' . $s->name . '</a>';
            }
        } else {
            $coname = $DB->get_record('block_scholarship_courselist', array("id" => $list));
            echo '<p id="coursename" style="color:black;font-variant:small-caps;font-size:20px;padding-left:15px;">' . $coname->coursename . ':</p>';
            $slist = $DB->get_records_sql('SELECT DISTINCT scholarship.name, scholarship.id 
                                           FROM mdl_block_scholarship as scholarship
                                           JOIN mdl_block_scholarship_courses as courses ON scholarship.id=courses.scholarshipid
                                           WHERE courses.courseid IN (' . $list . ', 0)
                                           ORDER BY scholarship.name');
            foreach ($slist as $s) {
                echo '<a class="list" onclick="show_info($(this))" href="#" value="' . $s->id . '">- ' . $s->name . '</a>';
            }
        }
    }
}


//Show Scholarship information
if ($info !== '0') {
    $sinfo = $DB->get_record('block_scholarship', array("id" => $info));

    echo '<input type="button" class="newbutton" onclick="edit_scholarship(' . $year . ')" style="margin-left:-15px;margin-top:10px;margin-bottom:5px;width:282px;" value="' . get_string('editscholarship', 'block_scholarship') . '" /><br/>';
    echo '<input type="button" class="newbutton" onclick="delete_scholarship()" style="margin-left:-15px;margin-top:0px;margin-bottom:5px;width:282px;" value="' . get_string('removescholarship', 'block_scholarship') . '" /><br/><br/>';
    echo '<input type="button" class="newadd" onclick="change_courses()" style="font-size:13px;margin-left:-15px;margin-bottom:5px;width:282px;" value="' . get_string('changecourses', 'block_scholarship') . '" />';
    echo '<input type="button" class="newadd" onclick="change_documents()" style="font-size:13px;margin-left:-15px;margin-bottom:25px;width:282px;" value="' . get_string('changedocuments', 'block_scholarship') . '" /><br/>';
    echo '<input type="button" class="yellowbtn" onclick="show_dd()" style="color:white;font-size:14px;margin-left:-15px;margin-bottom:25px;height:30px;width:282px;font-weight:bold;border:2px lightgrey outset;" value="' . get_string('deletedocs', 'block_scholarship') . '" /><br/>';
    echo '<b style="color:black;">' . get_string('name', 'block_scholarship') . ':</b><br/>';
    echo '<p id="' . $sinfo->id . '" name="scholname" style="font-weight:normal;color:black;">' . $sinfo->name . '</p><br/>';
    echo '<b style="color:black;">' . get_string('amount', 'block_scholarship') . ':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">' . $sinfo->amount . '</p><br/>';
    echo '<b style="color:black;">' . get_string('value', 'block_scholarship') . ':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">' . $sinfo->value . '</p><br/>';
    echo '<b style="color:black;">' . get_string('activefrom', 'block_scholarship') . ':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">' . date("F j, Y", $sinfo->opendate) . ' - ' . date("F j, Y", $sinfo->enddate) . '</p><br/>';
    echo '<b style="color:black;">' . get_string('type', 'block_scholarship') . ':</b><br/>';
    switch ($sinfo->scholarshiptype) {
        case 1:
            echo '<p style="font-weight:normal;color:black;">' . get_string('firstyear', 'block_scholarship') . '</p><br/>';
            break;
        case 2:
            echo '<p style="font-weight:normal;color:black;">' . get_string('secondyear', 'block_scholarship') . '</p><br/>';
            break;
        case 3:
            echo '<p style="font-weight:normal;color:black;">' . get_string('all', 'block_scholarship') . '</p><br/>';
            break;
    }
    echo '<b style="color:black;">' . get_string('description', 'block_scholarship') . ':</b><br/>';
    echo '<p style="font-weight:normal;color:black;">' . $sinfo->description . '</p><br/>';
}


//Edit scholarship info (not courses and documents)
if ($edit !== '0') {
    $sedit = $DB->get_record('block_scholarship', array("id" => $edit));

    echo '<div style="padding-left:10px;padding-top:10px;color:black;">';
    echo '<div id="blink" style="background-color:dimgray;width:299px;height:45px;border:1px black solid;color:white;margin-left:-11px;margin-top:-11px;"><p id="instr2" class="' . get_string('fillevery', 'block_scholarship') . '" style="padding:5px;">' . get_string('fillevery', 'block_scholarship') . '</p></div><br/>';
    echo get_string('name', 'block_scholarship') . ':<br/><input type="text" id="scholarshipnameedit" value="' . $sedit->name . '" /><br/><br/>';
    echo get_string('amount', 'block_scholarship') . ':<br/><input type="text" id="scholarshipamountedit" style="width:60px;" value="' . $sedit->amount . '" /><br/><br/>';
    echo get_string('value', 'block_scholarship') . ':<br/><input type="text" id="scholarshipvalueedit" style="width:60px;" value="' . $sedit->value . '" /><br/><br/>';
    echo get_string('opendate', 'block_scholarship') . '<br/>';
    echo '<input name="opendate" class="openedit datepicker" id="openedit" size="14" type="text" value="' . date('m/d/Y', $sedit->opendate) . '" datepicker_format="YYYY-MM-DD"><br/>';
    echo get_string('closingdate', 'block_scholarship') . '<br/>';
    echo '<input name="enddate" class="endedit datepicker" id="closeedit" size="14" type="text" value="' . date('m/d/Y', $sedit->enddate) . '" datepicker_format="YYYY-MM-DD"><br/><br/>';
    $one = '';
    $two = '';
    $three = '';
    switch ($sedit->scholarshiptype) {
        case 1:
            $one = 'selected';
            break;
        case 2:
            $two = 'selected';
            break;
        case 3:
            $three = 'selected';
            break;
    }
    echo get_string('type', 'block_scholarship');
    echo '<select id="scholarshiptypeedit" name="scholarshiptype" style="width:230px;">';
    echo '<option value="1" ' . $one . '>' . get_string('firstyear', 'block_scholarship') . '</option>';
    echo '<option value="2" ' . $two . '>' . get_string('secondyear', 'block_scholarship') . '</option>';
    echo '<option value="3" ' . $three . '>' . get_string('all', 'block_scholarship') . '</option>';
    echo '</select><br/><br/>';
    echo get_string('description', 'block_scholarship') . ':<br/><textarea rows="10" cols="33" id="scholarshipdescriptionedit" style="resize:none;">' . $sedit->description . '</textarea><br/>';
    echo '<input type="button" id="changevalues" class="newadd" onclick="change_info(' . $sedit->id . ')" value="' . get_string('continue', 'block_scholarship') . '" style="margin-left:-10px;width:299px;margin-top:-2px;" /><br/>';
    echo '<input type="button" id="canceledit" class="newbutton" onclick="cancel_edit()" style="width:300px;margin-left:-10px;margin-top:3px;" value="' . get_string('cancel', 'block_scholarship') . '" />';
    echo '</div>';
}


//Edit scholarship
if (($name !== '0') && ($change == 'true')) {
    $record = new stdClass();
    $ychange = $DB->get_record('block_scholarship', array("id" => $sid));
    if ($ychange->scholarshiptype !== $type) {
        $clist = $DB->get_records('block_scholarship_courses', array("scholarshipid" => $sid));

        foreach ($clist as $cl) {
            $record->scholarshipid = $sid;
            $record->yearid = $type;
            $record->courseid = $cl->courseid;
            $record->id = $cl->id;
            $DB->update_record('block_scholarship_courses', $record);
        }
    }

    $opentime = strtotime($open . ' 00:00:00');
    $closetime = strtotime($close . ' 00:00:00');

    $record->name = $name;
    $record->amount = $amount;
    $record->value = $value;
    $record->opendate = $opentime;
    $record->enddate = $closetime;
    $record->scholarshiptype = $type;
    $record->description = $desc;
    $record->timecreated = time();
    $record->timemodified = time();
    $record->id = $sid;
    $DB->update_record('block_scholarship', $record);

    echo get_string('changesmade', 'block_scholarship');
}


//Creating scholarship
if (($name !== '0') && ($change !== 'true')) {
    $opentime = strtotime($open . ' 00:00:00');
    $closetime = strtotime($close . ' 00:00:00');

    $record = new stdClass();
    $record->name = $name;
    $record->amount = $amount;
    $record->value = $value;
    $record->opendate = $opentime;
    $record->enddate = $closetime;
    $record->scholarshiptype = $type;
    $record->description = $desc;
    $record->timecreated = time();
    $record->timemodified = time();
    $DB->insert_record('block_scholarship', $record);
    $id = $DB->get_record('block_scholarship', array('name' => $name), 'id');


    $record = new stdClass();
    $insert = new stdClass();
    if ($doc !== '0') {
        $docstring = explode(".", $doc, -1);
        $ind = 0;
        foreach ($docstring as $ds) {
            $documents->$ind = explode(",", $ds);
            $ind++;
        }
        $docname = '';
        $docdesc = '';
        foreach ($documents as $docs) {
            $docname = $docs[0];
            $docdesc = $docs[1];

            $record->name = $docname;
            $record->description = $docdesc;
            $record->timemodified = time();
            $DB->insert_record('block_scholarship_document', $record);
            $did = $DB->get_record('block_scholarship_document', array('name' => $docname), 'id');

            $insert->scholarshipid = $id->id;
            $insert->documentid = $did->id;
            $insert->timemodified = time();
            $DB->insert_record('block_scholarship_doc', $insert);
        }
    }


    $record = new stdClass();
    if ($courses == '0') {
        $record->scholarshipid = $id->id;
        $record->yearid = $type;
        $record->courseid = $courses;
        $DB->insert_record('block_scholarship_courses', $record);
    } else {
        $coursearray = explode(",", $courses, -1);

        foreach ($coursearray as $course) {
            $record->scholarshipid = $id->id;
            $record->yearid = $type;
            $record->courseid = $course;
            $DB->insert_record('block_scholarship_courses', $record);
        }
    }
    echo get_string('scholarshipadded', 'block_scholarship');
    if ($courses == '0') {
        echo '<br/><pre>-' . get_string('allcourses', 'block_scholarship') . '</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">' . get_string('refreshpage', 'block_scholarship') . '</p>';
        echo '<input type="button" class="newbutton" onclick="window.location.reload()" style="margin-left:-10px;margin-top:15px;width:283px;" value="' . get_string('refresh', 'block_scholarship') . '" />';
    } else {
        echo '<pre>';
        foreach ($coursearray as $course) {
            $cname = $DB->get_record('block_scholarship_courselist', array("id" => $course), 'coursename');
            echo "<br/>-" . $cname->coursename;
        }
        echo '</pre>';
        echo '<p style="color:darkorange;width:250px;font-weight:normal;margin-top:20px;">' . get_string('refreshpage', 'block_scholarship') . '</p>';
        echo '<input type="button" class="newbutton" onclick="window.location.reload()" style="margin-left:-10px;margin-top:15px;width:283px;" value="' . get_string('refresh', 'block_scholarship') . '" />';
    }
}
?>
