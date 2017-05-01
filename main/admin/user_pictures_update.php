<?php
/**
 * upload user pictures to chamilo from folder with username.jpg or officialcode.jpg
 * pictures.
 * Picture directory defined below as $pictDir. Change if needed.
 */

use ChamiloSession as Session;

require_once __DIR__.'/../inc/global.inc.php';

$pictDir = realpath( __DIR__ . '/../../../userpictures') . "/" ;

api_protect_admin_script(true);

Display :: display_header("update pictures", "");

echo "<pre>START upload pictures from $pictDir\n\n";

//DEBUG: error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//remove memory and time limits as much as possible as this might be a long process...
if(function_exists('ini_set'))
{
	ini_set('memory_limit',-1);
	ini_set('max_execution_time',0);
}else{
        echo "error\n";
	error_log('Update use pictures: could not change memory and time limits',0);
}

$table_user = Database::get_main_table(TABLE_MAIN_USER);
$query = "SELECT user_id, username, official_code FROM $table_user WHERE picture_uri=''";
echo "$query \n";
$result_users =  Database::query($query);
                
while ($row= Database::fetch_row($result_users)) {
    $user_id = $row[0];
    $user_name = $row[1];
    //our $studentnummer = substr(strrchr($row[2], "_"), 1); // get part after _ sign
    $officialCode = substr($row[2],0,9); 

    // filename from user data
    $file =  $officialCode . '.jpg';
    $tdir = $pictDir;

    echo "checking officialcode=$file user=$user_name:";	
    if (!file_exists($tdir.$file)) { // maybe teacher? 
				$tdir = $pictDir;
				$file =  $user_name . '.jpg';
    }
    if (!file_exists($tdir.$file)) { // maybe teacher.png? 
				$tdir = $pictDir;
				$file =  $user_name . '.png';
    }
    if (!file_exists($tdir.$file)) {
        echo " file not found\n";
        continue;
    }
    echo "\n";
    
    $image_repository = $tdir.$file;
    echo "Processing $image_repository \n";
    $TMPPIC="/tmp/".$user_name.".jpg";
    copy($image_repository, $TMPPIC);
    // let UserManager do the work
    $picture_uri = UserManager::update_user_picture($user_id, $file, $TMPPIC, "0,0");
    unlink($TMPPIC); //remove old picture
    //echo "puri = ".$picture_uri;

    $query = "UPDATE ".$table_user . " SET picture_uri=\"$picture_uri\" WHERE user_id=$user_id";
    if ($picture_uri != "") {
        // Update the picture_uri
        $res = Database::query($query);
        //echo "<br> $query  executed <br>\n";
    }
    else echo "<br><b> Query NOT executed: $query  </b></br>\n";
    
    flush();
} // while
		
Display :: display_footer();
?>

