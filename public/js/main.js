function img2svg() {

    jQuery('.in-svg').each(function (i, e) {
  
      var $img = jQuery(e);
  
      var imgID = $img.attr('id');
  
      var imgClass = $img.attr('class');
  
      var imgURL = $img.attr('src');
      console.log({imgURL})
      if(imgURL){
        jQuery.get(imgURL, function (data) {
    
          // Get the SVG tag, ignore the rest
    
          var $svg = jQuery(data).find('svg');
    
          // Add replaced image's ID to the new SVG
    
          if (typeof imgID !== 'undefined') {
    
            $svg = $svg.attr('id', imgID);
    
          }
    
          // Add replaced image's classes to the new SVG
    
          if (typeof imgClass !== 'undefined') {
    
            $svg = $svg.attr('class', ' ' + imgClass + ' replaced-svg');
    
          }
    
          // Remove any invalid XML tags as per http://validator.w3.org
    
          $svg = $svg.removeAttr('xmlns:a');
    
          // Replace image with new SVG
    
          $img.replaceWith($svg);
    
        }, 'xml');
      }
  
    });
  
  }
  
  img2svg();



// Swiper Slider

var swiper = new Swiper(".logo-slider", {
  slidesPerView: "auto",
  spaceBetween: 80,
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  breakpoints: {
    0: {
      spaceBetween: 40,
    },
    575: {
      spaceBetween: 50,
    },
    767: {
      spaceBetween: 60,
    },
    1200: {
      spaceBetween: 80,
    },
  },
});
var swiper = new Swiper(".offer-slider", {
  // loop: true,
  // autoplay: {
  //   delay: 2500,
  //   disableOnInteraction: false,
  spaceBetween: 24,
  // },
  breakpoints: {
    0: {
      slidesPerView: "1",
    },
    575: {
      slidesPerView: "2",
    },
    767: {
      slidesPerView: "3",
    },
    1200: {
      slidesPerView: "4",
    },
  },
});

