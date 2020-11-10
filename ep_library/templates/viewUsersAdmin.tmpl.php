


                  
                            

                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">All Users</span>
                                    </div>                                    
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">

                                            
                                            <div class="col-md-12">
                                               <a class="btn blue pull-right" href="/manager/user.php"><i class="fa fa-plus"></i> Add User</a>
                                            </div>
                                            
                                          
                                        </div>
                                    </div>



                                    <table class="table table-striped table-hover table-bordered" id="usertable">
                                        <thead>
                                            <tr>
                                                                                                
                                                <th> Email </th>
												<th> Access to</th>											
                                                <th> First registered </th>
                                                <th> Expiry </th>
                                                <th> Is Trial? </th>										                               
                                                <th> Edit </th>
                                                <th> Delete </th>
                                            </tr>
                                        </thead>
                                        <tbody>

											<?php
                                        
                                                if(isset($userObjArr)){
                                                    $now = date('Y-m-d');
                                                    foreach($userObjArr as $userObj){
                                                                                    
                                                        $thedate = date('Y/m/d',strtotime($userObj->registeredDatetime));
                                                        $trial = ($userObj->isTrialAccount) ? '<i class="fa fa-check"></i>' : '';
                                                        $expiry = date('Y-m-d',strtotime($userObj->accountExpiry));  
														$expiryDisplay = date('Y/m/d',strtotime($userObj->accountExpiry));  
                                                        $expired = ($expiry > $now) ? 'not-expired' : 'account-expired';
														$uState = ($userObj->userGroup) ? $userObj->userGroup : $userObj->state;

                                                        echo "<tr>                                                                
                                                                <td>{$userObj->email}</td>
																<td>{$uState}</td>
                                                                <td>{$thedate}</td>
                                                                <td class='{$expired}'>{$expiryDisplay}</td>
                                                                <td>{$trial}</td>
                                                                <td>
                                                                    <a href='/manager/user.php?id={$userObj->id}'> Edit </a>
                                                                </td>
                                                                <td>
                                                                    <a class='delete delete-user' data-userid='{$userObj->id}' href='javascript:;' data-toggle='confirmation' data-singleton='true'> <i class='fa fa-close'></i> </a>
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



							