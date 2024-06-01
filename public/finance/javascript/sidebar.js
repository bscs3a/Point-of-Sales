document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('hidden', !sidebar.classList.contains('hidden'));
    });
});
