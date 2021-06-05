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
                    this.createEltPortfolio(allprojects[i]);
                    i++;
                }

                this.changeToButtonLess();
            });
    }

    /**
     * @param {array} data 
     */
    createEltPortfolio(data) {
        this.projectContainer = this.createElt("div");
        this.projectTitle     = this.createElt("h3");
        this.projectLink      = this.createElt("a");
        this.projectImg       = this.createElt("img");

        this.setOptionsElt();
        this.constructDOM();
        this.setContent(data);
    }

    /**
     * @param {string} type 
     * @returns {HTMLElement}
     */
    createElt(type) {
        return document.createElement(type);
    }

    setOptionsElt() {
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
        this.buttonLess = this.createElt("button");

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