!$(document).ready(function() {
    $('.autoWidth').lightSlider({
        item:4,
        loop:true,
        responsive : [
            {
                breakpoint:1024,
                settings: {
                    item:3,
                  }
            },
            {
                breakpoint:740,
                settings: {
                    item:2,
                  }
            }
        ],
        onSliderLoad: function() {
            $('.autoWidth').removeClass('cS-hidden');
        } 
    });  
  });

  