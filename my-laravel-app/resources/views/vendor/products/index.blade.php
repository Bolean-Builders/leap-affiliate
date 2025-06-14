@extends('layouts.app')
@section('title', 'My Products - Vendor Dashboard')

@push('styles')


<!-- NOTIFICATION STYLES -->
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

.notification-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.notification-info {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
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
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

.notification-content button:hover {
    opacity: 1;
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

/* Stack multiple notifications */
.notification:nth-child(n+2) {
    top: calc(20px + (80px * var(--notification-index, 0)));
}
</style>

<!-- NOTIFICATION STYLES END -->




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

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .loading-spinner {
        text-align: center;
        padding: 40px;
        color: #64748b;
        font-size: 18px;
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

        .products-grid {
            grid-template-columns: 1fr;
        }

        .product-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>My Products</h1>
        <a href="{{ route('vendor.products.create') }}" class="add-product-btn">
            ➕ Add New Product
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number" style="background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                {{ $stats['total'] ?? 0 }}
            </div>
            <div class="stat-label">Total Products</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="background: var(--warning-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                {{ $stats['active'] ?? 0 }}
            </div>
            <div class="stat-label">Active Products</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="background: var(--rose-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                {{ $stats['pending'] ?? 0 }}
            </div>
            <div class="stat-label">Pending Approval</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="background: var(--teal-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                ${{ number_format($stats['total_revenue'] ?? 0, 2) }}
            </div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <!-- Add this right before your img tag -->
<!-- <p>Debug - Featured Image: {{ $product->featured_image }}</p>
<p>Debug - Generated URL: {{ Storage::url($product->featured_image) }}</p>
<p>Debug - Full URL: {{ url(Storage::url($product->featured_image)) }}</p> -->
                    <div class="product-image {{ !$product->featured_image ? 'no-image' : '' }}">
                        @if($product->featured_image)
                            <img src="{{ Storage::url($product->featured_image) }}" 
                                 alt="{{ $product->name }}" 
                                 onerror="this.style.display='none'; this.parentElement.classList.add('no-image'); this.parentElement.innerHTML='{{ $product->getTypeIcon() }}';">
                        @else
                            {{ $product->getTypeIcon() }}
                        @endif
                        <div class="product-type-badge type-{{ $product->product_type }}">
                            {{ $product->product_type }}
                        </div>
                    </div>
                    <div class="product-title">{{ $product->name }}</div>
                    <div class="product-category">{{ $product->getCategoryDisplayName() }}</div>
                    <div class="product-description">{{ Str::limit($product->description, 100) }}</div>
                    <div class="product-meta">
                        <div class="product-price">{{ $product->getFormattedPrice() }}</div>
                        <div class="product-status status-{{ $product->status }}">{{ $product->status }}</div>
                    </div>
                    <div class="product-actions">
                        <button class="action-btn view-btn" onclick="viewProduct({{ $product->id }})">
                            👁️ View
                        </button>
                        <a href="{{ route('vendor.products.edit', $product) }}" class="action-btn edit-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">
                            ✏️ Edit
                        </a>
                        <button class="action-btn delete-btn" onclick="deleteProduct({{ $product->id }})">
                            🗑️ Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                {{ $products->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <div class="empty-title">No Products Yet</div>
            <div class="empty-description">Start building your product catalog by adding your first product.</div>
            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">Add Your First Product</a>
        </div>
    @endif
</div>

<!-- Product Info Modal -->
<div class="modal" id="productInfoModal" style="display: none;">
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
@endsection

<!-- NOTIFICATION SCRIPT  START-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Laravel session messages integration
    @if(session('success'))
        showNotification('{{ session('success') }}', 'success');
    @endif
    
    @if(session('error'))
        showNotification('{{ session('error') }}', 'error');
    @endif
    
    @if(session('warning'))
        showNotification('{{ session('warning') }}', 'warning');
    @endif
    
    @if(session('info'))
        showNotification('{{ session('info') }}', 'info');
    @endif
    
    // Handle validation errors
    @if($errors->any())
        @foreach($errors->all() as $error)
            showNotification('{{ $error }}', 'error');
        @endforeach
    @endif
});
</script>


<!-- NOTIFICATION SCRIPT  ENDS-->





@push('scripts')
<script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const currencySymbols = {
        USD: '$', EUR: '€', GBP: '£', CAD: 'C$', AUD: 'A$', 
        JPY: '¥', GHS: '₵', NGN: '₦', ZAR: 'R', KES: 'KSh'
    };

    // Notification System
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()">&times;</button>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    // View Product Function
   async function viewProduct(id) {
    try {
        const response = await fetch(`/vendor/products/${id}`, {
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        });
                     
        if (!response.ok) throw new Error('Failed to load product');
                     
        const result = await response.json();
        if (result.success) {
            showProductInfo(result.product);
            // Show success notification when product is successfully viewed
            showNotification('Product loaded successfully!', 'success');
        } else {
            showNotification('Failed to load product details', 'error');
        }
    } catch (error) {
        showNotification('Error loading product details', 'error');
    }
}


    function showProductInfo(product) {
        document.getElementById('infoModalTitle').textContent = product.name;
        
        const infoContent = document.getElementById('productInfoContent');
        infoContent.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div style="background: rgba(255, 255, 255, 0.05); padding: 1.5rem; border-radius: 15px; border: 1px solid var(--glass-border);">
                    <h3 style="margin-bottom: 1rem; color: #8b5cf6; font-size: 1.2rem;">📋 Product Details</h3>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Name:</span>
                        <span style="font-weight: 600;">${product.name}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Category:</span>
                        <span style="font-weight: 600;">${product.category_display_name}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Type:</span>
                        <span style="font-weight: 600;">${product.type_icon} ${product.product_type}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Price:</span>
                        <span style="font-weight: 600;">${product.formatted_price}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Commission:</span>
                        <span style="font-weight: 600;">${product.commission}%</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Status:</span>
                        <span style="font-weight: 600;" class="status-${product.status}">${product.status}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Created:</span>
                        <span style="font-weight: 600;">${new Date(product.created_at).toLocaleDateString()}</span>
                    </div>
                </div>
                
                <div style="background: rgba(255, 255, 255, 0.05); padding: 1.5rem; border-radius: 15px; border: 1px solid var(--glass-border);">
                    <h3 style="margin-bottom: 1rem; color: #8b5cf6; font-size: 1.2rem;">🔗 Links & Resources</h3>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Sales Page:</span>
                        <span style="font-weight: 600;">
                            ${product.sales_page_url ? `<a href="${product.sales_page_url}" target="_blank" style="color: #8b5cf6;">View Page</a>` : 'Not set'}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Resources:</span>
                        <span style="font-weight: 600;">
                            ${product.resources_page_url ? `<a href="${product.resources_page_url}" target="_blank" style="color: #8b5cf6;">View Resources</a>` : 'Not set'}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Thank You Page:</span>
                        <span style="font-weight: 600;">
                            ${product.thankyou_page_url ? `<a href="${product.thankyou_page_url}" target="_blank" style="color: #8b5cf6;">View Page</a>` : 'Not set'}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Meta Title:</span>
                        <span style="font-weight: 600;">${product.meta_title || 'Not set'}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <span style="opacity: 0.8; font-weight: 500;">Tags:</span>
                        <span style="font-weight: 600;">${product.tags_array && product.tags_array.length ? product.tags_array.join(', ') : 'None'}</span>
                    </div>
                </div>
            </div>
            
            <div style="background: rgba(255, 255, 255, 0.05); padding: 1.5rem; border-radius: 15px; border: 1px solid var(--glass-border);">
                <h3 style="margin-bottom: 1rem; color: #8b5cf6; font-size: 1.2rem;">📝 Description</h3>
                <p style="line-height: 1.6; opacity: 0.9;">${product.description}</p>
            </div>
        `;
        
        document.getElementById('productInfoModal').style.display = 'block';
    }

    // Delete Product Function
    async function deleteProduct(id) {
        if (!confirm('Are you sure you want to delete this product?')) return;

        try {
            const response = await fetch(`/vendor/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            if (result.success) {
                showNotification('Product deleted successfully!', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(result.message || 'Failed to delete product', 'error');
            }
        } catch (error) {
            showNotification('Error deleting product', 'error');
        }
    }

    // Modal Functions
    function closeInfoModal() {
        document.getElementById('productInfoModal').style.display = 'none';
    }

    // Event Listeners
    document.getElementById('productInfoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeInfoModal();
        }
    });

    // Add notification styles
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
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .modal {
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
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease-out;
        }
       .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--glass-border);
        }
        .modal-title {
            font-size: 1.8rem;
            font-weight: 600;
            background: var(--indigo-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .close-btn:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { 
                transform: translate(-50%, -50%) translateY(50px);
                opacity: 0;
            }
            to { 
                transform: translate(-50%, -50%) translateY(0);
                opacity: 1;
            }
        }
        </style>
    `;
    document.head.insertAdjacentHTML('beforeend', notificationStyles);

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Vendor Products Dashboard loaded');
        
        // Add smooth scrolling for any anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading states to buttons
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('delete-btn')) {
                    this.style.opacity = '0.7';
                    this.style.pointerEvents = 'none';
                    setTimeout(() => {
                        this.style.opacity = '1';
                        this.style.pointerEvents = 'auto';
                    }, 2000);
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.stat-card, .product-card').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Escape key to close modal
            if (e.key === 'Escape') {
                closeInfoModal();
            }
            
            // Ctrl/Cmd + N to add new product
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                window.location.href = document.querySelector('.add-product-btn').href;
            }
        });

        // Add tooltips for action buttons
        const tooltips = {
            'view-btn': 'View product details',
            'edit-btn': 'Edit this product',
            'delete-btn': 'Delete this product'
        };

        Object.keys(tooltips).forEach(className => {
            document.querySelectorAll(`.${className}`).forEach(btn => {
                btn.title = tooltips[className];
            });
        });

        // Auto-refresh stats every 5 minutes
        setInterval(async () => {
            try {
                const response = await fetch('/vendor/products/stats', {
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        updateStats(data.stats);
                    }
                }
            } catch (error) {
                console.log('Stats refresh failed:', error);
            }
        }, 300000); // 5 minutes
    });

    // Update stats function
    function updateStats(stats) {
        const statCards = document.querySelectorAll('.stat-card .stat-number');
        if (statCards.length >= 4) {
            statCards[0].textContent = stats.total || 0;
            statCards[1].textContent = stats.active || 0;
            statCards[2].textContent = stats.pending || 0;
            statCards[3].textContent = `$${parseFloat(stats.total_revenue || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }
    }

    // Add search functionality (if search input exists)
    const searchInput = document.querySelector('#productSearch');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterProducts(this.value);
            }, 300);
        });
    }

    function filterProducts(searchTerm) {
        const products = document.querySelectorAll('.product-card');
        const term = searchTerm.toLowerCase();
        
        products.forEach(product => {
            const title = product.querySelector('.product-title').textContent.toLowerCase();
            const description = product.querySelector('.product-description').textContent.toLowerCase();
            const category = product.querySelector('.product-category').textContent.toLowerCase();
            
            if (title.includes(term) || description.includes(term) || category.includes(term)) {
                product.style.display = 'block';
                product.style.animation = 'fadeInUp 0.3s ease-out';
            } else {
                product.style.display = 'none';
            }
        });
    }

    // Add bulk actions functionality
    function toggleBulkActions() {
        const checkboxes = document.querySelectorAll('.product-checkbox');
        const bulkActions = document.querySelector('.bulk-actions');
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        
        if (bulkActions) {
            bulkActions.style.display = checkedCount > 0 ? 'flex' : 'none';
        }
    }

    // Export products function
    async function exportProducts() {
        try {
            const response = await fetch('/vendor/products/export', {
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            });
            
            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `products_${new Date().toISOString().split('T')[0]}.csv`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
                showNotification('Products exported successfully!', 'success');
            }
        } catch (error) {
            showNotification('Export failed', 'error');
        }
    }

    // Performance optimization: Lazy load images
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });

    // Service Worker registration for offline support
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('SW registered: ', registration);
                })
                .catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }

    // Add print functionality
    function printProductList() {
        const printWindow = window.open('', '_blank');
        const products = document.querySelectorAll('.product-card');
        
        let printContent = `
            <html>
            <head>
                <title>My Products - ${new Date().toLocaleDateString()}</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .product { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; }
                    .product-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
                    .product-details { margin-bottom: 10px; }
                    @media print { .no-print { display: none; } }
                </style>
            </head>
            <body>
                <h1>My Products - ${new Date().toLocaleDateString()}</h1>
        `;
        
        products.forEach(product => {
            const title = product.querySelector('.product-title').textContent;
            const category = product.querySelector('.product-category').textContent;
            const price = product.querySelector('.product-price').textContent;
            const status = product.querySelector('.product-status').textContent;
            
            printContent += `
                <div class="product">
                    <div class="product-title">${title}</div>
                    <div class="product-details">
                        <strong>Category:</strong> ${category}<br>
                        <strong>Price:</strong> ${price}<br>
                        <strong>Status:</strong> ${status}
                    </div>
                </div>
            `;
        });
        
        printContent += `
            </body>
            </html>
        `;
        
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.print();
    }
</script>
@endpush