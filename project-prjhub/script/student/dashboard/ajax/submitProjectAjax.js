function submitProject() {
    // Get form data
    var formData = new FormData(document.getElementById('projectForm'));

    // Make AJAX call
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Backend/student/StudentDashboard/handle_prj_sub.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Handle successful response here
            alert(xhr.responseText);
            window.location.reload();
        } else {
            // Handle errors here
            alert('Error: ' + xhr.status);
        }
    };
    xhr.onerror = function () {
        // Handle network errors here
        alert('Network Error');
    };
    xhr.send(formData);
}