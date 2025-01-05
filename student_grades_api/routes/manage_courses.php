<?php
require_once '../config.php';
require_once '../utils/response.php';
require_once '../utils/auth.php';

// Authenticate the request
authenticate();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Add a new course
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['CourseName'], $input['CourseCode'])) {
            jsonResponse(400, null, 'Missing required fields: CourseName, CourseCode.');
        }

        try {
            $query = "INSERT INTO Courses (CourseName, CourseCode) VALUES (:CourseName, :CourseCode)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':CourseName' => $input['CourseName'],
                ':CourseCode' => $input['CourseCode']
            ]);
            jsonResponse(201, ['CourseID' => $conn->lastInsertId()], 'Course added successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    case 'GET': // Fetch all courses
        try {
            $query = "SELECT * FROM Courses";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            jsonResponse(200, $courses, 'Courses retrieved successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    case 'DELETE': // Delete a course
        if (!isset($_GET['course_id'])) {
            jsonResponse(400, null, 'Course ID is required.');
        }

        $course_id = intval($_GET['course_id']);

        try {
            $query = "DELETE FROM Courses WHERE CourseID = :CourseID";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':CourseID', $course_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                jsonResponse(404, null, 'Course not found.');
            }

            jsonResponse(200, null, 'Course deleted successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    default:
        jsonResponse(405, null, 'Method not allowed.');
}
?>