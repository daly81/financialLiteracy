$(function(){
  if ('speechSynthesis' in window) {
    $('.speak').click(function(){
      var text = $(this).parent().text();
      var msg = new SpeechSynthesisUtterance();
      msg.text = text;
      speechSynthesis.speak(msg);
    })
    $('.stop').click(function(){
      speechSynthesis.cancel();
    })
  } 
});
