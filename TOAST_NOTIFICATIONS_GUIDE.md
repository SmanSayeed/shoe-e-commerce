# Toast Notifications System - Complete Guide

## 📋 Table of Contents
1. [Overview](#overview)
2. [Implementation Types](#implementation-types)
3. [Frontend (Cart & Checkout)](#frontend-cart--checkout)
4. [Admin Dashboard](#admin-dashboard)
5. [Usage Patterns](#usage-patterns)
6. [Code Examples](#code-examples)
7. [Best Practices](#best-practices)
8. [Troubleshooting](#troubleshooting)

---

## 🎯 Overview

The site uses **two different toast notification systems**:

1. **Frontend (Cart & Checkout)**: Custom vanilla JavaScript implementation
2. **Admin Dashboard**: Toastify.js library with custom wrapper

Both systems provide user feedback for actions like:
- Adding items to cart
- Updating cart quantities
- Removing cart items
- Form validation errors
- Order placement success/failure
- API errors

---

## 🔧 Implementation Types

### Type 1: Custom Vanilla JavaScript (Frontend)

**Location**: Inline in Blade templates (`cart/index.blade.php`, `checkout/index.blade.php`)

**Characteristics**:
- No external dependencies
- Simple DOM manipulation
- Custom styling with Tailwind CSS
- Slide-in animation from right
- Auto-dismiss after 3 seconds

### Type 2: Toastify.js Library (Admin)

**Location**: `resources/js/admin/app.js` and `resources/js/admin/components/toast.js`

**Characteristics**:
- Uses `toastify-js` npm package
- More features (positioning, icons, close button)
- Consistent styling across admin
- Global helper functions
- Feather icons integration

---

## 🛒 Frontend (Cart & Checkout)

### Cart Page Implementation

**File**: `resources/views/frontend/cart/index.blade.php`

**Function**: `showNotification(message, type = 'info')`

```javascript
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

    // Apply type-based styling
    if (type === 'success') {
        notification.className += ' bg-green-500 text-white';
    } else if (type === 'error') {
        notification.className += ' bg-red-500 text-white';
    } else {
        notification.className += ' bg-blue-500 text-white';
    }

    notification.textContent = message;

    // Add to page
    document.body.appendChild(notification);

    // Animate in (remove translate-x-full)
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
```

**Usage in Cart**:

1. **Cart Quantity Update**:
```javascript
.then(data => {
    if (data.success) {
        // Update UI...
        showNotification('Cart updated successfully', 'success');
    } else {
        showNotification(data.message || 'Failed to update cart', 'error');
    }
})
.catch(error => {
    showNotification(error.message || 'Failed to update cart. Please try again.', 'error');
});
```

2. **Remove Cart Item**:
```javascript
.then(data => {
    if (data.success) {
        // Remove item from DOM...
        showNotification('Item removed successfully', 'success');
    } else {
        showNotification(data.message || 'Failed to remove item', 'error');
    }
})
.catch(error => {
    showNotification('Failed to remove item. Please try again.', 'error');
});
```

**Visual Behavior**:
- **Position**: Fixed top-right (`top-4 right-4`)
- **Animation**: Slides in from right (`translate-x-full` → visible)
- **Duration**: 3 seconds
- **Colors**:
  - Success: `bg-green-500`
  - Error: `bg-red-500`
  - Info: `bg-blue-500`

### Checkout Page Implementation

**File**: `resources/views/frontend/checkout/index.blade.php`

**Function**: Same `showNotification()` function (duplicated in checkout page)

**Usage in Checkout**:

1. **Form Validation Errors**:
```javascript
// First name validation
if (!firstNameInput || !firstNameInput.value || firstNameInput.value.trim() === '') {
    showNotification('Please enter your first name.', 'error');
    firstNameInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
    hasError = true;
}

// Phone validation
if (!phoneInput || !phoneInput.value || phoneInput.value.trim() === '') {
    showNotification('Please enter your phone number.', 'error');
    phoneInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
    hasError = true;
} else if (!/^\d+$/.test(phoneValue)) {
    showNotification('Phone number must contain only numbers.', 'error');
    phoneInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
    hasError = true;
}

// Address validation
if (!addressTextarea || !addressTextarea.value || addressTextarea.value.trim() === '') {
    showNotification('Please enter your shipping address.', 'error');
    addressTextarea.classList.add('border-red-500', 'ring-2', 'ring-red-500');
    hasError = true;
}

// Email format validation (if provided)
if (emailInput && emailInput.value && emailInput.value.trim() !== '') {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value.trim())) {
        showNotification('Please enter a valid email address.', 'error');
        emailInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
        hasError = true;
    }
}
```

2. **Order Placement**:
```javascript
fetch('{{ route("checkout.process") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
    },
    body: JSON.stringify(data),
})
.then(response => {
    if (!response.ok) {
        return response.json().then(errorData => {
            throw { status: response.status, data: errorData };
        });
    }
    return response.json();
})
.then(data => {
    if (data.success) {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            showNotification('Order placed successfully!', 'success');
        }
    } else {
        showNotification(data.message || 'Failed to place order', 'error');
    }
})
.catch(error => {
    // Handle validation errors (422)
    if (error.status === 422 && error.data && error.data.errors) {
        const errorMessages = [];
        Object.keys(error.data.errors).forEach(field => {
            const fieldErrors = error.data.errors[field];
            if (Array.isArray(fieldErrors) && fieldErrors.length > 0) {
                errorMessages.push(fieldErrors[0]);
            }
        });
        if (errorMessages.length > 0) {
            showNotification(errorMessages[0], 'error');
        }
    } else {
        const errorMessage = (error.data && error.data.message) 
            ? error.data.message 
            : 'An error occurred. Please try again.';
        showNotification(errorMessage, 'error');
    }
});
```

3. **Shipping Calculation Errors**:
```javascript
.catch(error => {
    console.error('Error calculating shipping:', error);
    showNotification('Failed to calculate shipping charge. Using default.', 'error');
});
```

4. **District Loading Errors**:
```javascript
.catch(error => {
    console.error('Error loading districts:', error);
    showNotification('Failed to load districts. Please try again.', 'error');
});
```

### Product Page (Add to Cart)

**File**: `resources/views/product/show.blade.php`

**Function**: `showNotification()` (similar implementation)

**Usage**:
```javascript
fetch('{{ route("cart.add") }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        'Accept': 'application/json',
    },
    body: JSON.stringify({
        product_id: {{ $product->id }},
        variant_id: selectedVariant,
        quantity: quantity,
    }),
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        updateCartCount(data.cart_count);
        showNotification('Product added to cart successfully!', 'success');
    } else {
        showNotification(data.message || 'Failed to add product to cart', 'error');
    }
});
```

### Cart Offcanvas (Sidebar Cart)

**File**: `resources/js/cart.js`

**Function**: `showToast(message)` (simpler version)

```javascript
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-5 right-5 bg-gray-900 text-white px-4 py-2 rounded-md';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
```

**Usage**:
```javascript
.then(data => {
    if (data.success) {
        openCart();
        updateCartView(data.cart_items, data.subtotal);
        updateCartCount(data.total_items);
        showToast('Item added to cart');
    }
});
```

**Differences from main cart page**:
- Simpler styling (no type-based colors)
- Position: `bottom-5 right-5` (instead of `top-4 right-4`)
- No animation (appears instantly)
- No type parameter (always same style)

---

## 👨‍💼 Admin Dashboard

### Toastify.js Implementation

**Files**:
- `resources/js/admin/app.js` - Global helper functions
- `resources/js/admin/components/toast.js` - Toast component module

### Global Helper Functions

**File**: `resources/js/admin/app.js`

```javascript
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

// Make Toastify globally available
window.Toastify = Toastify;

// Success toast
window.showSuccessToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#10b981",
        stopOnFocus: true,
        className: "toast-success"
    }).showToast();
};

// Error toast
window.showErrorToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#dc2626",
        stopOnFocus: true,
        className: "toast-error"
    }).showToast();
};

// Warning toast
window.showWarningToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#d97706",
        stopOnFocus: true,
        className: "toast-warning"
    }).showToast();
};

// Info toast
window.showInfoToast = function(message, duration = 3000) {
    return Toastify({
        text: message,
        duration: duration,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#0891b2",
        stopOnFocus: true,
        className: "toast-info"
    }).showToast();
};
```

### Toast Component Module

**File**: `resources/js/admin/components/toast.js`

```javascript
import Toastify from 'toastify-js';
import feather from 'feather-icons';

const toast = (() => {
  // Constructor for toast
  const toast = (text, options = {}) => {
    return Toastify({
      text: `<div>${text}</div>`,
      escapeMarkup: false,
      ...options,
    }).showToast();
  };

  toast.success = (text, options = {}) => {
    return Toastify({
      text: `
        <div class="flex items-center gap-2">
          ${options.icon || feather.icons['check'].toSvg({ width: '16', height: '16' })}
          <div>${text}</div>
        </div>
      `,
      escapeMarkup: false,
      className: 'toastify-success',
      ...options,
    }).showToast();
  };

  toast.danger = (text, options = {}) => {
    return Toastify({
      text: `
        <div class="flex items-center gap-2">
          ${options.icon || feather.icons['x'].toSvg({ width: '16', height: '16' })}
          <div>${text}</div>
        </div>
      `,
      escapeMarkup: false,
      className: 'toastify-danger',
      ...options,
    }).showToast();
  };

  toast.warning = (text, options = {}) => {
    return Toastify({
      text: `
        <div class="flex items-center gap-2">
          ${options.icon || feather.icons['alert-triangle'].toSvg({ width: '16', height: '16' })}
          <div>${text}</div>
        </div>
      `,
      escapeMarkup: false,
      className: 'toastify-warning',
      ...options,
    }).showToast();
  };

  toast.info = (text, options = {}) => {
    return Toastify({
      text: `
        <div class="flex items-center gap-2">
          ${options.icon || feather.icons['info'].toSvg({ width: '16', height: '16' })}
          <div>${text}</div>
        </div>
      `,
      escapeMarkup: false,
      className: 'toastify-info',
      ...options,
    }).showToast();
  };

  return toast;
})();

export default toast;
```

### Admin Usage Examples

**Product Variants Page**:
```javascript
.then(data => {
    if (data.success) {
        showSuccessToast(data.message);
        // Reload page after delay
        setTimeout(() => location.reload(), 1000);
    } else {
        showErrorToast(data.message || 'An error occurred');
    }
})
.catch(error => {
    showErrorToast(error.message || 'An error occurred while adding the variant');
});
```

**Stock Management Page**:
```javascript
function showToast(message, type = 'info') {
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(toastContainer);
    }

    const bgColor = type === 'success' ? 'bg-green-500' 
                  : type === 'error' ? 'bg-red-500'
                  : type === 'warning' ? 'bg-yellow-500'
                  : 'bg-blue-500';

    const toast = document.createElement('div');
    toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 min-w-[300px] max-w-[500px] animate-slide-in`;
    toast.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white hover:text-gray-200">×</button>
    `;
    
    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
```

### Admin CSS Styling

**File**: `resources/css/admin/app.css`

```css
/* Toastify custom styling */
.toastify {
    @apply rounded-lg shadow-lg;
    min-width: 300px;
    max-width: 500px;
}

.toastify.toast-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white !important;
}

.toastify.toast-error {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
    color: white !important;
}

.toastify.toast-warning {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
    color: white !important;
}

.toastify.toast-info {
    background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%) !important;
    color: white !important;
}

.toastify .toast-close {
    @apply opacity-80 hover:opacity-100 transition-opacity;
    color: white !important;
}

/* Dark mode support */
.dark .toastify.toast-success {
    background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
}

/* Responsive */
@media (max-width: 640px) {
    .toastify {
        min-width: 280px !important;
        max-width: calc(100vw - 32px) !important;
        margin: 16px !important;
    }
}
```

---

## 📊 Usage Patterns

### Pattern 1: Success Feedback

```javascript
// Cart update success
showNotification('Cart updated successfully', 'success');

// Order placed
showNotification('Order placed successfully!', 'success');

// Item added
showNotification('Product added to cart successfully!', 'success');
```

### Pattern 2: Error Handling

```javascript
// API error
.catch(error => {
    showNotification(error.message || 'An error occurred. Please try again.', 'error');
});

// Validation error
if (!field.value) {
    showNotification('Please fill in this field.', 'error');
    field.classList.add('border-red-500');
}

// Network error
if (!response.ok) {
    showNotification('Failed to connect to server. Please try again.', 'error');
}
```

### Pattern 3: Form Validation

```javascript
// Multiple validation checks
let hasError = false;
let firstErrorField = null;

if (!firstName.value) {
    showNotification('Please enter your first name.', 'error');
    firstName.classList.add('border-red-500');
    if (!firstErrorField) firstErrorField = firstName;
    hasError = true;
}

if (!phone.value) {
    showNotification('Please enter your phone number.', 'error');
    phone.classList.add('border-red-500');
    if (!firstErrorField) firstErrorField = phone;
    hasError = true;
}

if (hasError) {
    if (firstErrorField) {
        firstErrorField.focus();
        firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    return;
}
```

### Pattern 4: Loading States

```javascript
// Disable button and show loading
button.disabled = true;
button.innerHTML = '<span class="animate-spin">...</span>Processing...';

fetch(url, options)
    .then(data => {
        showNotification('Success!', 'success');
    })
    .catch(error => {
        showNotification('Error occurred', 'error');
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = originalText;
    });
```

---

## 💡 Best Practices

### 1. **Consistent Messaging**

✅ **Good**:
```javascript
showNotification('Cart updated successfully', 'success');
showNotification('Item removed from cart', 'success');
```

❌ **Bad**:
```javascript
showNotification('Cart updated', 'success');
showNotification('Removed!', 'success');
```

### 2. **Error Messages**

✅ **Good**:
```javascript
showNotification('Failed to update cart. Please try again.', 'error');
showNotification('Please enter a valid email address.', 'error');
```

❌ **Bad**:
```javascript
showNotification('Error', 'error');
showNotification('Invalid', 'error');
```

### 3. **Type Selection**

- **Success**: Operations completed successfully
- **Error**: Something went wrong, user action required
- **Info**: Informational messages (default)

### 4. **Timing**

- **Auto-dismiss**: 3 seconds (default)
- **Long messages**: Consider longer duration or manual close
- **Critical errors**: May need longer duration or manual close

### 5. **Positioning**

- **Frontend**: Top-right (`top-4 right-4`)
- **Admin**: Top-right (`gravity: "top"`, `position: "right"`)
- **Mobile**: Responsive, adjusts to screen size

### 6. **Accessibility**

- Use semantic colors (green=success, red=error)
- Provide clear, descriptive messages
- Ensure sufficient contrast
- Consider screen reader announcements

---

## 🔍 Troubleshooting

### Issue: Toasts not appearing

**Solutions**:
1. Check z-index: Ensure `z-50` or higher
2. Check positioning: Verify `fixed` positioning
3. Check JavaScript errors: Open browser console
4. Check DOM: Verify element is appended to body

### Issue: Multiple toasts stacking incorrectly

**Solutions**:
1. Use a toast container (like admin stock management)
2. Queue toasts instead of showing simultaneously
3. Clear previous toasts before showing new one

### Issue: Toasts appearing behind modals

**Solutions**:
1. Increase z-index: Use `z-[9999]` or higher
2. Append to modal container instead of body
3. Use portal/teleport pattern

### Issue: Animation not working

**Solutions**:
1. Check Tailwind classes: `translate-x-full`, `transition-all`, `duration-300`
2. Verify CSS is loaded
3. Check for conflicting styles

### Issue: Toasts not auto-dismissing

**Solutions**:
1. Check setTimeout implementation
2. Verify timeout duration (3000ms = 3 seconds)
3. Check for JavaScript errors preventing cleanup

---

## 📝 Summary

### Frontend Toast System
- **Type**: Custom vanilla JavaScript
- **Location**: Inline in Blade templates
- **Styling**: Tailwind CSS
- **Animation**: Slide-in from right
- **Duration**: 3 seconds
- **Types**: success, error, info

### Admin Toast System
- **Type**: Toastify.js library
- **Location**: Compiled JavaScript files
- **Styling**: Custom CSS + Toastify
- **Features**: Icons, close button, positioning options
- **Types**: success, error, warning, info

### Key Differences

| Feature | Frontend | Admin |
|---------|----------|-------|
| Library | None (vanilla JS) | Toastify.js |
| Icons | None | Feather icons |
| Close Button | No | Yes |
| Positioning | Fixed top-right | Configurable |
| Animation | Slide-in | Toastify default |
| Styling | Tailwind classes | Custom CSS |

---

**Last Updated**: November 14, 2025  
**Version**: 1.0.0

