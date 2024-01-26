function submitForm() {
    // Prevent the default form submission
    event.preventDefault();

    // Get the form data
    var formData = {
        
        'Email': $('#emailId').val(),
        'Fname': $('#FlName').val(),
        'deptno': $('#deptNo').val(),
        'deptName':$('#deptName').val(),
        'curYear': $('#curYear').val(),
        'degree': $('#degree').val(),
        'Section': $('#section').val(),
        'pwd': $('#pwd').val(),
        'cpwd': $('#cpwd').val()
    };

    // Print form data in the console for debugging
    console.log('Form Data:', formData);

    // Send the data using AJAX
    $.ajax({
        type: 'POST',
        url: 'http://localhost/prjhub/mvc/index.php?url=student/register',
        data: JSON.stringify(formData), // Convert formData to JSON string
        contentType: 'application/json', // Set content type to JSON
        success: function(response) {
            // Handle success response
            if (response.success) {
    // Registration was successful
    alert("Registration successful");
    // Optionally, redirect the user or show a success message
} else {
    // Registration failed
    alert("Registration failed");
    // Optionally, display a failure message to the user
}
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
            // Optionally, display an error message to the user
        }
    });
}