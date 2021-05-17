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
            this.checkEmptyInput("form_contact", "submit", [
                "nom",
                "mail",
                "message",
            ]);

        });
    }

    // +++++ +++++ Vérification que les inputs ne sont pas vide.
    async checkEmptyInput(formId, eventType, inputsId) {
    const form = document.getElementById(formId);

        if (form) {
            form.addEventListener(eventType, (e) => {
                inputsId.forEach((inputId) => {
                    const input = document.getElementById(inputId);
                    if(input.nodeValue.trim().length === 0) {
                        e.preventDefault();
                        e.stopPropagation();
                        return alert("Le champ " + inputId + " n\'est pas rempli !");
                    };
                });
            });
        }
    }
}
