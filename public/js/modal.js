window.onload = () => {
    //let portfolioElement = document.querySelector("#portfolio")
    //console.log(portfolioElement);
    let balises = document.querySelectorAll("a[data-show]")
    for(let balise of balises){
        balise.addEventListener("click", modale)
    }
}
function modale(){
    // On va lire les attributs data
    let titre = this.data.titre
    let description = this.data.description
    let url = this.data.url
    
    //console.log(titre)

    //On injecte le titre dans la modale
    document.querySelector("#staticBackdrop .modal-title").innerText = titre
    document.querySelector("#staticBackdrop .modal-description").innerText = description
    document.querySelector("#staticBackdrop .modal-url").href = url

}
