let formulaire = document.getElementById('form2');
formulaire.addEventListener('submit', function(e) {
  
    let titre = document.getElementById("titre");
    let description = document.getElementById("description");
    let nb = document.getElementById("nb_actions");
    let montant = document.getElementById("montant");

    let regExnb = /^\d+$/;
    let regExmontant = /^(\d+(\.\d+)?|\.\d+)$/;

    ;


    let myError = document.getElementById('erreur');
    myError.style.color = 'red';
    
    if (titre.value.trim() == '') {
        myError.innerHTML = 'Le champ titre est requis';
        e.preventDefault();}
    
    if (description.value.trim() == '') {
            myError.innerHTML = 'Le champ description est requis';
            e.preventDefault();}
        
    if (nb.value.trim() == '') {
                myError.innerHTML = 'Le champ nombre d actions a vendre est requis';
                e.preventDefault();}
    else if (regExnb.test(nb.value) == false) {
                myError.innerHTML = "Le champ nombre d actions a vendre doit être un entier";
                e.preventDefault();
            }
            
    if (montant.value.trim() == '') {
                    myError.innerHTML = 'Le champ valeur monetaire de l action est requis';
                    e.preventDefault();}
                
    else if (regExmontant.test(montant.value) == false) {
                    myError.innerHTML = "Le champ valeur monetaire de l action doit être un reel";
                    e.preventDefault();
                }                       
    
    
    
    
    });


    document.getElementById("annulerBtn").addEventListener("click", function(event) {
        event.preventDefault(); 
        annuler(); 
    });
    
    function annuler() {
        document.getElementById("titre").value = "";
        document.getElementById("description").value = "";
        document.getElementById("nb_actions").value = "";
        document.getElementById("montant").value = "";
        document.getElementById("erreur").innerHTML = ""; 
    }
    
    
    