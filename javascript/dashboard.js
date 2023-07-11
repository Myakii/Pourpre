document.addEventListener('DOMContentLoaded', function () {
    let search_glass = document.getElementById('arrow_more_mail');

    search_glass.addEventListener('mouseover', function () {
        this.src = 'assets/arrow-down-circle_pourpre.svg';
    });

    search_glass.addEventListener('mouseout', function () {
        this.src = 'assets/arrow-down-circle.svg';
    });
});
