"use strict";

class Ajax {
    /**
     * @param {string} url
     * @param {string} method
     * @param {JSON} data
     */
    constructor (url, method, data) {
        this.method = method;
        this.url    = url;
        this.data   = data;

        this.setRequest.bind(this.data);
    }

    async setRequest(data = {}) {
        this.request = await fetch(this.url, {
            method: this.method,
            credentials: "same-origin", //
            headers: {
                //"Content-Type": "application/json" //si l'on envoie du JSON
                "Content-Type": "text/plain;charset=UTF-8"
            },
            body: data // body data type doit correspondre au "Content-Type" du headers
        })
        .then(response => response.text())
        .then(response => alert(response))
        .catch(error => alert("Erreur : " + error));

        //this.result = await response.text();
    }
}