"use strict";

class Ajax {
    /**
     * @param {string} url
     * @param {function} callback
     */
    constructor (url) {
        this.url = url;

        this.setRequest();
    }

    async setRequest() {
        this.request = await fetch(this.url)
        .then(response => {
            if (response.ok) {
                response.json().then(data => {
                    console.log(data);

                    let i   = 0;
                    let nbr = data.length - 4;

                    let projects = {
                         for (i=0; i<=nbr; i++) {
                            data[i];
                        }
                    }
                    return projects;
                })
            } else {
                console.error("Erreur !");
            }
        })
    }
}