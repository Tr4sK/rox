<?php
require_once "lib/init.php";

$Message="" ;
switch (GetParam("action")) {

	case "ask" :
		$rCategory = LoadRow("select * from feedbackcategories where id=" . GetParam("IdCategory"));
		// feedbackcategory 3 = FeedbackAtSignup
		$IdMember=0 ;
		if (isset( $_SESSION['IdMember'] )) {
		      $IdMember=$_SESSION['IdMember'] ;
		}
		$str = "insert into feedbacks(created,Discussion,IdFeedbackCategory,IdVolunteer,Status,IdLanguage,IdMember) values(now(),'" . GetParam(FeedbackQuestion) . "'," . GetParam("IdCategory") . "," . $rCategory->IdVolunteer . ",'open'," . $_SESSION['IdLanguage'] . "," . $IdMember.")";
		sql_query($str);
		
		$EmailSender=$_SYSHCVOL['FeedbackSenderMail'] ;
		if (IsLoggedIn()) {
		    $EmailSender=GetEmail($IdMember) ; // The mail address of the sender can be used for the reply
		}
		else {
		   if (GetParam("Email")!="") {
		   	   $EmailSender=GetParam("Email") ;
		   }
		}

		// Notify volunteers that a new feedback come in
		$username = fUsername($_SESSION['IdMember']);
		$subj = "New feedback from " . $username . " Category " . $rCategory->Name;
		$text = " Feedback from " . $username . "\n";
		$text .= "Category " . $rCategory->Name . "\n";
		$text .= GetParam("FeedbackQuestion") . "\n";
		if (GetParam("answerneededt")=="on") {
		    $text .= "member requested for an answer (".$EmailSender.")\n";
		}
		if (GetParam("urgent")=="on") {
		    $text .= "member has ticked the urgent checkbox\n";
		}

		hvol_mail($rCategory->EmailToNotify, $subj, $text, "", $EmailSender, 0, "nohtml", "", "");

		// Todo : make a better display, hide the email
//		$Message= "FeedBack Sent to ".$rCategory->EmailToNotify."<br>";
		$Message= ww("FeedBackSent") ;;

}

$TFeedBackCategory = array ();
$str = "select * from feedbackcategories ";
$qry = mysql_query($str);
while ($rr = mysql_fetch_object($qry)) {
	if ($rr->id == 3)
		continue; // Skip category feedbackatsignup
	array_push($TFeedBackCategory, $rr);
}

include "layout/feedback.php";
DisplayFeedback($TFeedBackCategory,$Message,GetParam("IdCategory",0));
?>
