document.querySelectorAll('.logout-link').forEach(function(el) {
    el.addEventListener('click', function(e) {
        e.preventDefault();

        document.getElementById('logout-form').submit();

        return false;
    });
});
