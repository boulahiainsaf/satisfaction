var envoyer = document.getElementById("envoyer");
envoyer.addEventListener("click", function verif(event) {

    let prenom = document.getElementById("prenom").value;
    let nom = document.getElementById("nom").value;
    let avis = document.getElementById("disc").value;
    let note03 = document.getElementById("note03").checked;
    let note02 = document.getElementById("note02").checked;
    let note01 = document.getElementById("note03").checked;
    let alpha = /^[A-Za-zéèàç]+$/;
    let text=/^[A-Za-zéèàç.,?1_9]+$/;
    if (!alpha.test(nom)) {
        document.getElementById("c1").textContent = "Veulliez saisir votre nom";
        event.preventDefault();
    } else {
        document.getElementById("c1").textContent = "";
    }
    if (!alpha.test(prenom)) {
        document.getElementById("c2").textContent = "Veulliez saisir votre prenom";
        event.preventDefault();
    } else {
        document.getElementById("c2").textContent = "";

    }
    if (note01 == false && note02 == false && note03 == false) {
        document.getElementById("c3").textContent = "Veulliez choisir une reponse ";
        event.preventDefault();
    } else {
        document.getElementById("c3").textContent = "";
    }
        if (!text.test(avis)){
            document.getElementById("c4").textContent = "Veulliez saisir votre avis ";
            event.preventDefault();
        } else {
            document.getElementById("c4").textContent = "";
        }



});
