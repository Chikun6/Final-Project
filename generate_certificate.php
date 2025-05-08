<?php
session_start();
require_once 'db_connect.php';
require('fpdf/fpdf.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$studentId = $_SESSION['user_id'];
$courseId = $_GET['course_id'] ?? null;

if (!$courseId) {
    die("Invalid course ID.");
}

// Check if already issued
$stmt = $conn->prepare("SELECT certificate_path FROM certificates WHERE student_id = ? AND course_id = ?");
$stmt->bind_param('ii', $studentId, $courseId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Already exists
    $cert = $result->fetch_assoc();
    header('Location: ' . $cert['certificate_path']);
    exit;
}

// Check if course is completed
$progressQuery = "
    SELECT 
        ROUND(IFNULL(lp.completed_lectures / tl.total_lectures, 0) * 100, 0) AS progress_percent,
        u.name AS student_name,
        c.title AS course_title
    FROM courses c
    JOIN enrollments e ON c.id = e.course_id
    JOIN users u ON u.id = e.student_id
    LEFT JOIN (
        SELECT ch.course_id, COUNT(l.id) AS total_lectures
        FROM lectures l
        JOIN chapters ch ON l.chapter_id = ch.id
        GROUP BY ch.course_id
    ) tl ON tl.course_id = c.id
    LEFT JOIN (
        SELECT ch.course_id, lp.student_id, COUNT(lp.lecture_id) AS completed_lectures
        FROM lecture_progress lp
        JOIN lectures l ON lp.lecture_id = l.id
        JOIN chapters ch ON l.chapter_id = ch.id
        WHERE lp.progress_percent = 100
        GROUP BY ch.course_id, lp.student_id
    ) lp ON lp.course_id = c.id AND lp.student_id = e.student_id
    WHERE e.student_id = ? AND c.id = ?
";

$stmt = $conn->prepare($progressQuery);
$stmt->bind_param('ii', $studentId, $courseId);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Course not found.");
}

$data = $res->fetch_assoc();
if ((int)$data['progress_percent'] < 100) {
    die("Course not completed yet.");
}

$studentName = $data['student_name'];
$courseTitle = $data['course_title'];

// Generate PDF certificate
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 30, 'Certificate of Completion', 0, 1, 'C');
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 15, "This is to certify that", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 15, $studentName, 0, 1, 'C');
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 15, "has successfully completed the course", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 15, $courseTitle, 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 20, "Date: " . date('d M Y'), 0, 1, 'C');

$path = "certificates/";
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}
$filename = $path . "certificate_{$studentId}_{$courseId}.pdf";
$pdf->Output('F', $filename);

// Save to DB
$insert = $conn->prepare("INSERT INTO certificates (student_id, course_id, certificate_path) VALUES (?, ?, ?)");
$insert->bind_param('iis', $studentId, $courseId, $filename);
$insert->execute();

header('Location: ' . $filename);
exit;
?>
