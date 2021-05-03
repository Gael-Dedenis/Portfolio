"use strict";

class FormContact {

    /**
     * @param {HTMLElement} container Id du formulaire de contacts
     */
    constructor (container) {
        this.container = container;

        this.setContactEvents();
    }

    // +++++ Ajouts des évènements sur le formulaire de contact
    setContactEvents() {
        this.container.addEventListener("submit", (e) => {
            e.preventDefault();
            this.setPromiseAjax()
        });
    }

    // +++++ +++++ Requête Ajax +++++ +++++
    setPromiseAjax() {
        this.requestAjax = new Ajax("https://localhost/portfolio/public/index.php?access=contact");
        this.requestAjax.then(function (xhr) {
            if (xhr.status !== 200) {
                console.log("Erreur lors de la requête Ajax.");
            } else {
                console.log("Envoie réussi !");
            }
        }).catch(function (error) {
            console.error(error);
        })
    }
}


/* window.onload = () => {
    preventEmptyInputForm("form_contact", "submit", [
        "nom",
        "mail",
        "message",
    ]);
};

function preventEmptyInputForm(formId, eventType, inputsId) {
    const form = document.getElementById(formId);

    if (form) {
        form.addEventListener(eventType, (e) => {
            inputsId.forEach((inputId) => {
                const input =document.getElementById(inputId);
                if(input.nodeValue.trim().length === 0) {
                    e.preventDefault();
                    e.stopPropagation();
                    return alert("Le champ " + inputId + " n\'est pas rempli !");
                };
            });
        });
    }
} */