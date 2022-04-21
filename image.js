$(document).ready(function(){
$('#import').prepend('<img id="JLlive" src="https://i2.wp.com/www.rocksins.com/wp-content/uploads/2019/11/JamieLenmanRockSins-17.jpg?ssl=1" class="responsive"/>');
$('#import').addClass('grayscale');
$('#import').stop().animate({"opacity": ".4"}, "slow");
$('#import').hover(
    function () {
        $(this).removeClass('grayscale');
        $('#import').stop().animate({"opacity": ".9"}, "slow");
    },
    function () {
        $('#import').stop().animate({"opacity": ".4"}, "slow");
        $('#import').addClass('grayscale');
        
    }
);

});

