import Swiper from "swiper";
import {
  Autoplay,
  Pagination,
  Navigation,
} from "swiper/modules";
import "swiper/css/bundle";

document.addEventListener("DOMContentLoaded", function () {
    // Testimonials
    const swiper = new Swiper(".swiper", {
        modules: [Autoplay, Pagination, Navigation],
        slidesPerView: 1,
        grabCursor: true,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
});
