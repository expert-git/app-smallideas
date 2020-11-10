


                  
                            

                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">All Vouchers</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">

                                            <div class="col-md-3">
                                               <select name="state" class="form-control" id="stateSelector">  												                                                   
                                                   <?php 
												    	$currentState = (isset($_GET['state'])) ? $_GET['state'] : 'VIC';
   														$stateArr = array('VIC','NSW','QLD','SA','WA');
                                                       	foreach($stateArr as $state){   
                                                           $selected = ($currentState == $state) ? 'selected' : '';
                                                           echo "<option value='{$state}' {$selected}>{$indented}{$state}</option>";
                                                       	}
                                                   ?>                                                        
                                               </select>
                                            </div>
                                            <div class="col-md-9">
                                               <a class="btn blue pull-right" href="/manager/voucher.php"><i class="fa fa-plus"></i> Add Voucher</a>
                                            </div>
                                            
                                          
                                        </div>
                                    </div>



                                    <table class="table table-striped table-hover table-bordered" id="usertable">
                                        <thead>
                                            <tr>
                                                                                                
                                                <th> Business Name </th>
                                                <th> Voucher Title </th>
                                                <th> Valid From </th>										                               
                                                <th> Valid To </th>                                                                      
                                                <th> Edit </th>
                                                <th> Clone </th>
                                                <th> Delete </th>
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
                                        
                                                if(isset($voucherObjArr)){
                                                    foreach($voucherObjArr as $voucherObj){
                                        
                                                                                                    
                                                 
                                                        echo "<tr>                                                                
                                                                <td>{$voucherObj->businessName}</td>
                                                                <td>{$voucherObj->title}</td>
                                                                <td>{$voucherObj->validFrom}</td>
                                                                <td>{$voucherObj->validTo}</td>
       
                                                                <td>
                                                                    <a href='/manager/voucher.php?id={$voucherObj->id}'> <i class='fa fa-edit'></i> Edit </a>
                                                                </td>
                                                                <td> <a href='javascript:;' data-voucherid='{$voucherObj->id}' class='clone'><i class='fa fa-files-o'></i></a> </td>
                                                                <td>
                                                                    <a class='delete delete-voucher' data-toggle='confirmation' data-singleton='true' data-voucherid='{$voucherObj->id}' href='javascript:;'> <i class='fa fa-close'></i> </a>
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



							