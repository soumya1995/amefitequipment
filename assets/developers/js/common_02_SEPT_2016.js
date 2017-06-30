var gObj=gObj ||  {};
$.extend(gObj,{re_mail:/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z])+$/,re_vldname:/^[ a-zA-Z]+$/});

function validcheckstatus(name,action,text)
{
	var chObj	=	document.getElementsByName(name);
	var result	=	false;	
	for(var i=0;i<chObj.length;i++){
	
		if(chObj[i].checked){
		  result=true;
		  break;
		}
	}
 
	if(!result){
		 alert("Please select atleast one "+text+" to "+action+".");
		 return false;
	}else if(action=='delete'){
			 if(!confirm("Are you sure you want to delete this.")){
			   return false;
			 }else{
				return true;
			 }
	}else{
		return true;
	}
}

//function increase_quantity(fldName) {
//	var qty=document.getElementById(fldName).value;
//	/*if (parseInt('10') <= qty) {
//		alert("Total available quantity of this product is only 10 at the moment");
//	}
//	else {*/
//		qty++;
//		document.getElementById(fldName).value=qty;
//		document.getElementById('qty').value=qty;
//	//}	
//}

function increase_quantity(fldName,max_qty) {
	
	var qty=document.getElementById(fldName).value;
	if (parseInt(max_qty) <= qty) {
		alert("Total available quantity of this product is only "+max_qty+" at the moment");
	}
	else {
		qty++;
		document.getElementById(fldName).value=qty;
		document.getElementById('qty').value=qty;
	}	
}


function decrease_quantity(fldName) {
	var qty=document.getElementById(fldName).value;
	if (parseInt(qty) >1) {
		qty--;
	}
	document.getElementById(fldName).value=qty;
	document.getElementById('qty').value=qty;
}

function increment(id)
{ 

var obj = document.getElementById(id);
//var max_qty ;
//max_qty = document.getElementById('aval_qty').value;
//max_qty = parseInt(max_qty);


			var val=obj.value;	
			//if( parseInt(val)< max_qty ) {
				
			   obj.value=(+val + 1);
			   
			/*}else{
				if(max_qty==0){
					alert("None quantity is available.");
				}else{
					alert("Maximum available quantity is "+max_qty+". You can not add  more then available Quantity.");
			 	}
			}*/
}
function decrement(id)
{ 
   var obj = document.getElementById(id);
	var val=obj.value
	if(val==1 || val <1)
		val=1;
	else
	  val=(val - 1);
		
	obj.value=val || 1;
}


function addquentity(p)
{

var qty_="qty_"+p;
var addvalue=parseInt(document.getElementById(qty_).value);
document.getElementById(qty_).value=addvalue+1;

}

function addremovequentity(p)
{

var qty_="qty_"+p;
var addvalue=parseInt(document.getElementById(qty_).value);
	if(addvalue>=2)
	{
	document.getElementById(qty_).value=addvalue-1;
	}
}



function show_dialogbox()
{
	$("#dialog_overlay").fadeIn(100);
	$("#dialog_box").fadeIn(100);
}
function hide_dialogbox()
{
	$("#dialog_overlay").fadeOut(100);
	$("#dialog_box").fadeOut(100);
}

function showloader(id)
{
	$("#"+id).after("<span id='"+id+"_loader'><img src='"+site_url+"/assets/developers/images/loader.gif'/></span>");
}


function hideloader(id)
{
	$("#"+id+"_loader").remove();
}
												
												
function load_more(base_uri,more_container,formid)
{	
  showloader(more_container);
  $("#more_loader_link"+more_container).remove();
   if(formid!='0')
   {
	   form_data=$('#'+formid).serialize();
   }
   else
   {
	   form_data=null;
   }
  $.post
	  (
		  base_uri,
		  form_data,
		  function(data)
		  { 
		  
		  
			 var dom = $(data);
			
			dom.filter('script').each(function(){
			$.globalEval(this.text || this.textContent || this.innerHTML || '');
			});
			
			var currdata = $( data ).find('#'+more_container).html(); $('#'+more_container).append(currdata);
			hideloader(more_container);
		  }
	  );
}


function join_newsletter()
{
	var form = $("#chk_newsletter");
	showloader('newsletter_loder');
	$(".btn").attr('disabled', true);

	$.post(site_url+"pages/join_newsletter",
	$(form).serialize(),
	function(data){
		$("#refresh").click();
		$(".btn").attr('disabled', false);
		hideloader('newsletter_loder');
		if(data.error!=undefined){
			$("#my_newsletter_msg").html(data.error);
		}else{
			$("#my_newsletter_msg").html(data);
			clearForm("#chk_newsletter");
		}
	});
	
	return false;
}

function clearForm(frm)
{
	$(frm).find(':input').each(function() {
		switch(this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'textarea':
			$(this).val('');
			break;
			case 'checkbox':
			case 'radio':
			//this.checked = false;
		}
	});
} 

