function submitProject() {
    var projectName = document.getElementById('prjName').value;
    var projectDesc = document.getElementById('prj-desc').value;

    // Validate project name and description
    if (projectName.trim() === '' || projectDesc.trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please enter a project name and description!'
        });
        return; // Prevent form submission if validation fails
    }

    // Proceed with form submission if validation passes
    var formData = new FormData(document.getElementById('projectForm'));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../Backend/student/StudentDashboard/handle_prj_sub.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Handle successful response here
            var response = xhr.responseText;
            if (response.startsWith('Error')) {
                // Display error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response
                });
            } else {
                // Display success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response,
                }).then(() => {
                    if (!localStorage.getItem('pageRefreshed')) {
                        // Set the flag in localStorage to indicate the page has been refreshed
                        localStorage.setItem('pageRefreshed', 'true');
                        // Refresh the page
                        location.reload();
                    } else {
                        // Clear the flag so that the page behaves normally on subsequent loads
                        localStorage.removeItem('pageRefreshed');
                    }
                });
            }
        } else {
            // Handle server errors
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Server error: ' + xhr.status
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
