<?php
// index.php
header('Content-Type: application/json');

// List of available endpoints
$endpoints = [
    'Fetch Student Grades' => [
        'method' => 'GET',
        'url' => '/routes/get_student_grades.php?student_id={id}',
        'description' => 'Fetch grades for a specific student by ID.'
    ],
    'Manage Students' => [
        'methods' => ['POST', 'DELETE'],
        'url' => '/routes/manage_students.php',
        'description' => 'Add or delete student records.'
    ],
    'Manage Courses' => [
        'methods' => ['POST', 'DELETE', 'GET'],
        'url' => '/routes/manage_courses.php',
        'description' => 'Add, delete, or fetch course details.'
    ],
    'Manage Grades' => [
        'methods' => ['POST', 'PUT', 'DELETE'],
        'url' => '/routes/manage_grades.php',
        'description' => 'Add, update, or delete grades for students.'
    ],
];

// Respond with the list of endpoints
echo json_encode([
    'message' => 'Welcome to the Student Grades API!',
    'endpoints' => $endpoints
]);
