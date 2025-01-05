<?php
require_once '../config.php';
require_once '../utils/response.php';
require_once '../utils/auth.php';

// Authenticate the request
authenticate();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Add a grade
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['StudentID'], $input['CourseID'], $input['Grade'])) {
            jsonResponse(400, null, 'Missing required fields: StudentID, CourseID, Grade.');
        }

        try {
            $query = "INSERT INTO Grades (StudentID, CourseID, Grade) 
                      VALUES (:StudentID, :CourseID, :Grade)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':StudentID' => $input['StudentID'],
                ':CourseID' => $input['CourseID'],
                ':Grade' => $input['Grade']
            ]);
            jsonResponse(201, null, 'Grade added successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    case 'PUT': // Update a grade
        parse_str(file_get_contents('php://input'), $input);
        if (!isset($input['GradeID'], $input['Grade'])) {
            jsonResponse(400, null, 'Missing required fields: GradeID, Grade.');
        }

        try {
            $query = "UPDATE Grades SET Grade = :Grade WHERE GradeID = :GradeID";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':GradeID' => $input['GradeID'],
                ':Grade' => $input['Grade']
            ]);

            if ($stmt->rowCount() === 0) {
                jsonResponse(404, null, 'Grade not found.');
            }

            jsonResponse(200, null, 'Grade updated successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    case 'DELETE': // Delete a grade
        if (!isset($_GET['grade_id'])) {
            jsonResponse(400, null, 'Grade ID is required.');
        }

        $grade_id = intval($_GET['grade_id']);

        try {
            $query = "DELETE FROM Grades WHERE GradeID = :GradeID";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':GradeID', $grade_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                jsonResponse(404, null, 'Grade not found.');
            }

            jsonResponse(200, null, 'Grade deleted successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    default:
        jsonResponse(405, null, 'Method not allowed.');
}
?>