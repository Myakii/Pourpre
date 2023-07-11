document.getElementById('desc_img').addEventListener('change', function(event) {
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onloadend = function() {
    const base64 = reader.result;

    // Afficher la base64 dans l'élément <input>
    const outputBase64Input = document.getElementById('outputBase64');
    outputBase64Input.value = base64;

    // Créer un élément <img> pour afficher l'image
    const imgElement = document.createElement('img');
    imgElement.src = base64;
    imgElement.classList.add('image_preview');

    const imageContainer = document.getElementById('imageContainer');
    imageContainer.innerHTML = '';
    imageContainer.appendChild(imgElement);
  };

  reader.readAsDataURL(file);
});