   <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">                            

                             <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-list"></i>
                                        <span class="caption-subject sbold uppercase">Order Status</span>
                                    </div>                                    
                                </div>

                                <div class="portlet-body">
                                                                      
                                 
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th> Restaurant </th>
                                                    <th> Week Starting <?= date('D jS M Y',strtotime($currentWeekStart)) ?> - Status</th>
                                                    <th> Archive </th>                                                                                                        
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? foreach($restaurantObjArr as $restaurantObj): ?>
                                                <tr>
                                                    <td> <?= $restaurantObj->name ?> </td>
                                                    <td> 
                                                        <?php 
                                                            $orderObj = $restaurantObj->getLatestOrder();
                                                            if($orderObj->id){
                                                                echo "<a href='order.php?id={$orderObj->id}'>{$orderObj->status}</a> ";
                                                            } else {
                                                                echo "{$orderObj->status}";
                                                            }
                                                        ?>                                                     
                                                    </td>
                                                    <td> <a href="/orders.php?restaurantid=<?= $restaurantObj->id ?>">View All</a> </td>                                                    
                                                </tr>                    
                                                <? endforeach; ?>                           
                                            </tbody>
                                        </table>
                                    </div>




                                     
                                </div>                               
                            </div>
                            <!-- END Portlet -->


                           

                            

                            

                        </div>
                        




                        <div class="clearfix"></div>
                    </div>
                    
