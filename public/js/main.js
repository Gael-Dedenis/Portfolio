"use strict";

// attente de la fin de chargement de la fenêtre.
window.onload = () => {

    // +++++ +++++ Bouton Loadmore +++++ +++++
    new Loadmore(document.getElementById("loadmore"), "https://localhost/portfolio/public/index.php?access=portfolio", document.getElementById("container-portfolio"));

};
