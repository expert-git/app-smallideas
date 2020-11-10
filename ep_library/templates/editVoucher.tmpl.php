                       <form class="edit-voucher">
                      
                        <div class="col-md-6">

                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Edit Voucher</span>
                                    </div>                                    
                                </div>

                                <div class="col-md-12">                                    

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Business Name<sup>*</sup></label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">                                                    
                                                <input type="text" class="form-control" placeholder="eg Luna Park" name="businessName" value="<?= ($voucherObj) ? $voucherObj->businessName : "" ?>" autocomplete="off"> 
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Voucher Title<sup>*</sup></label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">                                                    
                                                <input type="text" class="form-control" placeholder="SAVE 15%" name="title" value="<?= ($voucherObj) ? $voucherObj->title : "" ?>" autocomplete="off"> 
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">                                                    
                                                <input type="text" class="form-control" placeholder="eg 5 Main St, Mornington" name="address" value="<?= ($voucherObj) ? $voucherObj->address : "" ?>" autocomplete="off"> 
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>
									
                                    

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Phone</label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">                                                    
                                                <input type="text" class="form-control" placeholder="(03) 9876 9876" name="phone" value="<?= ($voucherObj) ? $voucherObj->phone : "" ?>" autocomplete="off"> 
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>
									
		
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Website</label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">                                                    
                                                <input type="text" class="form-control" placeholder="www.mywebsite.com.au" name="web" value="<?= ($voucherObj) ? $voucherObj->web : "" ?>" autocomplete="off"> 
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>

                                  
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">State<sup>*</sup></label>
                                        <div class="col-md-9">                                        
                                            <select name="state" id="voucher-state" class="form-control">                                                  
                                                <?php 
													$stateArr = array('VIC','NSW','QLD','SA','WA');
                                                    foreach($stateArr as $state){   
                                                        $selected = ($voucherObj && $voucherObj->state == $state) ? 'selected' : '';
                                                        echo "<option value='{$state}' {$selected}>{$state}</option>";
                                                    }
                                                ?>                                                        
                                            </select>
                                            <span class="help-block"> </span> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Region<sup>*</sup></label>
                                        <div class="col-md-9">
											
											<?php 
												$initialState = ($voucherObj && $voucherObj->state) ? $voucherObj->state : 'VIC'; 											
											?>
											
                                            <?php foreach($regionObjArr as $regionObj): ?>
                                            <div class="col-md-12 region region-<?= $regionObj->state ?> <?= ($regionObj->state != $initialState) ? 'disabled' : '' ?>">
                                                <label class="mt-checkbox mt-checkbox-outline"> <?= $regionObj->name ?>
                                                    <input type="checkbox" value="1" name="region-<?= $regionObj->id ?>" <?= (isset($voucherObj->regions[$regionObj->id])) ? 'checked' : '';?> />
                                                    <span></span>
                                                </label>
                                            </div>                                                                           
                                            <?php endforeach; ?>                                                        
                                            
                                            
                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Category<sup>*</sup></label>
                                        <div class="col-md-9">                                        
                                            <select name="categoryId" class="form-control">  
                                                <option>Category...</option>                                                                                                                   
                                                <?php 
                                                    foreach($catObjArr as $catObj){   
                                                        $disabled = ($catObj->hasChildren=='1') ? 'disabled' : '';
                                                        $indented = ($catObj->parentId) ? " - " : '';
                                                        $selected = ($voucherObj && $voucherObj->categoryId == $catObj->id) ? 'selected' : '';
														$initialDisabled = ($catObj->state != $initialState) ? 'disabled' : '';
                                                        echo "<option class='catoption catoption-{$catObj->state} {$initialDisabled}' value='{$catObj->id}' {$disabled}{$selected}>{$indented}{$catObj->name}</option>";
                                                    }
                                                ?>                                                        
                                            </select>
                                            <span class="help-block"> </span>
                                        </div>
                                    </div>
									

                                    <?php
                                        $defaultFromDate = date('Y-m-d',strtotime($nextYear."-01-01"));                                            
                                        $defaultToDate = date('Y-m-d',strtotime($nextYear."-12-31"));
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Valid from</label>
                                        <div class="col-md-9">
                                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control"  value="<?= ($voucherObj && $voucherObj->validFrom) ? $voucherObj->validFrom : $defaultFromDate ?>" name="validFrom" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Valid to</label>
                                        <div class="col-md-9">
                                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control"  value="<?= ($voucherObj && $voucherObj->validTo) ? $voucherObj->validTo : $defaultToDate ?>" name="validTo" autocomplete="off">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div> 
                                    </div>
									
									
									

                                    <div class="form-group allowMonthlyUse" style="<?= ($voucherObj && $voucherObj->isOnlineCoupon == 2) ? 'display:none' : 'display:block' ?>">
                                        <label class="col-md-3 control-label">Voucher Use<sup>*</sup></label>
                                        <div class="col-md-9">
                                            <select name="allowMonthlyUse" class="form-control">  
                                                <option value="0" <?= ($voucherObj && $voucherObj->allowMonthlyUse == 0) ? 'selected' : '' ?>>Once only</option>                                                                            <option value="1" <?= ($voucherObj && $voucherObj->allowMonthlyUse == 1) ? 'selected' : '' ?>>Once per month</option>                      
                                                <option value="2" <?= ($voucherObj && $voucherObj->allowMonthlyUse == 2) ? 'selected' : '' ?>>Once per week</option>                                                                                                                                                                       
                                            </select>
                                            <span class="help-block"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Voucher type<sup>*</sup></label>
                                        <div class="col-md-9">
											<select name="isOnlineCoupon" class="form-control">  
											                                                <option value="0" <?= ($voucherObj && $voucherObj->isOnlineCoupon == 0) ? 'selected' : '' ?>>Regular voucher</option>                                                                                     
											                                                <option value="1" <?= ($voucherObj && $voucherObj->isOnlineCoupon == 1) ? 'selected' : '' ?>>Online only coupon code</option>
											                                                <option value="2" <?= ($voucherObj && $voucherObj->isOnlineCoupon == 2) ? 'selected' : '' ?>>Neat Ideas voucher</option>
																							<option value="3" <?= ($voucherObj && $voucherObj->isOnlineCoupon == 3) ? 'selected' : '' ?>>Experience Oz voucher</option>														
	<option value="4" <?= ($voucherObj && $voucherObj->isOnlineCoupon == 4) ? 'selected' : '' ?>>Online Purchase</option>					
											                                            </select>
                                            <span class="help-block"> </span>
                                        </div>
                                    </div>  
									
                                    <div class="form-group onlineCouponText" style="<?= ($voucherObj && $voucherObj->isOnlineCoupon == 1) ? 'display:block' : 'display:none' ?>">
                                        <label class="col-md-3 control-label">Online Coupon Text</label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right"> 
												
                                                <input type="text" class="form-control" placeholder="" name="onlineCouponFix" value="<?= ($voucherObj) ? $voucherObj->onlineCouponText : '' ?>" autocomplete="off">                                                                                         
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="form-group neatIdeas" style="<?= ($voucherObj && $voucherObj->isOnlineCoupon == 2) ? 'display:block' : 'display:none' ?>">
                                        <label class="col-md-3 control-label">Neat Ideas ID</label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">  
                                                <input type="text" class="form-control" placeholder="" name="neatIdeasId" value="<?= ($voucherObj) ? $voucherObj->neatIdeasId : "" ?>" autocomplete="off"> 
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group neatIdeas" style="<?= ($voucherObj && $voucherObj->isOnlineCoupon == 2) ? 'display:block' : 'display:none' ?>">
                                        <label class="col-md-3 control-label">Neat Ideas ID Type</label>
                                        <div class="col-md-9">
											<select name="neatIdeasType" class="form-control">  
                                                <option value="0" <?= ($voucherObj && $voucherObj->neatIdeasType == 0) ? 'selected' : '' ?>>Product</option>
												<option value="1" <?= ($voucherObj && $voucherObj->neatIdeasType == 1) ? 'selected' : '' ?>>Category</option>
                                            </select>
                                            <span class="help-block"> </span>
                                        </div>
                                    </div>
									
                                    <div class="form-group experienceOz" style="<?= ($voucherObj && $voucherObj->isOnlineCoupon == 3) ? 'display:block' : 'display:none' ?>">
                                       <label class="col-md-3 control-label">Experience Oz URL</label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">  
                                                <input type="text" class="form-control" placeholder="" name="experienceOzLink" value="<?= ($voucherObj) ? $voucherObj->onlineCouponText  : "" ?>" autocomplete="off">                                                                                                               
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="form-group onlineVoucherText" style="<?= ($voucherObj && $voucherObj->isOnlineCoupon == 4) ? 'display:block' : 'display:none' ?>">
                                        <label class="col-md-3 control-label">Voucher cost($)</label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right"> 
												
                                                <input type="number" class="form-control" placeholder="" name="onlineVoucherText" value="<?= ($voucherObj) ? $voucherObj->onlineCouponText : '1' ?>" autocomplete="off" min="1">
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
									<?php if($voucherObj): ?>	
										<div class="col-md-12">
										 <h4>Available PDF for this voucher <?=$ablPdfCount?></h4>
										</div>
									<?php endif; ?>	
                                    </div>
									
                                    <?php if($voucherObj): ?><input type="hidden" name="voucherId" value="<?= $voucherObj->id ?>" ><?php endif; ?>
                                    

                                </div>

                                <div class="clearfix"></div> 
                                <br>
                            </div> <!-- end portlet -->



                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Locations <span style="color:#aaa;font-weight:normal;">(vouchers near me functionality)</span></span>
                                    </div>                                    
                                </div>

                                <div class="col-md-12">      

                                    <p>Add location(s) below if you want to include the voucher in 'vouchers near me'.</p>                              

                                  <div class="form-group mt-repeater locations" style="margin-bottom:20px;">
                                        <div data-repeater-list="location-group" class="repeater-group">
                                            <div data-repeater-item class="mt-repeater-item itinery-item">
                                                <div class="row mt-repeater-row">
                                                                         
                                                    <div class="col-md-7">
                                                        <div class="form-group title">
                                                            <label class="control-label">Address</label>                                                                                        
                                                            <input name="address" class="form-control address" placeholder="eg 12 Main St, Mornington, VIC, 3931" readonly>
                                                        </div>
                                                    </div>                
                                                    <div class="col-md-2">
                                                        <label class="control-label">Coordinates</label>                                                                                        
                                                        <div class="coords">
                                                            <span class="alert-danger notset">NOT SET!</span>  
                                                            <input class="form-control coordinate lat" name="lat" value="" />
                                                            <input class="form-control coordinate lng" name="lng" value="" />                                                                                                                
                                                        </div>
                                                        
                                                    </div>                                                            
                                                     <div class="col-md-2">
                                                        <label class="control-label">&nbsp;</label> 
                                                        <a style="display:block;" class="btn blue set-coords" data-toggle="modal" href="#location-modal">Set </a>
                                                     </div>
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>                                                                            

                                                </div>
                                            </div>
                                            
                                        </div>
                                        <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add blue">
                                            <i class="fa fa-plus"></i> Add Location
                                        </a>
                                    </div>


                                    

                                </div>

                                <div class="clearfix"></div> 
                                <br>
                            </div> <!-- end portlet -->



                        </div>   

                        <div class="col-md-6">

                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings3 font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">&nbsp;</span>
                                    </div>                                    
                                </div>
                            
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Short description<sup>*</sup></label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">  
                                                <textarea class="form-control" name="description" placeholder="Present this Small Idea and receive 15% off" rows="3"><?= ($voucherObj && $voucherObj->description) ? $voucherObj->description : '' ?></textarea>                                                               
                                                
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3">Business description</label>
                                        <div class="col-md-9">
                                            <textarea class="wysihtml5 form-control" name="businessDescription" placeholder="Enter details about the business here" rows="12"><?= ($voucherObj && $voucherObj->businessDescription) ? $voucherObj->businessDescription : '' ?></textarea>             
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3">Photo</label>
                                        <div class="col-md-9">
                                            <?php if($voucherObj && $voucherObj->image): ?>
                                            <div id="sortable_images">
                                                <div class='sortable-image' id='<?= $voucherObj->image ?>'><a href='#' class='thumbnail '><img src='/images/voucher/cache-tn/<?= $voucherObj->image ?>' alt='' /></a><div class='remove'><i class='fa fa-remove'> </i> DELETE</div></div>                                                     
                                            </div>
                                            <div class="clearfix"></div>                                        
                                            <?php endif; ?>

                                            <input name="image" id="image" type="hidden" value="<?= ($voucherObj) ? $voucherObj->image : '' ?>" />
                                            <div class="dropzone dropzone-file-area" id="my-dropzone">       
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple />
                                                </div>
                                            </div>
                                         </div>   
                                     </div>   
                                    
                                    
                                </div>							
                                
                                <div class="clearfix"></div>
                                <br>
                            </div> <!-- end portlet -->

                        </div> 
                         
                        
                        <div class="col-md-12">
                            <a class="btn red save-user pull-left" href="/manager/vouchers.php">Cancel</a>
                            <a class="btn green save-voucher pull-right"><?= ($voucherObj) ? "Save Changes" : "Create Voucher" ?></a>
                        </div>                                                                                                                            
                            
                        <div class="clearfix"></div>

                      </form>    



                                            <!-- location modal -->
                                            <div class="modal fade" id="location-modal" tabindex="-1" role="basic" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                            <h4 class="modal-title">Set Location</h4>
                                                        </div>
                                                        <div class="modal-body">  



                                                            <form role="form" class="">

                                                                 <div class="form-group">
                                                                    <label class="col-md-2 control-label">Address</label>
                                                                    <div class="col-md-8">
                                                                        <div class="input-icon input-icon-md right">                                                    
                                                                            <input type="text" class="form-control" placeholder="eg 5 Main St, Mornington" id="address" name="search-address" value="<?= ($voucherObj) ? $voucherObj->address : "" ?>" autocomplete="off"> 
                                                                            <span class="help-block"> </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <a href="javascript:;" class="btn blue find" id="find">Find</a>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                                <p>Enter address above to find, or click map to set location.</p>
                                                                <div id="map" style="border:1px solid #ddd;height:400px;width:100%;"></div>
                                                                <input type="hidden" id="lat" />
                                                                <input type="hidden" id="lng" />

                                                            </form>   


                                                        </div> 
                                                        <!-- end modal body -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                                                 
                                                            <button type="button" id="location-save" class="btn green mt-ladda-btn ladda-button location-save" data-style="expand-right"><i class="fa fa-save"></i> Save</button>       
                                              
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->




                        <script>
                            var locationArr = [
                                <?php                                    
                                    if($voucherLocationObjArr){
                                        foreach($voucherLocationObjArr as $obj){
                                            $address = str_replace("'","\'",$obj->address);
                                            $lat = $obj->lat;
                                            $lng = $obj->lng;  
                                            echo "['{$address}','{$lat}','{$lng}'],";
                                        }
                                    }
                                ?>
                            ];
                        </script>   

                    