<?php
include "lib/dbaccess.php" ;
require_once "layout/error.php" ;
require_once "layout/adminpannel.php" ;	

  $sysvol_filename="lib/HCVol_Config.php" ;

function 	LoadingData($source="FromFile") {
  global $sysvol_filename ;


  $TData=array() ;
  if ($source=="FromBase") {
	  $str="select syskey as SYSHCvol_key,value as SYSHCvol_value,comment as SYSHCvol_comment from hcvol_config" ;
		$qry=sql_query($str) ;
		while ($rr=mysql_fetch_object($qry)) {
      array_push($TData,$rr) ;
		}
	} // end of From Base
	
  if ($source=="FromFile") {
	  if (! ($ff=fopen($sysvol_filename,"r"))) {
	    echo "failed to open ",$sysvol_filename ;
		  exit(0) ;
	  }
    $ss=fgets($ff) ; // skip <?php


	  while (!feof($ff)) {
	    $ss=fgets($ff) ;
//			echo "$ss<br>" ;
		  if ($ss=="?>") continue ;
		  if (ltrim(rtrim($ss))=="") continue ; // no
//		echo "<font color=green>",$ss,"</font><br>\n" ;
	    unset($struct) ;
		  $struct->SYSHCvol_key="" ;
		  $struct->SYSHCvol_value="" ;
		  $struct->SYSHCvol_comment="" ;

		  $tt=explode("=",$ss) ;
		
//		case the line is just a comment line
      if (strpos($ss,"//")===0) {
	      $struct->SYSHCvol_comment=substr($ss,2) ;
		  } 
		  else {
		    if (isset($tt[0])) {
		      $struct->SYSHCvol_key=$tt[0] ;
		    }
		    if (isset($tt[1])) $val=$tt[1] ;
		
		    if (isset($val)) {
		      $tt=explode("//",$val) ;
		      if (isset($tt[0])) $struct->SYSHCvol_value=$tt[0] ;
		      if (isset($tt[1])) $struct->SYSHCvol_comment=$tt[1] ;
		    }
		  }
      array_push($TData,$struct) ;

	  } // end of while not feof
	  fclose($ff) ;
	} // end of loading data from file
	
  return($TData) ;
} // end of loading data


  MustLog() ;
	
  $RightLevel=HasRight('Pannel'); // Check the rights
  if ($RightLevel<1) {  
    echo "This Need the sufficient <b>Pannel</b> rights<br>" ;
	  exit(0) ;
  }
	
	$action=GetParam("action") ;
  $PannelScope=RightScope('Pannel') ;
	$Message="" ;
  switch($action) {
	  case "DiffDB" :
      if (!HasRight('Pannel',$action)) { // Check the rights
        echo "This Need the scope <b>".$action."</b> within <b>Pannel</b> rights<br>" ;
	      exit(0) ;
			}
			break ;
	  case "SaveToDB" :
      if (!HasRight('Pannel',$action)) { // Check the rights
        echo "This Need the scope <b>".$action."</b> within <b>Pannel</b> rights<br>" ;
	      exit(0) ;
			}
			$ii=0 ;
			$str="truncate hcvol_config" ;
			sql_query($str) ;
			
		  $str="insert into hcvol_config(comment) values(concat('generated by ".$_SESSION["Username"]." using AdminPannel ',now()))" ;
			while ((GetParam("SYSHCvol_key_".$ii)!="")or(GetParam("SYSHCvol_value_".$ii)!="")or(GetParam("SYSHCvol_comment_".$ii)!="")) {
			  $str="insert into hcvol_config(syskey,value,comment) values('".addslashes(GetParam("SYSHCvol_key_".$ii))."','".addslashes(GetParam("SYSHCvol_value_".$ii))."','".addslashes(GetParam("SYSHCvol_comment_".$ii))."')" ;
			  sql_query($str) ;
				$ii++ ;
			}
			
      $Message= "Storing content in Database" ;
			LogStr("Saving file to base","AdminPannel") ;
      DisplayPannel(LoadingData("FromBase"),$Message) ; // call the layout
			exit(0) ;
 			break ;
	  case "LoadFromDB" :
      if (!HasRight('Pannel',$action)) { // Check the rights
        echo "This Need the scope <b>".$action."</b> within <b>Pannel</b> rights<br>" ;
	      exit(0) ;
			}
      $Message= "Loading content in Database" ;
			LogStr("Loading file from base","AdminPannel") ;
      DisplayPannel(LoadingData("FromBase"),$Message) ; // call the layout
 			break ;
			
	  case "" :
	  case "LoadFromFile" :
      if (!HasRight('Pannel',$action)) { // Check the rights
        echo "This Need the scope <b>".$action."</b> within <b>Pannel</b> rights<br>" ;
	      exit(0) ;
			}
      $Message= "Loading content from file ".$sysvol_filename ;
			LogStr("Loading file from base","AdminPannel") ;
      DisplayPannel(LoadingData("FromFile"),$Message) ; // call the layout
			exit(0) ;
 			break ;

	  case "Generate" :
      if (!HasRight('Pannel',$action)) { // Check the rights
        echo "This Need the scope <b>".$action."</b> within <b>Pannel</b> rights<br>" ;
	      exit(0) ;
			}
			
      $Message= "Generating file ".$sysvol_filename ;
			LogStr($Message,"AdminPannel") ;
	    if (! ($ff=fopen($sysvol_filename,"w"))) {
	      echo "failed to open ",$sysvol_filename ;
		    exit(0) ;
	    }
      $ss="<?php" ;
      fwrite($ff,$ss) ;
			$ss="// Generated using Admin Pannel at ".date("F j, Y, g:i a");
//			echo $ss,"<br>\n" ;
      fwrite($ff,$ss) ;
			$str="select * from hcvol_config" ;
			$qry=sql_query($str) ;
			while ($rr=mysql_fetch_object($qry)) {
			  $ss="" ;
				$ss=$rr->syskey ;
				if ($rr->value!="") {
				  $ss.="=".$rr->value ;
				}
				if ($rr->comment!="") {
				  $ss.=" //".$rr->comment ;
				}
        fwrite($ff,$ss) ;
			}
      $ss="?>" ;
      fwrite($ff,$ss) ;
	    fclose($ff) ;
			LogStr($Message." done","AdminPannel") ;
      DisplayPannel(LoadingData("FromFile"),$Message) ; // call the layout
			
 			break ;
	}

?>