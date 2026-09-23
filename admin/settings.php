<?php
$pageTitle = 'Site Settings';
require_once __DIR__ . '/header.php';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors = [];
        
        // Handle hero background image upload
        $currentHeroImage = getSetting('hero_background_image');
        if (isset($_FILES['hero_background_image']) && $_FILES['hero_background_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadProductImage($_FILES['hero_background_image']);
            if ($uploadResult['success']) {
                // Delete old hero image if exists
                if ($currentHeroImage) {
                    deleteProductImage($currentHeroImage);
                }
                updateSetting('hero_background_image', $uploadResult['filename']);
            } else {
                $errors[] = 'Hero image upload failed: ' . $uploadResult['error'];
            }
        }
        
        // Store settings
        $settings = [
            'store_name', 'store_email', 'store_phone',
            'bank_name', 'bank_account_holder', 'bank_account_number',
            'bank_branch_code', 'bank_account_type',
            'payfast_merchant_id', 'payfast_merchant_key',
            'payfast_passphrase', 'payfast_sandbox'
        ];
        
        foreach ($settings as $key) {
            $value = $_POST[$key] ?? '';
            updateSetting($key, $value);
        }
        
        if (empty($errors)) {
            setFlashMessage('success', 'Settings updated successfully');
        } else {
            setFlashMessage('error', implode('<br>', $errors));
        }
        redirect(BASE_URL . '/admin/settings.php');
    }
}

// Get current settings
$storeName = getSetting('store_name');
$storeEmail = getSetting('store_email');
$storePhone = getSetting('store_phone');
$heroBackgroundImage = getSetting('hero_background_image');
$bankName = getSetting('bank_name');
$accountHolder = getSetting('bank_account_holder');
$accountNumber = getSetting('bank_account_number');
$branchCode = getSetting('bank_branch_code');
$accountType = getSetting('bank_account_type');
$payfastMerchantId = getSetting('payfast_merchant_id');
$payfastMerchantKey = getSetting('payfast_merchant_key');
$payfastPassphrase = getSetting('payfast_passphrase');
$payfastSandbox = getSetting('payfast_sandbox');
?>

<h1>Site Settings</h1>

<?php if ($message = getFlashMessage('success')): ?>
    <div class="alert alert-success"><?= e($message) ?></div>
<?php endif; ?>

<?php if ($message = getFlashMessage('error')): ?>
    <div class="alert alert-error"><?= $message ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
    
    <div class="admin-card" style="max-width: 800px;">
        <h3>Store Information</h3>
        
        <div class="form-group">
            <label class="form-label">Store Name</label>
            <input type="text" name="store_name" class="form-input" value="<?= e($storeName) ?>">
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Store Email</label>
                <input type="email" name="store_email" class="form-input" value="<?= e($storeEmail) ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Store Phone</label>
                <input type="text" name="store_phone" class="form-input" value="<?= e($storePhone) ?>">
            </div>
        </div>
    </div>
    
    <div class="admin-card" style="max-width: 800px;">
        <h3>Homepage Hero Section</h3>
        <p style="color: var(--color-text-light); margin-bottom: var(--spacing-md);">
            Upload a background image for the homepage hero section. Recommended: 1920x1080px or larger, JPEG/PNG.
            <br>The image will have a dark overlay to ensure text remains readable.
        </p>
        
        <div class="form-group">
            <label class="form-label">Hero Background Image</label>
            <?php if ($heroBackgroundImage): ?>
                <div style="margin-bottom: var(--spacing-sm);">
                    <img src="<?= UPLOAD_URL . e($heroBackgroundImage) ?>" 
                         alt="Current hero background" 
                         style="max-width: 100%; height: auto; max-height: 200px; object-fit: cover; border-radius: var(--border-radius);">
                    <p style="color: var(--color-text-light); font-size: 0.875rem; margin-top: 0.5rem;">
                        Current image. Upload a new one to replace it.
                    </p>
                </div>
            <?php else: ?>
                <p style="color: var(--color-text-light); font-size: 0.875rem; margin-bottom: 0.5rem;">
                    No hero background image set. The default gradient will be used.
                </p>
            <?php endif; ?>
            <input type="file" name="hero_background_image" class="form-input" accept="image/jpeg,image/png,image/webp">
        </div>
    </div>
    
    <div class="admin-card" style="max-width: 800px;">
        <h3>Bank Details for EFT Payments</h3>
        <p style="color: var(--color-text-light); margin-bottom: var(--spacing-md);">
            These details will be displayed to customers after placing an order with EFT payment method.
        </p>
        
        <div class="form-group">
            <label class="form-label">Bank Name</label>
            <input type="text" name="bank_name" class="form-input" value="<?= e($bankName) ?>">
        </div>
        
        <div class="form-group">
            <label class="form-label">Account Holder</label>
            <input type="text" name="bank_account_holder" class="form-input" value="<?= e($accountHolder) ?>">
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Account Number</label>
                <input type="text" name="bank_account_number" class="form-input" value="<?= e($accountNumber) ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Branch Code</label>
                <input type="text" name="bank_branch_code" class="form-input" value="<?= e($branchCode) ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Account Type</label>
            <input type="text" name="bank_account_type" class="form-input" 
                   value="<?= e($accountType) ?>" placeholder="e.g., Business Cheque Account">
        </div>
    </div>
    
    <div class="admin-card" style="max-width: 800px;">
        <h3>PayFast Integration (Optional)</h3>
        <p style="color: var(--color-text-light); margin-bottom: var(--spacing-md);">
            Configure PayFast for online payment processing. Leave empty to use EFT only.<br>
            Get your credentials from <a href="https://www.payfast.co.za" target="_blank" style="color: var(--color-accent);">PayFast Dashboard</a>
        </p>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Merchant ID</label>
                <input type="text" name="payfast_merchant_id" class="form-input" value="<?= e($payfastMerchantId) ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Merchant Key</label>
                <input type="text" name="payfast_merchant_key" class="form-input" value="<?= e($payfastMerchantKey) ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Passphrase</label>
            <input type="text" name="payfast_passphrase" class="form-input" value="<?= e($payfastPassphrase) ?>">
            <small style="color: var(--color-text-light);">Optional but recommended for security</small>
        </div>
        
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="payfast_sandbox" value="1" <?= $payfastSandbox ? 'checked' : '' ?>>
                <span>Sandbox Mode (Testing)</span>
            </label>
            <small style="color: var(--color-text-light); display: block; margin-top: 0.5rem;">
                Enable this for testing. Disable for live payments.
            </small>
        </div>
    </div>
    
    <div style="max-width: 800px;">
        <button type="submit" name="save_settings" class="btn btn-primary">Save Settings</button>
    </div>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>
