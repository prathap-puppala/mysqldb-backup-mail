<?php
/*Script by Prathap Puppala(www.prathappuppala.com)*/
require('CreateBackup.php');
require('MailSettings.php');

//Config
define('DB_HOST',''); //put your database host here
define('DB_USER',''); //put your database user here
define('DB_PASS',''); //put your database password here
define('BACKUP_DIRECTORY','backupfiles/'); //put your database backup folder name here
define('DEL_FROM_LOCAL',true);

//Instantiating CreateBackup to take backup
$CreateBackup_Obj=new CreateBackup(DB_HOST,DB_USER,DB_PASS,BACKUP_DIRECTORY);


//Enter database names which need to take backup
$dbstobackup=array('smartquint','test');

foreach($dbstobackup as $db){

//Taking DB back up in backup directory
$filename=($CreateBackup_Obj->create_backup($db));
if($filename==false){echo "Sorry.. ".$db." backup is failed<br>";}
else{echo $db." backup is created and moved to ".BACKUP_DIRECTORY." with the name <b>".$filename."</b><br>";}

//Mailing backup
$status=sendmail($db,$filename,BACKUP_DIRECTORY);
if($status){echo $filename." is mailed<br>";}
else{echo "Sorry.. ".$filename." is not mailed<br>";}


//Deleting File from local(executed only when DEL_FROM_LOCAL set to true)
if(DEL_FROM_LOCAL){
unlink(BACKUP_DIRECTORY.$filename);
echo $db." Backup file removed<br>";
}
}

?>
