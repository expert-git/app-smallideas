var FormRepeater = function () {

    return {
        //main function to initiate the module
        init: function () {
        	$('.mt-repeater').each(function(){
        		$(this).repeater({
        			show: function () {
	                	$(this).slideDown();
                        $('.date-picker').datepicker({
                            rtl: App.isRTL(),
                            orientation: "left",
                            autoclose: true
                        });
		            },

		            hide: function (deleteElement) {					
						var dateId = $(this).find('.iDateId').val();
						var activityId = $('input[name=activityId]').val();
		                if(confirm('Are you sure you want to delete this element?')) {		                    												
							$(this).slideUp(deleteElement);
							//delete in db if it has been committed
							if(dateId){								
								$.ajax('/ajax/activityTime.php', {
									method: "POST",
									data: 'func=delete&id=' + dateId + '&activityId=' + activityId,
									success: function(data) {                    
										var result = jQuery.parseJSON( data );
										if(result.success){
											//refresh calendar
											if(dateClicked){
												//get month/year of this date
												var dp = dateClicked.split('-');                
												//refresh calendar                        
												getCalendar(dp[0],dp[1]);
											}

										} else {
											// alerterror
											toastr["error"]("There was a problem deleting the entry.", "ERROR");											
										}

									}
								});
								
							}
		                }
		            },

		            ready: function (setIndexes) {

		            }

        		});
        	});
        }

    };

}();

jQuery(document).ready(function() {	
    FormRepeater.init();
});
