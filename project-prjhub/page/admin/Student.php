<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/admindb.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>

    <title>Student details</title>
</head>
<body>
   <div class="logo-cont">
   <div class="logo">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    </div>
    <div class="searchBar-cont">
        <div class="search-top">
        <input type="text" id="searchInput" placeholder="Search...">
    <button id="searchButton">Search</button>
        </div>

    <div id="searchResults"></div>

    </div>
    
</body>
<script>
  $(document).ready(function(){
    $('#searchButton').click(function(){
        var searchTerm = $('#searchInput').val();
        searchDatabase(searchTerm);
    });
});

function searchDatabase(searchTerm){
    $.ajax({
        url: '../../Backend/admin/getStudent.php', // Update the path to your PHP file
        type: 'GET',
        data: { term: searchTerm },
        success: function(data){
            displayResults(data);
        },
        error: function(err){
            console.error('Error searching database:', err);
        }
    });
}

function displayResults(results){
    var $resultsContainer = $('#searchResults');
    $resultsContainer.empty(); // Clear previous results
    if(results.trim() === "<p>No results found.</p>"){
        $resultsContainer.append(results);
    } else {
        $resultsContainer.append(results);
    }
}


</script>
</html>