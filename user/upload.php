<?php
require_once('../../../config.php');
require_once('../lib.php');
require_once($CFG->libdir.'/filelib.php');
require_once($CFG->dirroot.'/lib/uploadlib.php');
require_login(1, true);

global $CFG, $USER, $COURSE, $OUTPUT, $DB;
$PAGE->requires->js('/blocks/scholarship/lib/scholarship.js');

echo '<link rel="stylesheet" type="text/css" href="../style.php">';
echo '<link type="text/css" rel="stylesheet" href="'.$CFG->wwwroot.'/blocks/scholarship/datepickercontrol.css">';

$navlinks = array(

            array(
                'name'=>get_string('availablescholarships', 'block_scholarship'),
                'link'=>$CFG->wwwroot.'/blocks/scholarship/user/view.php',
                'type'=>'misc'
                ),
            array(
                'name'=>get_string('uploaddoc', 'block_scholarship'),
                'link'=>'',
                'type'=>'misc'
                )

         );

$nav = build_navigation($navlinks);
print_header(get_string('blockname','block_scholarship'),get_string('blockname','block_scholarship'),$nav);

//context needed for access rights
$context = get_context_instance(CONTEXT_USER, $USER->id);

//Check to see if user has access rights.
if (!has_capability('block/scholarship:user',$context)) {
	print_string('norights','block_scholarship');
  } else {
      $selectedid = optional_param('selectedid', 0, PARAM_INT);
      $scholarshipid = optional_param('scholarshipid', 0, PARAM_INT);
      $submitted = optional_param('submitted', 0, PARAM_TEXT);
      $docid = optional_param('docid', 0, PARAM_INT);
      $mail = optional_param('mail', 0, PARAM_INT);

       if ($submitted == "yes"){
       $now = time();
        
           make_mod_upload_directory($id);
                
                if (! $basedir = make_upload_directory('1/block_scholarship/'.$USER->id.'/'.$now)) {
                error("The site administrator needs to fix the file permissions");
            }
        
                
                // remove the annoying warning from upload manager
                $el = error_reporting(0);

                // hardcode the file name
                if (isset($_FILES['userfile']['name'])) {
                    $name = $_FILES['userfile']['name'];
                    $_FILES['userfile']['name'] = $name;
                }

                // handle the upload
                $um = new upload_manager('userfile',false,true,$course,false,0,true,true);

                $dir = "$basedir";
                if ($um->process_file_uploads($dir)) {
                    $filename = $um->get_new_filename();
                    $fileurl = "$wdir/" . $filename;
                    if (!mail == '1'){
                    echo get_string('uploadsucces','block_scholarship')." 1/block_scholarship/$USER->id/".$now."$fileurl";
                    }

                }
        
                error_reporting($el);

                //enter data into database table
                $insert = new object();
                $insert->docid = $docid;
                $insert->scholarshipid = $scholarshipid;
                $insert->selectedid = $selectedid;
                $insert->userid = $USER->id;
                $insert->mail = $mail;
                $insert->filename = $filename;
                if (!empty($filename)) {
                    $insert->received = 1;
                } else {
                    $insert->received = 0;
                }
                $insert->folder = $now;
                $insert->timemodified = time();

              // print_object($insert);
             
               if (!$DB->insert_record('block_scholarship_doc_upload',$insert)){
                  echo 'not saved';
                  //print_object($insert);
                } else {
                
                redirect($CFG->wwwroot.'/blocks/scholarship/user/view.php?id='.$scholarshipid, '', 0);
                }

       }

       print_content_header();
       //get documents, associated with scholarship selected
        $documents = $DB->get_records('block_scholarship_doc','scholarshipid',$scholarshipid);
        
           print_inner_content_header('align: center; width: 40%');
           echo '<form name="uploadform" id="uploadform" action="'.$_SERVER['PHP_SELF'].'" enctype="multipart/form-data" method="post">';
           echo '<input type="hidden" name="submitted" value="yes"><p>';
           echo '<input type="hidden" name="selectedid" value="'.$selectedid.'"><p>';
           echo '<input type="hidden" name="scholarshipid" value="'.$scholarshipid.'"><p>';
           echo get_string('selectdocument','block_scholarship').'<br>';
           //Used for message
           foreach ($documents as $document){
                //Check if user has already uploaded doc
                $doc_verification = $DB->get_record('block_scholarship_doc_upload','userid',$USER->id,'docid',$document->documentid);


                     if ((!$doc_verification->mail == 1) AND ($doc_verification->filename == '')){

                        //USED TO WRITE THE DOCUMENT NAME
                        $docinfo = $DB->get_record('block_scholarship_document','id',$document->documentid);

                       

                    } else {

                        //now check if documents are associated with selectedid
                        $doc_associated = $DB->get_record('block_scholarship_doc_upload','userid',$USER->id,'docid',$document->documentid,'selectedid',$selectedid);


                            if (!$doc_associated){

                               echo '<b>'.get_string('documentalreadysubmitted','block_scholarship').'</b><br>';

                               break;

                            }

                    }
            }

           //used for select
           echo '<select name="docid">';
            foreach ($documents as $document){
                //Check if user has already uploaded doc
                $doc_verification = $DB->get_record('block_scholarship_doc_upload','userid',$USER->id,'docid',$document->documentid);

                   
                     if ((!$doc_verification->mail == 1) AND ($doc_verification->filename == '')){
                         
                        //USED TO WRITE THE DOCUMENT NAME
                        $docinfo = $DB->get_record('block_scholarship_document','id',$document->documentid);
                        
                        echo '<option value="'.$document->documentid.'">'.$docinfo->name.'</option>';
                    
                    } else {
                       
                        //now check if documents are associated with selectedid
                        $doc_associated = $DB->get_record('block_scholarship_doc_upload','userid',$USER->id,'docid',$document->documentid,'selectedid',$selectedid);
                            
                        
                            if (!$doc_associated){
                                
                                $insert = new object();
                                $insert->docid = $document->documentid;
                                $insert->scholarshipid = $scholarshipid;
                                $insert->selectedid = $selectedid;
                                $insert->userid = $USER->id;
                                $insert->mail =$doc_verification->mail;
                                    if ($doc_verification->mail == 1){
                                        $received = 0;
                                    } else {
                                        $received= 1;
                                    }
                                $insert->folder = $doc_verification->folder;
                                $insert->received = $received;
                                $insert->filename = $doc_verification->filename;
                                $insert->timemodified = time();
                             
                               $DB->insert_record('block_scholarship_doc_upload',$insert);
                               
                               redirect($CFG->wwwroot.'/blocks/scholarship/user/view.php?id='.$scholarshipid, '', 5);

                            }
                            //print meesage for uploaded doc and mailed doc
                                if ($doc_verification->mail == 1) {
                                    print_string('maildocument','block_scholarship');
                                } else {
                                   print_string('alldocumentssent','block_scholarship');
                                }
                    }
            }
            echo '</select>';

            
           
            
           
           
           echo '<p><input type="file" name="userfile"></p>';
           echo get_string('willmail','block_scholarship').'<input type="checkbox" name="mail" value="1" onClick="" ><p>';
           echo '<input type="submit" name="submit" value="'.get_string('save','block_scholarship').'">';
           echo '</form>';
           
           print_inner_content_footer();
       print_content_footer();


    

  }
  print_footer();
?>
