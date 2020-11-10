
/* additional js functions not specific to theme functions */ 

$('document').ready(function(){


	/* generic datepicker enable */
	if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }
        
	$('.stat-control select').change(function(){
		if($('#year').val()==''){
			$('#month').val('').prop('disabled','disabled');
		} else {
			$('#month').prop('disabled',false);
		}
	});
		
	$('.save-user').click(function(e){

		//update existing
		$.ajax('/ajax/saveUser.php', {
			method: "POST",
			data: $('form.edit-user').serialize(),
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//saved			
					toastr["success"]("The user details were saved.", "Saved");
					window.location.href="/manager/";

				} else {
					if(result.reason == 'email'){
						toastr["error"]("That email address is already in use.", "ERROR");
					} else if(result.reason == 'password'){
						toastr["error"]("Ensure your password has letters & numbers", "ERROR");
					} else {
						//alert error
						toastr["error"]("There was a problem saving your changes.", "ERROR");
					}
										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem saving your changes.", "ERROR");
			}
		});		
		
	});


	if ((typeof locationArr !== "undefined") && (locationArr !== null)) { // the variable is defined and not null } 
		for(var i=0;i<locationArr.length;i++){	
			var address = locationArr[i][0].replace("&#39;","'");  //put html code back  
			var lat = locationArr[i][1];
			var lng = locationArr[i][2];

			 $('.locations .mt-repeater-row:last .address').val(address);
			 $('.locations .mt-repeater-row:last .lat').val(lat);
			 $('.locations .mt-repeater-row:last .lng').val(lng);			 
			 //alert(lng);
			 if(lng != 0 && lat != 0){
			 	$('.locations .mt-repeater-row:last .notset').addClass('hidden');
			 }
			 if(i<locationArr.length-1){
			 		$('.locations a.mt-repeater-add').click();
			 }
		}
	}


	var $row = null;

	$('.locations').on('click', '.set-coords', function() {

	//$('.set-coords').click(function(){
		$row = $(this).closest('.mt-repeater-row');
		var address = $('.address',$row).val();
		var lat = $('.lat',$row).val();
		var lng = $('.lng',$row).val();
		//set address in map if already set
		if(address){
			$('#address').val(address);
			$('#lat').val(lat);
			$('#lng').val(lng);			
		}
		setTimeout(function() {
				initMap();	
		}, 500);			

	});


	/* save values back to page */
	$('#location-save').click(function(){
		$('.lat', $row).val($('#lat').val());
		$('.lng', $row).val($('#lng').val());
		$('.address', $row).val($('#address').val());
		$('.notset', $row).addClass('hidden');
		$('.modal').modal('hide');
	});



	$(document).on('click','.clone',function(e){

		var $id = $(this).data('voucherid');

		//update existing
		$.ajax('/ajax/cloneVoucher.php', {
			method: "POST",
			data: "id=" + $id,
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success && result.newid){                        
					//saved			
					window.location.href="/manager/voucher.php?id=" + result.newid;

				} else {
					//alert error
					toastr["error"]("There was a problem cloning the voucher.", "ERROR");		
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem cloning the voucher.", "ERROR");	
			}
		});		
		
	});
	
	$('#stateSelector').change(function(){
		var state = $(this).val();
		window.location.href = "/manager/vouchers.php?state=" + state;
	});
	
	
	$('#voucher-state').change(function(){
		var state = $(this).val();
		
		$('.region').addClass('disabled');
		$('.region-' + state).removeClass('disabled');
		
		$('select[name=categoryId]').val('');
		$('.catoption').addClass('disabled');
		$('.catoption-' + state).removeClass('disabled');		
		
	});


	$('select[name=isOnlineCoupon').change(function(){	

		$('.onlineCouponText').css('display','none');
		$('.form-group.neatIdeas').css('display','none');
		$('.allowMonthlyUse').css('display','block');
		$('.form-group.experienceOz').css('display','none');
		
		if($(this).val() == '1'){
			$('.onlineCouponText').css('display','block');
		} else if($(this).val() == '2') {
			$('.form-group.neatIdeas').css('display','block');
			$('.allowMonthlyUse').css('display','none');
		} else if($(this).val() == '3') {
			$('.form-group.experienceOz').css('display','block');
		}
			
	});


	$('.save-voucher').click(function(e){

		//remove checked regions that are in other states
		$('.region.disabled input').each(function(){
			$(this).prop('checked', false);
		});		
		
		//alert($('form.edit-voucher').serialize());
		//return;

		//update existing
		$.ajax('/ajax/saveVoucher.php', {
			method: "POST",
			data: $('form.edit-voucher').serialize(),
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//saved			
					toastr["success"]("The voucher details were saved.", "Saved");
					location.reload();

				} else {

					if(result.reason == 'validation'){
						toastr["error"]("Ensure all required fields have been entered.", "ERROR");
					} else {
						//alert error
						toastr["error"]("There was a problem saving your changes.", "ERROR");
					}
										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem saving your changes.", "ERROR");
			}
		});
		
	});


	$('#sortable_images .remove').click(function(){
		$div = $(this).closest('.sortable-image').remove();		
		$('#image').val('');
	});



	/* delete activity 
	$('.delete-user').click(function(){
		
		$id = $(this).data('userid');
		
		$.ajax('/ajax/deleteUser.php', {
			method: "POST",
			data: 'id=' + $id,
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//reload page
					window.location.href="/manager/";
//				toastr["error"]("There was a problem deleting the user.", "ERROR");
				} else {
					//alert error
					toastr["error"]("There was a problem deleting the user.", "ERROR");										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem deleting the user.", "ERROR");
			}
		});
	});	*/
	
	
	/* delete activity 
	$('.delete-voucher----old').click(function(){
		
		$id = $(this).data('voucherid');
		
		$.ajax('/ajax/deleteVoucher.php', {
			method: "POST",
			data: 'id=' + $id,
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//reload page
					//window.location.href="/manager/vouchers.php";
				} else {
					//alert error
					toastr["error"]("There was a problem deleting the voucher.", "ERROR");										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem deleting the voucher.", "ERROR");
			}
		});
	});	*/

	
});




/* toastr notifications general options */
toastr.options = {
		"closeButton": true,						
		"positionClass": "toast-top-right",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
		}










 