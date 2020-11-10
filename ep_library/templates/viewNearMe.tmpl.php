
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


        <div class="note note-error hidden" id="no-location">
			<p>We couldn't determine your location. </p>
			<div style="font-size:12px;text-align:left;">
				<p>If you denied access to 'Use your location' when prompted, you'll need to reset your location permissions -<br><br>
					<strong>iPhone</strong>, go to Settings -> General -> Reset -> Reset Location & Privacy.  After doing this, come back to this app, and <a href="javascript:;" id="reload">refresh the page</a>, ensuring to <strong>click Allow when prompted</strong>.<br><br>
					<strong>Android</strong>, see instructions here <a href="https://support.google.com/chrome/answer/142065?hl=en" target="_blank">https://support.google.com/chrome/answer/142065?hl=en</a>
				</p>
				<p>If you still don't get prompted to 'Allow location' after following the above, please ensure you have location services enabled on your phone.</p>
			</div>
		</div>


        <div id="all-vouchers">
            <div class="loading">Finding results...</div>
        </div>


       