$(document).ready(function() {

  $('.di__password_view, .di__password_hide').click(function() {
    var passwordInput = $(this).closest('.position-relative').find('.password');
    var currentType = passwordInput.attr('type');
    var newType = (currentType === 'password') ? 'text' : 'password';
    passwordInput.attr('type', newType);
  });

  $('.di__password_toggle img').click(function() {
    // Toggle the 'active' class on the parent div
    $(this).parent('.di__password_toggle').toggleClass('active');
  });

  $('.inner-dropdown .dropdown-arrow').click(function () {
    $(this).closest('.inner-dropdown').find('ul').slideToggle();
  });

  $('.di__chat__mobile').click(function () {
    $('.di__chat-list').toggleClass('active');
  });

  $('.di-search_icon').click(function () {
    $('.di__dashboard_search--mobile').toggleClass('active');
  });

  $('.di__toogle-sidebar').click(function () {
    $(this).toggleClass('active');
    $('.di__dashboard-sidebar').toggleClass('active');
  });

  $('.di__notification').on('click', function() {
    $('.di__notification_pannel').toggleClass('active');
});

  $( '.input-select-duration' ).select2( {
    theme: "bootstrap-5",
    // minimumResultsForSearch: Infinity,
    placeholder: "Duration",
    dropdownCssClass: 'di__select_duration'
  } );

  $( '.di__select' ).select2( {
    theme: "bootstrap-5",
    // minimumResultsForSearch: Infinity,
  } );
  $( '.di__telephone--select' ).select2( {
    theme: "bootstrap-5",
    dropdownCssClass: "di__telephone--select"
  } );

  $(".timepicker").timepicker({
    timeFormat: "hha", 
    maxTime: "23:55pm", 
    defaultTime: "time", 
    startTime: "01:00",
    dynamic: true, 
    dropdown: true,
    scrollbar: false
  });

  $('#di__user_table').dataTable({
    
    searching: false,
    "ordering": false,
    "autoWidth": false,
    scrollX: true,
    scroller: true,
    "language": {
      "info": "",
      "lengthMenu": "Showing result: _MENU_",
    },
  dom: "<'row'<'col-sm-12'tr>>" + "<'row mt-3'<'col-sm-4'l><'col-sm-8'p>>",
  });

  $('.di__portfolio_table').dataTable({
    
    // searching: false,
    "ordering": false,
    "autoWidth": false,
    scrollX: true,
    scroller: true,
    "language": {
      search: "",
      "searchPlaceholder": "Search",
      "info": "",
      "lengthMenu": "Showing result: _MENU_",
    },
  dom:"<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6 di__filter_wrapper text-end'>>" +
  "<'row'<'col-sm-12'tr>>" +
  "<'row mt-2 mt-lg-4'<'col-sm-12 col-md-6 mt-2'><'col-sm-12 col-md-6 mt-2'p>>",
  });
 
  $('#di__post_group').dataTable({
    columnDefs: [
      { "width": "24%", "targets": 0 },
      { "width": "30%", "targets": 1 },
      { "width": "30%", "targets": 2 },
      { "width": "16%", "targets": 3 }
    ],
    "ordering": true,
    "autoWidth": false,
    scrollX: true,
    scroller: true,
    "language": {
      "lengthMenu": "Showing result: _MENU_",
    },
  dom:"<'row'<'col-sm-12'>tr>" + "<'row mt-3'<'col-sm-4'l><'col-sm-8'p>>",
  });

  $('.di__post_view').dataTable({
    "ordering": true,
    "autoWidth": false,
    scrollX: true,
    scroller: true,
    "language": {
      "lengthMenu": "Showing result: _MENU_",
    },
  dom:"<'row'<'col-sm-12'>tr>" + "<'row mt-3'<'col-sm-4'l><'col-sm-8'p>>",
  });



  $('.di__super_table').dataTable({
    
    "ordering": true,
    "autoWidth": false,
    scrollX: true,
    scroller: true,
    "language": {
      search: "",
      "searchPlaceholder": "Search",
      "info": "",
      "lengthMenu": "Showing result: _MENU_",
    },
  dom:"<'row'<'col-sm-12 col-md-6 mb-5 di__table_search'f><'col-sm-12 col-md-6 mb-5 di__filter_wrapper text-end'>>" +
  "<'row'<'col-sm-12'tr>>" +
  "<'row gy-4 mt-lg-4'<'col-sm-12 col-md-6 'l><'col-sm-12 col-md-6'p>>",
  });

  $(".di__filter_main").appendTo(".di__filter_wrapper");

    var clonedDiv = $("di__filter_main").clone();
    $(".di__filter_wrapper").append(clonedDiv);
  
  $('.timepicker').click(function() {
    $(this).closest('.di__time_input').addClass('active');
  });

  // $('.di__filter_main .form-control').click(function() {
  //   $('.di__filter_options').toggleClass('active');
  // });

  $(".di__duration_select").on("click", function() {
    $(this).addClass("active");
  });

/**/


$(".di__select").on("change", function() {
  var selectedOption = $(this).val();
  
  // Hide all data divs
  $(".option1Data").hide();
  $(".option2Data").hide();
  
  // Show the selected data div
  $("." + selectedOption + "Data").show();

});



// When you click on the close button within a .di__popup_message container
$('.di__popup_message .di__popup_btn').click(function() {
  // Find the parent .di__popup_message container and target elements within it
  var $container = $(this).closest('.di__popup_message');
  $container.find('.di__popup, .di__popup_btn').addClass('active');
  $('.di__bg_overlay').addClass('active');
});

// When you click on the close button within a .di__popup_message container
$('.di__popup_message .close').on('click', function(e) {
  e.stopPropagation(); // Prevent the click event from propagating to .di__notification
  // Find the parent .di__popup_message container and target elements within it
  var $container = $(this).closest('.di__popup_message');
  $container.find('.di__notification_pannel').removeClass('active');
  $container.find('.di__popup, .di__popup_btn').removeClass('active');
  $('.di__bg_overlay').removeClass('active');
});

  
  function adjustPopupPosition() {
    var $popupMessage = $('.di__popup_message');
    var $popup = $popupMessage.find('.di__popup');
    var popupWidth = $popup.outerWidth();
    var buttonOffset = $popupMessage.offset();

    // Calculate new position relative to .di__popup_message
    var newLeft = 0;

    // Ensure the popup stays inside the window
    var windowWidth = $(window).width();

    if (buttonOffset.left + popupWidth > windowWidth) {
        newLeft = windowWidth - popupWidth - buttonOffset.left;
    }

    $popup.css({
        left: newLeft
    });
  }
  // Update the popup position when the window is resized
  $(window).resize(function() {
      adjustPopupPosition();
    });


});

var CryptoJSAesJson = {
  stringify: function(cipherParams) {
      var j = {
          ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)
      };
      if (cipherParams.iv) j.iv = cipherParams.iv.toString();
      if (cipherParams.salt) j.s = cipherParams.salt.toString();
      return JSON.stringify(j);
  },
  parse: function(jsonStr) {
      var j = JSON.parse(jsonStr);
      var cipherParams = CryptoJS.lib.CipherParams.create({
          ciphertext: CryptoJS.enc.Base64.parse(j.ct)
      });
      if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
      if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
      return cipherParams;
  }
}

jQuery.ajaxSetup({
  // dataFilter: function(data, type) {
  //     //modify the data
  //     const res = JSON.parse(data);
  //     if (res.aaData) {
  //         var decrypted = JSON.parse(JSON.parse(CryptoJS.AES.decrypt(res.aaData,
  //           __secretKey, {
  //                 format: CryptoJSAesJson
  //             }).toString(CryptoJS.enc.Utf8)));
  //         res.aaData = decrypted
  //     }
  //     return JSON.stringify(res);
  // }
});

// Dropzone.options.myDropzone = {
//   // Configuration options go here
// };

// ClassicEditor
// .create( document.querySelector( '#editor' ), {
//     toolbar: [ 'bold', 'italic', 'underline', 'bulletedList','outdent', 'indent' ]
// } )
// .catch( error => {
//     console.log( error );
// } );


