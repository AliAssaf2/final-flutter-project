<?php
require_once '../config.php';
require_once '../utils/response.php';
require_once '../utils/auth.php';

// Authenticate the request
authenticate();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Add a new student
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['FirstName'], $input['LastName'], $input['Email'])) {
            jsonResponse(400, null, 'Missing required fields: FirstName, LastName, Email.');
        }

        try {
            $query = "INSERT INTO Students (FirstName, LastName, DateOfBirth, Email)
                      VALUES (:FirstName, :LastName, :DateOfBirth, :Email)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':FirstName' => $input['FirstName'],
                ':LastName' => $input['LastName'],
                ':DateOfBirth' => $input['DateOfBirth'] ?? null,
                ':Email' => $input['Email']
            ]);
            jsonResponse(201, ['StudentID' => $conn->lastInsertId()], 'Student added successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    case 'DELETE': // Delete a student
        if (!isset($_GET['student_id'])) {
            jsonResponse(400, null, 'Student ID is required.');
        }

        $student_id = intval($_GET['student_id']);

        try {
            $query = "DELETE FROM Students WHERE StudentID = :StudentID";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':StudentID', $student_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                jsonResponse(404, null, 'Student not found.');
            }

            jsonResponse(200, null, 'Student deleted successfully.');
        } catch (Exception $e) {
            jsonResponse(500, null, 'Server error: ' . $e->getMessage());
        }
        break;

    default:
        jsonResponse(405, null, 'Method not allowed.');
}
?>