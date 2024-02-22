function submitProject() {
    // Get form data
    var formData = new FormData(document.getElementById('projectForm'));

    // Make AJAX call
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Backend/student/StudentDashboard/handle_prj_sub.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Handle successful response here
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: xhr.responseText,
            }).then(() => {
                window.location.reload();
            });
        } else {
            // Handle errors here
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error: ' + xhr.status,
            });
        }
    };
    xhr.onerror = function () {
        // Handle network errors here
        Swal.fire({
            icon: 'error',
            title: 'Network Error!',
            text: 'There was a network error. Please try again later.',
        });
    };
    xhr.send(formData);
}
