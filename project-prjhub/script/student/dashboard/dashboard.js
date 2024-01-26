// Listen for the custom event
$(document).on('loginSuccess', function() {
    // Access the login response data from the global variable
    console.log("Login success event received:", loginResponseData); // Debug statement
    // Now you can use loginResponseData for further processing
});
