

        <div class="row">
            <div class="voucher">
                <h2 class="vtitle"><?= $voucherObj->title ?></h2>
                <?php if($voucherObj->image): ?>
                <p><img src="/images/voucher/cache-md/<?= $voucherObj->image ?>"></p>
                <?php else: ?>
                <p><img src="/images/voucher/cache-md/_generic.jpg"></p>
                <?php endif; ?>
                <p class="vdescription"><?= $voucherObj->description ?></p>
                                
                <div class="vaddress">
                    
                    <?php if($voucherObj->phone): ?><div class="phone"><i class="fa fa-phone"></i> <a href="tel:<?= $voucherObj->phone ?>"><?= $voucherObj->phone ?></a></div><?php endif; ?>
                    <?php if($voucherObj->web): ?><div class="web"><i class="fa fa-external-link"></i> <?= $voucherObj->web ?></div><?php endif; ?>
                    <?php if($voucherObj->address): ?>
						<!--<div class="address"><i class="fa fa-map-marker"></i> <a target="_blank" href="https://maps.google.com/?q=<?= $voucherObj->address ?>"><?= $voucherObj->address ?></a></div>-->
						<div class="address"><i class="fa fa-map-marker"></i> <?= $voucherObj->address ?></div>
					<?php endif; ?>
                </div>
                <div class="valid">VALID <?= date('d M',strtotime($voucherObj->validFrom)); ?> - <?= date('d M Y',strtotime($voucherObj->validTo)); ?> </div>
				
				<?php if($hasAccess): ?>
                <p class="redeem">     															
					
                 <?php 
					if($existingHistoryObj || isset($_GET['refreshed'])){
						if($existingHistoryObj)
							echo '<a href="#" class="btn grey lrg">Redeemed '.date('dS M',strtotime($existingHistoryObj->dateRedeemed));
						else
							echo '<a href="#" class="btn grey lrg">Redeemed ';
						
						if($voucherObj->allowMonthlyUse){
							echo '<span class="small">This voucher can be used monthly</span>';
						}
						echo '</a>';						
						
					} else {
						if($voucherObj->isOnlineCoupon){
                            echo '<a href="#" class="btn red lrg" data-featherlight="#online-coupon">Redeem</a>';
                        } else {
				            $now = date('Y-m-d');
		                    if($now < $voucherObj->validFrom || $now > $voucherObj->validTo){
								echo '<a href="#" class="btn grey lrg">Voucher expired</a>';
							} else {
								echo '<a href="#" class="btn red lrg" data-featherlight="#cashier">Redeem</a>';
							}
						}					
					}
				?>

					<?php if(!isset($_SESSION['allow-insecure'])):?>
                    	<a href="javascript:;" class="favourite <?= ($userFavouriteObj) ? 'heart' : 'heart-o' ?>" title="Favourite">&nbsp;</a>
					<?php endif; ?>
                </p>
				
				<?php else: ?>
					
					<div class="alert alert-danger">
	                    <span>You don't have access to the current edition. Please <a href="https://www.smallideas.com.au/">purchase here</a>.</span>
	                </div>
				
				<?php endif; ?>

                <div class="vbusdescription">
                    <div class="name"><strong><?= $voucherObj->businessName ?></strong></div>
                    <p><?= $voucherObj->businessDescription ?></p>
                </div>
            </div>
         
		 	<input type="hidden" id="voucherid" value="<?= $voucherObj->id ?>">
            
        </div>
		
        <div class="lightbox" id="success-favourite">
             <h2 id="redeemTitle">Added to your favourites!</h2>
             <div class="buttons">
                 <a class="btn green lrg closeFeatherlight" href="javascript:;">Close</a>                                
             </div>
        </div>
        
        <?php if(!$existingHistoryObj && $hasAccess): ?>

        <div class="lightbox" id="online-coupon">
			<h2>This is an online coupon code.</h2>
            <p><?= ($voucherObj->onlineCouponText) ? $voucherObj->onlineCouponText : $voucherObj->description ?></p>
			<div class="buttons">
                <a class="btn blue lrg pull-right featherlight-close" href="#">Close</a>                
                <div class="clearfix"></div>
            </div>
		</div>

        <div class="lightbox" id="cashier">
			<h2>Please take this to a cashier to redeem.</h2>
			
			<?php
				//temporary override to show detail on redeem popup
				if($voucherObj->id == 220){
					//legoland
					echo "<p>Promo code <strong>1880</strong></p>";
				} else if($voucherObj->id == 55){
					//sea life aquarium
					echo "<p>Promo code <strong>PL071</strong></p>";
				}
			?>
			
			<div class="buttons">
                <a class="btn red lrg pull-left featherlight-close" href="#">Cancel</a>
                <a class="btn blue lrg pull-right featherlight-close" href="#" data-featherlight="#redeem">Redeem</a>
                <div class="clearfix"></div>
            </div>
		</div>

        <div class="lightbox" id="redeem">
			<h2>Are you sure you want to redeem this voucher?</h2>
			<div class="buttons">
                <a class="btn red lrg pull-left featherlight-close" href="#">No</a>
                <a class="btn blue lrg pull-right" id="btn-redeem" data-vid="<?= $voucherObj->id ?>" href="#">Yes</a>                
                <div class="clearfix"></div>
            </div>
            
		</div>
       
       <div class="lightbox" id="success">
            <h2 id="redeemTitle">Successfully redeemed!</h2>
            <div class="buttons">
                <a class="btn green lrg" href="#" id="redeemed" data-insecure='<?= (isset($_SESSION['allow-insecure'])) ? '1' : '0' ?>'>Done</a>                                
            </div>
       </div>       

       <div class="lightbox" id="fail">
            <h2 id="redeemTitle">There was a problem redeeming the voucher.</h2>
            <div class="buttons">
                <a class="btn red lrg" href="javascript:location.reload();">Close &amp; Try Again</a>                                
            </div>
       </div>

       <div class="lightbox" id="fail-favourite">
            <h2 id="redeemTitle">There was a problem adding to favourites.</h2>
            <div class="buttons">
                <a class="btn red lrg" href="javascript:location.reload();">Close</a>                                
            </div>
       </div>
       <?php endif; ?>