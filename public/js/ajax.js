"use strict";

class Ajax {

    /**
     * @param {string} url
     * @param {function} callback
     * @param {string} methode soit "POST" soit "GET".
     */

    constructor(url, callback, methode) {
        this.request = new XMLHttpRequest();

        this.url      = url;
        this.callback = callback;
        this.methode  = methode;

        this.runAjax(this.methode);
    }

    // Création d'un appel par la méthode passer en argument
    runAjax(methode) {

        if(methode === null || methode === "") {
            return alert("La méthode est requise pour éxécuter l\'appel Ajax.");
        }

        this.request.open(methode, this.url);
        this.checkStatus();
        this.listenAjax();
        this.request.send();
    }

    // Ajout écouteurs événements Ajax
    listenAjax() {
        this.request.addEventListener("load", this.listenLoad.bind(this));
        this.request.addEventListener("error", this.listenError.bind(this));
    }

    // Détection Fin de l'appel
    listenLoad() {
        if (this.request.status >= 200 && this.request.status < 400) {
        this.callback(this.request.responseText);

        } else {
            console.error(this.request.status + " " + this.request.statusText + " " + this.url);
        }
    }

    listenError() {
        console.error("Network Error @URL => " + this.url);
    }

    checkStatus() {
        if(this.request.status == 404) 
            throw new Error(this.url + ' replied 404');
    }
    
}