<?php
$pageTitle = 'Request a Diamond';
$pageDescription = 'Request a polished or rough diamond from SS Jewellery. Our diamond specialists will help you find the perfect stone.';
require_once __DIR__ . '/includes/header.php';

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_request'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        // Validate inputs
        $diamondType = $_POST['diamond_type'] ?? '';
        $shape = trim($_POST['shape'] ?? '');
        $caratMin = !empty($_POST['carat_min']) ? floatval($_POST['carat_min']) : null;
        $caratMax = !empty($_POST['carat_max']) ? floatval($_POST['carat_max']) : null;
        $colorNotes = trim($_POST['color_notes'] ?? '');
        $clarityNotes = trim($_POST['clarity_notes'] ?? '');
        $budget = !empty($_POST['budget']) ? floatval($_POST['budget']) : null;
        $customerName = trim($_POST['customer_name'] ?? '');
        $customerEmail = trim($_POST['customer_email'] ?? '');
        $customerPhone = trim($_POST['customer_phone'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        if (empty($diamondType) || !in_array($diamondType, ['polished', 'rough'])) {
            $errors[] = 'Please select a diamond type';
        }
        if (empty($customerName)) {
            $errors[] = 'Name is required';
        }
        if (empty($customerEmail) || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        if (empty($customerPhone)) {
            $errors[] = 'Phone number is required';
        }
        
        if (empty($errors)) {
            try {
                $requestNumber = generateRequestNumber();
                
                db()->query(
                    "INSERT INTO diamond_requests 
                    (request_number, diamond_type, shape, carat_min, carat_max, color_notes, clarity_notes, 
                     budget, customer_name, customer_email, customer_phone, message, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new')",
                    [
                        $requestNumber, $diamondType, $shape ?: null, $caratMin, $caratMax,
                        $colorNotes ?: null, $clarityNotes ?: null, $budget,
                        $customerName, $customerEmail, $customerPhone, $message ?: null
                    ]
                );
                
                // Send notification email to store owner (optional)
                $storeEmail = getSetting('store_email', 'info@ssjewellery.store');
                $subject = "New Diamond Request: $requestNumber";
                $emailBody = "New diamond request received:\n\n";
                $emailBody .= "Request Number: $requestNumber\n";
                $emailBody .= "Type: " . ucfirst($diamondType) . "\n";
                $emailBody .= "Shape: $shape\n";
                if ($caratMin || $caratMax) {
                    $emailBody .= "Carat Range: " . ($caratMin ?: 'Any') . " - " . ($caratMax ?: 'Any') . "\n";
                }
                if ($budget) {
                    $emailBody .= "Budget: R " . number_format($budget, 2) . "\n";
                }
                $emailBody .= "\nCustomer Details:\n";
                $emailBody .= "Name: $customerName\n";
                $emailBody .= "Email: $customerEmail\n";
                $emailBody .= "Phone: $customerPhone\n";
                if ($message) {
                    $emailBody .= "\nMessage:\n$message\n";
                }
                
                $headers = "From: $customerEmail\r\n";
                $headers .= "Reply-To: $customerEmail\r\n";
                
                @mail($storeEmail, $subject, $emailBody, $headers);
                
                $success = true;
            } catch (PDOException $e) {
                $errors[] = 'Unable to submit request. Please try again or contact us directly.';
            }
        }
    } else {
        $errors[] = 'Invalid form submission. Please try again.';
    }
}
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0;">
        <h1 style="margin-bottom: var(--spacing-md);">Request a Diamond</h1>
        <p style="color: var(--color-text-light); font-size: 1.125rem; margin-bottom: var(--spacing-lg); max-width: 700px;">
            Looking for a specific polished or rough diamond? Our diamond specialists will help you find the perfect stone. Fill out the form below with your requirements.
        </p>
        
        <?php if ($success): ?>
            <div class="alert alert-success" style="max-width: 700px; margin-bottom: var(--spacing-lg);">
                <h3 style="margin: 0 0 var(--spacing-sm);">Request Submitted Successfully!</h3>
                <p style="margin: 0;">
                    Thank you for your diamond request. Our specialists will review your requirements and contact you within 1-2 business days.
                </p>
            </div>
            
            <div style="margin-top: var(--spacing-lg);">
                <a href="<?= BASE_URL ?>/" class="btn btn-primary">Return to Home</a>
                <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">Browse Jewellery</a>
            </div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" style="max-width: 700px; margin-bottom: var(--spacing-lg);">
                    <strong>Please correct the following errors:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" style="max-width: 700px;">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                
                <div class="form-card">
                    <h3>Diamond Requirements</h3>
                    
                    <div class="form-group">
                        <label class="form-label required">Diamond Type</label>
                        <div style="display: flex; gap: var(--spacing-md); margin-top: var(--spacing-sm);">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="diamond_type" value="polished" 
                                       <?= ($_POST['diamond_type'] ?? '') === 'polished' ? 'checked' : '' ?> required>
                                <span>Polished Diamond</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="diamond_type" value="rough" 
                                       <?= ($_POST['diamond_type'] ?? '') === 'rough' ? 'checked' : '' ?> required>
                                <span>Rough Diamond</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Preferred Shape</label>
                        <input type="text" name="shape" class="form-input" 
                               value="<?= e($_POST['shape'] ?? '') ?>"
                               placeholder="e.g., Round, Princess, Emerald, Oval">
                        <small style="color: var(--color-text-light);">Optional - leave blank for any shape</small>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Min Carat Weight</label>
                            <input type="number" name="carat_min" class="form-input" 
                                   value="<?= e($_POST['carat_min'] ?? '') ?>"
                                   step="0.01" min="0" placeholder="0.50">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Max Carat Weight</label>
                            <input type="number" name="carat_max" class="form-input" 
                                   value="<?= e($_POST['carat_max'] ?? '') ?>"
                                   step="0.01" min="0" placeholder="2.00">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Color Preferences</label>
                            <input type="text" name="color_notes" class="form-input" 
                                   value="<?= e($_POST['color_notes'] ?? '') ?>"
                                   placeholder="e.g., D-F, Fancy Yellow">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Clarity Preferences</label>
                            <input type="text" name="clarity_notes" class="form-input" 
                                   value="<?= e($_POST['clarity_notes'] ?? '') ?>"
                                   placeholder="e.g., VVS1, VS1-VS2">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Budget (ZAR)</label>
                        <input type="number" name="budget" class="form-input" 
                               value="<?= e($_POST['budget'] ?? '') ?>"
                               step="0.01" min="0" placeholder="50000.00">
                        <small style="color: var(--color-text-light);">Optional - helps us recommend suitable options</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="message" class="form-textarea" rows="4" 
                                  placeholder="Any additional requirements, preferences, or questions..."><?= e($_POST['message'] ?? '') ?></textarea>
                    </div>
                </div>
                
                <div class="form-card">
                    <h3>Your Contact Information</h3>
                    
                    <div class="form-group">
                        <label class="form-label required">Full Name</label>
                        <input type="text" name="customer_name" class="form-input" 
                               value="<?= e($_POST['customer_name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">Email Address</label>
                            <input type="email" name="customer_email" class="form-input" 
                                   value="<?= e($_POST['customer_email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Phone Number</label>
                            <input type="tel" name="customer_phone" class="form-input" 
                                   value="<?= e($_POST['customer_phone'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: var(--spacing-lg);">
                    <button type="submit" name="submit_request" class="btn btn-primary">Submit Request</button>
                    <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">Browse Jewellery</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
