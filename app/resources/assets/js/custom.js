// Custom JS

/**
 * Menu responsive behavior
 */
$('[data-toggle="collapse"]').on('click', function (e) {
    e.preventDefault();
    $('.navbar').toggleClass('active');
});

$('.nav-link').on('click', function () {
    $('.nav-item').removeClass('active');
    $(this).closest('.nav-item').addClass('active');
});

/**
 * Tootlips on forms
 */
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});