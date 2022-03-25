<?php
include("../includes/header.php");
include $_SERVER["DOCUMENT_ROOT"] . "/includes/auth.php";
include("../config/Connection.php");
global $conn;
$sqlCourses = "SELECT * FROM course";
$res = $conn->query($sqlCourses);
$courses = null;
if($res->num_rows > 0 ){
    $courses = mysqli_fetch_all($res, MYSQLI_ASSOC);
}
if(isset($_POST["course"]) && $_POST["course"] !== null){
    $courseId = $_POST["course"];
    echo $courseId;
    $studentId = $_SESSION["userId"];
    $sql = "INSERT INTO studentcourse (student_id,course_id) VALUES ('$studentId','$courseId')";
    $res = $conn->query($sql);
    if($res){
        Header("Location: dashboard.php?formSubmission=true");
    } else {
        echo "There was an error while enrolling on to a course";
        echo mysqli_error($conn);
    }
}
?>
<div class="wrapper-center">
    <form action="enrollOnCourse.php" class="flex-form" method="POST">
        <label for="course">Choose a course:</label>
        <select name="course" id="course" required>
            <option disabled selected value=""> -- select an option -- </option>
            <?php
            if($courses){
                foreach($courses as $course){
                    $courseName = $course["courseName"];
                    $courseId = $course["courseId"];
                    echo "<option value='$courseId'>$courseName</option>";
                }
            } else {
                echo "No courses available";
            }
            ?>
        </select>
        <button type="submit">Enroll</button>
    </form>
</div>


<?php include "../includes/footer.php"?>
