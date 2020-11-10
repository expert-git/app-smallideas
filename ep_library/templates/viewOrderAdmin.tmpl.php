                           <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Orders Details</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                 <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-3">
										 <p><b>Order No.: </b><?=$orderObjArr->id?></p>
										 <p><b>Transaction ID:</b></p>
										 <p><b>Processing fee:</b></p>
										 <p><b>Paid Amount:</b></p>
                                         <p><b>Voucher Business Name:</b></p>
										 <p><b>Voucher Title:</b></p>
                                         <p><b>Status: </b><?=$orderObjArr->paymentStatus?></p>
										 <p></p> 
                                        </div>
                                        <div class="col-md-9">
										 <p><b>Quantity: </b><?=$orderObjArr->quantity?></p>
										 <p><?=$orderObjArr->txnId?></p>
										 <p><?=$orderObjArr->tax?>%</p>		 
										 <p>$<?=$orderObjArr->paidAmount?> <?=strtoupper($orderObjArr->pac)?></p> 
										 <p><?=$orderObjArr->businessName?></p>  
										 <p><?=$orderObjArr->title?></p>
										 <p><b>Date: </b><?=date('d M, Y', strtotime($orderObjArr->created));?></p>
										</div>
									</div>									
										<hr>
									<div class="row">
										<div class="col-md-12"><h4>Customer information</h4></div>
										<div class="col-md-3">
										 <p><b>Name:</b></p>
										 <p><b>Email ID:</b></p>
                                        </div>
                                        <div class="col-md-9">
										 <p><?=$orderObjArr->name?></p>
										 <p><?=$orderObjArr->email?></p>
										</div>
                                    </div>
                                 </div>

                                    <table class="table table-striped table-hover table-bordered" id="usertable">
                                        <thead>
                                            <tr>									
												<th>Item Price</th> 
												<th>e-Voucher</th>
                                            </tr>
                                        </thead>
                                        <tbody>
			<?php 
                if(isset($ordItemObjArr)){
                    foreach($ordItemObjArr as $oiObj){				
                     echo "<tr>"; 
					 echo "<td>".$oiObj->itemPrice." ".strtoupper($orderObjArr->pac)."</td><td><a href='/images/pdf/".$oiObj->fileName."' target='_blank'>PDF view</a></td>";
                     echo "</tr>";
                                                    }
                                                }
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->