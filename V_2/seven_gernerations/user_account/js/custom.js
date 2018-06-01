(function ($) {
	$( '#dl-menu' ).dlmenu();
	$('ul.dl-menu li a').smoothScroll();


	//animation
	new WOW().init();

})(jQuery);

//===================DETECT IF ON DEVICE========================
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 		$('.off_device').hide();
		$('#tools p').addClass('margin');
}

//========================CHECK LOGIN STATE CHECK=======================================
 function checkLoginState() {
    var data = {
      action: "checkLoginState"
    }
    $.post("../php/user_switch.php", data, function(res){
      var logged_in = JSON.parse(res);
      console.log(res);
      if (logged_in.success) {
          //DO NOTHING
      } else {
        window.location.replace("../index.html");
      }

    })
 }
  //============================GET USER INFO =======================
  function getUserInfo() {
    var data = {
      action: "get_user_info"
    }
    $.post("../php/user_switch.php", data, function(res){
      var info = JSON.parse(res);
      $('#first_name').html(info.first_name +" "+ info.last_name);
    })
  }

  //=============================LOGOUT======================================
    function logout(){
      var data = {
        action: "logout"
      }
      $.post("../php/user_switch.php", data, function(res){
        //console.log(res)
        var json = $.getJSON(res);
        if(json.success){
          window.location.replace('../index.html');
        }else{
          //TODO Something when logout fails, however unlikely
        }
      })
    }

	//============================SCANNING DOCUMENTS FOR KEY WORDS========================================

	$(document).ready(function(){
		//============================GETTING LINKS FROM DATABASE AND SCANNING DOCUMENT======================
				// var data = {
				//   action: "get_links"
				// }
				// $.post("../php/user_switch.php", data, function(res){
				// 	var info = JSON.parse(res);
				// 	var result = info.length;
				// 	var links = [];
				// 	for (var i = 0; i < result; i++){
				// 		$(".message").mark(info[i].link);
				// 		$('mark:contains("'+ info[i].link +'")').html('<a href="' + info[i].direct + '" target="_blank">' + info[i].link + '</a>')
				// 	}

					var links = [
						{
							tooltip: 'buying',
							def: 'https://facebook.com'
						},
						{
							tooltip: 'power',
							def: 'https://youtube.com'
						}
					];
					jQuery.expr[':'].contains = function(a,i,m){
					     return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
					};
					for (var i=0; i < links.length; i++){
						$(".message").mark(links[i].tooltip);
						$('mark:contains('+ links[i].tooltip +')').html('<a href="' + links[i].def + '" target="_blank">' + links[i].tooltip + '</a>')
					}
					// $.each(links,function(){
					// 	// $(".message").mark(this.tooltip);
					//
					// 	if ($(".message").mark(this.tooltip)){
					// 		$('.message').html('<a target="_blank" href='+ this.def +'>'+ this.tooltip +'<a/>');
					// 	}
					// });


					//MOSEOVER MOD IMAGES
					$('#eagle_img').mouseover(function(){
						$("#eagle_img").attr("src","img/home_icons/eagle3.png");
					})
					$('#eagle_img').mouseout(function(){
						$("#eagle_img").attr("src","img/home_icons/eagle2.png");
					})

					$('#bear_img').mouseover(function(){
						$("#bear_img").attr("src","img/home_icons/bear3.png");
					})
					$('#bear_img').mouseout(function(){
						$("#bear_img").attr("src","img/home_icons/bear2.png");
					})

					$('#squirl_img').mouseover(function(){
						$("#squirl_img").attr("src","img/home_icons/squirl3.png");
					})
					$('#squirl_img').mouseout(function(){
						$("#squirl_img").attr("src","img/home_icons/squirl2.png");
					})

					$('#turtle_img').mouseover(function(){
						$("#turtle_img").attr("src","img/home_icons/turtle3.png");
					})
					$('#turtle_img').mouseout(function(){
						$("#turtle_img").attr("src","img/home_icons/turtle2.png");
					})


					//MODULE ONE HOVER FUNCTIONS
					//Overview Making Decisions
					$('#bq').mousemove(function(){
						$('#overview-making-decisions').show();
					})
					$('#bq').mouseleave(function(){
						$('#overview-making-decisions').hide();
					})
					//Overview of Budgeting
					$('#resource').mousemove(function(){
						$('#overview-budgeting').show();
					})
					$('#resource').mouseleave(function(){
						$('#overview-budgeting').hide();
					})


				})
