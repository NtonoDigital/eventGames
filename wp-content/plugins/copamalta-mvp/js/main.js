;
(function($) {

    $(function() {

        var mySwiper = new Swiper('.copamalta-mvp .swiper-container', {
            speed: 400,
            spaceBetween: 20,
            slidesPerView: 2,
            slidesPerGroup: 2,
            autoHeight: true,
            pagination: {
                el: '.copamalta-mvp .swiper-pagination',
                type: 'bullets',
                clickable: true
            },
            breakpoints: {

                480: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    slidesPerGroup: 1
                },
                993: {
                    slidesPerView: 2,
                    spaceBetween: 30,

                }
            }
        });
    });

})(jQuery);