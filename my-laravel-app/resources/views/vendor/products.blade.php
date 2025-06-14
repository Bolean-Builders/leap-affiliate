<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Products - Vendor Dashboard</title>
    <style>
        :root {
            /* Gradient Colors - Matching Welcome Page */
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --indigo-gradient: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --purple-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            --teal-gradient: linear-gradient(135deg, #0d9488 0%, #14b8a6 50%, #2dd4bf 100%);
            --rose-gradient: linear-gradient(135deg, #e11d48 0%, #f43f5e 50%, #fb7185 100%);
            --orange-gradient: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #dc2626 100%);
            
            /* Glassmorphism Effects */
            --glass-bg: rgba(0, 0, 0, 0.4);
            --glass-bg-hover: rgba(0, 0, 0, 0.5);
            --glass-border: rgba(255, 255, 255, 0.15);
            --glass-blur: blur(20px);
            
            /* Card Backgrounds */
            --card-bg-primary: rgba(99, 102, 241, 0.1);
            --card-bg-success: rgba(16, 185, 129, 0.1);
            --card-bg-warning: rgba(245, 158, 11, 0.1);
            --card-bg-danger: rgba(239, 68, 68, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideDown 0.8s ease-out;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--indigo-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .add-product-btn {
            background: var(--success-gradient);
            border: none;
            padding: 1rem 2rem;
            border-radius: 15px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
        }

        .add-product-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 48px rgba(16, 185, 129, 0.4);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: var(--glass-bg-hover);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.8;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .product-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--indigo-gradient);
            border-radius: 20px 20px 0 0;
        }

        .product-card:hover {
            transform: translateY(-8px);
            background: var(--glass-bg-hover);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: var(--card-bg-primary);
            border-radius: 15px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            opacity: 0.6;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .product-image.no-image {
            background: var(--card-bg-primary);
        }

        .product-type-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-digital {
            background: var(--purple-gradient);
            color: white;
        }

        .type-physical {
            background: var(--orange-gradient);
            color: white;
        }

        .type-service {
            background: var(--teal-gradient);
            color: white;
        }

        .product-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .product-category {
            font-size: 0.9rem;
            opacity: 0.7;
            margin-bottom: 0.5rem;
            color: #8b5cf6;
        }

        .product-description {
            opacity: 0.8;
            margin-bottom: 1rem;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--success-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-status {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: var(--card-bg-success);
            color: #10b981;
        }

        .status-pending {
            background: var(--card-bg-warning);
            color: #facc15;
        }

        .status-inactive {
            background: var(--card-bg-danger);
            color: #ef4444;
        }

        .product-actions {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .view-btn {
            background: var(--teal-gradient);
            color: white;
        }

        .edit-btn {
            background: var(--indigo-gradient);
            color: white;
        }

        .delete-btn {
            background: var(--danger-gradient);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            z-index: 1000;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease-out;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .modal-title {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }

        .close-btn:hover {
            opacity: 1;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-textarea {
            height: 120px;
            resize: vertical;
        }

        .image-upload {
            position: relative;
            width: 100%;
            height: 200px;
            border: 2px dashed var(--glass-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
        }

        .image-upload:hover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
        }

        .image-upload input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .upload-text {
            text-align: center;
            opacity: 0.7;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--indigo-gradient);
            color: white;
        }

        .btn-secondary {
            background: var(--glass-bg);
            color: white;
            border: 1px solid var(--glass-border);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            margin-top: 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.6;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            opacity: 0.8;
            margin-bottom: 2rem;
        }

        /* Product Info Modal Styles */
        .product-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--glass-border);
        }

        .info-section h3 {
            margin-bottom: 1rem;
            color: #8b5cf6;
            font-size: 1.2rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-label {
            opacity: 0.8;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
        }

        /* Statistics Styles */
        .stats-section {
            margin-top: 2rem;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card-small {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            border: 1px solid var(--glass-border);
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-title {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translate(-50%, -40%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, -50%);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .header h1 {
                font-size: 2rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .product-actions {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .product-info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
@include('partials.vendor.navbar')
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>My Products</h1>
            <button class="add-product-btn" onclick="openAddProductModal()">
                ➕ Add New Product
            </button>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number" style="background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;" id="totalProducts">0</div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: var(--warning-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;" id="activeProducts">0</div>
                <div class="stat-label">Active Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: var(--rose-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;" id="pendingProducts">0</div>
                <div class="stat-label">Pending Approval</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: var(--teal-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;" id="totalRevenue">$0</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="products-grid" id="productsGrid">
            <!-- Products will be loaded here -->
        </div>

        <!-- Empty State -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-icon">📦</div>
            <div class="empty-title">No Products Yet</div>
            <div class="empty-description">Start building your product catalog by adding your first product.</div>
            <button class="btn btn-primary" onclick="openAddProductModal()">Add Your First Product</button>
        </div>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add New Product</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form id="productForm">
                <div class="form-group">
                    <label class="form-label">Featured Image</label>
                    <div class="image-upload" onclick="document.getElementById('imageInput').click()">
                        <input type="file" id="imageInput" accept="image/*" onchange="previewImage(this)">
                        <div id="imagePreview" class="upload-text">
                            📷 Click to upload featured image<br>
                            <small>JPG, PNG, GIF up to 5MB</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" class="form-input" id="productName" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select class="form-select" id="productCategory" required>
                            <option value="">Select Category</option>
                            <option value="education">Education & Training</option>
                            <option value="technology">Technology & Software</option>
                            <option value="business">Business & Finance</option>
                            <option value="health">Health & Wellness</option>
                            <option value="marketing">Marketing & Sales</option>
                            <option value="design">Design & Creative</option>
                            <option value="lifestyle">Lifestyle & Personal</option>
                            <option value="entertainment">Entertainment & Media</option>
                            <option value="food">Food & Beverage</option>
                            <option value="fashion">Fashion & Beauty</option>
                            <option value="sports">Sports & Fitness</option>
                            <option value="travel">Travel & Tourism</option>
                            <option value="automotive">Automotive</option>
                            <option value="home">Home & Garden</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Product Type *</label>
                        <select class="form-select" id="productType" required>
                            <option value="">Select Type</option>
                            <option value="digital">Digital Product</option>
                            <option value="physical">Physical Product</option>
                            <option value="service">Service</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Currency *</label>
                        <select class="form-select" id="productCurrency" required>
                            <option value="USD">USD ($)</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="GBP">GBP (£)</option>
                            <option value="CAD">CAD (C$)</option>
                            <option value="AUD">AUD (A$)</option>
                            <option value="JPY">JPY (¥)</option>
                            <option value="GHS">GHS (₵)</option>
                            <option value="NGN">NGN (₦)</option>
                            <option value="ZAR">ZAR (R)</option>
                            <option value="KES">KES (KSh)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea class="form-textarea" id="productDescription" placeholder="Describe your product..." required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Price *</label>
                        <input type="number" class="form-input" id="productPrice" placeholder="0.00" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Commission (%)</label>
                        <input type="number" class="form-input" id="productCommission" placeholder="0.00" step="0.01" min="0" max="100">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Sales Page URL</label>
                        <input type="url" class="form-input" id="salesPageUrl" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Resources Page URL</label>
                        <input type="url" class="form-input" id="resourcesPageUrl" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Thank you page</label>
                        <input type="url" class="form-input" id="thankyouPageUrl" placeholder="https://...">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-input" id="metaTitle" placeholder="SEO title for your product">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="productStatus">
                            <option value="pending">Pending</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Tags (comma-separated)</label>
                    <input type="text" class="form-input" id="productTags" placeholder="tag1, tag2, tag3">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Info Modal -->
    <div class="modal" id="productInfoModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="infoModalTitle">Product Information</h2>
                <button class="close-btn" onclick="closeInfoModal()">&times;</button>
            </div>
            <div id="productInfoContent">
                <!-- Product info will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Sample products data with enhanced features
      // Laravel Controller Integration - Replace the existing JavaScript code

// Global variables
let products = [];
let editingProductId = null;
const currencySymbols = {
    USD: '$', EUR: '€', GBP: '£', CAD: 'C$', AUD: 'A$', 
    JPY: '¥', GHS: '₵', NGN: '₦', ZAR: 'R', KES: 'KSh'
};

// CSRF Token setup for Laravel
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// API Configuration
const API_BASE = '/vendor/products';
const API_ENDPOINTS = {
    index: `${API_BASE}`,
    store: `${API_BASE}`,
    show: (id) => `${API_BASE}/${id}`,
    update: (id) => `${API_BASE}/${id}`,
    destroy: (id) => `${API_BASE}/${id}`,
    getProducts: `${API_BASE}/get-products`,
    bulkUpdate: `${API_BASE}/bulk-update-status`,
    analytics: (id) => `${API_BASE}/${id}/analytics`
};

// HTTP Request Helper
async function makeRequest(url, options = {}) {
    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    };

    // Merge options
    const config = {
        ...defaultOptions,
        ...options,
        headers: {
            ...defaultOptions.headers,
            ...options.headers
        }
    };

    try {
        const response = await fetch(url, config);
        
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || `HTTP ${response.status}: ${response.statusText}`);
        }

        return await response.json();
    } catch (error) {
        console.error('API Request failed:', error);
        showNotification('Error: ' + error.message, 'error');
        throw error;
    }
}

// Notification System
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()">&times;</button>
        </div>
    `;

    // Add to page
    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Utility Functions
function getCurrencySymbol(currency) {
    return currencySymbols[currency] || '';
}

function formatPrice(price, currency) {
    const symbol = getCurrencySymbol(currency);
    return `${symbol}${parseFloat(price).toFixed(2)}`;
}

function getTypeIcon(type) {
    switch(type) {
        case 'digital': return '💻';
        case 'physical': return '📦';
        case 'service': return '🛠️';
        default: return '📄';
    }
}

function getCategoryDisplayName(category) {
    const categories = {
        'education': 'Education & Training',
        'technology': 'Technology & Software',
        'business': 'Business & Finance',
        'health': 'Health & Wellness',
        'marketing': 'Marketing & Sales',
        'design': 'Design & Creative',
        'lifestyle': 'Lifestyle & Personal',
        'entertainment': 'Entertainment & Media',
        'food': 'Food & Beverage',
        'fashion': 'Fashion & Beauty',
        'sports': 'Sports & Fitness',
        'travel': 'Travel & Tourism',
        'automotive': 'Automotive',
        'home': 'Home & Garden',
        'other': 'Other'
    };
    return categories[category] || category;
}

// Data Loading Functions
async function loadProducts() {
    try {
        showLoading(true);
        const response = await makeRequest(API_ENDPOINTS.getProducts);
        
        if (response.success) {
            products = response.products;
            renderProducts();
            updateStats(response.stats);
        }
    } catch (error) {
        console.error('Failed to load products:', error);
        products = [];
        renderProducts();
    } finally {
        showLoading(false);
    }
}

// Loading State Management
function showLoading(show) {
    const grid = document.getElementById('productsGrid');
    const emptyState = document.getElementById('emptyState');
    
    if (show) {
        grid.innerHTML = '<div class="loading-spinner">Loading products...</div>';
        emptyState.style.display = 'none';
    }
}

// Render Functions
function renderProducts() {
    const grid = document.getElementById('productsGrid');
    const emptyState = document.getElementById('emptyState');
    
    if (products.length === 0) {
        grid.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }
    
    grid.style.display = 'grid';
    emptyState.style.display = 'none';
    
    grid.innerHTML = products.map(product => `
        <div class="product-card">
            <div class="product-image ${!product.featured_image ? 'no-image' : ''}">
                ${product.featured_image ? 
                    `<img src="${product.featured_image}" alt="${product.name}" onerror="this.style.display='none'; this.parentElement.classList.add('no-image'); this.parentElement.innerHTML='${getTypeIcon(product.product_type)}';">` : 
                    getTypeIcon(product.product_type)
                }
                <div class="product-type-badge type-${product.product_type}">
                    ${product.product_type}
                </div>
            </div>
            <div class="product-title">${product.name}</div>
            <div class="product-category">${getCategoryDisplayName(product.category)}</div>
            <div class="product-description">${product.description}</div>
            <div class="product-meta">
                <div class="product-price">${formatPrice(product.price, product.currency)}</div>
                <div class="product-status status-${product.status}">${product.status}</div>
            </div>
            <div class="product-actions">
                <button class="action-btn view-btn" onclick="viewProduct(${product.id})">
                    👁️ View
                </button>
                <button class="action-btn edit-btn" onclick="editProduct(${product.id})">
                    ✏️ Edit
                </button>
                <button class="action-btn delete-btn" onclick="deleteProduct(${product.id})">
                    🗑️ Delete
                </button>
            </div>
        </div>
    `).join('');
}

function updateStats(stats) {
    document.getElementById('totalProducts').textContent = stats.total || 0;
    document.getElementById('activeProducts').textContent = stats.active || 0;
    document.getElementById('pendingProducts').textContent = stats.pending || 0;
    document.getElementById('totalRevenue').textContent = `$${(stats.total_revenue || 0).toFixed(2)}`;
}

// Product Actions
async function viewProduct(id) {
    try {
        const response = await makeRequest(API_ENDPOINTS.show(id));
        
        if (response.success) {
            const product = response.product;
            showProductInfo(product);
        }
    } catch (error) {
        console.error('Failed to view product:', error);
    }
}

function showProductInfo(product) {
    document.getElementById('infoModalTitle').textContent = product.name;
    
    const infoContent = document.getElementById('productInfoContent');
    infoContent.innerHTML = `
        <div class="product-info-grid">
            <div class="info-section">
                <h3>📋 Product Details</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span class="info-value">${product.name}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Category:</span>
                    <span class="info-value">${getCategoryDisplayName(product.category)}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Type:</span>
                    <span class="info-value">${getTypeIcon(product.product_type)} ${product.product_type}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Price:</span>
                    <span class="info-value">${formatPrice(product.price, product.currency)}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Commission:</span>
                    <span class="info-value">${product.commission}%</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value status-${product.status}">${product.status}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Created:</span>
                    <span class="info-value">${new Date(product.created_at).toLocaleDateString()}</span>
                </div>
            </div>
            
            <div class="info-section">
                <h3>🔗 Links & Resources</h3>
                <div class="info-item">
                    <span class="info-label">Sales Page:</span>
                    <span class="info-value">
                        ${product.sales_page_url ? `<a href="${product.sales_page_url}" target="_blank" style="color: #8b5cf6;">View Page</a>` : 'Not set'}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Resources:</span>
                    <span class="info-value">
                        ${product.resources_page_url ? `<a href="${product.resources_page_url}" target="_blank" style="color: #8b5cf6;">View Resources</a>` : 'Not set'}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Thank You Page:</span>
                    <span class="info-value">
                        ${product.thankyou_page_url ? `<a href="${product.thankyou_page_url}" target="_blank" style="color: #8b5cf6;">View Page</a>` : 'Not set'}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Meta Title:</span>
                    <span class="info-value">${product.meta_title || 'Not set'}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tags:</span>
                    <span class="info-value">${product.tags && product.tags.length ? product.tags.join(', ') : 'None'}</span>
                </div>
            </div>
        </div>
        
        <div class="info-section">
            <h3>📝 Description</h3>
            <p style="line-height: 1.6; opacity: 0.9;">${product.description}</p>
        </div>
        
        ${product.stats ? `
        <div class="stats-section">
            <h3 style="margin-bottom: 1rem; color: #8b5cf6;">📊 Product Statistics</h3>
            <div class="stats-cards">
                <div class="stat-card-small">
                    <div class="stat-value" style="color: #10b981;">${product.stats.views.toLocaleString()}</div>
                    <div class="stat-title">Total Views</div>
                </div>
                <div class="stat-card-small">
                    <div class="stat-value" style="color: #6366f1;">${product.stats.sales}</div>
                    <div class="stat-title">Total Sales</div>
                </div>
                <div class="stat-card-small">
                    <div class="stat-value" style="color: #f59e0b;">${formatPrice(product.stats.revenue, product.currency)}</div>
                    <div class="stat-title">Revenue</div>
                </div>
                <div class="stat-card-small">
                    <div class="stat-value" style="color: #8b5cf6;">${product.stats.conversion_rate}%</div>
                    <div class="stat-title">Conversion Rate</div>
                </div>
                <div class="stat-card-small">
                    <div class="stat-value" style="color: #ef4444;">⭐ ${product.stats.avg_rating}</div>
                    <div class="stat-title">Avg Rating</div>
                </div>
                <div class="stat-card-small">
                    <div class="stat-value" style="color: #14b8a6;">${product.stats.total_reviews}</div>
                    <div class="stat-title">Reviews</div>
                </div>
            </div>
        </div>
        ` : ''}
    `;
    
    document.getElementById('productInfoModal').style.display = 'block';
}

function editProduct(id) {
    const product = products.find(p => p.id === id);
    if (!product) return;
    
    editingProductId = id;
    document.getElementById('modalTitle').textContent = 'Edit Product';
    document.getElementById('submitBtn').textContent = 'Update Product';
    
    // Populate form
    document.getElementById('productName').value = product.name;
    document.getElementById('productCategory').value = product.category;
    document.getElementById('productType').value = product.product_type;
    document.getElementById('productCurrency').value = product.currency;
    document.getElementById('productDescription').value = product.description;
    document.getElementById('productPrice').value = product.price;
    document.getElementById('productCommission').value = product.commission;
    document.getElementById('salesPageUrl').value = product.sales_page_url || '';
    document.getElementById('resourcesPageUrl').value = product.resources_page_url || '';
    document.getElementById('thankyouPageUrl').value = product.thankyou_page_url || '';
    document.getElementById('metaTitle').value = product.meta_title || '';
    document.getElementById('productTags').value = product.tags ? product.tags.join(', ') : '';
    document.getElementById('productStatus').value = product.status;
    
    // Show existing image
    if (product.featured_image) {
        document.getElementById('imagePreview').innerHTML = `<img src="${product.featured_image}" class="image-preview" alt="Current image">`;
    }
    
    document.getElementById('productModal').style.display = 'block';
}

async function deleteProduct(id) {
    if (!confirm('Are you sure you want to delete this product?')) {
        return;
    }

    try {
        const response = await makeRequest(API_ENDPOINTS.destroy(id), {
            method: 'DELETE'
        });

        if (response.success) {
            showNotification('Product deleted successfully!', 'success');
            loadProducts(); // Reload the products list
        }
    } catch (error) {
        console.error('Failed to delete product:', error);
    }
}

// Modal Functions
function openAddProductModal() {
    editingProductId = null;
    document.getElementById('modalTitle').textContent = 'Add New Product';
    document.getElementById('submitBtn').textContent = 'Add Product';
    document.getElementById('productForm').reset();
    document.getElementById('imagePreview').innerHTML = '📷 Click to upload featured image<br><small>JPG, PNG, GIF up to 5MB</small>';
    document.getElementById('productModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
}

function closeInfoModal() {
    document.getElementById('productInfoModal').style.display = 'none';
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="image-preview" alt="Preview">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Form Submission
document.getElementById('productForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    const imageInput = document.getElementById('imageInput');
    
    // Collect form data
    formData.append('name', document.getElementById('productName').value);
    formData.append('category', document.getElementById('productCategory').value);
    formData.append('product_type', document.getElementById('productType').value);
    formData.append('currency', document.getElementById('productCurrency').value);
    formData.append('description', document.getElementById('productDescription').value);
    formData.append('price', document.getElementById('productPrice').value);
    formData.append('commission', document.getElementById('productCommission').value || 0);
    formData.append('sales_page_url', document.getElementById('salesPageUrl').value);
    formData.append('resources_page_url', document.getElementById('resourcesPageUrl').value);
    formData.append('thankyou_page_url', document.getElementById('thankyouPageUrl').value || '');
    formData.append('meta_title', document.getElementById('metaTitle').value);
    formData.append('tags', document.getElementById('productTags').value);
    formData.append('status', document.getElementById('productStatus').value);
    
    // Add image if selected
    if (imageInput.files && imageInput.files[0]) {
        formData.append('featured_image', imageInput.files[0]);
    }

    try {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = editingProductId ? 'Updating...' : 'Adding...';

        let response;
        if (editingProductId) {
            // Add method spoofing for Laravel
            formData.append('_method', 'PUT');
            response = await fetch(API_ENDPOINTS.update(editingProductId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            });
        } else {
            response = await fetch(API_ENDPOINTS.store, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData
            });
        }

        const result = await response.json();

        if (result.success) {
            showNotification(result.message, 'success');
            closeModal();
            loadProducts(); // Reload the products list
        } else {
            throw new Error(result.message || 'Failed to save product');
        }
    } catch (error) {
        console.error('Failed to save product:', error);
        showNotification('Error: ' + error.message, 'error');
    } finally {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = false;
        submitBtn.textContent = editingProductId ? 'Update Product' : 'Add Product';
    }
});

// Event Listeners
document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.getElementById('productInfoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInfoModal();
    }
});

// Bulk Actions (Optional Enhancement)
async function bulkUpdateStatus(productIds, status) {
    try {
        const response = await makeRequest(API_ENDPOINTS.bulkUpdate, {
            method: 'POST',
            body: JSON.stringify({
                product_ids: productIds,
                status: status
            })
        });

        if (response.success) {
            showNotification(response.message, 'success');
            loadProducts();
        }
    } catch (error) {
        console.error('Bulk update failed:', error);
    }
}

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
});

// Add notification styles to head
const notificationStyles = `
<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    max-width: 400px;
    animation: slideIn 0.3s ease-out;
}

.notification-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.notification-error {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.notification-content {
    padding: 16px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.notification-content button {
    background: none;
    border: none;
    color: inherit;
    font-size: 20px;
    cursor: pointer;
    margin-left: 12px;
}

.loading-spinner {
    text-align: center;
    padding: 40px;
    color: #64748b;
    font-size: 18px;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
`;

document.head.insertAdjacentHTML('beforeend', notificationStyles);
    </script>
</body>
</html>