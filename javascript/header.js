document.addEventListener('DOMContentLoaded', function () {
    let profil_img = document.getElementById('profil_image');
    let click = false;

    // Changer l'image quand on passe la souris dessus
    profil_img.addEventListener('mouseover', function () {
        if (!click) {
            this.src = 'assets/user_pourpre.svg';
        }
    });

    profil_img.addEventListener('mouseout', function () {
        if (!click) {
            this.src = 'assets/user.svg';
        }
    });

    profil_img.addEventListener('click', function () {
        if (click) {
            this.src = 'assets/user.svg';
        } else {
            this.src = 'assets/user_pourpre.svg';
        }
        click = !click;
    });

});

function toggleHiddenDiv() {
    var belowDiv = document.querySelector(".below_div");
    belowDiv.classList.toggle("hidden_div");
}