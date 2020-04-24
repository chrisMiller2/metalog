<form method="post">
    <input class="shortInput" value='' name='ideaText'><br>
    <button type="submit" name="submitIdea">Submit Idea</button>
</form>
<?php
if(isset($_POST["submitIdea"])){
    $idea = $_POST["ideaText"];
    include "../dbInfo.php";
    mysqli_query($con, "INSERT INTO ideaBox (idea) VALUES('$idea')");
}
