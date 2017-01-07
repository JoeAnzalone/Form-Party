
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

document.querySelectorAll('.logout-link').forEach(function(el) {
    el.addEventListener('click', function(e) {
        e.preventDefault();

        document.getElementById('logout-form').submit();

        return false;
    });
});

document.querySelectorAll('button.delete').forEach(function(el) {
    el.addEventListener('click', function(e) {
        e.preventDefault();

        if (window.confirm('Are you sure you want to delete this message?')) {
            el.form.submit();
        }

        return false;
    });
});

if (document.body.dataset.page == 'invite') {
    document.querySelectorAll('.invite-codes .unclaimed').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            prompt('Send this special URL to a special friend! ♥️', el.href);
            return false;
        });
    });
}

if (document.body.dataset.page == 'settings') {
    document.querySelectorAll('[data-requires-password-if-changed]').forEach(function(el) {
        // If the input field requires the current password to be entered before updating,
        // add the requiresPasswordBeforeSubmit data attribute to the form so it can be checked before submitting

        el.addEventListener('keydown', function(e) {
            el.form.dataset.requiresPasswordBeforeSubmit = '';
        });
    });

    document.querySelector('.settings-form').addEventListener('submit', function(e) {
        e.preventDefault();

        var currentPass = document.querySelector('[name="current-password"]');

        if (e.target.dataset.requiresPasswordBeforeSubmit === '' && !currentPass.value) {
            document.querySelector('.profile-panel').style.display = 'none';
            document.querySelector('.account-panel').style.display = 'none';
            document.querySelector('.confirm-password-panel').style.display = 'block';
            currentPass.focus();
        } else {
            e.target.submit();
        }

        return false;
    });

    document.querySelector('[name="password"]').addEventListener('keydown', function(e) {
        document.querySelector('.password-confirm-wrapper').style.display = 'block';
    });
}
