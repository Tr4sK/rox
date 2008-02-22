<?php
$words = new MOD_words();
?>
<div id="nextmap">
<p class="floatbox">
    <a <?php if ($mapstyle!=='mapoff') { ?> href="searchmembers/mapoff" <?php } ?> class="small <?php if ($mapstyle=='mapoff') echo 'active'; ?> float_right">
    <img src="images/misc/list6<?php if ($mapstyle=='mapoff') echo '_green'; ?>.gif" class="list-icon"> Text view &nbsp;
    </a>
        
    <a <?php if ($mapstyle!=='small') { ?> href="searchmembers/small" <?php } ?> class="small <?php if ($mapstyle=='small') echo 'active'; ?> float_right">
    <img src="images/misc/list4<?php if ($mapstyle=='small') echo '_green'; ?>.gif" class="list-icon"> Mixed &nbsp;
    </a>
    
    <a <?php if ($mapstyle!=='big') { ?> href="searchmembers/big" <?php } ?> class="small <?php if ($mapstyle=='big') echo 'active'; ?> float_right">
    <img src="images/misc/list-map<?php if ($mapstyle=='big') echo '_green'; ?>.gif" class="list-icon"> Map view &nbsp;
    </a>
    
</p>
<?php if ($mapstyle != "mapoff") { ?>    
    <a name="memberlist"></a>
    <div id="member_list"></div>
<?php } ?>
    <div id="searchinfo">
        <h3><?php echo $words->getFormatted('searchmembersIntro'); ?></h3>
        <?php echo $words->getFormatted('searchmembersIntroText'); ?>
        
        <h3><?php echo $words->getFormatted('searchmembersIntro2'); ?></h3>
        <?php echo $words->getFormatted('searchmembersIntroText2'); ?>
    </div>
</div>
