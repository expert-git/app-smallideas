
        <?php 
            $parentid = (isset($_GET['id'])) ? $_GET['id'] : 0;
            if(isset($_GET['parent'])){                
				switch($_GET['parent']){
					case 'browse':
                        if(isset($_GET['regionid'])){
                            //visit ballarat etc within browse
                            $parent = '&parent=browsecat&parentregionid='.$_GET['regionid'];    
                        } else {
						    $parent = '&parent=browsecat&parentid='.$parentid;
                        }
						break;
                    case 'browsecat':  //within play
                        $parentcatid = (isset($_GET['parentid'])) ? $_GET['parentid'] : 0;
						$parent = '&parent=browsecatcat&parentid='.$parentid."&parentcatid=".$parentcatid;
						break;
                    case 'regionscat':                        
                        $regionid = (isset($_GET['regionid'])) ? $_GET['regionid'] : 0;
						$parent = '&parent=regionscatv&parentid='.$parentid.'&parentregionid='.$regionid;
						break;
                    case 'regions':  //ie visit ballarat via regions                        
                        $regionid = (isset($_GET['regionid'])) ? $_GET['regionid'] : 0;
						$parent = '&parent=regionsv&parentid='.$regionid;
						break;
				}		
			} else {
				$parent = '&parent=browsecat&parentid='.$parentid;
			}
            
        ?>



        <?php if($voucherObjArr): ?>
        <?php foreach($voucherObjArr as $voucherObj): 
			
			//hide vouchers that are in a 'visit...' region (if in category)
			$isVisitRegion = false;
			if($categoryObj){
				foreach($voucherObj->regions as $regionObj){
					if(strpos($regionObj->name,'Visit ')!==false)
						$isVisitRegion = true;
				}
				if($isVisitRegion){
					continue;
				}
			}
			
			// if($_SERVER['REMOTE_ADDR']=='1.128.107.96'){
// 				print_r($userHiddenArr); exit;
// 			}
			//hide vouchers that are in the user's hidden list
			if(isset($userHiddenArr[$voucherObj->id])){
				continue;
			}
			
			?>
			
			
        


        <div class="row">
            <ul class="vouchers <?= (isset($userHistoryObjArr[$voucherObj->id]) && $userHistoryObjArr[$voucherObj->id]->allowMonthlyUse!=1 && $userHistoryObjArr[$voucherObj->id]->allowMonthlyUse!=2) ? 'redeemed' : '' ?> ">
                <li>
                    <a class="" data-transition="slide" data-inline="true" id="v<?= $voucherObj->id ?>" href="voucher.html?id=<?= $voucherObj->id ?><?= $parent ?>&pos=v<?= $previousVoucherid ?>">
                        <span class="name"><?= $voucherObj->businessName ?></span>                        
                        <span class="title"><?= $voucherObj->title ?></span>
                        <span class="address"><?= $voucherObj->address ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </div>
		
			<?php $previousVoucherid = $voucherObj->id; ?>
        
        <?php endforeach; ?>

        <?php else: ?>
            <p>No vouchers</p>
        <?php endif; ?>

       