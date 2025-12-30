<?php
// Debug mode (remove on production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "error: Invalid request method";
    exit;
}

// Collect data from form
$plan        = trim($_POST['plan'] ?? '');
$amount      = trim($_POST['amount'] ?? '');
$wishNumber  = trim($_POST['wish_number'] ?? '');
$reference   = trim($_POST['reference_code'] ?? '');
$proof       = $_FILES['proof'] ?? null;

// Validate fields
if (empty($plan) || empty($amount) || empty($wishNumber) || empty($reference) || !$proof) {
    echo "error: Missing required field";
    exit;
}

// Path to store subscriptions
$dbFile = __DIR__ . '/payments.json';

// Ensure uploads folder exists
$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Handle file upload
$fileName = '';
if ($proof['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($proof['name'], PATHINFO_EXTENSION);
    $safeName = preg_replace("/[^A-Za-z0-9_\-\.]/", "_", pathinfo($proof['name'], PATHINFO_FILENAME));
    $fileName = uniqid('', true) . '_' . $safeName . '.' . $ext;

    if (!move_uploaded_file($proof['tmp_name'], $uploadDir . $fileName)) {
        echo "error: Failed to upload proof file";
        exit;
    }
} else {
    echo "error: No proof file uploaded";
    exit;
}

// Prepare payment entry
$entry = [
    'plan'           => $plan,
    'amount'         => $amount,
    'wish_number'    => $wishNumber,
    'reference_code' => $reference,
    'proof_file'     => $fileName,
    'timestamp'      => date('Y-m-d H:i:s')
];

// Load existing data
$existing = file_exists($dbFile) ? json_decode(file_get_contents($dbFile), true) : [];
if (!is_array($existing)) {
    $existing = [];
}

// Add new entry
$existing[] = $entry;

// Save back to JSON
if (file_put_contents($dbFile, json_encode($existing, JSON_PRETTY_PRINT))) {
    echo "success";
} else {
    echo "error: Could not save payment record";
}
?>
