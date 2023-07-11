// Creation de l'objet litteral
let produit = {
    libelle: "Appartement - Paris X",
    description: "Petit appartement a l'habrite des regarde/nbien située dans le X /nIl vous fera profiter d'une conforte inegalable. ",
    prix: "2700",
  };
  
  // Affichage des donnees de l'objet dans la page web
  document.querySelector('#libelle').textContent = produit.libelle;
  document.querySelector('#description').textContent = 'Description : ' + produit.description;
  document.querySelector('#prix').textContent = 'Prix : ' + produit.prix + ' €';
  
  console.log(produit)

  
