let formulaire = document.getElementById('form1');
formulaire.addEventListener('submit', function(e) {
    let pseudo = document.getElementById("pseudo");
    let password = document.getElementById("password");

    let myError = document.getElementById('erreur');
    myError.style.color = 'red';
    if (pseudo.value.trim() == '') {
        myError.innerHTML = 'Le champ pseudo est requis';
        e.preventDefault();
    }
    if (password.value.length < 8) {
        myError.innerHTML = 'Le mot de passe doit contenir au moins 8 caractères';
        e.preventDefault();
    } else if (!/[#$]/.test(password.value.slice(-1))) {
        myError.innerHTML = 'Le mot de passe doit se terminer par $ ou #';
        e.preventDefault();}});