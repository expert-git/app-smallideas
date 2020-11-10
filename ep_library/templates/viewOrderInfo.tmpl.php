    <div class="row">
        <div class="voucher">
            <h2 class="vtitle">Thank you</h2>                                
            <div class="vaddress">
                    
            <?php if(!empty($paymentId)){ ?>
            <h1 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h1>
            <h4>Payment Information</h4>
            <p><b>Reference Number:</b> <?php echo $paymentId; ?></p>
            <p><b>Transaction ID:</b> <?php echo $transactionID; ?></p>
            <p><b>Paid Amount:</b> <?php echo $paidAmount.' '.$paidCurrency; ?></p>
            <p><b>Payment Status:</b> <?php echo $paymentStatus; ?></p>			
			<p><i>Please go to your nominated email for your discounted tickets. Allow up to 10 min</i></p>
			<?php }else{ ?>
            <h1 class="error">Your Payment has Failed</h1>
			<?php } ?> 
			</div>
			<br>
			<a class="btn-no blue outline " style="font-size:0.9em;color:#289bbb;text-decoration:none" href="https://app.smallideas.com.au/">Home</a>
		</div>
	</div>