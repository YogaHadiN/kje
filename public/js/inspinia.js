// Custom scripts
$(document).ready(function () {
    // MetsiMenu
    $('#side-menu').metisMenu();

    imgError();

    // Collapse ibox function
    $('.collapse-link').click( function() {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').click( function() {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Small todo handler
    $('.check-link').click( function(){
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // minimalize menu
    $('.navbar-minimalize').click(function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    })

    // tooltips
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // Move modal to body
    // Fix Bootstrap backdrop issu with animation.css
    $('.modal').appendTo("body")

    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");
    }
    fix_height();

    $('.nav-tabs').addClass('nav-justified')

    // Fixed Sidebar
    // unComment this only whe you have a fixed-sidebar
            //    $(window).bind("load", function() {
            //        if($("body").hasClass('fixed-sidebar')) {
            //            $('.sidebar-collapse').slimScroll({
            //                height: 'auto',
            //                railOpacity: 0.9,
            //            });
            //        }
            //    })

    $(window).bind("load resize click scroll", function() {
        if(!$("body").hasClass('body-small')) {
            fix_height();
        }
    })

    $("[data-toggle=popover]")
        .popover();

    $('.uang').attr('nowrap', 'nowrap');
    $('.uang').closest('td').attr('nowrap', 'nowrap');

    $('.angka').keyup(function(e){
        var before = $(this).val();
        $(this).val(parseInt(before) || '');
    });



    
});


// For demo purpose - animation css script
function animationHover(element, animation){
    element = $(element);
    element.hover(
        function() {
            element.addClass('animated ' + animation);
        },
        function(){
            //wait for animation to finish before removing classes
            window.setTimeout( function(){
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

// Minimalize menu when screen is less than 768px
$(function() {
    $(window).bind("load resize", function() {
        if ($(this).width() < 769) {
            $('body').addClass('body-small')
        } else {
            $('body').removeClass('body-small')
        }
    })
})

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 100);
    } else if ($('body').hasClass('fixed-sidebar')){
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 300);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8,
        })
        .disableSelection();
};

 function validasi(selector, pesan) {

    $(selector).parent()
    .find('code')
    .remove();

    $(selector).parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    $(selector).parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   $(selector).on('keyup change', function(){
      $(this).parent()
      .removeClass('has-error')
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};
 function validasi1(selector, pesan) {

    selector.parent()
    .find('code')
    .remove();

    selector.parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    selector.parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   selector.on('keyup change', function(){
      $(this).parent()
      .removeClass('has-error')
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};
 function validasi4(selector, pesan) {

    $(selector).parent()
    .find('code')
    .remove();

    $(selector)
    .parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    $(selector).parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   $(selector).on('keyup change', function(){
      $(this)
      .removeClass('has-error')
      .parent()
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};

 function validasi2(selector, pesan) {

    $(selector).parent().parent()
    .find('code')
    .remove();

    $(selector).parent().parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    $(selector).parent().parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   $(selector).on('keyup change', function(){
      $(this).parent().parent()
      .removeClass('has-error')
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};
 function validasi3(selector, pesan) {

    validasi(selector, pesan);

    $('#register_hamil_id').change(function(e) {
        if ($('#register_hamil_id').val() != '') {
            $(selector).parent()
              .removeClass('has-error')
              .find('code')
              .fadeOut('1000', function() {
                  $(this).remove();
            });
        }
    });
     
};


function hari_ini(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    } 

    if(mm<10) {
        mm='0'+mm
    } 

    return yyyy + '-'+ mm + '-' + dd;

}

function tanggal(tanggal){
    var arr = tanggal.split('-');

    return arr[2] + '-' + arr[1]+ '-' +arr[0];
}

function rataAtas5000(biaya){
    if (biaya == 0 || biaya == '') {
        return 0;
    }

    for (var i = 0; i < biaya; i = i+5000) {
    }
    return i;

}

function imgError() {
    $("img").error(function () {
      $(this).unbind("error").attr("src", "/img/notfound.jpg");
    });
}

function cleanUang(uang){

    if (uang == '' || undefined) {
        uang = 0;
    } else {
        uang = uang.replace(/\./g,'');
        uang = uang.split(",")[0];
        uang = uang.split(" ")[1];
    }
    return parseInt( uang );
}

function validatePass(){
    var pass = true;
    var string = '';
    $('.rq:not(div)').each(function(index, el) {
      if ($(this).val() == '') {
        string += $(this).closest('.form-group').find('label').html() + ', ';
        validasi1($(this), 'Harus Diisi!!');
        pass = false;
      }
    });
    if (!pass) {
        alert(string + ' tidak boleh dikosongkan');
        $('.rq').each(function(index, el) {
          if ($(this).val() == '') {
            $(this).focus();
            return false;
          }
        });
    }
    return pass;
}

function formatUang(){
    $('.uang:not(:contains("Rp."))').each(function() {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html('Rp. ' + number + ',-');
    });
}


function uang(content){
        var number = content;
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        return 'Rp. ' + number + ',-';
}

