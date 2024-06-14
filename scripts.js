document.addEventListener('DOMContentLoaded', function () {
    const rememberCheckbox = document.getElementById('remember');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    // Preencher os campos se os cookies existirem
    if (getCookie('username') && getCookie('password')) {
        usernameInput.value = getCookie('username');
        passwordInput.value = getCookie('password');
        rememberCheckbox.checked = true;
    }

    // Salvar cookies ao enviar o formulário
    document.querySelector('form').addEventListener('submit', function () {
        if (rememberCheckbox.checked) {
            setCookie('username', usernameInput.value, 30);
            setCookie('password', passwordInput.value, 30);
        } else {
            deleteCookie('username');
            deleteCookie('password');
        }
    });

    // Funções auxiliares para manipulação de cookies
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        const cname = name + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(cname) === 0) {
                return c.substring(cname.length, c.length);
            }
        }
        return "";
    }

    function deleteCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    }
});
