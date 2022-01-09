window.onload = () => {
    let balises = document.querySelectorAll("a.btn")
    for(let balise of balises){
        balise.addEventListener("click", persoModale)
    }

}
function persoModale(){
    // On va lire les attributs data
    let titre = this.dataset.titre
    let url = this.dataset.url
    let description = this.dataset.description
    //console.log(titre)

    //On injecte le titre dans la modale
    document.querySelector("#staticBackdrop .modal-title").innerText = titre
    document.querySelector("#staticBackdrop .modal-description").innerText = description
    document.querySelector("#staticBackdrop .modal-url").innerText = url

}