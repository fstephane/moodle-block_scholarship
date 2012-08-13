<?php

function print_content_header($style) {
    $styles = 'style="' . $style . '"';
    echo '<div class="cornerBox" ' . $styles . '>' . "\n";
    echo '<div class="corner TL"></div>' . "\n";
    echo '<div class="corner TR"></div>' . "\n";
    echo '<div class="corner BL"></div>' . "\n";
    echo '<div class="corner BR"></div>' . "\n";
    echo '	<div class="cornerBoxInner">' . "\n";

    return;
}

function print_content_footer() {
    echo ' </div>' . "\n"; //cornerbox inner 1
    echo '</div>' . "\n"; //cornerbox

    return;
}

function print_inner_content_header($style) {

    $styles = 'style="' . $style . '"';
    echo '<div class="lightcornerBox" ' . $styles . '">' . "\n";
    echo '<div class="lightcorner TL"></div>' . "\n";
    echo '<div class="lightcorner TR"></div>' . "\n";
    echo '<div class="lightcorner BL"></div>' . "\n";
    echo '<div class="lightcorner BR"></div>' . "\n";
    echo '	<div class="cornerBoxInner">' . "\n";

    return;
}

function print_inner_content_footer() {
    echo ' </div>' . "\n"; //lightcornerbox inner
    echo '</div>' . "\n"; //lightcornerbox

    return;
}

//********************scholarship administration*************************
function print_add_scholarship_form() {
    global $CFG, $COURSE, $PAGE;
    echo '   <form name="addscholarship" action="add.php">' . "\n";
    //hidden values for the form
    echo '<input type="hidden" name="submitted" value="yes">';
    echo '<input type="hidden" id="DPC_TODAY_TEXT" value="' . get_string('today', 'block_scholarship') . '">' . "\n";
    echo '<input type="hidden" id="DPC_BUTTON_TITLE" value="' . get_string('opencalendar', 'block_scholarship') . '">' . "\n";
    echo '<input type="hidden" id="DPC_MONTH_NAMES" value="' . get_string('monthnames', 'block_scholarship') . '">' . "\n";
    echo '<input type="hidden" id="DPC_DAY_NAMES" value="' . get_string('daynames', 'block_scholarship') . '">' . "\n";
    echo '   <table align="center" style="text-align: left; width: 60%;" border="0" cellpadding="2" cellspacing="2">' . "\n";
    echo '     <tbody>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('name', 'block_scholarship') . '</td>' . "\n";
    echo '         <td>' . get_string('amount', 'block_scholarship') . '</td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td><input name="name"></td>' . "\n";
    echo '         <td><input name="amount"></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('description', 'block_scholarship') . '</td>' . "\n";
    echo '         <td>' . get_string('multiple', 'block_scholarship') . '<input type="checkbox" name="multiple" value="1"></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td style="vertical-align: top;" colspan="1" rowspan="5">' . "\n";
    print_textarea(true, 20, 60, 680, 400, 'description', '', $COURSE->id);
    echo '         <td colspan="1" rowspan="5" valign="top">' . "\n";
    echo '       ' . get_string('opendate', 'block_scholarship') . '<br>' . "\n";
    echo '        <input name="opendate" id="DPC_date1" size="14" type="text" datepicker_format="YYYY-MM-DD"><p>' . "\n";
    echo '       ' . get_string('closingdate', 'block_scholarship') . '<br>' . "\n";
    echo '        <input name="enddate" id="DPC_date2" size="14" type="text" datepicker_format="YYYY-MM-DD"><p>' . "\n";
    echo '         ' . get_string('type', 'block_scholarship') . '<br>' . "\n";
    echo '         <select name="scholarshiptype">' . "\n";
    echo '           <option value="" selected></option>' . "\n";
    echo '          <option value="1">' . get_string('firstyear', 'block_scholarship') . '</option>' . "\n";
    echo '          <option value="2">' . get_string('secondyear', 'block_scholarship') . '</option>' . "\n";
    echo '          <option value="3">' . get_string('all', 'block_scholarship') . '</option>' . "\n";
    echo '         </select><p>' . "\n";
    echo '         <input type="submit" name="submit" value="submit">' . "\n";
    echo '         </td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '       </tr>' . "\n";
    echo '     </tbody>' . "\n";
    echo '   </table>' . "\n";
    echo '	</form>' . "\n";
    use_html_editor();
    return;
}

