let slider = document.querySelector(".section-1 .slider");
let slides = slider.children;
let index = 0;

setInterval(() => {
    index = (index + 1) % slides.length;
    slider.scrollTo({
        left: slider.clientWidth * index,
        behavior: "smooth"
    });
}, 3000);




let currentQuantity = 1;
let currentProduct = {};

function openModal(name, price, img, description, id) {
	currentProduct = { name, price, img, description, id };
	currentQuantity = 1;

	document.getElementById('modalProductName').textContent = name;
	document.getElementById('modalProductPrice').textContent = price;
	document.getElementById('modalProductImg').src = img;
	document.getElementById('modalProductDescription').textContent = description;
	document.getElementById('modalProductId').value = id;
	document.getElementById('modalQuantity').value = currentQuantity;
	document.getElementById('quantityDisplay').textContent = currentQuantity;

	document.getElementById('productModal').classList.add('active');
	document.body.style.overflow = 'hidden';
}

function closeModal() {
	document.getElementById('productModal').classList.remove('active');
	document.body.style.overflow = 'auto';
}

function increaseQuantity() {
	currentQuantity++;
	document.getElementById('quantityDisplay').textContent = currentQuantity;
	document.getElementById('modalQuantity').value = currentQuantity;
}

function decreaseQuantity() {
	if (currentQuantity > 1) {
		currentQuantity--;
		document.getElementById('quantityDisplay').textContent = currentQuantity;
		document.getElementById('modalQuantity').value = currentQuantity;
	}
}

function addToCart() {
	// AJAX call to add to cart
	fetch('/cart/add', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		},
		body: JSON.stringify({
			product_id: currentProduct.id, // Need to pass product id, but modal doesn't have it
			quantity: currentQuantity
		})
	})
	.then(response => response.json())
	.then(data => {
		if (data.success) {
			alert(`Added ${currentQuantity} ${currentProduct.name} to cart!`);
			closeModal();
			// Update cart count if needed
		} else {
			alert('Error adding to cart');
		}
	})
	.catch(error => {
		console.error('Error:', error);
		alert('Error adding to cart');
	});
}

// Close modal when clicking outside
window.onclick = function(event) {
	const modal = document.getElementById('productModal');
	if (event.target === modal) {
		closeModal();
	}
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
	if (event.key === 'Escape') {
		closeModal();
		closeSuccessModal();
	}
});

// Initialize success modal close functionality
document.addEventListener('DOMContentLoaded', function() {
	const closeBtn = document.querySelector('.success-close-btn');
	if (closeBtn) {
		closeBtn.addEventListener('click', closeSuccessModal);
	}

	// Also handle Add More button
	const addMoreBtn = document.querySelector('.success-btn-secondary');
	if (addMoreBtn) {
		addMoreBtn.addEventListener('click', closeSuccessModal);
	}
});

function closeSuccessModal() {
	const modal = document.getElementById('successModal');
	if (modal) {
		modal.style.display = 'none';
		// Clear the session flash by redirecting without parameters
		const url = new URL(window.location);
		url.search = '';
		window.location.href = url.toString();
	}
}

// Bootstrap handles the navbar collapse functionality automatically
