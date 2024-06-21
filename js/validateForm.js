let btnLogin = document.querySelector('#btn-login');
let btnRegister = document.querySelector('#btn-register');

btnLogin.addEventListener('click', function() {
    document.querySelector('.all-form-login').style.display = 'block';
    document.querySelector('.all-form-register').style.display = 'none';
    btnLogin.classList.add('color-in');
    btnRegister.classList.remove('color-in')
});
btnRegister.addEventListener('click', function() {
    document.querySelector('.all-form-login').style.display = 'none'
    document.querySelector('.all-form-register').style.display = 'block'
    btnLogin.classList.remove('color-in');
    btnRegister.classList.add('color-in')
});