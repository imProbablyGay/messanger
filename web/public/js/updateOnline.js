document.querySelector('.logout-btn').addEventListener('click', updateOnline);
window.onbeforeunload = updateOnline;
window.onblur = updateOnline;

function updateOnline () {
    fetch('./template/update_online_data.php');
}