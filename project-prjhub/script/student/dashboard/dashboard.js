

function viewPrj(prjId) {
    console.log('Clicked on View button. Project ID:', prjId);
    window.open('../student/yourPrj.php?prjId=' + prjId, '_blank');
}
function timesheetPage(prjId){
    console.log('Clicked on time button. Project ID:', prjId);
    window.open('../student/stuTimesheet.php?prjId=' + prjId, '_blank');
}