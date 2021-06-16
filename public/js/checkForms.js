"use strict";

class checkForms {

    /**
     * @param {HTMLElement} form
     */
    constructor(form) {
        this.form = form;

        this.form.addEventListener("submit", (evt) => {
            this.checkEvent(evt);
        });
    }

    checkEvent(evt) {
        if (! this.form.checkValidity()) {
            evt.preventDefault();
            evt.stopPropagation();
        }
        this.form.classList.add("was-validated");
    }

}