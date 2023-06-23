var $ = jQuery.noConflict();

jQuery(document).ready(function($) {

    $("body").keydown(function(e) {
        if (e.keyCode == 37) { // left
            plusSlides(-1);
            console.log('plusSlides(-1);');
        } else if (e.keyCode == 39) { // right
            plusSlides(1);
            console.log('plusSlides(1);');
        } else if (e.keyCode == 27) { //esc
            var anime = $('.open').attr('id');
            closeModal(anime);
            console.log('closeModal();');
        }
    });


});

function openModal(anime) {
    document.getElementById(anime).style.display = "block";
    //add class to anime div
    $('#' + anime).addClass('open');
}

function closeModal(anime) {
    console.log('closeModal ' + anime);
    $('.modal').css('display', 'none');
    $('#' + anime).removeClass('open');
}


var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    console.log('currentSlide slideIndex ' + n);
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;

    var slides = $('.open').find('.mySlides'); //lightbox_main_image
    var dots = $('.open').find('.demo'); //slides under main img
    console.log('slides ' + slides);
    console.log('dots ' + dots);

    //var captionText = document.getElementById("caption");

    if (n > slides.length) { slideIndex = 1 } //last slide
    if (n < 1) { slideIndex = slides.length } //no slides 

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    //show 4 slides only
    for (i = 0; i < dots.length; i++) {
        dots[i].style.display = "none";

        if (slideIndex + 2 == i || slideIndex + 1 == i || slideIndex == i || slideIndex - 1 == i) { //4 slides nearest slideIndex
            dots[i].style.display = "block";
        }

        console.log('i: ' + i + ' slideIndex: ' + slideIndex);
    }

    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}