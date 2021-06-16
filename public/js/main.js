"use strict";

// attente de la fin de chargement de la fenêtre.
window.onload = () => {

    // +++++ +++++ Check Formulaire de contact +++++ +++++
    let form = new checkForms(document.getElementById("form_contact"));

    // +++++ +++++ Bouton Loadmore +++++ +++++
    let button_Loadmore = new Loadmore(document.getElementById("loadmore"), "https://localhost/portfolio/public/index.php?access=portfolio", document.getElementById("container-portfolio"));

};
