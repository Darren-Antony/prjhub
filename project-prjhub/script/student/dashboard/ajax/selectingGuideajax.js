function SelectGuide(guideId) {
    // Prompt the user for confirmation
    var confirmation = confirm("Are you sure you want to select this guide?");
    console.log(guideId);
    // If the user confirms, proceed with the operation
    if (confirmation) {
       
        $.ajax({
            url: '../../Backend/student/StudentDashboard/process_select_guide.php', // URL to your PHP script
            method: 'POST',
            data: { guideId: guideId }, // Pass the guide ID as data
            success: function(response) {
                // Handle success response
                alert('Guide selected successfully!');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('Error selecting guide: ' + error);
            }
        });
    } else {
        // If the user cancels, do nothing or provide feedback
        alert('Selection canceled.');
    }
}