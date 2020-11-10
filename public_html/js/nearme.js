
// Request a position. We accept positions whose age is not
// greater than 10 minutes. If the user agent does not have a
// fresh enough cached position object, it will automatically
// acquire a new one.
navigator.geolocation.getCurrentPosition(successCallback,
                                         errorCallback,
                                         {maximumAge:600000});

								 


									     // navigator.geolocation.getCurrentPosition(
	     // 									         function(position) {
	     // 									              alert("Lat: " + position.coords.latitude + "\nLon: " + position.coords.longitude);
	     // 									         },
	     // 									         function(error){
	     // 									              alert("message..." + error.message);
	     // 									         }, {
	     // 									              enableHighAccuracy: true
	     // 									                   ,timeout : 5000
	     // 									         }
	     // 									     );

										 

function successCallback(position) {
  	// By using the maximumAge option above, the position
  	// object is guaranteed to be at most 10 minutes old.
  	//console.log(position["coords"]["latitude"]);
		
//		alert(position["coords"]["latitude"]);
	
		//ajax fetch vouchers
		$.ajax('/ajax/getNearMe.php', {
			method: "POST",
			data: "lat=" + position["coords"]["latitude"] + '&lng=' + position["coords"]["longitude"],
			success: function(data) {                    
				var result = jQuery.parseJSON( data );
				if(result.success){
					
					var previousId = '';
					
					//console.log(result);
					$('.loading').addClass('hidden');
					//add to DOM

					for(var i=0;i<result.results.length;i++){
						$('#all-vouchers').append('<div class="row">\
										            <ul class="vouchers ' + result.results[i].redeemed + '">\
										                <li>\
										                    <a class="" data-transition="slide" data-inline="true" id="v' + result.results[i].id + '" href="voucher.html?id=' + result.results[i].id + '&parent=nearme&pos=v' + previousId + '">\
										                        <span class="name">' + result.results[i].businessName + '</span>\
										                        <span class="title">' + result.results[i].title + '</span>\
										                        <span class="address">' + result.results[i].address + '</span>\
										                        <i class="fa fa-angle-right"></i>\
										                    </a>\
										                </li>\
										            </ul>\
										        </div>');
												
						previousId = result.results[i].id;
					}

					//scroll to one if required - not always needed but does if ajax is slow
					var hsh = window.location.hash.replace('#','');					
					if(hsh){
						var element_to_scroll_to = document.getElementById(hsh);
						element_to_scroll_to.scrollIntoView();
					}
					
				} else {
					//error						
					$("#no-location").removeClass("hidden");
					$('.loading').addClass('hidden');
				}				
			},
			error: function() {
				//error
				$("#no-location").removeClass("hidden");
				$('.loading').addClass('hidden');
			}
		});


}


function errorCallback(error) {
	//alert(error.message);
  // Update a div element with error.message.
	$("#no-location").removeClass("hidden");
}