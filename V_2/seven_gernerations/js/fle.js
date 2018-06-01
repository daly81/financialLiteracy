(function($) {
  "use strict"; // Start of use strict

  // Vide - Video Background Settings
  $('body').vide({
    mp4: "mp4/finance_bg.mp4",
    poster: "img/financials.jpg"
  }, {
    posterType: 'jpg'
  });

})(jQuery); // End of use strict


function showLogin() {
    $('.masthead_main').hide();
    $('.masthead_login').show();
}

function showSignUp() {
    $('.masthead_main').hide();
    $('.masthead_signup').show();
}

$('.signUpHome').click(function(){
    $('.form-control').val("");
    $('.masthead_signup').hide();
    $('.masthead_main').show();
});

$('.loginHome').click(function(){
    $('.form-control').val("");
    $('.masthead_login').hide();
    $('.masthead_main').show();
})
