@extends('layouts.app')
@section('title', 'Edit Product - Vendor Dashboard')

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
        
        /* Form Specific */
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
        box-shadow: 0 8px 32px rgba(13, 148, 136, 0.3);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 48px rgba(13, 148, 136, 0.4);
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
        color: #8b5cf6;
        font-size: 0.95rem;
    }

    .form-input, .form-select, .form-textarea {
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

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px var(--input-focus);
        background: rgba(255, 255, 255, 0.15);
    }

    .form-input::placeholder, .form-textarea::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
        font-family: inherit;
    }

    .form-select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8L10 12L14 8'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        appearance: none;
    }

    .form-select option {
        background: #1f2937;
        color: white;
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

    .file-upload-area:hover {
        border-color: #8b5cf6;
        background: rgba(139, 92, 246, 0.1);
    }

    .file-upload-area.dragover {
        border-color: #8b5cf6;
        background: rgba(139, 92, 246, 0.2);
        transform: scale(1.02);
    }

    #file-input {
        position: absolute;
        left: -9999px;
        opacity: 0;
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

    .upload-subtext {
        font-size: 0.9rem;
        opacity: 0.7;
    }

    .current-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        margin-bottom: 1rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .image-preview {
        display: none;
        margin-top: 1rem;
    }

    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .tags-input {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.5rem;
        background: var(--input-bg);
        border: 1px solid var(--input-border);
        border-radius: 12px;
        min-height: 3rem;
        cursor: text;
    }

    .tag {
        background: var(--indigo-gradient);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
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
        background: rgba(255, 255, 255, 0.2);
    }

    .tag-input {
        flex: 1;
        min-width: 120px;
        border: none;
        background: none;
        color: white;
        outline: none;
        padding: 0.5rem;
        font-size: 1rem;
    }

    .tag-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid var(--glass-border);
    }

    .btn-danger {
        background: var(--danger-gradient);
        color: white;
        box-shadow: 0 8px 32px rgba(239, 68, 68, 0.3);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 48px rgba(0, 0, 0, 0.2);
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .success-message {
        background: var(--success-gradient);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        animation: slideDown 0.5s ease-out;
    }

    .help-text {
        font-size: 0.85rem;
        opacity: 0.7;
        margin-top: 0.3rem;
        line-height: 1.4;
    }

    .required {
        color: #ef4444;
    }

    .form-section {
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #8b5cf6;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .checkbox {
        width: 20px;
        height: 20px;
        accent-color: #8b5cf6;
    }

    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top: 3px solid #8b5cf6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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

        .form-actions {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Edit Product</h1>
        <a href="{{ route('vendor.products.index') }}" class="back-btn">
            ← Back to Products
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="success-message">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <form action="{{ route('vendor.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="form-section">
                <h2 class="section-title">📝 Basic Information</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">Product Name <span class="required">*</span></label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input" 
                               value="{{ old('name', $product->name) }}" 
                               placeholder="Enter product name"
                               required>
                        @error('name')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category" class="form-label">Category <span class="required">*</span></label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="digital_products" {{ old('category', $product->category) == 'digital_products' ? 'selected' : '' }}>Digital Products</option>
                            <option value="physical_products" {{ old('category', $product->category) == 'physical_products' ? 'selected' : '' }}>Physical Products</option>
                            <option value="services" {{ old('category', $product->category) == 'services' ? 'selected' : '' }}>Services</option>
                            <option value="courses" {{ old('category', $product->category) == 'courses' ? 'selected' : '' }}>Courses</option>
                            <option value="books_ebooks" {{ old('category', $product->category) == 'books_ebooks' ? 'selected' : '' }}>Books & eBooks</option>
                            <option value="software" {{ old('category', $product->category) == 'software' ? 'selected' : '' }}>Software</option>
                            <option value="other" {{ old('category', $product->category) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="product_type" class="form-label">Product Type <span class="required">*</span></label>
                        <select id="product_type" name="product_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="digital" {{ old('product_type', $product->product_type) == 'digital' ? 'selected' : '' }}>Digital</option>
                            <option value="physical" {{ old('product_type', $product->product_type) == 'physical' ? 'selected' : '' }}>Physical</option>
                            <option value="service" {{ old('product_type', $product->product_type) == 'service' ? 'selected' : '' }}>Service</option>
                        </select>
                        @error('product_type')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ old('status', $product->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label">Description <span class="required">*</span></label>
                    <textarea id="description" 
                              name="description" 
                              class="form-textarea" 
                              placeholder="Describe your product in detail..."
                              required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="error-message">⚠️ {{ $message }}</div>
                    @enderror
                    <div class="help-text">Provide a detailed description that will help customers understand your product.</div>
                </div>
            </div>

            <!-- Pricing Section -->
            <div class="form-section">
                <h2 class="section-title">💰 Pricing & Commission</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="price" class="form-label">Price <span class="required">*</span></label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               class="form-input" 
                               value="{{ old('price', $product->price) }}" 
                               placeholder="0.00"
                               step="0.01"
                               min="0"
                               required>
                        @error('price')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="currency" class="form-label">Currency <span class="required">*</span></label>
                        <select id="currency" name="currency" class="form-select" required>
                            <option value="USD" {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                            <option value="EUR" {{ old('currency', $product->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            <option value="GBP" {{ old('currency', $product->currency) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                            <option value="CAD" {{ old('currency', $product->currency) == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                            <option value="AUD" {{ old('currency', $product->currency) == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                            <option value="JPY" {{ old('currency', $product->currency) == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                            <option value="GHS" {{ old('currency', $product->currency) == 'GHS' ? 'selected' : '' }}>GHS - Ghana Cedi</option>
                            <option value="NGN" {{ old('currency', $product->currency) == 'NGN' ? 'selected' : '' }}>NGN - Nigerian Naira</option>
                            <option value="ZAR" {{ old('currency', $product->currency) == 'ZAR' ? 'selected' : '' }}>ZAR - South African Rand</option>
                            <option value="KES" {{ old('currency', $product->currency) == 'KES' ? 'selected' : '' }}>KES - Kenyan Shilling</option>
                        </select>
                        @error('currency')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="commission" class="form-label">Commission Rate (%) <span class="required">*</span></label>
                        <input type="number" 
                               id="commission" 
                               name="commission" 
                               class="form-input" 
                               value="{{ old('commission', $product->commission) }}" 
                               placeholder="50"
                               step="0.01"
                               min="0"
                               max="100"
                               required>
                        @error('commission')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                        <div class="help-text">Commission rate for affiliates (0-100%)</div>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="form-section">
                <h2 class="section-title">🖼️ Featured Image</h2>
                
                <div class="form-group">
                    <label class="form-label">Product Image</label>
                    
                    @if($product->featured_image)
                        <div style="margin-bottom: 1rem;">
                            <p style="margin-bottom: 0.5rem; opacity: 0.8;">Current Image:</p>
                            <img src="{{ Storage::url($product->featured_image) }}" 
                                 alt="Current product image" 
                                 class="current-image">
                        </div>
                    @endif

                    <div class="file-upload-area" onclick="document.getElementById('file-input').click()">
                        <div class="upload-icon">📸</div>
                        <div class="upload-text">{{ $product->featured_image ? 'Change Image' : 'Upload Product Image' }}</div>
                        <div class="upload-subtext">Click to browse or drag and drop</div>
                        <div class="upload-subtext">PNG, JPG, GIF up to 5MB</div>
                    </div>
                    
                    <input type="file" 
                           id="file-input" 
                           name="featured_image" 
                           accept="image/*">
                    
                    <div class="image-preview" id="image-preview">
                        <p style="margin-bottom: 0.5rem; opacity: 0.8;">New Image Preview:</p>
                        <img id="preview-img" alt="Preview">
                    </div>
                    
                    @error('featured_image')
                        <div class="error-message">⚠️ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- URLs Section -->
            <div class="form-section">
                <h2 class="section-title">🔗 URLs & Links</h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="sales_page_url" class="form-label">Sales Page URL</label>
                        <input type="url" 
                               id="sales_page_url" 
                               name="sales_page_url" 
                               class="form-input" 
                               value="{{ old('sales_page_url', $product->sales_page_url) }}" 
                               placeholder="https://example.com/sales-page">
                        @error('sales_page_url')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                        <div class="help-text">The main sales page where customers can learn about and purchase your product</div>
                    </div>

                    <div class="form-group">
                        <label for="thankyou_page_url" class="form-label">Thank You Page URL</label>
                        <input type="url" 
                               id="thankyou_page_url" 
                               name="thankyou_page_url" 
                               class="form-input" 
                               value="{{ old('thankyou_page_url', $product->thankyou_page_url) }}" 
                               placeholder="https://example.com/thank-you">
                        @error('thankyou_page_url')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                        <div class="help-text">Page customers see after successful purchase</div>
                    </div>

                    <div class="form-group full-width">
                        <label for="resources_page_url" class="form-label">Resources Page URL</label>
                        <input type="url" 
                               id="resources_page_url" 
                               name="resources_page_url" 
                               class="form-input" 
                               value="{{ old('resources_page_url', $product->resources_page_url) }}" 
                               placeholder="https://example.com/resources">
                        @error('resources_page_url')
                            <div class="error-message">⚠️ {{ $message }}</div>
                        @enderror
                        <div class="help-text">Page containing downloadable resources, bonuses, or additional content</div>
                    </div>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="form-section">
                <h2 class="section-title">🔍 SEO & Marketing</h2>
                
                <div class="form-group">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" 
                           id="meta_title" 
                           name="meta_title" 
                           class="form-input" 
                           value="{{ old('meta_title', $product->meta_title) }}" 
                           placeholder="SEO title for search engines"
                           maxlength="60">
                    @error('meta_title')
                        <div class="error-message">⚠️ {{ $message }}</div>
                    @enderror
                    <div class="help-text">Recommended length: 50-60 characters</div>
                </div>

                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea id="meta_description" 
                              name="meta_description" 
                              class="form-textarea" 
                              placeholder="Brief description for search engines..."
                              maxlength="160">{{ old('meta_description', $product->meta_description) }}</textarea>
                    @error('meta_description')
                        <div class="error-message">⚠️ {{ $message }}</div>
                    @enderror
                    <div class="help-text">Recommended length: 150-160 characters</div>
                </div>

                <label for="tags" class="form-label">Tags</label>
                    <div class="tags-input" id="tagsContainer">
                        @if($product->tags)
                            @foreach(json_decode($product->tags) as $tag)
                                <span class="tag">
                                    {{ $tag }}
                                    <button type="button" class="tag-remove" onclick="removeTag(this)">×</button>
                                </span>
                            @endforeach
                        @endif
                        <input type="text" 
                               class="tag-input" 
                               placeholder="Add tags..." 
                               onkeydown="handleTagInput(event)">
                    </div>
                    <input type="hidden" name="tags" id="tagsHidden" value="{{ old('tags', $product->tags) }}">
                    @error('tags')
                        <div class="error-message">⚠️ {{ $message }}</div>
                    @enderror
                    <div class="help-text">Press Enter to add tags. Use relevant keywords to help people find your product.</div>
                </div>
            </div>
            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteProduct()">
                    🗑️ Delete Product
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    💾 Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000; justify-content: center; align-items: center;">
    <div style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 20px; padding: 2rem; max-width: 400px; text-align: center;">
        <h3 style="margin-bottom: 1rem; color: #ef4444;">⚠️ Delete Product</h3>
        <p style="margin-bottom: 2rem; opacity: 0.8;">Are you sure you want to delete this product? This action cannot be undone.</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button onclick="closeDeleteModal()" class="btn btn-secondary">Cancel</button>
            <form method="POST" action="{{ route('vendor.products.destroy', $product) }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // File upload functionality
    const fileInput = document.getElementById('file-input');
    const fileUploadArea = document.querySelector('.file-upload-area');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag and drop functionality
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

    // Tags functionality
    function handleTagInput(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const input = event.target;
            const tag = input.value.trim();
            
            if (tag && !tagExists(tag)) {
                addTag(tag);
                input.value = '';
                updateTagsHidden();
            }
        }
    }

    function addTag(tagText) {
        const tagsContainer = document.getElementById('tagsContainer');
        const tagInput = tagsContainer.querySelector('.tag-input');
        
        const tagElement = document.createElement('span');
        tagElement.className = 'tag';
        tagElement.innerHTML = `
            ${tagText}
            <button type="button" class="tag-remove" onclick="removeTag(this)">×</button>
        `;
        
        tagsContainer.insertBefore(tagElement, tagInput);
    }

    function removeTag(button) {
        button.parentElement.remove();
        updateTagsHidden();
    }

    function tagExists(tagText) {
        const existingTags = document.querySelectorAll('.tag');
        return Array.from(existingTags).some(tag => 
            tag.textContent.trim().replace('×', '') === tagText
        );
    }

    function updateTagsHidden() {
        const tags = Array.from(document.querySelectorAll('.tag')).map(tag => 
            tag.textContent.trim().replace('×', '')
        );
        document.getElementById('tagsHidden').value = JSON.stringify(tags);
    }

    // Form submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Updating...';
        loadingOverlay.style.display = 'flex';
        
        // Update tags before submission
        updateTagsHidden();
    });

    // Delete product functionality
    function deleteProduct() {
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Auto-resize textareas
    document.querySelectorAll('.form-textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
        
        // Initial resize
        textarea.style.height = textarea.scrollHeight + 'px';
    });

    // Character count for meta fields
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');

    if (metaTitle) {
        metaTitle.addEventListener('input', function() {
            const length = this.value.length;
            const helpText = this.parentElement.querySelector('.help-text');
            const color = length > 60 ? '#ef4444' : length > 50 ? '#facc15' : '#10b981';
            helpText.style.color = color;
            helpText.textContent = `${length}/60 characters - Recommended length: 50-60 characters`;
        });
    }

    if (metaDescription) {
        metaDescription.addEventListener('input', function() {
            const length = this.value.length;
            const helpText = this.parentElement.querySelector('.help-text');
            const color = length > 160 ? '#ef4444' : length > 150 ? '#facc15' : '#10b981';
            helpText.style.color = color;
            helpText.textContent = `${length}/160 characters - Recommended length: 150-160 characters`;
        });
    }

    // Initialize character counts
    if (metaTitle && metaTitle.value) {
        metaTitle.dispatchEvent(new Event('input'));
    }
    if (metaDescription && metaDescription.value) {
        metaDescription.dispatchEvent(new Event('input'));
    }

    // Form validation
    function validateForm() {
        const requiredFields = document.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = '#ef4444';
                isValid = false;
            } else {
                field.style.borderColor = '';
            }
        });

        return isValid;
    }

    // Real-time validation
    document.querySelectorAll('[required]').forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '';
            }
        });

        field.addEventListener('input', function() {
            if (this.style.borderColor === 'rgb(239, 68, 68)' && this.value.trim()) {
                this.style.borderColor = '';
            }
        });
    });

    // Prevent form submission if invalid
    document.getElementById('productForm').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('submitBtn').innerHTML = '💾 Update Product';
            document.getElementById('loadingOverlay').style.display = 'none';
            
            // Scroll to first error
            const firstError = document.querySelector('[style*="border-color: rgb(239, 68, 68)"]');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    // Initialize tags on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTagsHidden();
    });
</script>
@endpush
@endsection