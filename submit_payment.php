<?php
// Debug mode — remove in production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $type        = isset($_POST['type']) ? trim($_POST['type']) : 'one_time';
    $plan        = isset($_POST['plan']) ? trim($_POST['plan']) : 'Unknown';
    $amount      = isset($_POST['amount']) ? trim($_POST['amount']) : '0';
    $email       = isset($_POST['email']) ? trim($_POST['email']) : '';
    $wishNumber  = isset($_POST['wish_number']) ? trim($_POST['wish_number']) : '';
    $reference   = isset($_POST['reference_code']) ? trim($_POST['reference_code']) : '';
    $proof       = $_FILES['proof'] ?? null;

    // Validate required fields
    if (empty($amount) || empty($email) || empty($wishNumber) || empty($reference) || !$proof) {
        echo "error: Missing required field";
        exit;
    }

    // Decide which JSON file to save to
    $dbFile = __DIR__ . '/' . ($type === 'subscription' ? 'payments.json' : 'payment2.json');

    // Ensure uploads directory exists
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Handle file upload
    $fileName = '';
    if ($proof && $proof['error'] === UPLOAD_ERR_OK) {
        // Create a safe file name
        $ext = pathinfo($proof['name'], PATHINFO_EXTENSION);
        $safeName = preg_replace("/[^A-Za-z0-9_\-\.]/", "_", pathinfo($proof['name'], PATHINFO_FILENAME));
        $fileName = uniqid('', true) . '_' . $safeName . '.' . $ext;

        $targetPath = $uploadDir . $fileName;
        if (!move_uploaded_file($proof['tmp_name'], $targetPath)) {
            echo "error: Failed to upload proof file";
            exit;
        }
    } else {
        echo "error: No proof file uploaded";
        exit;
    }

    // Prepare the entry to save
    $entry = [
        'plan'           => $plan,
        'amount'         => $amount,
        'email'          => $email,
        'wish_number'    => $wishNumber,
        'reference_code' => $reference,
        'proof_file'     => $fileName,
        'timestamp'      => date('Y-m-d H:i:s')
    ];

    // Read existing data
    $existing = file_exists($dbFile) ? json_decode(file_get_contents($dbFile), true) : [];
    if (!is_array($existing)) {
        $existing = [];
    }

    // Append the new entry
    $existing[] = $entry;

    // Save back to the JSON file
    if (file_put_contents($dbFile, json_encode($existing, JSON_PRETTY_PRINT))) {
    header("Location: payment_success.html");
    exit;
} else {
    echo "error: Could not save payment record";
}

} else {
    echo "error: Invalid request method";
}
?>
