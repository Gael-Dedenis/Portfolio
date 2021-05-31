"use strict";

// attente de la fin de chargement de la fenêtre.
window.onload = () => {

    // +++++ +++++ Formulaire de contact +++++ +++++
    let formContact = new FormContact(document.getElementById("form_contact"));

    // +++++ +++++ Bouton Loadmore +++++ +++++
    let buttonLoadmore = new Loadmore(document.getElementById("loadmore"), "https://localhost/portfolio/public/index.php?access=portfolio", document.getElementById("container-portfolio"));
};
