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
                <div class="redeem">									
					
				 <?php
				  $strip_form = null;
				 					if(!$existingHistoryObj){
				 						if($voucherObj->isOnlineCoupon == 1 ){
				                             echo '<a href="#" class="btn red lrg" data-featherlight="#online-coupon">Redeem</a>';
				 						} elseif($voucherObj->isOnlineCoupon == 2){
				 							//neat ideas 							
				 							$categoryOrProduct = ($voucherObj->neatIdeasType) ? 'category' : 'product';
				 							$sharedSecret = 'AIza66SyCVHl0uF7h';
				 							$ssoid = hash('sha256',$sharedSecret.date('Ymd').$_SESSION['username']);
				 							//echo '<a href="https://store.neatideas.com.au/smallideas/handoversso/index/smallideastoken/?ssoid='.$ssoid.'&email='.$_SESSION['username'].'&urlType='.$categoryOrProduct.'&urlId='.$voucherObj->neatIdeasId.'" class="btn red lrg" data-featherlight="">Open Voucher</a>';
												echo '<a target="_blank" href="https://smallideas.neatideas.com.au/handoversso/index/smallideastoken/?ssoid='.$ssoid.'&email='.$_SESSION['username'].'&urlType='.$categoryOrProduct.'&urlId='.$voucherObj->neatIdeasId.'" class="btn red lrg">Open Voucher</a>';
							
											//	echo $sharedSecret.date('Ymd').$_SESSION['username'];
											//	echo "<br>".date('Y-m-d H:i:s');
										} elseif($voucherObj->isOnlineCoupon == 3){
											$vurl = ($voucherObj->onlineCouponText && strpos($voucherObj->onlineCouponText,'http')===false) ? 'http://'.$voucherObj->onlineCouponText : $voucherObj->onlineCouponText;
											echo '<a target="_blank" href="'.$vurl.'" class="btn red lrg">Open Voucher</a>';
				                        } elseif($voucherObj->isOnlineCoupon == 4){
	if($pdfCount > 0){
		  $qtyVal = 10;
		if($pdfCount < 10){
		  $qtyVal = $pdfCount;
		}
		$qtyOptions=null;
        for($c=1; $c <= $qtyVal; $c++){
		   $qtyOptions .= '<option value="'.$c.'">'.$c.'</option>';
	    }	
		$tax = 1.75;
		$totalCst= $voucherObj->onlineCouponText;
		$ctPrst= ($totalCst*$tax)/100;
		$totalTxCost= number_format($totalCst+$ctPrst, 2, '.', '');

		$strip_form = '<script src="https://js.stripe.com/v2/"></script>';		
		$strip_form .= '<div class="strip-section" id="stripSection"><div class="payment-status"></div>	
        <form action="payment.html?id='.$_GET['id'].'" method="POST" id="paymentFrm">
            <div class="form-group"><label>NAME</label><input type="text" name="name" id="name" placeholder="Enter name" required="" autofocus="">
            </div>
			<input type="hidden" name="qty" id="qty" required value="1">
			<input type="hidden" name="customer" required="" value="'.$_SESSION['userid'].'"><input type="hidden" name="itemPrice" id="itemPrice" required="" value="'.$totalCst.'"><input type="hidden" name="currency" required="" value="AUD"><input type="hidden" name="itemName" required="" value="'.$voucherObj->title.'">
            <div class="form-group"><label>EMAIL</label><input type="email" name="email" id="email" placeholder="Enter email" required=""></div>
            <div class="form-group"><label>CARD NUMBER</label><input type="text" name="card_number" id="card_number" placeholder="1234 1234 1234 1234" autocomplete="off" required=""></div>
            <div class="row"><div class="left"><div class="form-group"><label>EXPIRY DATE</label><div class="col-1"><input type="text" name="card_exp_month" id="card_exp_month" placeholder="MM" required=""></div><div class="col-2"><input type="text" name="card_exp_year" id="card_exp_year" placeholder="YYYY" required=""></div></div></div>
            <div class="right"><div class="form-group"><label>CVC CODE</label><input type="text" name="card_cvc" id="card_cvc" placeholder="CVC" autocomplete="off" required=""></div></div></div>
            <button type="submit" class="btn btn-success" id="payBtn">Submit Payment</button>
        </form></div>';
		$strip_form .= '<script>jQuery(document).ready(function($){$("#stripSection").hide();$("#buyNow").click(function(){$("#stripSection").toggle();});});</script>';
		$strip_form .= '<script>Stripe.setPublishableKey("'.STRIPE_PUBLISHABLE_KEY.'");</script>';
		
        echo '<p><strong>Voucher Price $<span id="vPrice">'.$totalCst.'</span> Total Price $<span id="totalPrice">'.$totalTxCost.'</span></strong></p>';
		echo '<div class="qty-section"><strong>Quantity:</strong>
			<select name="quantity" id="quantity" autocomplete="off" id="quantity" tabindex="-1" class="a-native-dropdown">'.$qtyOptions.'</select></div>';
		echo '<a href="javascript:void(0)" id="buyNow" class="btn red lrg buy-now-button">Buy now</a>';
	} else {
		echo '<a href="#" class="btn grey lrg">Sold out</a>';
	}		
?>		
<?php		
				 						} else {
				 				            $now = date('Y-m-d');
				 		                    if($now < $voucherObj->validFrom || $now > $voucherObj->validTo){
				 								echo '<a href="#" class="btn grey lrg">Voucher expired</a>';
				 							} else {
				 								echo '<a href="#" class="btn red lrg" data-featherlight="#cashier">Redeem</a>';
				 							}
				 						}
				 					} else {
				 						echo '<a href="#" class="btn grey lrg">Redeemed '.date('dS M',strtotime($existingHistoryObj->dateRedeemed));
				 						if($voucherObj->allowMonthlyUse == 1){
				 							echo '<span class="small">This voucher can be used monthly</span>';
				 						} else if($voucherObj->allowMonthlyUse == 2){
				 							echo '<span class="small">This voucher can be used weekly</span>';
				 						}
				 						echo '</a>';						
				 					}
				 				?>
								
					<?php if(!isset($_SESSION['allow-insecure'])):?>
                    	<a href="javascript:;" class="favourite <?= ($userFavouriteObj) ? 'heart' : 'heart-o' ?>" title="Favourite">&nbsp;</a>
					<?php endif; ?>
				 <?php echo $strip_form;?>
