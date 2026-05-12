<?php
/**
 * Send Practical English Test Results via Email
 * This script handles sending test results to the user's registered email
 */

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate input
if (!$data || !isset($data['email']) || !isset($data['name']) || !isset($data['results'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit();
}

$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$name = htmlspecialchars($data['name']);
$results = $data['results'];

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit();
}

// Email configuration
$to = $email;
$subject = 'Your Practical English Test Results - Kampong Inggris Pare';
$from = 'noreply@kampunginggris.com'; // Change this to your actual email
$fromName = 'Kampong Inggris Pare';

// Create email body
$emailBody = createEmailBody($name, $results);

// Email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: $fromName <$from>" . "\r\n";
$headers .= "Reply-To: $from" . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
$mailSent = mail($to, $subject, $emailBody, $headers);

if ($mailSent) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Results sent successfully to ' . $email
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to send email. Please try again later.'
    ]);
}

/**
 * Create HTML email body
 */
function createEmailBody($name, $results) {
    $currentDate = date('F j, Y');
    
    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practical English Test Results</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="margin: 0; font-size: 28px;">🎉 Practical English Test Results</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px;">Kampong Inggris Pare</p>
    </div>
    
    <div style="background: #f8fafc; padding: 30px; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 10px 10px;">
        <h2 style="color: #1e40af; margin-top: 0;">Dear {$name},</h2>
        
        <p>Congratulations on completing the Practical English Test! Here are your results:</p>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6;">
            <h3 style="color: #2563eb; margin-top: 0;">Overall Score</h3>
            <p style="font-size: 24px; font-weight: bold; color: #1e40af; margin: 10px 0;">
                {$results['overall']}
            </p>
        </div>
        
        <div style="background: white; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #2563eb; margin-top: 0;">Detailed Scores</h3>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0;"><strong>📖 Reading Comprehension:</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #059669; font-weight: bold;">{$results['reading']}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0;"><strong>🎧 Listening Comprehension:</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #7c3aed; font-weight: bold;">{$results['listening']}</td>
                </tr>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 10px 0;"><strong>📝 Grammar & Structure:</strong></td>
                    <td style="padding: 10px 0; text-align: right; color: #2563eb; font-weight: bold;">{$results['grammar']}</td>
                </tr>
            </table>
        </div>
        
        <div style="background: #e0f2fe; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0284c7;">
            <p style="margin: 0; font-size: 14px;">
                <strong>📅 Test Date:</strong> {$currentDate}
            </p>
        </div>
        
        <div style="margin: 30px 0; padding: 20px; background: #fef3c7; border-radius: 8px; border-left: 4px solid #f59e0b;">
            <h4 style="color: #92400e; margin-top: 0;">Next Steps</h4>
            <ul style="margin: 10px 0; padding-left: 20px; color: #78350f;">
                <li>Review your results and identify areas for improvement</li>
                <li>Consider enrolling in our specialized courses</li>
                <li>Practice regularly to maintain and improve your skills</li>
                <li>Contact our mentors for personalized guidance</li>
            </ul>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="https://kampunginggris.com" style="display: inline-block; background: #3b82f6; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: bold;">
                Visit Our Website
            </a>
        </div>
        
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #64748b; text-align: center; margin: 0;">
            This is an automated email from Kampong Inggris Pare.<br>
            For questions or support, please contact us at support@kampunginggris.com
        </p>
        
        <p style="font-size: 12px; color: #64748b; text-align: center; margin: 10px 0 0 0;">
            © 2024 Kampong Inggris Pare. All rights reserved.
        </p>
    </div>
</body>
</html>
HTML;
    
    return $html;
}
?>
