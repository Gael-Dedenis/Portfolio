"use strict";

class Ajax {
    /**
     * @param {string} url
     */
    constructor (url) {
        this.url = url;

        return new Promise(function (resolve, reject) {
            const xhr = new XMLHttpRequest();

            // En cas de succès
            xhr.onload = function () {
                resolve(this);
            }

            // En cas d'échec
            xhr.onerror = function () {
                reject(new Error("Erreur pendant l'envoie, réessayer."));
            };

            xhr.open("POST", this.url, true);
            xhr.send(null);
        });
    }
}