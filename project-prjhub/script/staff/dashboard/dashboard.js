function StudentPage(){
    window.location.href='../../../../../prjhub/project-prjhub/page/staff/student.php';
}
function viewtmsht(prjId){
    console.log('Clicked on time button. Project ID:', prjId);
    window.open('viewPrjTmsht.php?prjId=' + prjId, '_blank');
}