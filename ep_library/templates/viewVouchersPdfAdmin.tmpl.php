                           <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">All Vouchers PDF</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-9">
                                               <a class="btn blue pull-right" href="/manager/voucher-pdf.php"><i class="fa fa-plus"></i> Add Voucher PDF</a>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-hover table-bordered" id="usertable">
                                        <thead>
                                            <tr>
                                                <th>Voucher Business Name</th>
												<th>Voucher Title</th>
                                                <th>PDF Status</th>     
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php                                        
                                                if(isset($voucherObjArr)){
                                                    foreach($voucherObjArr as $voucherObj){
														
												 $status = 'Sold out';
                                                if($voucherObj->status == 1){
												 $status = 'Available';	
												}
												
                                                        echo "<tr>   
                                                                <td>{$voucherObj->businessName}</td>
																<td>{$voucherObj->title}</td>";
                                                        echo "<td>{$status}</td>";
                                                        echo "<td>
                                                                    <a href='/manager/voucher-pdf.php?id={$voucherObj->id}'> <i class='fa fa-edit'></i> Edit </a>
																	</td>
                                                                <td>
                                                                    <a class='delete' data-toggle='confirmation' data-singleton='true' data-voucherpdfid='{$voucherObj->id}' href='javascript:;'> <i class='fa fa-close'></i> </a>
                                                                </td>
                                                            </tr>";
                                                    }
                                                }
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->