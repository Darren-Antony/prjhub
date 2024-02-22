function SelectGuide(guideId) {
    // Prompt the user for confirmation using SweetAlert
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to select this guide?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, select it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms, proceed with the operation
            $.ajax({
                url: '../../Backend/student/StudentDashboard/process_select_guide.php', // URL to your PHP script
                method: 'POST',
                data: { guideId: guideId }, // Pass the guide ID as data
                success: function(response) {
                    // Handle success response
                    Swal.fire(
                        'Success!',
                        'Guide selected successfully!',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    Swal.fire(
                        'Error!',
                        'Error selecting guide: ' + error,
                        'error'
                    );
                }
            });
        } else {
            // If the user cancels, do nothing or provide feedback
            Swal.fire(
                'Canceled',
                'Selection canceled.',
                'info'
            );
        }
    });
}
