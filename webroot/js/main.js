'use strict';

$('#sl2').slider();

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

$('.active-cat').css('background-color', 'orange');

$('.main-cat').on('click', function () {
   let clickedCat = $(this).data('id'),
       block = $(this);
    $('.cat-' + clickedCat).hide();
    $(block).addClass('closed-' + clickedCat);
});

$('.closed-' + clickedCat).on('click', function () {
    $('.cat-' + clickedCat).show();
    $('.closed-' + clickedCat).removeClass('closed-' + clickedCat);
});
