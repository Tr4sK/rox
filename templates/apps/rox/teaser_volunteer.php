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

*/
$words = new MOD_words();
?>

<div id="teaser" class="clearfix">

<div id="teaser_l1"> 
<?php	
	echo "<h1>", $words->get('VolunteerPage'),"</h1>\n"; // Needs to be something like "Go, travel the world!"
?>
</div>
<!-- Google CSE Search Box Begins  -->
<form action="volunteer/search" id="searchbox_003793464580395137050:uwli_johi5g">
  <input type="hidden" name="cx" value="003793464580395137050:uwli_johi5g" />
  <input type="hidden" name="cof" value="FORID:9" />
  <input type="text" name="q" size="25" />
  <input type="submit" name="sa" value="Search" />
</form>
<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=searchbox_003793464580395137050%3Auwli_johi5g&lang=en"></script>
<!-- Google CSE Search Box Ends -->
<!--<div id="teaser_r"> 
</div>-->
</div>