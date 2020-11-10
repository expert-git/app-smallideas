
        
        <?php 

			//to ensure backlink goes back same path
			if(isset($_GET['parent'])){
				switch($_GET['parent']){
					case 'browse':  //within play
						$parentid = (isset($_GET['id'])) ? $_GET['id'] : 1;
						$parent = '&parent=browsecat&parentid='.$parentid;
						break;
					case 'regions':
						$parentid = (isset($_GET['regionid'])) ? $_GET['regionid'] : 1;
						$parent = '&parent=regionscat';
						break;
				}		
			} else {
				$parent = '&parent=browse';
			}			

            foreach($categoryObjArr as $catObj){
                $region = ($regionId) ? "&regionid=".$regionId : "";
        		
				$href = ($catObj->hasChildren && !$regionId) ? "categories.html?id=".$catObj->id.$region.$parent : "category.html?id=".$catObj->id.$region.$parent;
				
				echo '<div class="row">
			            <a class="btn blue lrg" data-transition="slide" data-inline="true" href="'.$href.'">'.$catObj->name.'</a>
			        </div>';
       		 } 
	   ?>

       <!-- also show 'visit' regions  at top level-->	   
	   <?php if(!$regionId && !$categoryId): ?>
	   <!--<div class="row">
       		<a class="btn green lrg" data-transition="slide" data-inline="true" href="category.html?regionid=6&parent=browse">Visit Ballarat</a>
       </div>        
                
       <div class="row">
       		<a class="btn green lrg" data-transition="slide" data-inline="true" href="category.html?regionid=7&parent=browse">Visit Geelong & Bellarine</a>
       </div>        
                
       <div class="row">
       		<a class="btn green lrg" data-transition="slide" data-inline="true" href="category.html?regionid=8&parent=browse">Visit Mornington Peninsula</a>
       </div> -->
		   
		   <!--
 	    <div class="row">
        		<a class="btn green lrg" data-transition="slide" data-inline="true" href="category.html?regionid=9&parent=browse">Visit NSW</a>
        </div>        
                
        <div class="row">
        		<a class="btn green lrg" data-transition="slide" data-inline="true" href="category.html?regionid=10&parent=browse">Visit WA</a>
        </div>        
		
        <div class="row">
        		<a class="btn green lrg" data-transition="slide" data-inline="true" href="category.html?regionid=11&parent=browse">Visit QLD</a>
        </div>-->
		
		<?php if($regionObjArr): ?>
			<?php foreach($regionObjArr as $rObj): ?>
			
	 	    	<div class="row">
	        		<a class="btn green lrg" data-transition="slide" data-inline="true" href="category.html?regionid=<?= $rObj->id ?>&parent=browse"><?= $rObj->name ?></a>
				</div>
			
			<?php endforeach; ?>
			
		<?php endif; ?>
		
                

	   <?php endif;?>