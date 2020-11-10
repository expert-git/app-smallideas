
        
       <form method="get" class="search">
            <div class="row">                
                <input type="text" class="form-control" name="s" placeholder="Search name or offer...">
                <input type="submit" value="Search" class="btn btn-search">                
            </div>        
        </form>

        <?php if($voucherObjArr): ?>
			<?php $previousVoucherId = ''; ?>
        <?php foreach($voucherObjArr as $voucherObj): ?>
            <div class="row">
            <ul class="vouchers <?= (isset($userHistoryObjArr[$voucherObj->id]) && $userHistoryObjArr[$voucherObj->id]->allowMonthlyUse!=1 && $userHistoryObjArr[$voucherObj->id]->allowMonthlyUse!=2) ? 'redeemed' : '' ?>">
                <li>
                    <a class="" data-transition="slide" data-inline="true" id="v<?= $voucherObj->id ?>" href="voucher.html?id=<?= $voucherObj->id ?>&parent=search&parentid=<?= $search ?>&pos=v<?= $previousVoucherId ?>">
                        <span class="name"><?= $voucherObj->businessName ?></span>
                        <span class="title"><?= $voucherObj->title ?></span>
                        <span class="address"><?= $voucherObj->address ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </div>
			<?php $previousVoucherId = $voucherObj->id; ?>
        <?php endforeach; ?>
        <?php else: ?>
        <?php if(isset($_GET['s'])): ?>
            No results were found.
        <?php endif; ?>
        <?php endif; ?>

       