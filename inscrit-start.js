let formulaire = document.getElementById('form1');
formulaire.addEventListener('submit', function(e) {
  
    let prenom = document.getElementById("prenom");
    let nom = document.getElementById("nom");
    let cin = document.getElementById("cin");
    let email = document.getElementById("email");
    let entreprise = document.getElementById("entreprise");
    let adresse = document.getElementById("adresse");
    let registre = document.getElementById("registre");
    let pseudo = document.getElementById("pseudo");
    let password = document.getElementById("password");
    let confirmPassword = document.getElementById("confirmPassword");
    let photo = document.getElementById("photo");

    let regExNomPrenom = /^[a-zA-Z\s]+$/;
    let regExEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let regExAdresse = /^[a-zA-Z0-9\s\,\;\:]+$/;

    let myError = document.getElementById('erreur');
    myError.style.color = 'red';
    
    if (prenom.value.trim() == '') {
        myError.innerHTML = 'Le champ prénom est requis';
        e.preventDefault();
    } else if (regExNomPrenom.test(prenom.value) == false) {
        myError.innerHTML = "Le champ prénom doit être composé de lettres ou d'espaces";
        e.preventDefault();
    }

    if (nom.value.trim() == '') {
        myError.innerHTML = 'Le champ nom est requis';
        e.preventDefault();
    } else if (regExNomPrenom.test(nom.value) == false) {
        myError.innerHTML = "Le champ nom doit être composé de lettres ou d'espaces";
        e.preventDefault();
    }

    if (cin.value.trim() == '') {
        myError.innerHTML = 'Le champ CIN est requis';
        e.preventDefault();
    } else if (!/^\d{8}$/.test(cin.value)) {
        myError.innerHTML = 'Le CIN doit être composé de 8 chiffres';
        e.preventDefault();
    }

    if (email.value.trim() == '') {
        myError.innerHTML = 'Le champ email est requis';
        e.preventDefault();
    } else if (regExEmail.test(email.value) == false) {
        myError.innerHTML = "L'adresse email n'est pas valide";
        e.preventDefault();
    }

    if (entreprise.value.trim() == '') {
        myError.innerHTML = 'Le champ nom entreprise est requis';
        e.preventDefault();
    }

    if (adresse.value.trim() == '') {
        myError.innerHTML = 'Le champ adresse  est requis';
        e.preventDefault();
    } else if (regExAdresse.test(adresse.value) == false) {
        myError.innerHTML = "L'adresse doit être composée de lettres, chiffres, espaces et des caractères spéciaux , ; :";
        e.preventDefault();
    }

    if (registre.value.trim() == '') {
        myError.innerHTML = 'Le champ numero de registre de commerce est requis';
        e.preventDefault();
    } else if (!/^[A-Z]\d{10}$/.test(registre.value)) {
        myError.innerHTML = 'Le numero de registre de commerce doit être formé par une lettre majuscule suivie de 10 chiffres';
        e.preventDefault();
    }

    if (pseudo.value.trim() == '') {
        myError.innerHTML = 'Le champ pseudo est requis';
        e.preventDefault();
    }

    if (password.value.length < 8) {
        myError.innerHTML = 'Le mot de passe doit contenir au moins 8 caractères';
        e.preventDefault();
    } else if (!/[#$]/.test(password.value.slice(-1))) {
        myError.innerHTML = 'Le mot de passe doit se terminer par $ ou #';
        e.preventDefault();
    } else if (password.value !== confirmPassword.value) {
        myError.innerHTML = 'Les mots de passe ne correspondent pas';
        e.preventDefault();
    }

    
});
