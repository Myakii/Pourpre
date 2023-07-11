function blank_page() {
    let liens = document.querySelectorAll(".partner_logo a");
    
    for (let i = 0; i < liens.length; i++) {
      let lien = liens[i];
      lien.setAttribute("target", "_blank");
    }
  }
  
window.onload = function() {
    blank_page();
};
  