/*
function join_newsletter()
{	
	
	var form = $("#chk_newsletter");	
	showloader('newsletter_loder');
	$(".btn").attr('disabled', true);		
	
	
	
	$.post(site_url+"pages/join_newsletter",
		  $(form).serialize(),		   
		   function(data){
			     $("#my_newsletter_msg").html(data);				
				 $(".btn").attr('disabled', false);				 
			     hideloader('newsletter_loder');	
			    
				 $('#subscriber_name').val('');
				  $('#subscriber_email').val('');
				  $('#verification_code').val('');
				  
				 					 
			   });
	
	return false;
	}
*/


$(document).ready(function() {
	
	$(':checkbox.ckblsp').click(function()
    {
	 
		//$(':input','#ship_container').val('');
		
		if($(this).is(':checked'))
		{
			//alert($('#billing_name').val());
			//$('#ship_container').hide();
			$('#shipping_name').val($('#billing_name').val());
			$('#shipping_address').val($('#billing_address').val());
			$('#shipping_zipcode').val($('#billing_zipcode').val());
			$('#shipping_phone').val($('#billing_phone').val());
			$('#shipping_mobile').val($('#billing_mobile').val());
			$('#shipping_city').val($('#billing_city').val());
			$('#shipping_state').val($('#billing_state').val());
			$('#shipping_country').val($('#billing_country').val());			
		}else{		
			//$('#ship_container').show();
			$('#shipping_name').val('');
			$('#shipping_address').val('');
			$('#shipping_zipcode').val('');
			$('#shipping_phone').val('');
			$('#shipping_mobile').val('');
			$('#shipping_city').val('');
			$('#shipping_state').val('');
			$('#shipping_country').val('');	
		}	
	});
	
});

function multisearch(srchkey,chkname,cate_id)
{	
	var arrval=new Array();
	$('[name='+chkname+']:checked').each(function(mkey,mval)
	{		
		arrval.push($(mval).val());		
	})
	
	$('#'+srchkey).val(arrval.join(","));
	$('#category_id').val(cate_id);	
	$("#srcfrm").submit();
} 

function check_zip_location(prd_id){
	$(".errors_value").hide();
	var hasError = false;
	var locationVal = $('#zip_location').val();
	if(locationVal == ''){
		$('#location_error').html('<span class="red mt5 loc_err">Please enter delivery location.</span>');
		$("#zip_location").focus();
		hasError = true;
	}
	if(hasError == true) { return false; }
	else{
		$("#location_loader").show();
		$('#location_loader').html('<img src="'+site_url+'assets/developers/images/loader.gif"/>');
		term = $('input[name="zip_location"]').val();
		url= site_url+'products/ajax_search_zip_location/';
		$.post(url,{zip_location: term },
		function(data){
			$("#location_error_show").html('<span class="">'+data+'</span>');
			$("#location_loader").hide();
			$("#location_search_form").hide();
			$("#location_error").hide();			
			$(".loc_err").hide();
			$("#zip_location").val('');
		});
	}
	return false;
}

function show_location_form(){
	$("#location_search_form").show();
}

function getproducts(cat_id,reff_pid,url){
	
	 var ajax_url=site_url+url;
	 $.ajax({
				type: "POST",
				url: ajax_url,
				dataType: "html",
				data: "category_id="+cat_id+"&reff_pid="+reff_pid,
				cache:false,
				success:
					function(data)
					{		
						$("#categoryId").html(data);
						$("#show_hide1").show();						
					}
					
		}); 
}


function lookup_products(inputString) {
	
	if(inputString.length == 0) {
		
		// Hide the suggestion box.
		$('#suggestions').hide();
		$('#autoSuggestionsList').hide();
	}
	 else {
		
		$.post(site_url+"home/keyword_suggestions", {mysearchString: ""+inputString+""}, function(data){
		
			if(data.length >0) {
		              $('#suggestions').show();				
				      $('#autoSuggestionsList').html(data);
					  $('#autoSuggestionsList').show();
			}
			else{
					  $('#suggestions').show();				
				      $('#autoSuggestionsList').html(data);
					  $('#autoSuggestionsList').show();
				
			}
		});
	}
} //end

// if user clicks a suggestion, fill the text box.
function fill_products(thisValue) {
	
	$('#inputString').val(thisValue);
	setTimeout("$('#suggestions').hide();", 200);
}


function getstate(country_id,url){

 var ajax_url=site_url+url;
 $.ajax({
			type: "POST",
			url: ajax_url,
			dataType: "html",
			data: "country_id="+country_id,
			cache:false,
			success:
				function(data)
				{					
					$("#stateid").html(data);
					$("#st").show();
					
				}
				
	}); 
	
}

function getcity(state_id,url){
 var ajax_url=site_url+url;
 $.ajax({
			type: "POST",
			url: ajax_url,
			dataType: "html",
			data: "state_id="+state_id,
			cache:false,
			success:
				function(data)
				{
					
					$("#cityid").html(data);
					$("#ct").show();
					
				}
				
	}); 
 
}

function show_hide_pattr(val){
	
	$('#pattr1').hide();
	$('#pattr2').hide();
	$('#pattr_id1').val('');
	$('#pattr_id2').val('');
	$('#type_id').val('');
	
	
	if(val == 'W') {
		
		$('#pattr1').show();
	}
	if(val == 'P') {
		
		$('#pattr2').show();
	}	
}

function put_type_id(val){
	
	$('#type_id').val(val);
}
