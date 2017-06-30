function include(url){ 
  document.write('<script src="'+ url + '" type="text/javascript"></script>'); 
}
include(resource_url+'Scripts/helpers.min.js');
include(resource_url+'Scripts/jquery.placeholder.js');
include(resource_url+'fancybox/jquery.fancybox.pack.js');
//include(resource_url+'Scripts/addthis_widget.js');

if(Page=='home'){
include(resource_url+'Scripts/fluid_dg.min.js');
}

if(Page=='details'){
include(resource_url+'zoom/magiczoomplus.js');
include(resource_url+'Scripts/jquery.rating.js');
}

else{}
$(window).load(function(e) {

$('.fancybox').fancybox();
$('.mygallery').fancybox({wrapCSS:'fancybox-custom',closeClick: true, openEffect:'none',helpers : {title :{type : 'inside'},overlay: {css: {'background' : 'rgba(0,0,0,0.6)'}}}});

$('.pop1').fancybox({'width':500,'height':205,'type':'iframe',title:{type:'outside'}});
$('.pop2').fancybox({'width':700,'height':205,'type':'iframe',title:{type:'outside'}});
$('.pop3').fancybox({'width':500,'height':205,'type':'iframe',title:{type:'outside'}});
$('.c_pop').fancybox({'width':500,'height':205,'type':'iframe',title:{type:'outside'}});
$('.review_pop').fancybox({'width':500,'height':205,'type':'iframe',title:{type:'outside'}});
$('.print-invoice').fancybox({'width':750,'height':205,'type':'iframe',title:{type:'outside'}});
$('.video').fancybox({'width':390,'height':205,'type':'iframe',title:{type:'outside'}});

$('input').placeholder();$('textarea').placeholder();
$('.show-hide').click(function(){$(this).next().slideToggle();});

$(".vd_ttl").click(function(){return $(this).next().slideToggle("fast")});
$('.close').click(function(){$('.chat_inr').hide('fast')})

$('.filt_bar').slimscroll({height:'240px',size:'10px',color:"#000"});
$(function(){
$(".pro_scroll").jCarouselLite({btnPrev:".prev4",btnNext:".next4",vertical:true,hoverPause:true,auto:2000,visible:4,speed:1800,'easing':'easeOutExpo'});	
	
$(".bid_scroll").jCarouselLite({btnPrev:".prev",btnNext:".next",vertical:false,hoverPause:true,auto:2000,visible:1,speed:1800,'easing':'easeOutExpo'});
$(".offer_scroll").jCarouselLite({btnPrev:".prev2",btnNext:".next2",vertical:false,hoverPause:true,auto:2000,visible:3,speed:1800,'easing':'easeOutExpo'});
$(".sale_scroll").jCarouselLite({btnPrev:".prev3",btnNext:".next3",vertical:false,hoverPause:true,auto:2000,visible:3,speed:1800,'easing':'easeOutExpo'});
});


$(".new_scroll").jCarouselLite({btnPrev:".prev4",btnNext:".next4",vertical:false,hoverPause:true,auto:2000,visible:4,speed:1800,'easing':'easeOutExpo'});

$(".hot_scroll").jCarouselLite({btnPrev:".prev5",btnNext:".next5",vertical:false,hoverPause:true,auto:4000,visible:4,speed:1800,'easing':'easeOutExpo'});

$(".fea_scroll").jCarouselLite({btnPrev:".prev6",btnNext:".next6",vertical:false,hoverPause:true,auto:6000,visible:6,speed:1800,'easing':'easeOutExpo'});

$(".bot-title").click(function(){return $(this).next().slideToggle("fast"),$(this).toggleClass("open-links"),!1});

$('#video-area').flash({src:'swf/player.swf', 'width': 390,'height': 270, 'wmode': 'transparent','allowfullscreen':'true','flashvars':{'skin':'swf/slim.zip','file':'../video/boogie-board.mp4'}});

$('input.sr_tabs').click(function(){var dg='.'+$(this).attr('title'); $('.form_box').slideUp('fast');$(dg).slideDown('fast')});


$(".scroll").click(function(event){
event.preventDefault();
$('html,body').animate({scrollTop:$(this.hash).offset().top-175}, 1000);
});

$(window).scroll(function(){
if($(this).scrollTop()>80){$('.top2').addClass('t2_fixer'); $('.top2_b').css({'display':'block'})}
else{$('.top2').removeClass('t2_fixer'); $('.top2_b').css({'display':'none'})}
})

$("#back-top").hide();	
$(function () {$(window).scroll(function () {if ($(this).scrollTop() > 100) {$('#back-top').fadeIn();} else {$('#back-top').fadeOut();}});
$('#back-top a').click(function () {$('body,html').animate({scrollTop: 0}, 800);return false;});
});

$('.tabs').click(function(){var dg=$(this).attr('href'); $('.form_box').css({'visibility':'hidden','left':'-4000px','top':'-2000px','position':'absolute'});$(dg).css({'visibility':'visible','left':'0px','top':0,'position':'relative'}); $('.tabs').removeClass('act'); $(this).addClass('act'); return false})

$('input.tabs-op').click(function(){var dg='.'+$(this).attr('title'); $('.form_op').slideUp('fast');$(dg).slideDown('fast'); })
$('input.tabs-op2').click(function(){var dg='.'+$(this).attr('title'); $('.form_op2').slideUp('fast');$(dg).slideDown('fast'); })

if(Page=='home'){
$(function(){$('#fluid_dg_wrap_1').fluid_dg({thumbnails: false,height:"29%",fx:'scrollLeft,scrollRight,scrollTop,scrollBottom',playPause:'false',minHeight:'0',loader:'none',navigation:'false',hover:'false',time:3000});})
}

});



function lookup(inputString) {
	if(inputString.length == 0) {
		// Hide the suggestion box.
		$('#States_sugg').hide();
		$('#suggestions').hide();
	} else {
		// post data to our php processing page and if there is a return greater than zero
		// show the suggestions box
		$.post("Scripts/string_search.php", {mysearchString: ""+inputString+""}, function(data){
			if(data.length >0) {
		$('#States_sugg').hide();
				$('#suggestions').show();
				$('#autoSuggestionsList').html(data);
			}
		});
	}
} //end

// if user clicks a suggestion, fill the text box.
function fill(thisValue) {
	$('#inputString').val(thisValue);
	setTimeout("$('#suggestions').hide();", 200);
}

function lookup_state(inputString) {
	if(inputString.length == 0) {
		// Hide the suggestion box.
		$('#suggestions').hide();
		$('#States_sugg').hide();
	} else {
		// post data to our php processing page and if there is a return greater than zero
		// show the suggestions box
		$.post("Scripts/string_search.php", {mysearchString: ""+inputString+""}, function(data){
			if(data.length >0) {
		$('#suggestions').hide();
				$('#States_sugg').show();
				$('#autoSuggestionsList_State').html(data);
			}
		});
	}
} //end