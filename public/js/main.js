function querySelector(el) {
    return document.querySelector(el);
}

function getElementById(id) {
    return document.getElementById(id);
}

function disableBtn() {
    querySelector('#btn').disabled = true;
}

function enableBtn() {
    querySelector('#btn').disabled = false;
}

// Mostrar contraseña
function showPassword() {
    var password = getElementById("password");
    var confirm_password = getElementById("confirm-password");
    if (confirm_password) {
        if (password.type === "password" && confirm_password.type === "password") {
            password.type = confirm_password.type = "text";
        } else {
            password.type = confirm_password.type = "password";
        }
    } else {
        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }
    }
}
// Fin de la funcion mostrar contraseña

// Dark/Light Mode
if (localStorage.dark === 'true') {
    darkLightMode();
}

document.addEventListener('DOMContentLoaded', function () {
    if (querySelector('.dark-switcher'))
        querySelector('.dark-switcher').onclick = darkLightMode;
})

function darkLightMode() {
    var src, alt;
    if (querySelector('.theme-icon').getAttribute('src') === 'img/moon.svg') {
        localStorage.dark = true;
        src = 'img/sun.svg';
        alt = 'Light';
    } else {
        localStorage.dark = false;
        src = 'img/moon.svg';
        alt = 'Dark';
    }
    document.body.classList.toggle('dark');
    // if(querySelector('.table')) querySelector('.table').classList.toggle('table-dark');
    querySelector('.navbar').classList.toggle('navbar-dark');
    querySelector('.navbar').classList.toggle('navbar-light');
    querySelector('.theme-icon').src = src;
    querySelector('.theme-icon').alt = alt + ' Mode';
}
// END Dark/Light Mode


// Ajax
let ajax;

function makeAjaxCall(method, url, callBack, parameters) {
    ajax = get_xhr();
    ajax.open(method, url + Math.random(), true);
    ajax.withCredentials = true;
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (ajax.readyState != 4 || ajax.status != 200) return;
        callBack();
    };
    ajax.send(parameters);
}

function get_xhr() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}
// FIN AJAX