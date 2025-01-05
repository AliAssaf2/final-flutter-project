<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');
include_once '../utils/auth.php';
include_once '../utils/response.php';
include_once '../config.php';
// Authenticate the request
//authenticate();

if (!isset($_GET['student_id'])) {
    jsonResponse(400, null, 'Student ID is required.');
}

$student_id = intval($_GET['student_id']);

try {
    $query = "SELECT Students.FirstName, Students.LastName, Courses.CourseName, Grades.Grade 
              FROM Grades
              INNER JOIN Students ON Grades.StudentID = Students.StudentID
              INNER JOIN Courses ON Grades.CourseID = Courses.CourseID
              WHERE Students.StudentID = :student_id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();

    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($grades)) {
        jsonResponse(404, null, 'No grades found for the specified student ID.');
    }

    jsonResponse(200, $grades, 'Grades retrieved successfully.');
} catch (Exception $e) {
    jsonResponse(500, null, 'Server error: ' . $e->getMessage());
}
?>