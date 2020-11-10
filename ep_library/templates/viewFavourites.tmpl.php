
        
        <?php if($voucherObjArr): ?>
        <?php foreach($voucherObjArr as $voucherObj): ?>
		
        <div class="row">
            <ul class="vouchers">
                <li>
                    <a class="" data-transition="slide" data-inline="true" href="voucher.html?id=<?= $voucherObj->id ?>&parent=favourites">
                        <span class="name"><?= $voucherObj->businessName ?></span>
                        <span class="title"><?= $voucherObj->title ?></span>
                        <span class="address"><?= $voucherObj->address ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </div>
        
        <?php endforeach; ?>

        <?php else: ?>
            <p>To add a favourite, click the heart button on each voucher page.</p>
        <?php endif; ?>

       