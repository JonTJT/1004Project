jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    $("img","#gifs-rows-tetris").hover(function(){
       $('.tetrispng').toggle();
       $('.tetrisgif').toggle();
   })
   $("img","#gifs-rows-2048").hover(function(){
       $('.x2048png').toggle();
       $('.x2048gif').toggle();
   })
   $("img","#gifs-rows-typingtest").hover(function(){
       $('.typingtestpng').toggle();
       $('.typingtestgif').toggle();
   })
   $("img","#gifs-rows-colourblast").hover(function(){
       $('.colourblastpng').toggle();
       $('.colourblastgif').toggle();
   })
});