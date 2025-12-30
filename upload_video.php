<?php
// upload_video.php
$courseId = $_POST['courseId'] ?? '';
$title = $_POST['title'] ?? '';
if (!$courseId || !isset($_FILES['video'])) { http_response_code(400); echo "Missing data."; exit; }

$targetDir = __DIR__ . "/uploads/" . basename($courseId);
if (!is_dir($targetDir)) { mkdir($targetDir, 0775, true); }

$tmp = $_FILES['video']['tmp_name'];
$base = preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['video']['name']);
$dest = $targetDir . "/" . $base;

if (move_uploaded_file($tmp, $dest)) {
  // You can optionally auto-append to courses.json here.
  echo "Uploaded. File path: uploads/$courseId/$base\n";
  echo "Now add this to courses.json lectures list (src: \"uploads/$courseId/$base\", title: \"$title\").";
} else {
  http_response_code(500);
  echo "Upload failed.";
}
