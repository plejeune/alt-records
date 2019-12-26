
/* Jquery Action */

$( ".param-1" ).on( "click", function() {
    $("#data-table").show();
    $(".data-description").hide();
    $('.param-1').removeClass('btn-light').addClass('btn-success');
    $('.param-2').removeClass('btn-success').addClass('btn-light');
});

$( ".param-2" ).on( "click", function() {
    $("#data-table").hide();
    $(".data-description").show();
    $('.param-1').removeClass('btn-success').addClass('btn-light');
    $('.param-2').removeClass('btn-light').addClass('btn-success');
});

$( ".option_btn" ).on( "click", function() {
    $(".sub-options").show();
});

$( ".sub-options" ).mouseleave(function() {
    $(".sub-options").hide();
});

$( ".del_btn" ).on( "click", function() {
    $(".delete-window").show();
});

$( ".cancel" ).on( "click", function() {
    $(".delete-window").hide();
});

$( ".btn-delete" ).on( "click", function() {
    $(".btn-confirm").show();
    $(".btn-hide").show();
});

$( ".btn-hide" ).on( "click", function() {
    $(".btn-confirm").hide();
    $(".btn-hide").hide();
});


$( ".btn-all" ).on( "click", function() {
    $(".Rock").show();
    $(".Pop").show();
    $(".Metal").show();
    $(".Grunge").show();
    $('.btn-rock').removeClass('btn-success').addClass('btn-light');
    $('.btn-pop').removeClass('btn-success').addClass('btn-light');
    $('.btn-metal').removeClass('btn-success').addClass('btn-light');
    $('.btn-grunge').removeClass('btn-success').addClass('btn-light');
    $('.btn-all').removeClass('btn-light').addClass('btn-success');
});

$( ".btn-rock" ).on( "click", function() {
    $(".Rock").show();
    $(".Pop").hide();
    $(".Metal").hide();
    $(".Grunge").hide();
    $('.btn-rock').removeClass('btn-light').addClass('btn-success');
    $('.btn-pop').removeClass('btn-success').addClass('btn-light');
    $('.btn-metal').removeClass('btn-success').addClass('btn-light');
    $('.btn-grunge').removeClass('btn-success').addClass('btn-light');
    $('.btn-all').removeClass('btn-success').addClass('btn-light');
});

$( ".btn-pop" ).on( "click", function() {
    $(".Rock").hide();
    $(".Pop").show();
    $(".Metal").hide();
    $(".Grunge").hide();
    $('.btn-pop').removeClass('btn-light').addClass('btn-success');
    $('.btn-rock').removeClass('btn-success').addClass('btn-light');
    $('.btn-metal').removeClass('btn-success').addClass('btn-light');
    $('.btn-grunge').removeClass('btn-success').addClass('btn-light');
    $('.btn-all').removeClass('btn-success').addClass('btn-light');
});

$( ".btn-metal" ).on( "click", function() {
    $(".Rock").hide();
    $(".Pop").hide();
    $(".Metal").show();
    $(".Grunge").hide();
    $('.btn-metal').removeClass('btn-light').addClass('btn-success');
    $('.btn-pop').removeClass('btn-success').addClass('btn-light');
    $('.btn-rock').removeClass('btn-success').addClass('btn-light');
    $('.btn-grunge').removeClass('btn-success').addClass('btn-light');
    $('.btn-all').removeClass('btn-success').addClass('btn-light');
});

$( ".btn-grunge" ).on( "click", function() {
    $(".Rock").hide();
    $(".Pop").hide();
    $(".Metal").hide();
    $(".Grunge").show();
    $('.btn-grunge').removeClass('btn-light').addClass('btn-success');
    $('.btn-pop').removeClass('btn-success').addClass('btn-light');
    $('.btn-metal').removeClass('btn-success').addClass('btn-light');
    $('.btn-rock').removeClass('btn-success').addClass('btn-light');
    $('.btn-all').removeClass('btn-success').addClass('btn-light');
});
