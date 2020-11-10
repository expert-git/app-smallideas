
       
        <div class="row">
            <a class="btn blue xlrg" data-transition="slide" data-inline="true" href="categories.html">Browse vouchers</a>
        </div>
        <div class="row">
            <a class="btn green xlrg" data-transition="slide" data-inline="true" href="regions.html">Browse by location</a>
        </div>
        <div class="row">
            <a class="btn red xlrg" data-transition="slide" data-inline="true" href="search.html">Search</a>
        </div>
        <? //if(isset($_SESSION[isAdmin]) && $_SESSION[isAdmin]): ?>
        <div class="row">
            <a class="btn  pink xlrg" data-transition="slide" data-inline="true" href="nearme.html">Vouchers near me</a>
        </div>
        <? //endif;?>

        <div class="foot-surr">
            <div class="foot">                
                <div class="foot-inner">
                    <a class="btn blue outline " href="favourites.html">Favourites</a>
                    <a class="btn blue outline " href="history.html">History</a>
					<a class="btn blue outline " href="hidden.html">Hidden</a>             
                    <a class="btn blue outline" href="faq.html">FAQ</a> 
<!--                    <a class="btn blue outline" href="/contact.html">Contact</a> -->
					<br><br>
                    <a class="btn-no blue outline " style="font-size:0.9em;color:#289bbb;text-decoration:none" href="?logout=1">Logout</a>
                    <!--<p class="edition">  &copy; <?= date('Y'); ?></p>-->
                </div>
            </div>
        </div>
