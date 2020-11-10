

        <?php if($voucherObjArr): ?>
        <?php foreach($voucherObjArr as $voucherObj): ?>
		
        <div class="row">
            <ul class="vouchers">
                <li>
                    <span class="title"><?= $voucherObj->title ?></span>
                    <span class="name"><?= $voucherObj->businessName ?></span>
                    <span class="redeemed">Redeemed: <?= date('jS M Y',strtotime($voucherObj->dateRedeemed)); ?></span>
                </li>
            </ul>
        </div>
        
        <?php endforeach; ?>

        <?php else: ?>
            <p>No vouchers</p>
        <?php endif; ?>

       