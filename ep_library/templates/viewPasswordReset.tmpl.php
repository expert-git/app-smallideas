
            

                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container">
    
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">

                                        <div class="contact-details">
                                        <div class="row">
                                              
                                            <div class="col-md-9">
                                                <div class="portlet light">
                                                    <div class="col-md-12">
                                                        <p>Reset password for <strong><?= $userObj->email ?></strong>.  Ensure that the new password is at least 6 characters long, and includes both numbers &amp; letters.</p>                                                        
                                                    </div>
                                                    <div class="clearfix"></div>                                                    
                                                    <div class="note note-success hidden">
                                                        <h4 class="block">Reset!</h4>
                                                        <p>Your password has been reset. <a data-toggle="modal" href="#login" href="javascript:;">Login here</a>.</p>
                                                    </div>
                               
                                                        

                                                    <form role="form" class="resetpw main">                                 
                                                        <div class="form-group">
                                                            <label for="newpassword" class="col-md-3">Enter New Password:</label>
                                                            <div class="col-md-7">                                                        
                                                                <input class="form-control" name="newpassword" type="password" > 
																<input class="form-control" name="url" value="<?= $userObj->passwordResetUrl ?>" type="hidden" >                                                 
                                                            </div>   
                                                            <div class="clearfix"></div>                                          
                                                        </div>                                                        
                
                                                        <div class="col-md-3">&nbsp;</div>
                                                        <div class="col-md-7">                                
                                                            <div class="login-button"><input type="submit" class="btn blue mt-ladda-btn ladda-button" data-style="expand-right" value="Reset Password"> </div>
                                                        </div>
                                                        <div class="clearfix"></div>

                                                    </form>

                                                </div>                        
                                            </div>
                                            <div class="clearfix"></div>

                                        </div>
                                        </div>
                                    </div>
                                <!-- END PAGE CONTENT INNER -->
                            </div>
                        </div>
                        <!-- END PAGE CONTENT BODY -->