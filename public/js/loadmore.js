"use strict";

class Loadmore {

    /**
     * @param {HTMLElement} button
     *  @param {string} url
     *  @param {string} method
     */
    constructor(button, url) {
        this.button = button;
        this.url    = url;

        this.setEventUi();
    }

    setEventUi() {
        this.getEventButton();
    }

    getEventButton() {
        this.button.addEventListener("click", (e) => {
            let newRequest = new Ajax(this.url);
            console.log(newRequest);
            this.addProjects(newRequest);
        });
    }

    addProjects(data) {
        let container = document.getElementById("container-portfolio");
/*         let card      = this.createElmtWithClass("div", ["my-3 px-5 text-center project"]);
        let title     = this.createElmtWithClass("h3", ["text-decoration-underline fw-bold"]);
        let link      = this.createElmtWithClass("a", [""]); */
    }

    createElmtWithClass(type, className) {
        let element = document.createElement(type);

        if (className !== "" || className !== null || className !== "undefined" || className !== []) {
            element.setAttribute("class", className);
        }

        return element;
    }

}