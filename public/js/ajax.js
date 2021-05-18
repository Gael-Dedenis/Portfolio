"use strict";

class Ajax {
    /**
     * @param {string} url
     * @param {string} method
     * @param {JSON} data
     */
    constructor (url, method) {
        this.method = method;
        this.url    = url;

        this.setRequest();
    }

    async setRequest() {
        this.request = await fetch(this.url, this.method)
        .then(response => console.log(response)); //response.text()

        //this.result = await response.text();
    }
}