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

            this.setPreventEmptyInputForm("form_contact", "submit", [
                "nom",
                "mail",
                "message",
            ]);

            this.setAjax();
        });
    }

    // +++++ +++++ Récupération des données +++++ +++++
    async getData() {
        let data         = {};
        let inputName    = document.getElementById("nom");
        let inputMail    = document.getElementById("mail");
        let inputMessage = document.getElementById("message");

        data = {
            nom: inputName.value,
            mail: inputMail.value,
            message: inputMessage.value
        };

        return data;
    }

    // +++++ +++++ Requête Ajax +++++ +++++
    async setAjax() {
        console.log(this.getData());
        let requestAjax = new Ajax("https://localhost/portfolio/public/index.php?access=contact", "POST", this.getData());
    }

    // +++++ +++++ Vérification que les inputs ne sont pas vide.
    async setPreventEmptyInputForm(formId, eventType, inputsId) {
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
