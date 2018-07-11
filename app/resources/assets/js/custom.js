// Custom JS

$('[data-toggle="collapse"]').on('click', function (e) {
    e.preventDefault();
    $('.navbar').toggleClass('active');
});

$('.nav-link').on('click', function () {
    $('.nav-item').removeClass('active');
    $(this).closest('.nav-item').addClass('active');
});
