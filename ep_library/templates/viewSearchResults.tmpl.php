

        <?php if($voucherObjArr): ?>
        <?php foreach($voucherObjArr as $voucherObj): ?>
        
        <div class="row">
            <a class="btn white outline" data-transition="slide" data-inline="true" href="voucher.html?id=<?= $voucherObj->id ?>"><?= $voucherObj->title ?></a>
        </div>
        
        <?php endforeach; ?>

        <?php else: ?>
            <p>No vouchers</p>
        <?php endif; ?>

       