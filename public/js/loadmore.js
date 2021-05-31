"use strict";

class Loadmore {

    /**
     * @param {HTMLElement} button
     * @param {string} url
     * @param {HTMLElement} container
     */
    constructor(button, url, container) {
        this.button     = button;
        this.url        = url;
        this.container  = container;
        this.article    = document.getElementById("portfolio");

        this.setEventUi();
    }

    setEventUi() {
        this.getEventButton();
    }

    getEventButton() {
        this.button.addEventListener("click",() => {
            this.createRequest();
        });
    }

    createRequest() {
        let newRequest = fetch(this.url)
            .then(response => response.json())
            .then(data => {
                let allprojects = data.slice(4);
                let i           = 0;

                while (i < allprojects.length) {
                    this.createElmtPortfolio(allprojects[i]);
                    i++;
                }

                this.changeToButtonLess();
            });
    }

    /**
     * @param {array} data 
     */
    createElmtPortfolio(data) {
        this.projectContainer = this.createElmt("div");
        this.projectTitle     = this.createElmt("h3");
        this.projectLink      = this.createElmt("a");
        this.projectImg       = this.createElmt("img");

        this.setOptionsElmt();
        this.constructDOM();
        this.setContent(data);
    }

    /**
     * @param {string} type 
     * @returns {HTMLElement}
     */
    createElmt(type) {
        return document.createElement(type);
    }

    setOptionsElmt() {
        this.projectContainer.classList.add("my-3", "px-5", "text-center", "project", "project-added");
        this.projectTitle.classList.add("text-decoration-underline", "fw-bold");
    }

    constructDOM() {
        this.container.appendChild(this.projectContainer);
        this.projectContainer.appendChild(this.projectTitle);
        this.projectContainer.appendChild(this.projectLink);
        this.projectLink.appendChild(this.projectImg);
    }

    /**
     * @param {array} data 
     */
    setContent(data) {
        this.projectTitle.innerHTML = data.titre;

        Object.assign(this.projectLink, {
            href: data.lien,
            target: "_blank",
            rel: "noreferrer"
        });

        Object.assign(this.projectImg, {
            src: "images/projets/" + data.lien_image,
            alt: data.description,
            title: data.description,
            rel: "external"
        });
    }

    changeToButtonLess() {
        this.buttonLess = this.createElmt("button");

        this.button.remove();
        this.buttonLess.setAttribute("id", "lessProject");
        this.buttonLess.classList.add("my-3", "btn", "btn-outline-dark", "fas", "fa-minus", "fa-2x");
        this.article.appendChild(this.buttonLess);

        this.buttonLess.addEventListener("click", () => {
            this.lessProjects();
        });
    }

    lessProjects() {
        let addedProjects = document.querySelectorAll(".project-added");

        addedProjects.forEach((value) => {
            value.remove();
        });

        this.changeToButtonMore();
    }

    changeToButtonMore() {
        this.buttonLess.replaceWith(this.button);
    }

}