function print_edit_scholarship_form($id) {
    global $CFG, $DB, $COURSE;

    //Retrieve record data
    $scholarship = $DB->get_record('block_scholarship', array("id" => $id), 'name, description, opendate, enddate, amount, multiple, scholarshiptype');

    //Get documents
    $documents = $DB->get_records('block_scholarship_doc', array("scholarshipid" => $id), 'id, scholarshipid, documentid');

    echo '   <form name="editscholarship" action="edit.php">' . "\n";
    //hidden values for the form
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="submitted" value="yes">';
    echo '<input type="hidden" id="DPC_TODAY_TEXT" value="' . get_string('today', 'block_scholarship') . '">' . "\n";
    echo '<input type="hidden" id="DPC_BUTTON_TITLE" value="' . get_string('opencalendar', 'block_scholarship') . '">' . "\n";
    echo '<input type="hidden" id="DPC_MONTH_NAMES" value="' . get_string('monthnames', 'block_scholarship') . '">' . "\n";
    echo '<input type="hidden" id="DPC_DAY_NAMES" value="' . get_string('daynames', 'block_scholarship') . '">' . "\n";
    echo '   <table align="center" style="text-align: left; width: 60%;" border="0" cellpadding="2" cellspacing="2">' . "\n";
    echo '     <tbody>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('name', 'block_scholarship') . '</td>' . "\n";
    echo '         <td>' . get_string('amount', 'block_scholarship') . '</td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td><input name="name" value="' . $scholarship->name . '"></td>' . "\n";
    echo '         <td><input name="amount" value="' . $scholarship->amount . '"></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('description', 'block_scholarship') . '</td>' . "\n";
    if ($scholarship->multiple == 1) {
        $checked = ' checked';
    }
    else
        $checked = '';
    echo '         <td>' . get_string('multiple', 'block_scholarship') . '<input type="checkbox" name="multiple" value="1"' . $checked . '></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td style="vertical-align: top;" colspan="1" rowspan="5">' . "\n";
    print_textarea(true, 20, 60, 680, 400, 'description', $scholarship->description, $COURSE->id);
    echo '         <td colspan="1" rowspan="5" valign="top">' . "\n";
    echo '       ' . get_string('opendate', 'block_scholarship') . '<br>' . "\n";
    echo '        <input name="opendate" id="DPC_date1" size="14" type="text" datepicker_format="YYYY-MM-DD" value="' . date("Y-m-d", $scholarship->opendate) . '"><p>' . "\n";
    echo '       ' . get_string('closingdate', 'block_scholarship') . '<br>' . "\n";
    echo '        <input name="enddate" id="DPC_date2" size="14" type="text" datepicker_format="YYYY-MM-DD" value="' . date("Y-m-d", $scholarship->enddate) . '"><p>' . "\n";
    echo '         ' . get_string('type', 'block_scholarship') . '<br>' . "\n";

    echo '<select name="scholarshiptype">' . "\n";
    if ($scholarship->scholarshiptype == 1) {
        echo '<option value="1" selected>' . get_string('firstyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="2">' . get_string('secondyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="3">' . get_string('all', 'block_scholarship') . '</option>' . "\n";
    }
    if ($scholarship->scholarshiptype == 2) {
        echo '<option value="1">' . get_string('firstyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="2" selected>' . get_string('secondyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="3">' . get_string('all', 'block_scholarship') . '</option>' . "\n";
    }
    if ($scholarship->scholarshiptype == 3) {
        echo '<option value="1">' . get_string('firstyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="2">' . get_string('secondyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="3" selected>' . get_string('all', 'block_scholarship') . '</option>' . "\n";
    }
    if (empty($scholarship->scholarshiptype)) {
        echo '<option value="" selected></option>' . "\n";
        echo '<option value="1">' . get_string('firstyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="2">' . get_string('secondyear', 'block_scholarship') . '</option>' . "\n";
        echo '<option value="3">' . get_string('all', 'block_scholarship') . '</option>' . "\n";
    }
    echo '         </select><p>' . "\n";
    echo '         <input type="submit" name="submit" value="submit">' . "\n";
    echo '         </td>' . "\n";
    echo '       </tr>' . "\n";
    echo '     </tbody>' . "\n";
    echo '   </table>' . "\n";
    echo '	</form>' . "\n";
    //*********************Start document box*********************
    //*********************Document box content*********************
    print_string('documents', 'block_scholarship');

    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">' . "\n";
    echo '<tbody>' . "\n";
    echo '	<tr>' . "\n";
    echo '		  <td>' . get_string('name', 'block_scholarship') . '</td>' . "\n";
    echo '		  <td></td>' . "\n";
    echo '	</tr>' . "\n";

    //used to change row colors
    $i = 1;
    foreach ($documents as $document) {

        //Get document name and description
        $docinfo = $DB->get_record('block_scholarship_document', 'id', $document->documentid);

        if ($i % 2) {
            $bgcolor = ' bgcolor = "#E9E9E9" ';
        } else {
            $bgcolor = '';
        }
        echo '	<tr' . $bgcolor . '>' . "\n";
        echo '	  <td><a href="editdoc.php?id=' . $docinfo->id . '&scholarshipid=' . $id . '">' . $docinfo->name . '</a></td>' . "\n";
        echo '	  <td>' . $docinfo->description . '</td>' . "\n";
        echo '	  <td><a href="editdoc.php?id=' . $document->id . '&delete=yes&scholarshipid=' . $id . '">' . get_string('delete', 'block_scholarship') . '</a></td>' . "\n";
        echo '	</tr>' . "\n";
        $i = $i + 1;
    }
    echo '	<tr>' . "\n";
    echo '	  <td></td>' . "\n";
    echo '	  <td></td>' . "\n";
    echo '	  <td><br><input type="button" name="adddoc" value="' . get_string('adddocument', 'block_scholarship') . '" onclick="window.location=\'adddoc.php?id=' . $id . '\'"></td>' . "\n";
    echo '	</tr>' . "\n";
    echo '  </tbody>' . "\n";
    echo '</table>' . "\n";

    //*********************Document box end content*********************
    //*********************End document box*********************
    use_html_editor();

    return;
}

function print_add_document_form($id) {
    global $CFG;
    //Get documents. Used to fill in select field
    $documents = $DB->get_records('block_scholarship_document');

    echo '   <div class="mform fieldset">';
    echo '   <form name="adddoc" action="adddoc.php">' . "\n";
    //hidden values for the form
    echo '<input type="hidden" name="submitted" value="yes">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '   <table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">' . "\n";
    echo '     <tbody>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('selectexisting', 'block_scholarship') . '</td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td><select name="existingdoc">' . "\n";
    echo '             <option value=""></option>' . "\n";
    foreach ($documents as $document) {
        echo '<option value="' . $document->id . '" >' . $document->name . '</option>' . "\n";
    }
    echo '             </select>' . "\n";
    echo '         </td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('name', 'block_scholarship') . '</td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td><input name="name"></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('description', 'block_scholarship') . '</td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . "\n";
    print_textarea(true, 20, 60, 680, 400, 'description', '', $COURSE->id);
    echo '         </td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td colspan="2" rowspan="1"><input type="submit" name="submit" value="submit"></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '     </tbody>' . "\n";
    echo '   </table>' . "\n";
    echo '	</form>' . "\n";
    use_html_editor();
    return;
}

function print_edit_document_form($id, $scholarshipid) {
    global $CFG;
    //get document
    $document = $DB->get_record('block_scholarship_document', 'id', $id);

    print_string('documenteditwarning', 'block_scholarship');
    echo '   <form name="adddoc" action="editdoc.php">' . "\n";
    //hidden values for the form
    echo '<input type="hidden" name="submitted" value="yes">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="scholarshipid" value="' . $scholarshipid . '">';
    echo '   <table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">' . "\n";
    echo '     <tbody>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('name', 'block_scholarship') . '</td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td><input name="name" value="' . $document->name . '"></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . get_string('description', 'block_scholarship') . '</td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td>' . "\n";
    print_textarea(true, 20, 60, 680, 400, 'description', $document->description, $COURSE->id);
    echo '         </td>' . "\n";
    echo '       </tr>' . "\n";
    echo '       <tr>' . "\n";
    echo '         <td colspan="2" rowspan="1"><input type="submit" name="submit" value="submit"></td>' . "\n";
    echo '       </tr>' . "\n";
    echo '     </tbody>' . "\n";
    echo '   </table>' . "\n";
    echo '	</form>' . "\n";
    use_html_editor();
}

function print_view_user_scholarships($id, $userid, $selected) {
    global $CFG, $USER, $COURSE, $DB;
    //$id = scholarshipid
    //$userid = user id
    //Get all scholarships
    $zero = 0;
    $scholarships = $DB->get_records_sql('SELECT id, name, description, amount, opendate, enddate FROM {block_scholarship} WHERE deleted=' . $zero);

//    if (!empty($id)){
//        //$scholarshipusers = $DB->get_records('block_scholarship_selected','scholarshipid',$id);
//        $scholarshipusers = $DB->get_records_sql('SELECT id, name, description, amount, opendate, enddate FROM {block_scholarship} WHERE id='.$id.'AND deleted='.$zero);
//    }
    //Scholarships
    foreach ($scholarships as $scholarship) {
        echo '<a href="' . $CFG->wwwroot . '/blocks/scholarship/admin/view.php?id=' . $scholarship->id . '&userid=0">' . $scholarship->name . '</a><br>';
    }
    if (!empty($id)) {
        //Users MUST HAVE STUDENTS APPLYING BEFORE THIS WILL WORK
        $userinfo = $DB->get_records('block_scholarship_users');
        foreach ($userinfo as $user)
            echo '<a href="' . $CFG->wwwroot . '/blocks/scholarship/admin/view.php?id=' . $id . '&userid=' . $userinfo->userid . '&selected=' . $userinfo->scholarshipid . '">' . $userinfo->firstname . ' ' . $userinfo->lastname . '</a><br>';
    }

    echo '<div style="clear:both;"></div>';
    //Edit view documents
    if ((!$id == 0) && (!$userid == 0)) {
        //Get scholarship information to pront out scholarship name ect
        $scholarshipinfo = $DB->get_record('block_scholarship', array("id" => $id));
        //Get specific user info so we can print name
        $userdetails = $DB->get_record('user', array("id" => $userid));
        //get scholarship docments
        $scholarshipdocuments = $DB->get_records('block_scholarship_doc', array("scholarshipid" => $id));

        $countscholarshipdocuments = $DB->count_records('block_scholarship_doc', array("scholarshipid" => $id));
        //get user documents for scholarship
        //I used the get_records_sql because for whatever reason get_records would not work... don't know why.
        $userdocssql = 'SELECT * FROM ' . $CFG->dbname . '.' . $CFG->prefix . 'block_scholarship_doc_upload
                        WHERE userid=' . $userid . '
                        AND scholarshipid=' . $id;

        $userdocs = $DB->get_records_sql($userdocssql);

        $countuserdocuments = $DB->count_records('block_scholarship_doc_upload', array("scholarshipid" => $id, "userid" => $userid));
        $countuserdocumentsreceived = $DB->count_records('block_scholarship_doc_upload', array("scholarshipid" => $id, "userid" => $userid, "reveived" => 1));

        echo get_string('viewing', 'block_scholarship') . $userdetails->firstname . ' ' . $userdetails->lastname . ' -> ' . $scholarshipinfo->name . '<p>';


        $count = 0;
        //get all documents and verify if user has submitted
        foreach ($scholarshipdocuments as $document) {

            $count = $count + 1;
            $userdoc = $DB->get_record('block_scholarship_doc_upload', 'userid', $userid, 'docid', $document->documentid);
            $docname = $DB->get_record('block_scholarship_document', 'id', $document->documentid);
            echo '<form name="receivedform' . $count . '" method="get">';
            echo '<input type="hidden" name="userdocid" value="' . $userdoc->id . '">';
            echo '<input type="hidden" name="submitted" value="yes">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="userid" value="' . $userid . '">';
            echo '<input type="hidden" name="docid" value="' . $userdoc->docid . '">';
            //if document mailed don't write link
            if (($userdoc->mail == 1) OR (empty($userdoc->mail))) {
                echo $docname->name;
            } else { //removed '.$COURSE->id.' so that files upload into course 1
                echo '<a href="' . $CFG->wwwroot . '/file.php/1/block_scholarship/' . $userid . '/' . $userdoc->folder . '/' . $userdoc->filename . '" title="' . get_string('viewdocument', 'block_scholarship') . '">' . $docname->name . '</a>';
            }


            if ($userdoc->received == 1) {
                if ($userdoc->mail == 1) {
                    echo ' -> ' . get_string('documentreceived', 'block_scholarship') . ' (' . get_string('bymail', 'block_scholarship') . ')';
                } else {
                    echo ' -> ' . get_string('documentreceived', 'block_scholarship') . ' (' . get_string('viewdocument', 'block_scholarship') . ')';
                }
            } else {
                echo ' -> ' . get_string('received', 'block_scholarship') . '<input type="checkbox" name="received" value="1" onClick="document.receivedform' . $count . '.submit()">';
                if ($userdoc->mail == 1) {
                    echo ' (' . get_string('bymail', 'block_scholarship') . ')';
                } else {
                    echo '';
                }
            }
            echo '</form>';
        }
    } else {
        echo '';
    }

    if (isset($countuserdocumentsreceived)) {
        if ($countuserdocuments == $countuserdocumentsreceived) {

            //get selected scholarship info
            $selectedinfo = $DB->get_record('block_scholarship_selected', 'id', $selected);
            if ($selectedinfo->awarded == 1) {
                echo get_string('awarded', 'block_scholarship');
            }
            echo '<form name="award" action="view.php" method="GET">';
            echo '<input type="hidden" name="selected" value="' . $selected . '">';
            echo '<input type="hidden" name="awarded" value="1">';
            echo '<input type="hidden" name="userid" value="' . $userid . '">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="submittedaward" value="yes">';
            $subject = str_replace("'", "\'", $scholarshipinfo->name);
            echo '<input type="submit" name="submit" value="' . get_string('award', 'block_scholarship') . '" onClick="emaildoc(\'' . $userdetails->email . '\',\'' . $subject . '\');">';
            echo '</form>';
            //echo '<input type="button" value="'.get_string('award','block_scholarship').'" onclick="window.location.replace(\'mailto:'.$userdetails->email.'?subject='.$scholarshipinfo->name.'\');document.award.submit();">'."\n";
        }
    }
}

//********************scholarship administration end*************************
//********************scholarship selected *************************

function print_available_scholarships($id, $yearid) {
    global $CFG, $USER, $DB;
    $zero = '0';
    //verifiy if user has selected his what year they are in
    //$useryear = $DB->get_record('block_scholarship_year',array("userid" => $USER->id, "yearid" => $yearid, "deleted" => '0'));
    $useryear = $DB->get_records_sql('SELECT yearid 
                                      FROM {block_scholarship_year}
                                      WHERE userid=' . $USER->id . ' AND yearid=' . $yearid);
    if (!$useryear) {
        redirect($CFG->wwwroot . '/blocks/scholarship/user/year.php', '', 0);
    }

    //gather all data concerning particlar scholarships
    //first get all scholarships
    foreach ($useryear as $year)
        $availablescholarshipssql = 'SELECT * FROM ' . $CFG->prefix . 'block_scholarship WHERE scholarshiptype=3 OR scholarshiptype=' . $year->yearid;
    $scholarships = $DB->get_records_sql($availablescholarshipssql);

    //get detailed information for a specific scholarship
    if (!empty($id)) {
        $scholarshipdetails = $DB->get_record('block_scholarship', array("id" => $id));
    }

    //get documents needed for the scholarship
    $scholarshipdocuments = $DB->get_records('block_scholarship_doc', array("scholarshipid" => $id));
    //Document details must be added as a loop later in the code
    //Get user selected scholarships
    $userselected = $DB->get_records('block_scholarship_selected', array("userid" => $USER->id));
    //We need to determine if scholarship is available
    $now = time();
    if (isset($scholarshipdetails))
        $available = $scholarshipdetails->opendate < $now && ($now < $scholarshipdetails->enddate || !$scholarshipdetails->enddate);

    echo '<table border="0" width="100%">' . "\n";
    echo ' <tr>' . "\n";
    echo '   <td>' . "\n";
    print_string('availableinstructions', 'block_scholarship');
    echo '   </td>' . "\n";
    foreach ($scholarships as $scholarship) {
        echo ' </tr>' . "\n";
        echo ' <tr>' . "\n";
        echo '   <td>' . "\n";
        echo '<a href="' . $CFG->wwwroot . '/blocks/scholarship/user/view.php?id=' . $scholarship->id . '&yearid=' . $yearid . '">' . $scholarship->name . '</a>';
        echo '   </td>' . "\n";
        echo ' </tr>' . "\n";
    }
    echo '</table>' . "\n";

    if (!empty($id)) {
        echo $scholarshipdetails->name . '<p>';
        echo get_string('valueof', 'block_scholarship') . '<br><b>' . $scholarshipdetails->amount . '</b><p>';
        echo get_string('availablefrom', 'block_scholarship') . '<br><b>' . date('Y-m-d', $scholarshipdetails->opendate) . ' ' . get_string('availabletoo', 'block_scholarship') . ' ' . date('Y-m-d', $scholarshipdetails->enddate) . '</b><p>';
        echo get_string('description', 'block_scholarship') . ':<br><b>';
        echo $scholarshipdetails->description . '</b><p>';
        //print out associated documents
        echo get_string('documents', 'block_scholarship') . ':<br>';
        foreach ($scholarshipdocuments as $document) {
            //Get actual document name and data
            $doc = $DB->get_record('block_scholarship_document', array("id" => $document->documentid));
            echo '<a href="' . $CFG->wwwroot . '/blocks/scholarship/user/scholarshipdocuments.php?id=' . $doc->id . '" target="_blank" title="' . $doc->description . '">' . $doc->name . '</a><br>';
        }
        if ($available) {
            echo '<form name="applyform" method="get" action="view.php">';
            echo '<input type="hidden" name="scholarshipid" value="' . $id . '">';
            echo '<input type="hidden" name="userid" value="' . $USER->id . '">';
            echo '<input type="hidden" name="submitted" value="yes">';
            echo '<br><input type="submit" value="' . get_string('applyforscholarship', 'block_scholarship') . '">';
            echo '</form>';
        }
    }

    echo '<div style="clear:both;"></div>';

    //print out scholarship that user has
    echo '<table width="100%" border="0" >';
    echo '  <tr>';
    echo '      <td colspan="3">';
    echo get_string('myscholarships', 'block_scholarship');
    echo '      </td>';
    echo '  </tr>';


    foreach ($userselected as $selected) {

        $scholar = $DB->get_record('block_scholarship', array("id" => $selected->scholarshipid));
        $doc_verification = $DB->count_records('block_scholarship_doc_upload', array("userid" => $USER->id, "scholarshipid" => $selected->scholarshipid, "selectedid" => $selected->id));
        $doc_received = $DB->count_records('block_scholarship_doc_upload', array("userid" => $USER->id, "scholarshipid" => $selected->scholarshipid, "received" => 1));
        //If number of docs received equals number of documents then all documents are received

        if ($doc_received == $doc_verification) {
            $received = 1;
        } else {
            $received = 0;
        }
        // echo 'userid='.$USER->id.'<br>';
        // echo 'scholarshipid ='.$selected->scholarshipid.'<br>';
        // echo 'doc_received='.$doc_received.'<br>';
        // echo 'doc_verification='.$doc_verification;
        $doc_info = $DB->get_record('block_scholarship_doc_upload', array("userid" => $USER->id, "scholarshipid" => $selected->scholarshipid, "selectedid" => $selected->id));
        //now retrive number of documents needed for this scholarship
        $numdocuments = $DB->count_records('block_scholarship_doc', array("scholarshipid" => $selected->scholarshipid));
        $numdocumentsleft = $numdocuments - $doc_verification;

        if ($doc_verification == $numdocuments) {
            $hide = '1';
        } else {
            $hide = '0';
        }
        echo '  <tr>';
        echo '      <td>';
        echo $scholar->name;
        echo '      </td>';
        echo '      <td>';

        if ($hide == 0) {
            echo get_string('note', 'block_scholarship') . ' ' . $numdocumentsleft . ' ' . get_string('numberofassociateeddocuments', 'block_scholarship') . '
               &nbsp;|&nbsp; <a href="upload.php?scholarshipid=' . $selected->scholarshipid . '&selectedid=' . $selected->id . '">' . get_string('uploaddoc', 'block_scholarship') . '</a>'; //scholarship id  needed to retrieve documents associated.
        } else {

            if ($received == 0) {
                echo get_string('maildocument', 'block_scholarship') . '<a href="' . $CFG->wwwroot . '/blocks/scholarship/adresse.php" target="_blank">' . get_string('maildocumentlink', 'block_scholarship') . '</a>';
            } else {
                print_string('alldocumentssent', 'block_scholarship');
            }
        }
        echo '      </td>';
        echo '      <td>';
        if ($selected->awarded == '1') {
            echo '<font color="#009900">' . get_string('awarded', 'block_scholarship') . '</font><br>';
        } else {
            echo ' <a href="' . $CFG->wwwroot . '/blocks/scholarship/user/view.php?id=' . $selected->scholarshipid . '&selectedid=' . $selected->id . '&delete=1">
                        <img src="' . $CFG->wwwroot . '/blocks/scholarship/pix/delete.gif" border="0" valign="middle" ></a><br>';
        }
        echo '      </td>';
    }
    echo '  </tr>';
    echo '</table>';
}

//********************scholarship selected end*************************
//********************scholarship administration*************************
function insert_record_scholarship($name, $description, $opendate, $enddate, $amount, $scholarshiptypeid, $multiple) {
    global $CFG, $DB;
    //convert string time to unix timestamp

    $opendatetime = strtotime($opendate . ' 00:00:00');
    $enddatetime = strtotime($enddate . ' 00:00:00');


    $insert = new object();
    $insert->name = $name;
    $insert->description = $description;
    $insert->opendate = $opendatetime;
    $insert->enddate = $enddatetime;
    $insert->amount = $amount;
    $insert->multiple = $multiple;
    $insert->scholarshiptype = $scholarshiptypeid;
    $insert->timecreated = time();
    $insert->timemodified = time();

    $newid = $DB->insert_record('block_scholarship', $insert, true);
    return $newid;

    //redirect($CFG->wwwroot.'/blocks/scholarship/admin/edit.php?id='.$newid, '', 0);
}

function update_record_scholarship($id, $name, $description, $opendate, $enddate, $amount, $scholarshiptypeid, $multiple) {
    global $CFG, $DB;
    //Date conversion to unix timestamp
    $opendatetime = strtotime($opendate . ' 00:00:00');
    $enddatetime = strtotime($enddate . ' 00:00:00');

    //after recording
    $update = new object();
    $update->id = $id;
    $update->name = $name;
    $update->description = $description;
    $update->opendate = $opendatetime;
    $update->enddate = $enddatetime;
    $update->multiple = $multiple;
    $update->amount = $amount;
    $update->scholarshiptype = $scholarshiptypeid;
    $update->timemodified = time();



    $DB->update_record('block_scholarship', $update);

    //redirect($CFG->wwwroot.'/blocks/scholarship/admin/edit.php?id='.$id, '', 0);
}

function delete_record_scholarship($id) {
    global $CFG, $DB, $OUTPUT;
    $update = new object();
    $update->id = $id;
    $update->deleted = 1;
    $DB->update_record('block_scholarship', $update);
    //redirect($CFG->wwwroot.'/blocks/scholarship/admin/manage.php', '', 0);
}

function insert_record_document($id, $existingdoc, $name, $description) {
    global $CFG, $DB;
    //first find out if it was from the selection menu
    //if it is insert record into scholarship_doc table,
    //otherwise create document and then insert record
    //into scholarship_doc
    if ($existingdoc > 0) {

        $insert = new object();
        $insert->scholarshipid = $id;
        $insert->documentid = $existingdoc;
        $insert->timemodified = time();

        $DB->insert_record('block_scholarship_doc', $insert);

        redirect($CFG->wwwroot . '/blocks/scholarship/admin/edit.php?id=' . $id, '', 0);
    } else {

        $insertdoc = new object();
        $insertdoc->name = $name;
        $insertdoc->description = $description;
        $insertdoc->timemodified = time();

        $docid = $DB->insert_record('block_scholarship_document', $insertdoc);
        //now enter all information into the shcolarship_doc table
        $insert = new object();
        $insert->scholarshipid = $id;
        $insert->documentid = $docid;
        $insert->timemodified = time();

        $DB->insert_record('block_scholarship_doc', $insert);

        redirect($CFG->wwwroot . '/blocks/scholarship/admin/edit.php?id=' . $id, '', 0);
    }
}

function update_record_document($id, $name, $description, $scholarshipid) {
    global $CFG;
    $update = new object();
    $update->id = $id;
    $update->name = $name;
    $update->description = $description;
    $update->scholarshipid = $scholarshipid;
    $update->timemodified = time();

    if (!$DB->update_record('block_scholarship_document', $update)) {
        echo 'Failed to save record!';
    }

    redirect($CFG->wwwroot . '/blocks/scholarship/admin/edit.php?id=' . $scholarshipid, '', 0);
}

//update user document record
function update_record_user_document($docid, $userdocid, $received, $id, $userid) {
    global $CFG, $DB;

    $update = new object();
    $update->id = $userdocid;
    $update->received = $received;

    $updatesql = 'UPDATE ' . $CFG->prefix . 'block_scholarship_doc_upload
                        SET received=' . $received . ' WHERE userid=' . $userid
            . ' AND docid=' . $docid;

    $DB->execute($updatesql);

    redirect($CFG->wwwroot . '/blocks/scholarship/admin/view.php?id=' . $id . '&userid=' . $userid, '', 0);
}

//update awarded scholarship
function update_record_user_awarded($selectedid, $awarded, $id, $userid) {
    global $CFG, $DB;

    $updateaward = new object();
    $updateaward->id = $selectedid;
    $updateaward->awarded = $awarded;

    if (!$DB->update_record('block_scholarship_selected', $updateaward)) {
        echo 'not saved';
        print_object($updateaward);
    }

    redirect($CFG->wwwroot . '/blocks/scholarship/admin/view.php?id=' . $id . '&userid=' . $userid . '&selected=' . $selectedid, '', 0);
}

//This delete functioin deletes the record association between the shoclarship table
//and the scholarship_doc table. It does NOT delete the actual document record
//found in the scholarship_document table
function delete_record_document_scholarship($id, $scholarshipid) {
    global $CFG;
    $DB->delete_records('block_scholarship_doc', 'id', $id);

    redirect($CFG->wwwroot . '/blocks/scholarship/admin/edit.php?id=' . $scholarshipid, '', 0);
}

//********************scholarship administration end*************************
//********************scholarship selected*************************

function insert_record_selected($scholarshipid, $userid) {
    global $CFG, $DB;
    //First thing is to verify if the user has already applied for the scholarship
    //Find out if scholarship has been selected
    $scholarshipselected = $DB->count_records('block_scholarship_selected', array("userid" => $userid, "scholarshipid" => $scholarshipid));
    //if count > 0 then search actual scholarship to find opendate closedate and if mutliple

    if ($scholarshipselected > 0) {
        $scholarship = $DB->get_record('block_scholarship', array("id" => $scholarshipid));
        $opendate = $scholarship->opendate;
        $enddate = $scholarship->enddate;
        $multiple = $scholarship->multiple;
        $today = time();

        //Check to see if multiple is allowed
        if ($multiple == 1) {
            //now check the dates. If it is within the same dates, then do not insert record
            if (($today >= $opendate) && ($today <= $enddate)) {
                echo '<script language="javascript">alert("' . get_string('applyonceonly', 'block_scholarship') . '")</script>';
                redirect($CFG->wwwroot . '/blocks/scholarship/user/view.php?id=' . $scholarshipid, '', 0);
            } else {
                $insert = new object();
                $insert->scholarshipid = $scholarshipid;
                $insert->userid = $userid;
                $insert->awarded = 0;
                $insert->timemodified = time();

                if (!$DB->insert_record('block_scholarship_selected', $insert)) {
                    echo 'Data was not saved';
                }

                redirect($CFG->wwwroot . '/blocks/scholarship/user/view.php?id=' . $scholarshipid, '', 0);
            }
        } else {
            echo '<script language="javascript">alert("' . get_string('applyonceonly', 'block_scholarship') . '")</script>';
            redirect($CFG->wwwroot . '/blocks/scholarship/user/view.php?id=' . $scholarshipid, '', 0);
        }
    } else {

        $insert = new object();
        $insert->scholarshipid = $scholarshipid;
        $insert->userid = $userid;
        $insert->awarded = 0;
        $insert->timemodified = time();

        if (!$DB->insert_record('block_scholarship_selected', $insert)) {
            echo "Data was not saved";
        }
    }
}

function delete_record_selected($id, $scholarshipid) {
    global $CFG, $DB;

    $DB->delete_records('block_scholarship_selected', array("id" => $id));
    $DB->delete_records('block_scholarship_doc_upload', array("selectedid" => $id));
}

function block_scholarship_pluginfile($course, $cm, $context, $filearea, array $args, $forcedownload) {

    global $DB, $CFG;

    $fileinfo = array(
        'component' => 'block_scholarship', // usually = table name
        'filearea' => $filearea, // usually = table name
        'itemid' => $args[1], // usually = ID of row in table
        'contextid' => $context->id, // ID of context
        'filepath' => '/' . $args[0] . '/', // any path beginning and ending in /
        'filename' => $args[2]); // any filename

    $fs = get_file_storage();
    $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
    
    header("Content-Type: " . $file->get_mimetype());
    header("Content-Length: " . $file->get_filesize());
    header("Content-Disposition: attachment; filename='{$fileinfo['filename']}'");
    
    $file->readfile();

    die();
}

//********************scholarship selected end*************************
?>
