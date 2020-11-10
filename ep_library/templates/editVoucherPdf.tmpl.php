    <form class="edit-voucher_pdf" enctype="multipart/form-data">
                        <div class="col-md-12">

                            <div class="portlet light portlet-fit ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Edit Voucher PDF</span>
                                    </div>                                    
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Vouchers<sup>*</sup></label>
                                        <div class="col-md-9">
                                          <div class="input-icon input-icon-md right">
                                            <select name="voucherId" class="form-control">  
                                                <?php 
                                                    foreach($voucherObj as $vObj){
                                                        $selected = ($voucherPdfObj && $voucherPdfObj->voucherId == $vObj->id) ? 'selected' : '';
                                                        echo "<option class='catoption catoption-{$vObj->id}' value='{$vObj->id}'{$selected}>{$vObj->businessName} - {$vObj->title}</option>";
                                                    }
                                                ?>    
                                            </select>
                                             <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">PDF File<sup>*</sup></label>
                                        <div class="col-md-9">
										<div class="input-icon input-icon-md right">
                                            <?php if($voucherPdfObj && $voucherPdfObj->fileName): ?>
                                            <div id="sortable_images">
                                                <div class='sortable-image' id='<?= $voucherPdfObj->fileName?>'><a href='/images/pdf/<?=$voucherPdfObj->fileName ?>' class='thumbnail' target="_blank">PDF view</a></div>                 
                                            </div>
                                            <div class="clearfix"></div>                                        
                                            <?php endif; ?>  
                                               <input name="pdfFile" type="file" class="form-control"/>
											     <span class="help-block"> </span>
											</div>
                                         </div>   
                                     </div> 
		
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Status<sup>*</sup></label>
                                        <div class="col-md-9">
                                            <div class="input-icon input-icon-md right">
                                               <select name="status" class="form-control">
											    <option value="1" <?php echo ($voucherPdfObj && $voucherPdfObj->status == 1) ? 'selected' : ''?>>Available</option>
												<option value="0" <?php echo ($voucherPdfObj && $voucherPdfObj->status == 0) ? 'selected' : ''?>>Sold out</option>
											   </select>
                                                <span class="help-block"> </span>
                                            </div>
                                        </div>
                                    </div>
									
                                    <?php if($voucherPdfObj): ?><input type="hidden" name="voucherPdfId" value="<?=$voucherPdfObj->id?>" ><?php endif; ?>
                                </div>

                                <div class="clearfix"></div> 
                                <br>
                            </div> <!-- end portlet -->

                        </div> 
                        
                        <div class="col-md-12">
                            <a class="btn red save-user pull-left" href="/manager/vouchers-pdf..php">Cancel</a>
                            <a class="btn green save-voucherPdf pull-right"><?= ($voucherPdfObj) ? "Save Changes" : "Create Voucher PDF" ?></a>
                        </div>                                                  
                            
                        <div class="clearfix"></div>
    </form>  