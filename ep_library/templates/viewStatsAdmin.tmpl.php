

<?php
	
	$year = (isset($_GET['year'])) ? $_GET['year'] : "";
	$month = (isset($_GET['month'])) ? $_GET['month'] : "";
	$voucher = (isset($_GET['voucher'])) ? $_GET['voucher'] : "";
	$state = (isset($_GET['state'])) ? $_GET['state'] : "";
	
	$yearNow = date('Y')*1;
	
?>					
                  
                            

                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Stats</span>
                                    </div> 
                                    <div class="pull-right">
                                        
                                        <a href="/manager/stats-user.php"><i class="fa fa-download"></i> Download User Redeems</a>
                                    </div>                                   
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row stat-control">

                                            <form method="get">
	                                            <div class="col-md-2">
	                                              State
												  <select class="form-control" id="state" name="state">
													  <option value="">Any</option>
													  <option value="VIC" <?= ($state=='VIC') ? 'selected' : ''; ?>>VIC</option>
													  <option value="NSW" <?= ($state=='NSW') ? 'selected' : ''; ?>>NSW</option>
													  <option value="QLD" <?= ($state=='QLD') ? 'selected' : ''; ?>>QLD</option>
													  <option value="SA" <?= ($state=='SA') ? 'selected' : ''; ?>>SA</option>
													  <option value="WA" <?= ($state=='WA') ? 'selected' : ''; ?>>WA</option>													  													<option value="Playgroup NSW" <?= ($state=='Playgroup NSW') ? 'selected' : ''; ?>>Playgroup NSW</option>										  													  
												  </select>
											  											 
	                                            </div>
	                                            <div class="col-md-2">
	                                              Year
												  <select class="form-control" id="year" name="year">
													  <option value="">Any</option>
													  <?php 
													  	for($i=2017;$i<=$yearNow;$i++){
															$selected = ($i==$year) ? 'selected' : '';
													  		echo '<option '.$selected.'>'.$i.'</option>';
													  	}
													  ?>
												  </select>
											  											 
	                                            </div>
	                                            <div class="col-md-2">
                                              
												  Month
												  <select class="form-control" id="month" name="month" <?= (!$year) ? 'disabled' : '' ?>>
													  <option value="">Any</option>
													  <option value="01" <?= ($month=='01') ? 'selected' : ''; ?>>JAN</option>
													  <option value="02" <?= ($month=='02') ? 'selected' : ''; ?>>FEB</option>
													  <option value="03" <?= ($month=='03') ? 'selected' : ''; ?>>MAR</option>
													  <option value="04" <?= ($month=='04') ? 'selected' : ''; ?>>APR</option>
													  <option value="05" <?= ($month=='05') ? 'selected' : ''; ?>>MAY</option>
													  <option value="06" <?= ($month=='06') ? 'selected' : ''; ?>>JUN</option>
													  <option value="07" <?= ($month=='07') ? 'selected' : ''; ?>>JUL</option>
													  <option value="08" <?= ($month=='08') ? 'selected' : ''; ?>>AUG</option>
													  <option value="09" <?= ($month=='09') ? 'selected' : ''; ?>>SEP</option>
													  <option value="10" <?= ($month=='10') ? 'selected' : ''; ?>>OCT</option>
													  <option value="11" <?= ($month=='11') ? 'selected' : ''; ?>>NOV</option>
													  <option value="12" <?= ($month=='12') ? 'selected' : ''; ?>>DEC</option>
												  </select>
											  											 
	                                            </div>
	                                            <div class="col-md-3">
                                              
												  Voucher
												  <select class="form-control" id="voucher" name="voucher" >
													  <option value="">Any</option>
													  <?php

														  foreach($availableVoucherHistoryObjArr as $option){
															  $selected = ($option->voucherId==$voucher) ? 'selected' : '';
															  echo "<option value='{$option->voucherId}' {$selected}>{$option->businessName}</option>\n";
														  }
													  ?>
												  </select>
											  											 
	                                            </div>
											
												<div class="col-md-3">
													&nbsp;<br>
													<input type="submit" class="blue btn" value="Go">
												</div>
											</form>
                                            
                                          
                                        </div>
                                    </div>



                                    <table class="table table-striped table-hover table-bordered" id="usertable">
                                        <thead>
                                            <tr>
                                                <th> Voucher ID </th>                        
                                                <th> Business Name </th>
                                                <th> Voucher Title </th>
                                                <th> Redeemed <?= $totalCount ?> </th>										                               
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
                                        
                                                if(isset($sortedVoucherHistoryObjArr)){
                                                    foreach($sortedVoucherHistoryObjArr as $id => $voucherObj){
                                                                                                                                                                                             
                                                        echo "<tr>                                                                
                                                                <td style='color:#ddd'>{$voucherObj->voucherId}</td>															
                                                                <td>{$voucherObj->businessName}</td>
                                                                <td>{$voucherObj->title}</td>
                                                                <td>{$voucherHistoryCount[$id]}</td>                                                            
                                                            </tr>";
                                                    }
                                                }
											?>

                                            
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->



							