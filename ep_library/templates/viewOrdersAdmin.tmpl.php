                           <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">All Orders</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-9"></div>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-hover table-bordered" id="usertable">
                                        <thead>
                                            <tr>									
												<th>Order No.</th> 
												<th>Transaction ID</th>
												<th>Paid Amount</th>
                                                <th>Voucher Business Name</th>
												<th>Voucher Title</th>
                                                <th>Status</th>
												<th>Date</th>
												<th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
			<?php   
                if(isset($voucherObjArr)){
                    foreach($voucherObjArr as $voucherObj){
						$status = $voucherObj->paymentStatus;
                        $date = date('d M, Y', strtotime($voucherObj->created));
												
                     echo "<tr> 
							<td>".$voucherObj->id."</td>	
							<td>".$voucherObj->txnId."</td>";
					echo "<td>$".$voucherObj->paidAmount."</td>";														
					echo "<td>".$voucherObj->businessName."</td>
							<td>".$voucherObj->title."</td>";
                    echo "<td>".$status."</td>
							<td>".$date."</td>
							<td><a href='/manager/order.php?id=".$voucherObj->id."'>View</a></td>";
                                                        echo "</tr>";
                                                    }
                                                }
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->