                        <div class="col-md-6">

                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Edit User</span>
                                    </div>                                    
                                </div>

                                
								
                                    <div class="col-md-12">
                                        <?php if(!$userObj): ?>
                                        <p class="note note-info">If you're manually creating a login for a customer, you'll need to email their login details to them. </p>
                                        <?php endif; ?>

                                        <form class="edit-user" style="margin-top:55px;">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email<sup>*</sup></label>
                                            <div class="col-md-9">
                                                <div class="input-icon input-icon-md right">
                                                    <i id="emailok" class="fa hidden fa-check font-green"></i> <i id="emailtaken" class="fa hidden fa-close font-red"></i>
                                                    <input type="text" class="form-control" name="email" value="<?= ($userObj) ? $userObj->email : "" ?>" autocomplete="off"> 
                                                    <span class="help-block"> </span>
                                                </div>
                                            </div>
											<div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Password<sup>*</sup></label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="password" value="<?= ($userObj) ? "00000000" : "" ?>" autocomplete="off">
                                                <span class="help-block"> </span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php if($userObj): ?><input type="hidden" name="userId" value="<?= $userObj->id ?>" ><?php endif; ?>
                                        </div>                                        
                                        
	                                    <div class="form-group">
	                                        <label class="col-md-3 control-label">State</label>
	                                        <div class="col-md-9">                                        
	                                            <select name="state" id="user-state" class="form-control">                                                  
	                                                <?php 
														$stateArr = array('VIC','NSW','QLD','SA','WA','Playgroup NSW');
														$uStateOption = ($userObj->userGroup) ? $userObj->userGroup : $userObj->state;
	                                                    foreach($stateArr as $state){   
	                                                        $selected = ($userObj && $uStateOption == $state) ? 'selected' : '';
	                                                        echo "<option value='{$state}' {$selected}>{$state}</option>";
	                                                    }
	                                                ?>                                                        
	                                            </select>
	                                            <span class="help-block"> </span> 
	                                        </div>
											<div class="clearfix"></div>
	                                    </div>
										
										
                                        <div class="form-group" >
                                            <label class="col-md-3 control-label">Expiry</label>
                                            <div class="col-md-9" >
                                 
                                                <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="-1d">
                                                        <input type="text" class="form-control" name="accountExpiry" readonly value="<?= ($userObj->accountExpiry) ? $userObj->accountExpiry : date('Y-m-d',strtotime('+1 year')) ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                    

                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
										
										<div class="form-group" >
											<?php 
												switch($userObj->isSubscription){
													case 0:
														$accountType = 'No subscription (is a Gift or old account)';
														break;
													case 1:
														$accountType = '12 Month subscription';
														break;																							
												}
											?>										
	                                        <label class="col-md-3 control-label">Account Type</label>
	                                        <div class="col-md-9">
												<?= $accountType ?>
											</div>
                                            
                                            <div class="clearfix"></div>
                                        </div>
										
										
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Is a trial account?</label>
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline" style="padding-top:0px;">
                                                    <label class="mt-radio">
                                                        <input type="radio" name="isTrialAccount" value="1" <?= ($userObj->isTrialAccount) ? 'checked' : ''; ?>> Yes
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio">
                                                        <input type="radio" name="isTrialAccount" value="0" <?= ($userObj->isTrialAccount) ? '' : 'checked'; ?>> No
                                                        <span></span>
                                                    </label>
                                                    
                                               
                                                </div>
												<div class="help-block">
													<?php if($userObj->trialFirstName): ?>
														Name on trial signup - <strong><?= $userObj->trialFirstName ?> <?= $userObj->trialLastName ?> </strong>
													<?php endif;?>
												</div>
												
                                                <span class="help-block"> A trial account will expire after <?= TRIAL_DAYS ?> days. To extend, alter the account expiry above.</span>
                                            </div>
                                        </div>
										
										
                                        
                                        </form>
									</div>							
                                    <div class="col-md-12">
                                        <hr>
                                        <a class="btn red pull-left" href="/manager/">Cancel</a>
                                        <a class="btn green save-user pull-right"><?= ($userObj) ? "Save Changes" : "Create User" ?></a>
                                    </div>                                                                                                                            
                                    <div class="clearfix"></div>
									<br>	

                                </div>

                          </div>    