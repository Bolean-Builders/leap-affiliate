@extends('layouts.app')
@section('title', 'Add New Product - Vendor Dashboard')

@push('styles')
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
        
        /* Form Colors */
        --input-bg: rgba(255, 255, 255, 0.1);
        --input-border: rgba(255, 255, 255, 0.2);
        --input-focus: rgba(139, 92, 246, 0.3);
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
        max-width: 1000px;
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

    .back-btn {
        background: var(--teal-gradient);
        border: none;
        padding: 1rem 2rem;
        border-radius: 15px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 8px 32px rgba(13, 148, 136, 0.3);
    }

    .back-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 48px rgba(13, 148, 136, 0.4);
        color: white;
        text-decoration: none;
    }

    .form-container {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 2.5rem;
        animation: fadeInUp 0.8s ease-out;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #e2e8f0;
        font-size: 0.95rem;
    }

    .form-label.required::after {
        content: ' *';
        color: #ef4444;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 1rem 1.5rem;
        background: var(--input-bg);
        border: 1px solid var(--input-border);
        border-radius: 12px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px var(--input-focus);
        background: rgba(255, 255, 255, 0.15);
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-select {
        cursor: pointer;
    }

    .form-select option {
        background: #1f2937;
        color: white;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .file-upload-area {
        border: 2px dashed var(--input-border);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: var(--input-bg);
        position: relative;
        overflow: hidden;
    }

    .file-upload-area:hover,
    .file-upload-area.dragover {
        border-color: #8b5cf6;
        background: rgba(139, 92, 246, 0.1);
    }

    .file-upload-area input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    .upload-text {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        font-size: 0.9rem;
        opacity: 0.7;
    }

    .image-preview {
        margin-top: 1rem;
        display: none;
    }

    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        object-fit: cover;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-section {
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        background: var(--indigo-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--glass-border);
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 140px;
        justify-content: center;
    }

    .btn-primary {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
    }

    .btn-secondary {
        background: var(--glass-bg);
        color: white;
        border: 1px solid var(--glass-border);
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary:hover {
        box-shadow: 0 12px 48px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary:hover {
        background: var(--glass-bg-hover);
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .tags-input-container {
        position: relative;
    }

    .tags-display {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        min-height: 40px;
        align-items: flex-start;
        align-content: flex-start;
    }

    .tag-item {
        background: var(--indigo-gradient);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: fadeInScale 0.3s ease-out;
    }

    .tag-remove {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
        line-height: 1;
        padding: 0;
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.2s;
    }

    .tag-remove:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .error-message {
        color: #fca5a5;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: none;
    }

    .form-group.error .form-input,
    .form-group.error .form-select,
    .form-group.error .form-textarea {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
    }

    .form-group.error .error-message {
        display: block;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid #8b5cf6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .character-counter {
        text-align: right;
        font-size: 0.8rem;
        opacity: 0.7;
        margin-top: 0.25rem;
    }

    .form-help {
        font-size: 0.85rem;
        opacity: 0.8;
        margin-top: 0.25rem;
        color: #cbd5e1;
    }

    .price-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .currency-symbol {
        position: absolute;
        left: 1rem;
        z-index: 1;
        font-weight: 600;
        color: #10b981;
    }

    .price-input-group .form-input {
        padding-left: 2.5rem;
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

    @keyframes fadeInScale {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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

        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }

    /* Product type specific styling */
    .product-type-section {
        display: none;
        animation: fadeInUp 0.5s ease-out;
    }

    .product-type-section.active {
        display: block;
    }

    .type-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
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
</style>
@endpush

@section('content')
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Add New Product</h1>
        <a href="{{ route('vendor.products.index') }}" class="back-btn">
            ← Back to Products
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <form id="productForm" action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="form-section">
                <h2 class="section-title">
                    📋 Basic Information
                </h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label required">Product Name</label>
                        <input type="text" id="name" name="name" class="form-input" 
                               placeholder="Enter product name" required maxlength="255" 
                               value="{{ old('name') }}">
                        <div class="character-counter">
                            <span id="nameCounter">0</span>/255 characters
                        </div>
                        <div class="error-message" id="nameError"></div>
                    </div>

                    <div class="form-group">
                        <label for="product_type" class="form-label required">Product Type</label>
                        <select id="product_type" name="product_type" class="form-select" required>
                            <option value="">Select Product Type</option>
                            <option value="digital" {{ old('product_type') == 'digital' ? 'selected' : '' }}>🔮 Digital Product</option>
                            <option value="physical" {{ old('product_type') == 'physical' ? 'selected' : '' }}>📦 Physical Product</option>
                            <option value="service" {{ old('product_type') == 'service' ? 'selected' : '' }}>🛠️ Service</option>
                        </select>
                        <div class="error-message" id="productTypeError"></div>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label required">Description</label>
                    <textarea id="description" name="description" class="form-textarea" 
                              placeholder="Describe your product in detail..." required 
                              maxlength="2000">{{ old('description') }}</textarea>
                    <div class="character-counter">
                        <span id="descriptionCounter">0</span>/2000 characters
                    </div>
                    <div class="form-help">Provide a detailed description to help customers understand your product.</div>
                    <div class="error-message" id="descriptionError"></div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="category" class="form-label required">Category</label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Clothing & Fashion</option>
                            <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>Home & Garden</option>
                            <option value="books" {{ old('category') == 'books' ? 'selected' : '' }}>Books & Media</option>
                            <option value="health" {{ old('category') == 'health' ? 'selected' : '' }}>Health & Beauty</option>
                            <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>Sports & Outdoors</option>
                            <option value="automotive" {{ old('category') == 'automotive' ? 'selected' : '' }}>Automotive</option>
                            <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>Software</option>
                            <option value="courses" {{ old('category') == 'courses' ? 'selected' : '' }}>Online Courses</option>
                            <option value="consulting" {{ old('category') == 'consulting' ? 'selected' : '' }}>Consulting</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <div class="error-message" id="categoryError"></div>
                    </div>

                    <div class="form-group">
                        <label for="tags" class="form-label">Tags</label>
                        <div class="tags-input-container">
                            <div class="tags-display" id="tagsDisplay"></div>
                            <input type="text" id="tags" name="tags" class="form-input" 
                                   placeholder="Type tags and press Enter..." 
                                   autocomplete="off">
                            <input type="hidden" id="tagsHidden" name="tags_array" value="{{ json_encode(old('tags_array', [])) }}">
                        </div>
                        <div class="form-help">Add relevant tags to help customers find your product (Press Enter to add).</div>
                        <div class="error-message" id="tagsError"></div>
                    </div>
                </div>
            </div>

            <!-- Pricing Section -->
            <div class="form-section">
                <h2 class="section-title">
                    💰 Pricing & Commission
                </h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="price" class="form-label required">Price</label>
                        <div class="price-input-group">
                            <span class="currency-symbol">$</span>
                            <input type="number" id="price" name="price" class="form-input" 
                                   placeholder="0.00" required min="0" step="0.01" 
                                   value="{{ old('price') }}">
                        </div>
                        <div class="form-help">Set your product price in USD.</div>
                        <div class="error-message" id="priceError"></div>
                    </div>

                    <div class="form-group">
                        <label for="commission" class="form-label required">Commission Rate (%)</label>
                        <input type="number" id="commission" name="commission" class="form-input" 
                               placeholder="10" required min="1" max="50" step="0.1" 
                               value="{{ old('commission', '10') }}">
                        <div class="form-help">Commission rate for affiliates (1-50%).</div>
                        <div class="error-message" id="commissionError"></div>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="form-section">
                <h2 class="section-title">
                    🖼️ Product Media
                </h2>
                
                <div class="form-group">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <div class="file-upload-area" id="imageUploadArea">
                        <input type="file" id="featured_image" name="featured_image" 
                               accept="image/*" onchange="handleImageUpload(this)">
                        <div class="upload-icon">🖼️</div>
                        <div class="upload-text">Click to upload or drag and drop</div>
                        <div class="upload-hint">PNG, JPG, GIF up to 5MB</div>
                    </div>
                    <div class="image-preview" id="imagePreview">
                        <img id="previewImg" src="" alt="Preview">
                    </div>
                    <div class="form-help">Upload a high-quality image that represents your product.</div>
                    <div class="error-message" id="featuredImageError"></div>
                </div>
            </div>

            <!-- URLs Section -->
            <div class="form-section">
                <h2 class="section-title">
                    🔗 Product URLs
                </h2>
                
                <div class="form-group">
                    <label for="sales_page_url" class="form-label">Sales Page URL</label>
                    <input type="url" id="sales_page_url" name="sales_page_url" class="form-input" 
                           placeholder="https://example.com/product-sales-page" 
                           value="{{ old('sales_page_url') }}">
                    <div class="form-help">URL where customers can view and purchase your product.</div>
                    <div class="error-message" id="salesPageUrlError"></div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="resources_page_url" class="form-label">Resources Page URL</label>
                        <input type="url" id="resources_page_url" name="resources_page_url" class="form-input" 
                               placeholder="https://example.com/resources" 
                               value="{{ old('resources_page_url') }}">
                        <div class="form-help">URL for product resources and downloads.</div>
                        <div class="error-message" id="resourcesPageUrlError"></div>
                    </div>

                    <div class="form-group">
                        <label for="thankyou_page_url" class="form-label">Thank You Page URL</label>
                        <input type="url" id="thankyou_page_url" name="thankyou_page_url" class="form-input" 
                               placeholder="https://example.com/thank-you" 
                               value="{{ old('thankyou_page_url') }}">
                        <div class="form-help">URL customers see after purchase.</div>
                        <div class="error-message" id="thankyouPageUrlError"></div>
                    </div>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="form-section">
                <h2 class="section-title">
                    🎯 SEO & Meta Information
                </h2>
                
                <div class="form-group">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-input" 
                           placeholder="SEO-friendly title for search engines" maxlength="60" 
                           value="{{ old('meta_title') }}">
                    <div class="character-counter">
                        <span id="metaTitleCounter">0</span>/60 characters
                    </div>
                    <div class="form-help">Optimized title for search engines (recommended: 50-60 characters).</div>
                    <div class="error-message" id="metaTitleError"></div>
                </div>

                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="form-textarea" 
                              placeholder="Brief description for search engine results..." 
                              maxlength="160" style="min-height: 80px;">{{ old('meta_description') }}</textarea>
                    <div class="character-counter">
                        <span id="metaDescriptionCounter">0</span>/160 characters
                    </div>
                    <div class="form-help">Brief description for search results (recommended: 150-160 characters).</div>
                    <div class="error-message" id="metaDescriptionError"></div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <span id="submitText">Create Product</span>
                    <span id="submitLoader" style="display: none;">Creating...</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>
@endsection

@push('scripts')
<script>
    // Form state management
  // Form state management
let formData = {
    tags: JSON.parse(document.getElementById('tagsHidden').value || '[]')
};

// Character counters
const counters = [
    { input: 'name', counter: 'nameCounter', max: 255 },
    { input: 'description', counter: 'descriptionCounter', max: 2000 },
    { input: 'meta_title', counter: 'metaTitleCounter', max: 60 },
    { input: 'meta_description', counter: 'metaDescriptionCounter', max: 160 }
];

// Initialize character counters
counters.forEach(item => {
    const input = document.getElementById(item.input);
    const counter = document.getElementById(item.counter);
    
    if (input && counter) {
        const updateCounter = () => {
            const count = input.value.length;
            counter.textContent = count;
            counter.style.color = count > item.max * 0.9 ? '#fca5a5' : '';
        };
        
        input.addEventListener('input', updateCounter);
        updateCounter(); // Initialize
    }
});

// NOTIFICATION SYSTEM - NEW CODE
function createNotificationContainer() {
    if (!document.getElementById('notificationContainer')) {
        const container = document.createElement('div');
        container.id = 'notificationContainer';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
        `;
        document.body.appendChild(container);
    }
}

function showNotification(message, type = 'success', duration = 5000) {
    createNotificationContainer();
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    const colors = {
        success: { bg: '#10b981', border: '#059669' },
        error: { bg: '#ef4444', border: '#dc2626' },
        warning: { bg: '#f59e0b', border: '#d97706' },
        info: { bg: '#3b82f6', border: '#2563eb' }
    };
    
    const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
    };
    
    notification.style.cssText = `
        background: ${colors[type].bg};
        color: white;
        padding: 16px 20px;
        border-radius: 8px;
        border-left: 4px solid ${colors[type].border};
        margin-bottom: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 14px;
        line-height: 1.4;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        cursor: pointer;
    `;
    
    notification.innerHTML = `
        <span style="font-size: 16px; font-weight: bold;">${icons[type]}</span>
        <span style="flex: 1;">${message}</span>
        <span style="opacity: 0.7; font-size: 18px; padding-left: 8px;">×</span>
    `;
    
    // Add click to dismiss
    notification.addEventListener('click', () => {
        dismissNotification(notification);
    });
    
    document.getElementById('notificationContainer').appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto dismiss
    if (duration > 0) {
        setTimeout(() => {
            dismissNotification(notification);
        }, duration);
    }
}

function dismissNotification(notification) {
    notification.style.transform = 'translateX(100%)';
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 300);
}

// Tags functionality
const tagsInput = document.getElementById('tags');
const tagsDisplay = document.getElementById('tagsDisplay');
const tagsHidden = document.getElementById('tagsHidden');

function renderTags() {
    tagsDisplay.innerHTML = '';
    formData.tags.forEach((tag, index) => {
        const tagElement = document.createElement('div');
        tagElement.className = 'tag-item';
        tagElement.innerHTML = `
            <span>${tag}</span>
            <button type="button" class="tag-remove" onclick="removeTag(${index})">×</button>
        `;
        tagsDisplay.appendChild(tagElement);
    });
    tagsHidden.value = JSON.stringify(formData.tags);
}

function addTag(tag) {
    const trimmedTag = tag.trim().toLowerCase();
    if (trimmedTag && !formData.tags.includes(trimmedTag) && formData.tags.length < 10) {
        formData.tags.push(trimmedTag);
        renderTags();
        tagsInput.value = '';
    }
}

function removeTag(index) {
    formData.tags.splice(index, 1);
    renderTags();
}

// Tags input event listeners
if (tagsInput) {
    tagsInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addTag(this.value);
        }
    });

    tagsInput.addEventListener('blur', function() {
        if (this.value.trim()) {
            addTag(this.value);
        }
    });
}

// Initialize tags display
renderTags();

// Image upload functionality
function handleImageUpload(input) {
    const file = input.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            showError('featuredImageError', 'File size must be less than 5MB');
            input.value = '';
            return;
        }
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            showError('featuredImageError', 'Please select a valid image file');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
        clearError('featuredImageError');
    } else {
        preview.style.display = 'none';
    }
}

// Drag and drop functionality for image upload
const imageUploadArea = document.getElementById('imageUploadArea');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    imageUploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    imageUploadArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    imageUploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    imageUploadArea.classList.add('dragover');
}

function unhighlight(e) {
    imageUploadArea.classList.remove('dragover');
}

imageUploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        document.getElementById('featured_image').files = files;
        handleImageUpload(document.getElementById('featured_image'));
    }
}

// Product type change handler
const productTypeSelect = document.getElementById('product_type');
const typeIndicators = document.querySelectorAll('.product-type-section');

productTypeSelect.addEventListener('change', function() {
    const selectedType = this.value;
    
    // Hide all type-specific sections
    typeIndicators.forEach(section => {
        section.classList.remove('active');
    });
    
    // Show relevant section
    if (selectedType) {
        const typeSection = document.querySelector(`.type-${selectedType}`);
        if (typeSection) {
            typeSection.classList.add('active');
        }
        
        // Add type indicator
        updateTypeIndicator(selectedType);
    }
});

function updateTypeIndicator(type) {
    // Remove existing indicators
    const existingIndicator = document.querySelector('.type-indicator');
    if (existingIndicator) {
        existingIndicator.remove();
    }
    
    // Create new indicator
    const indicator = document.createElement('div');
    indicator.className = `type-indicator type-${type}`;
    
    const icons = {
        digital: '🔮',
        physical: '📦',
        service: '🛠️'
    };
    
    const labels = {
        digital: 'Digital Product',
        physical: 'Physical Product',  
        service: 'Service'
    };
    
    indicator.innerHTML = `${icons[type]} ${labels[type]}`;
    
    // Insert after the product type form group
    const productTypeGroup = productTypeSelect.closest('.form-group');
    productTypeGroup.parentNode.insertBefore(indicator, productTypeGroup.nextSibling);
}

// Form validation
function validateForm() {
    let isValid = true;
    const requiredFields = [
        { id: 'name', error: 'nameError', message: 'Product name is required' },
        { id: 'product_type', error: 'productTypeError', message: 'Please select a product type' },
        { id: 'description', error: 'descriptionError', message: 'Product description is required' },
        { id: 'category', error: 'categoryError', message: 'Please select a category' },
        { id: 'price', error: 'priceError', message: 'Price is required and must be greater than 0' },
        { id: 'commission', error: 'commissionError', message: 'Commission rate is required (1-50%)' }
    ];
    
    // Clear all errors first
    requiredFields.forEach(field => clearError(field.error));
    
    // Validate required fields
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        const value = element.value.trim();
        
        if (!value) {
            showError(field.error, field.message);
            isValid = false;
        } else {
            // Additional validation for specific fields
            if (field.id === 'price') {
                const price = parseFloat(value);
                if (price <= 0) {
                    showError(field.error, 'Price must be greater than 0');
                    isValid = false;
                }
            }
            
            if (field.id === 'commission') {
                const commission = parseFloat(value);
                if (commission < 1 || commission > 50) {
                    showError(field.error, 'Commission rate must be between 1% and 50%');
                    isValid = false;
                }
            }
        }
    });
    
    // Validate URLs if provided
    const urlFields = ['sales_page_url', 'resources_page_url', 'thankyou_page_url'];
    urlFields.forEach(fieldId => {
        const element = document.getElementById(fieldId);
        const value = element.value.trim();
        
        if (value && !isValidUrl(value)) {
            const errorId = fieldId.replace('_', '') + 'Error';
            showError(errorId, 'Please enter a valid URL');
            isValid = false;
        }
    });
    
    return isValid;
}

function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

function showError(errorId, message) {
    const errorElement = document.getElementById(errorId);
    const formGroup = errorElement.closest('.form-group');
    
    if (errorElement && formGroup) {
        errorElement.textContent = message;
        formGroup.classList.add('error');
    }
}

function clearError(errorId) {
    const errorElement = document.getElementById(errorId);
    const formGroup = errorElement.closest('.form-group');
    
    if (errorElement && formGroup) {
        errorElement.textContent = '';
        formGroup.classList.remove('error');
    }
}

// Form submission
const productForm = document.getElementById('productForm');
const submitBtn = document.getElementById('submitBtn');
const submitText = document.getElementById('submitText');
const submitLoader = document.getElementById('submitLoader');
const loadingOverlay = document.getElementById('loadingOverlay');

productForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateForm()) {
        // Scroll to first error
        const firstError = document.querySelector('.form-group.error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }
    
    // Mark form as submitted to prevent beforeunload warning
    productForm.submitted = true;
    formChanged = false;
    
    // Show loading state
    submitBtn.disabled = true;
    submitText.style.display = 'none';
    submitLoader.style.display = 'inline';
    loadingOverlay.style.display = 'flex';
    
    // ENHANCED FORM SUBMISSION - You can use either method below:
    
    // METHOD 1: Traditional form submission with success message on page reload
    // Add a success parameter to the form action or handle it server-side
    this.submit();
    
    // METHOD 2: AJAX submission (uncomment and modify as needed)
    /*
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            handleSubmissionSuccess(data.message || 'Product created successfully!');
            
            // Optional: Redirect after delay
            setTimeout(() => {
                window.location.href = data.redirect_url || "{{ route('vendor.products.index') }}";
            }, 2000);
        } else {
            throw new Error(data.message || 'Something went wrong');
        }
    })
    .catch(error => {
        handleSubmissionError(error.message);
    })
    .finally(() => {
        // Reset loading state
        submitBtn.disabled = false;
        submitText.style.display = 'inline';
        submitLoader.style.display = 'none';
        loadingOverlay.style.display = 'none';
    });
    */
});

// Real-time validation on input
document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(element => {
    element.addEventListener('blur', function() {
        const errorId = this.id + 'Error';
        if (document.getElementById(errorId)) {
            clearError(errorId);
            
            // Validate this specific field
            if (this.hasAttribute('required') && !this.value.trim()) {
                const fieldName = this.previousElementSibling.textContent.replace(' *', '');
                showError(errorId, `${fieldName} is required`);
            }
        }
    });
    
    element.addEventListener('input', function() {
        const errorId = this.id + 'Error';
        if (document.getElementById(errorId)) {
            clearError(errorId);
        }
    });
});

// Price formatting
const priceInput = document.getElementById('price');
if (priceInput) {
    priceInput.addEventListener('blur', function() {
        const value = parseFloat(this.value);
        if (!isNaN(value)) {
            this.value = value.toFixed(2);
        }
    });
}

// Commission validation
const commissionInput = document.getElementById('commission');
if (commissionInput) {
    commissionInput.addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (value > 50) {
            this.value = 50;
        } else if (value < 1 && this.value !== '') {
            this.value = 1;
        }
    });
}

// Initialize form
document.addEventListener('DOMContentLoaded', function() {
    // Trigger product type change if there's a selected value
    if (productTypeSelect.value) {
        productTypeSelect.dispatchEvent(new Event('change'));
    }
    
    // Focus first input
    const firstInput = document.querySelector('.form-input');
    if (firstInput) {
        firstInput.focus();
    }
    
    // Check for success message from server (for traditional form submission)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
        showNotification('Product created successfully! 🎉', 'success');
    }
});

// Prevent accidental form loss
let formChanged = false;

// Track form changes
document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(element => {
    element.addEventListener('change', function() {
        formChanged = true;
    });
    
    element.addEventListener('input', function() {
        formChanged = true;
    });
});

// Beforeunload warning
window.addEventListener('beforeunload', function(e) {
    if (formChanged && !productForm.submitted) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return 'You have unsaved changes. Are you sure you want to leave?';
    }
});

// SUCCESS AND ERROR HANDLERS - ENHANCED VERSIONS
function handleSubmissionSuccess(message = 'Product created successfully! 🎉') {
    formChanged = false;
    productForm.submitted = true;
    
    // Show success notification
    showNotification(message, 'success', 6000);
    
    // Reset form if needed
    // productForm.reset();
    // formData.tags = [];
    // renderTags();
    
    // Scroll to top smoothly
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function handleSubmissionError(message = 'An error occurred while creating the product. Please try again.') {
    showNotification(message, 'error', 8000);
    
    // Reset form submission state
    productForm.submitted = false;
    
    // Scroll to top to show error
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Additional utility functions for different notification types
function showSuccessMessage(message) {
    showNotification(message, 'success');
}

function showErrorMessage(message) {
    showNotification(message, 'error');
}

function showWarningMessage(message) {
    showNotification(message, 'warning');
}

function showInfoMessage(message) {
    showNotification(message, 'info');
}
</script>
@endpush