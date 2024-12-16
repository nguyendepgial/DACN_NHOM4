


    // Kiểm tra nhập liệu trong Form
    const form = document.querySelector('#myForm');
    if (form) {
        form.onsubmit = function (event) {
            let isValid = true;

            // Kiểm tra trường "Tên"
            let name = document.getElementById("name").value;
            if (!name) {
                document.getElementById("nameError").style.display = "inline";
                isValid = false;
            } else {
                document.getElementById("nameError").style.display = "none";
            }

            // Kiểm tra trường "Email"
            let email = document.getElementById("email").value;
            let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!email || !emailPattern.test(email)) {
                document.getElementById("emailError").style.display = "inline";
                isValid = false;
            } else {
                document.getElementById("emailError").style.display = "none";
            }

            // Nếu form không hợp lệ, ngừng gửi
            if (!isValid) {
                event.preventDefault();
            }
        };
    }

    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: { items: 1 },
                600: { items: 2 },
                1000: { items: 3 }
            }
        });
    });
     

    document.addEventListener('DOMContentLoaded', function () {
        const categoryItems = document.querySelectorAll('.category-item');
        const productList = document.getElementById('product-list');
    
        // Lọc sản phẩm theo danh mục
        categoryItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const categorySlug = e.target.getAttribute('data-category');
                const allProducts = document.querySelectorAll('.product-item');
    
                allProducts.forEach(product => {
                    if (categorySlug === 'all' || product.getAttribute('data-category') === categorySlug) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        });
    
        // Thêm vào giỏ hàng
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = button.getAttribute('data-id');
                const productName = button.getAttribute('data-name');
                const productPrice = button.getAttribute('data-price');
                const productImage = button.getAttribute('data-image');
    
                // Hiển thị prompt nhập số lượng
                const quantity = prompt(`Nhập số lượng cho sản phẩm: ${productName}`, 1);
                if (quantity !== null && quantity > 0) {
                    // Gửi dữ liệu đến server qua fetch API (hoặc AJAX)
                    fetch('add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: productId,
                            name: productName,
                            price: productPrice,
                            image: productImage,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Sản phẩm đã được thêm vào giỏ hàng!');
                        } else {
                            alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                    });
                }
            });
        });
    });
    


