function goBack() {
    console.log("1");
    window.history.back();
  }


  function confirmLogout(event) {
 event.preventDefault();
 Swal.fire({
     title: 'Are you sure?',
     text: 'You will be logged out',
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes, log out'
 }).then((result) => {
     if (result.isConfirmed) {
         // If user confirms, redirect to logout page
         window.location.href = '../logout.php';
         // Destroy session
     }
 });
}
function toggleDropdown() {
    var dropdownMenu = document.getElementById("dropdownMenu");
    dropdownMenu.classList.toggle("show"); 
}

