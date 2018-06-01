(function ($) {
	$( '#dl-menu' ).dlmenu();
	$('ul.dl-menu li a').smoothScroll();


	//animation
	new WOW().init();

})(jQuery);

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
		var data = {
		  action: "get_links"
		}
		$.post("../php/user_switch.php", data, function(res){
			var info = JSON.parse(res);
			var result = info.length;
			//var links = [];
			for (var i = 0; i < result; i++){
				$(".message").mark(info[i].link);
				$('mark:contains("'+ info[i].link +'")').html('<a href="' + info[i].direct + '" target="_blank">' + info[i].link + '</a>')
			}
			//$.each(links,function(){
				//var msg = $(".message").html();
				//msg = msg.replace(this.link, '<a href="' + this.direct + '" target="_blank">' + this.link + '</a>');
				//$(".message").html(msg);
			//})
		})   
    })
	 
	 