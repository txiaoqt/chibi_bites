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

function openModal(name, price, img, description) {
	currentProduct = { name, price, img, description };
	currentQuantity = 1;
	
	document.getElementById('modalProductName').textContent = name;
	document.getElementById('modalProductPrice').textContent = price;
	document.getElementById('modalProductImg').src = img;
	document.getElementById('modalProductDescription').textContent = description;
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
}

function decreaseQuantity() {
	if (currentQuantity > 1) {
		currentQuantity--;
		document.getElementById('quantityDisplay').textContent = currentQuantity;
	}
}

function addToCart() {
	alert(`Added ${currentQuantity} ${currentProduct.name} to cart!`);
	closeModal();
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
	}
});