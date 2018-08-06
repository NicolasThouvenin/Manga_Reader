
function validateRegisterForm(){
    var login = document.getElementById('login');
    var firstname = document.getElementById('firstname');
    var surname = document.getElementById('surname');
    var birtDate = document.getElementById('bithDate');
    validateEmail(document.getElementById('email'));
    return false;
};
function validateEmail(email) {
    //Cette function sert a valider un input email
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var check = re.test(String(email.value).toLowerCase());
    if (!check) {
        _setErrorStyle(email);
    };
    return check;
};

function checkLogin(login) {
    
}

function _setErrorStyle(inputElement) {
    inputElement.classList.add('bad-input');
}
