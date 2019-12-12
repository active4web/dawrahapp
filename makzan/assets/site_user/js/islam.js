	$(document).ready(function(){
	$('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get('<?=base_url();?>site_user/products/auto_search', { query: query }, function (data) {
                console.log(data);
                data = $.parseJSON(data);
                return process(data);
            });
        }
    });
	function change_order_status(order_id,id,msg){
		if (confirm('هل أنت متأكد من '+msg)) {
			$.ajax({
				url: '<?=base_url();?>site_merchant/orders/change_order_status', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{order_id:order_id,id:id},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					//alert(data.status);
					//console.log(data);
					alert(data.msg); // alert the 0th value
					window.location = "<?=base_url();?>site_merchant/orders/";
					// let's iterate through the returned values
					// for loops are good for that, $.each() is fine too
					// but unnecessary here
					/*for (var i = 0; i < data.length; i++) {
						// data[i] can be used to get each value
					}*/
				}
			});
			//alert(id+msg);
			/*$.post('<?=base_url();?>site_merchant/orders/change_order_status', {order_id:order_id,id:id}, function(data){
				console.log(data);
				alert(data[0]);
			});*/
    // Save it!
		} else {
			// Do nothing!
			//alert('no');
		}
	}
	
	function update_qty(rowid,qty,owner){
		//alert(rowid+" "+qty);
		$.ajax({
				url: '<?=base_url();?>site_user/Shopping_cart/update_item', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{rowid:rowid,qty:qty},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					//console.log(data);
				}
			});
			final_total(owner);
	}
	
	function get_subtotal(rowid,id,owner){
		//alert(rowid+" "+qty);
		setTimeout(function(){
		$.ajax({
				url: '<?=base_url();?>site_user/Shopping_cart/get_subtotal', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{rowid:rowid},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					//console.log(data);
					$('#pro_'+id).html('');
					$('#pro_'+id).html(data.msg);
				}
			});
			owner_total(owner);
			final_total(owner);
		}, 1000);
	}
	
	function owner_total(id){
		$.ajax({
				url: '<?=base_url();?>site_user/Shopping_cart/get_sub_total', // returns "[1,2,3,4,5,6]"
				type: "POST",
				data:{id:id},
				dataType: 'json', // jQuery will parse the response as JSON
				success: function (data) {
					console.log(data);
					//alert('#sub_'+id);
					$('#sub_'+id).html('');
					$('#sub_'+id).html(data.msg);
					$('#sub_total'+id).val('');
					$('#sub_total'+id).val(data.msg);
				}
				
			});
	}
	
	function change_delivery(owner){
		var radios = document.getElementsByName('delivering_'+owner);
		for (var i = 0, length = radios.length; i < length; i++)
		{
			if (radios[i].checked)
				{
					// do whatever you want with the checked radio
					$('#delivery_'+owner).html('');
					$('#delivery_'+owner).html(radios[i].value);
					$('#method_'+owner).val('');
					$('#method_'+owner).val(radios[i].id);
					//alert(radios[i].value);
					// only one radio can be logically checked, don't check the rest
					break;
				}
		}
		final_total(owner);
		//alert(radios);
	}
	
	function final_total(id){
		$(':input[type="submit"]').prop('disabled', true);
		setTimeout(function(){
		var sub = $('#sub_'+id).text();
		var tax = $('#tax_'+id).text();
		var delivery = $('#delivery_'+id).text();
		var sum = +sub + +tax + +delivery;
		//alert(sum);
		$('#final_total_'+id).html('');
		var total = $('#final_total_'+id).html(sum);
		$('#total'+id).val('');
		$('#total'+id).val(sum);
		$(':input[type="submit"]').prop('disabled', false);
		}, 1000);
		/*setTimeout(function(){
			finshed_total();
		}, 1000);*/
	}
});