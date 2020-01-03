
/* Jquery Action */

$(document).ready(function() {

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

    $("#admin-info-table").hide();
    $("#admin-info2").hide();

    $(".box").animate({height: '55px'});
    $(".box").animate({height: '55px'}, 1000);
    $(".box").animate({height: '290px'}, 1500);

    $(".btn-cat2").hide();
    $(".btn-com2").hide();
    $(".btn-user2").hide();
    $(".btn-git2").hide();

    $(".btn-cat").click(function() {
        $(".box-cat").animate({height: '55px'}, 300)
        $("#cat-box").hide();
        $(".btn-cat").hide();
        $(".btn-cat2").show();
    });

    $(".btn-cat2").click(function() {
        $(".box-cat").animate({height: '290px'}, 600)
        $("#cat-box").show();
        $(".btn-cat").show();
        $(".btn-cat2").hide();
    });

    $(".btn-com").click(function() {
        $(".box-com").animate({height: '55px'}, 300)
        $("#com-box").hide();
        $(".btn-com").hide();
        $(".btn-com2").show();
    });

    $(".btn-com2").click(function() {
        $(".box-com").animate({height: '290px'}, 600)
        $("#com-box").show();
        $(".btn-com").show();
        $(".btn-com2").hide();
    });

    $(".btn-user").click(function() {
        $(".box-user").animate({height: '55px'}, 300)
        $("#user-box").hide();
        $(".btn-user").hide();
        $(".btn-user2").show();
    });

    $(".btn-user2").click(function() {
        $(".box-user").animate({height: '290px'}, 600)
        $("#user-box").show();
        $(".btn-user").show();
        $(".btn-user2").hide();
    });

    $(".btn-git").click(function() {
        $(".box-git").animate({height: '55px'}, 300)
        $("#git-box").hide();
        $(".btn-git").hide();
        $(".btn-git2").show();
    });

    $(".btn-git2").click(function() {
        $(".box-git").animate({height: '290px'}, 600)
        $("#git-box").show();
        $(".btn-git").show();
        $(".btn-git2").hide();
    });

    $(".articles").draggable();

    $("#admin-info").click(function() {
        $("#admin-info-table").show();
        $("#admin-info2").show();
        $(this).hide();
    });

    $("#admin-info2").click(function() {
        $("#admin-info-table").hide();
        $("#admin-info").show();
        $(this).hide();
    });

});
