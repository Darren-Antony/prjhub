

function viewPrj(prjId) {
    console.log('Clicked on View button. Project ID:', prjId);
    window.location.href ='../student/yourPrj.php?prjId=' + prjId;
}
function timesheetPage(prjId) {
    console.log('Clicked on time button. Project ID:', prjId);
    window.location.href = '../student/stuTimesheet.php?prjId=' + prjId;
}

function Mark(prjId){
    console.log('Clicked on time button. Project ID:', prjId);
    window.location.href ='../student/yourMarks.php?prjId=' + prjId;
}
function toggleDropdown() {
    var dropdownMenu = document.getElementById("dropdownMenu");
    dropdownMenu.classList.toggle("show"); 
}


