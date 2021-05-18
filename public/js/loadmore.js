"use strict";

class Loadmore {

    /**
     * @param {HTMLElement} button
     */
    constructor(button, url, method) {
        this.button = button;
        this.url    = url;
        this.method = method;

        console.log(this.button, this.url, this.method);
        this.setEventUi();
    }

    setEventUi() {
        this.button.addEventListener("submit", (e) => {
            console.log("submit ok !");
            this.setNewRequest();
        });
    }

    async setNewRequest() {
        let newRequest = new Ajax(this.url, this.method);
    }
}