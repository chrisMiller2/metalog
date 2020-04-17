<?php
session_start();

?>

<script>
    function searchFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("searchUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>

<?php
//instructions
echo '<p style="width: 1080px">To close the search panel, click the "Search" button again!</p>';

echo "<br><input id='searchInput' onkeyup='searchFunction()' 
type='search' placeholder='Search...' name='search'>";

echo "<ul id='searchUL'>";

if ($statement->num_rows > 0) {
    while ($row = $statement->fetch_assoc()) {
        echo "<li><a href='#'>" . $row["time"]. " : " . $row["service"] . " : " . $row["message"] . "</a></li>";
    }
} else {
    echo "<textarea rows='1' readonly>0 results</textarea>";
}
echo "</ul>";

$con->close();