<?php if(!empty($strip_form)){ ?>
<script>
function stripeResponseHandler(status, response) {
    if(response.error){
        $('#payBtn').removeAttr("disabled");
        $(".payment-status").html('<p>'+response.error.message+'</p>');
    } else {
        var form$ = $("#paymentFrm");
        var token = response.id;
        form$.append("<input type='hidden' name='stripeToken' value='"+token+"'/>");
        form$.get(0).submit();
    }
}
$(document).ready(function(){
    $("#paymentFrm").submit(function() {
        $('#payBtn').attr("disabled", "disabled");		
        Stripe.createToken({
            number: $('#card_number').val(),exp_month: $('#card_exp_month').val(),exp_year: $('#card_exp_year').val(),cvc: $('#card_cvc').val()
        }, stripeResponseHandler);
        return false;
    });
	
    $("select#quantity").change(function(){
        var Qty = $(this).children("option:selected").val();
        $('#qty').val(Qty);
	 var totalAmount = <?=$totalCst?>*Qty;
	 var ctPrst = (totalAmount*1.75)/100;
	 var totalTxCost = totalAmount+ctPrst;
	 var CalCVal = totalTxCost.toFixed(2);
	  $('#totalPrice').html(CalCVal);
	  $('#vPrice').html(totalAmount.toFixed(2));
    });
});
</script>
<?php } ?>
                </div>
				
				<?php else: ?>
					
					<div class="alert alert-danger">
	                    <span>You don't have access to the current edition. Please <a href="https://www.smallideas.com.au/">purchase here</a>.</span>
	                </div>
				
				<?php endif; ?>

                <div class="vbusdescription">
                    <div class="name"><strong><?= $voucherObj->businessName ?></strong></div>
                    <p><?= $voucherObj->businessDescription ?></p>
                </div>
				
				<?php if(!isset($_SESSION['allow-insecure'])):?>
					<div class="hide-container">
						<a href="javascript:;" id="hidevoucher" class="<?= ($userHiddenObj) ? 'hidden' : '' ?>" title="Hide voucher">Hide this voucher</a>
						<a href="javascript:;" id="unhidevoucher" class="<?= (!$userHiddenObj) ? 'hidden' : '' ?>" title="Hide voucher">Un-hide this voucher</a>
					</div>
				<?php endif; ?>
				
            </div>
         
		 	<input type="hidden" id="voucherid" value="<?= $voucherObj->id ?>">
			
			
            
        </div>
		
        <div class="lightbox" id="success-favourite">
             <h2 id="redeemTitle">Added to your favourites!</h2>
             <div class="buttons">
                 <a class="btn green lrg closeFeatherlight" href="javascript:;">Close</a>                                
             </div>
        </div>
		
        <div class="lightbox" id="success-hidevoucher">
             <h2 id="redeemTitle">Voucher is now hidden!</h2>
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
	   
       <?php endif; ?>
	   
       <div class="lightbox" id="fail-favourite">
            <h2 id="redeemTitle">There was a problem adding to favourites.</h2>
            <div class="buttons">
                <a class="btn red lrg" href="javascript:location.reload();">Close</a>                                
            </div>
       </div>
	   
       <div class="lightbox" id="fail-hidevoucher">
            <h2 id="redeemTitle">There was a problem hiding this voucher.</h2>
            <div class="buttons">
                <a class="btn red lrg" href="javascript:location.reload();">Close</a>                                
            </div>
       </div>
<style>
#paymentFrm {
    margin-top: 23px;
}

#paymentFrm label {
    display: block;
    text-align: left;
    margin-bottom: 6px;
    font-size: 14px;
    font-weight: 600;
}
#paymentFrm input {
    width: 100%;
    height: 42px;
    padding: 5px;
    box-sizing: border-box;
    margin-bottom: 19px;
    border: 1px solid #ccc;
}

 #paymentFrm .btn{
    padding: 9px 27px;
    border: none;
    border-radius: 0px;
    background: #e7505a;
    font-size: 20px;
    text-transform: uppercase;
}
#paymentFrm  .left {
    width: 58%;
    float: left;
}
 #paymentFrm  .right{
    margin-left: 17px;
    width: 37%;
    float: right;
}
#paymentFrm  .left .col-1 ,#paymentFrm  .left .col-2{
    width: 48%;
    display: inline;
    float: left;
}
.qty-section {
    padding: 14px 0 14px;
    background: #f2f2f2;
    margin-bottom: 21px;
}
.qty-section select{height: 35px;
    width: 53px;
    margin-left: 6px;}
</style>