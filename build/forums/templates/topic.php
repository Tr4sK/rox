<?php
/*

Copyright (c) 2007 BeVolunteer

This file is part of BW Rox.

BW Rox is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BW Rox is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/> or 
write to the Free Software Foundation, Inc., 59 Temple Place - Suite 330, 
Boston, MA  02111-1307, USA.


This File display a topic and the messages which are inside it


* @author     Original author unknown
* @author     Michael Dettbarn (lupochen) <mail@lupochen.com>

*/
    //$i18n = new MOD_i18n('apps/forums/board.php');
    //$boardText = $i18n->getText('boardText');
    $words = new MOD_words();

    $User = APP_User::login();
    $can_del = $User && $User->hasRight('delete@forums'); // Not to use anymore (JeanYves)
    $can_edit_own = $User ;
//    $can_edit_own = $User && $User->hasRight('edit_own@forums');
    $can_edit_foreign = $User && $User->hasRight('edit_foreign@forums');

	 if (!isset($topic->topicinfo->IsClosed)) {
	 	$topic->topicinfo->IsClosed=false ;
	 }

?>
<h2><?php 
	
	if ($User) {
		$url=$_SERVER['REQUEST_URI'] ;
		if (strpos($url,"/reverse")===false) { // THis in order to avoid to concatenate /reverse twice
			$url.="/reverse"  ;
		}
		echo "<a href=\"".$url."\" title=\"reverse the display list\" ><img src=\"images/icons/reverse_order.png\" /></a> " ;
	}
	if ($topic->topicinfo->IdGroup>0) {
		echo $words->getFormatted("Group_" . $topic->topicinfo->GroupName),"::" ;
	}
// If the forum belongs to a group display the group name first
// Display the title of the post
	echo $words->fTrad($topic->topicinfo->IdTitle); 

?></h2>

<span class="forumsthreadtags"><strong>Tags:</strong> <?php

    $url = ForumsView::getURI().'';
    $breadcrumb = '';
    if (isset($topic->topicinfo->continent) && $topic->topicinfo->continent) {
        $url = $url.'k'.$topic->topicinfo->continent.'-'.Forums::$continents[$topic->topicinfo->continent].'/';
        $breadcrumb .= '<a href="'.$url.'">'.Forums::$continents[$topic->topicinfo->continent].'</a> ';
        
        if (isset($topic->topicinfo->countryname) && $topic->topicinfo->countryname) {
            $url = $url.'c'.$topic->topicinfo->countrycode.'-'.$topic->topicinfo->countryname.'/';
            $breadcrumb .= ':: <a href="'.$url.'">'.$topic->topicinfo->countryname.'</a> ';

            if (isset($topic->topicinfo->adminname) && $topic->topicinfo->adminname) {
                $url = $url.'a'.$topic->topicinfo->admincode.'-'.$topic->topicinfo->adminname.'/';
                $breadcrumb .= ':: <a href="'.$url.'">'.$topic->topicinfo->adminname.'</a> ';
                
                if (isset($topic->topicinfo->geonames_name) && $topic->topicinfo->geonames_name) {
                    $url = $url.'g'.$topic->topicinfo->geonameid.'-'.$topic->topicinfo->geonames_name.'/';
                    $breadcrumb .= ':: <a href="'.$url.'">'.$topic->topicinfo->geonames_name.'</a> ';
                }
            }
        }
    }


	 for ($ii=0;$ii<$topic->topicinfo->NbTags;$ii++) {
		$wordtag=$words->fTrad($topic->topicinfo->IdName[$ii]) ;
		if ($breadcrumb) {
		   $breadcrumb .= '|| ';
		}
       $url = $url.'t'.$topic->topicinfo->IdTag[$ii].'-'.$wordtag.'/';
        $breadcrumb .= '<a href="'.$url.'">'.$wordtag.'</a> ';
    } // end of for $ii

    echo $breadcrumb;

?></span>
<?php
	  $topic->topicinfo->IsClosed=false ;
	  if ($topic->topicinfo->expiredate!="0000-00-00 00:00:00") {
	  	 echo "&nbsp;&nbsp;&nbsp;<span class=\"forumsthreadtags\"><strong> expiration date :",$topic->topicinfo->expiredate,"</strong>" ; 
	  	 $topic->topicinfo->IsClosed=(strtotime($topic->topicinfo->expiredate)<=time()) ;
	  } 

	  if ($topic->topicinfo->IsClosed) {
	 	 echo " &nbsp;&nbsp;&nbsp;<span class=\"forumsthreadtags\"><strong> this thread is closed</strong>" ;
	  }
?>
<?php
if ($User) {
?>

    <div id="forumsthreadreplytop">
	 <?php 
	 if (!$topic->topicinfo->IsClosed) {
	 ?>
	 <span class="button"><a href="
	 <?php 

	 	if (isset($topic->IdSubscribe)) {
	 	   echo ForumsView::getURI()."subscriptions/unsubscribe/thread/",$topic->IdSubscribe,"/",$topic->IdKey,"\">",$words->getBuffered('ForumUnsubscribe'),"</a></span>",$words->flushBuffer();
	 	}
	 	else {
	 	   echo ForumsView::getURI()."subscribe/thread/",$topic->IdThread,"\">",$words->getBuffered('ForumSubscribe'),"</a></span>",$words->flushBuffer(); 
	 	}  
	 	?>
	 	<span class="button"><a href="<?php echo $uri; ?>reply"><?php echo $words->getBuffered('ForumReply'); ?></a></span><?php echo $words->flushBuffer() ?>

<?php
	  }
	 	?>
	 	</div>
<?php

} // end if ($User)
    
    // counting for background switch trick
    $cntx = '1';
	

if ($this->_model->ForumOrderList=="No") {
	for ($ii=count($topic->posts)-1;$ii>=0;$ii--) {
		$post=$topic->posts[$ii] ;
        $cnt = $ii + 1;
        require 'singlepost.php';
        $cntx = $cnt;
    }
}
else { // Not logged member will always see the forum in ascending order
	for ($ii=0;$ii<count($topic->posts);$ii++) {
		$post=$topic->posts[$ii] ;
        $cnt = $ii + 1;
        require 'singlepost.php';
        $cntx = $cnt;
    }
}
        
if ($User) {

	 if (!$topic->topicinfo->IsClosed) {
?>
<div id="forumsthreadreplybottom"><span class="button"><a href="<?php echo $uri; ?>reply"><?php echo $words->getBuffered('ForumReply');; ?></a></span><?php echo $words->flushBuffer() ?></div>
<?php
	 }

}
?>