
        
        <?php
            $parent = '&parent=regions';									
        ?>

        <?php foreach($regionObjArr as $regionObj): ?>        
        <div class="row">
            <?php
			
				$url = "categories.html?regionid={$regionObj->id}{$parent}";
			
                //'visit... regions should go straight into the vouchers'
				//states with little vouchers should go straigh to vouchers too							
                if(strpos($regionObj->name,'Visit ')!==false || in_array($userObj->state,$statesStraightToVouchersArr)){
               		$url = "category.html?regionid={$regionObj->id}{$parent}";
                }
				
				//if($regionObj->id > 8)
				//	continue; // temporarily hide wa nsw
            ?>
            <a class="btn green lrg" data-transition="slide" data-inline="true" href="<?= $url ?>"><?= $regionObj->name ?></a>
        </div>        
        <?php endforeach; ?>

       