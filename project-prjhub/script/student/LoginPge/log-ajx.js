// Define a global variable to store the response
var loginResponseData;

function LoginForm(){
    event.preventDefault();

    var logData = {
        'Email': $('#emailId').val(),
        'pwd': $('#pwd').val()
    };

    // Send the data using AJAX
    $.ajax({
        type: 'POST',
        url: 'http://localhost/prjhub/mvc/index.php?url=student/login',
        data: JSON.stringify(logData), // Convert formData to JSON string
        contentType: 'application/json', // Set content type to JSON
        success: function(response) {
            // Store the response in the global variable
            loginResponseData = response;
            // Trigger a custom event
            $(document).trigger('loginSuccess');
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
            // Optionally, display an error message to the user
        }
    });
}

// Handle the login success event
$(document).on('loginSuccess', function() {
    if (loginResponseData.success) {
        alert("Login successful");
        window.location.href = "./dashboard.html";
    } else {
        alert("Login failed");
    }
});
