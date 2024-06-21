document.addEventListener('DOMContentLoaded', function() {
    initializeSlider();
});

function initializeSlider(sliderContainer, dotContainer) {
    let currentIndex = 0;
    const slides = sliderContainer.querySelector('.slides');
    const dots = dotContainer.querySelectorAll('.dot');

    if (!slides || dots.length === 0) {
        console.error('Slides or dots not found.');
        return;
    }

    function updateDots(index) {
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    function showSlide(index) {
        if (index >= slides.children.length) {
            currentIndex = slides.children.length - 1;
        } else if (index < 0) {
            currentIndex = 0;
        } else {
            currentIndex = index;
        }
        const offset = -currentIndex * 1116;
        slides.style.transform = `translateX(${offset}px)`;
        updateDots(currentIndex);
    }

    function currentSlide(index) {
        showSlide(index);
    }
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => currentSlide(index));
    });

    let isDown = false;
    let startX;
    let walk;
    let offset = 0;

    slides.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - offset;
        slides.classList.add('grabbing');
        slides.style.transition = 'none'; // Disable transition during drag
    });

    slides.addEventListener('mouseleave', () => {
        isDown = false;
        slides.classList.remove('grabbing');
        slides.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition
    });

    slides.addEventListener('mouseup', () => {
        isDown = false;
        slides.classList.remove('grabbing');
        slides.style.transition = 'transform 0.5s ease-in-out'; // Re-enable transition
        if (Math.abs(walk) > slides.offsetWidth / 4) {
            if (walk < 0) {
                currentSlide(currentIndex + 1);
            } else {
                currentSlide(currentIndex - 1);
            }
        } else {
            showSlide(currentIndex);
        }
    });

    slides.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - offset;
        walk = x - startX;
        slides.style.transform = `translateX(${-currentIndex * slides.offsetWidth + walk}px)`;
    });

    // Initial display
    showSlide(currentIndex);
}

// Initialize both sliders
const slider1 = document.querySelector('#banner-index');
const slider1Dots = document.querySelector('#banner-index .dots');
initializeSlider(slider1, slider1Dots);

const slider2 = document.querySelector('.slider-text');
const slider2Dots = document.querySelector('.slider-text .dots');
initializeSlider(slider2, slider2Dots);



function showDropdown() {
    var dropdown = document.getElementById("my-dropdown");
    dropdown.classList.toggle("active");
}

// Thêm sự kiện click cho cả document để ẩn dropdown khi click vào chỗ khác
document.addEventListener("click", function(event) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('active') && !event.target.closest('.successful')) {
            openDropdown.classList.remove('active');
        }
    }
});

// // Ngăn sự kiện click từ phần tử dropdown-content lan sang phần tử successful
// let bug = document.querySelector('.dropdown-content')
// bug.addEventListener('click', function(event) {
//     event.stopPropagation();
// });

document.addEventListener("DOMContentLoaded", function() {
    // Lấy ra các phần tử cần thiết
    var dropdownToggle = document.querySelector('#navbarDropdown');
    var dropdownMenu = document.querySelector('#dropdown-menu');

    // Thêm sự kiện click vào dropdown toggle
    dropdownToggle.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

        // Xóa class d-none từ dropdown menu
        dropdownMenu.classList.remove('d-none');
    });

    // Thêm sự kiện click vào body để xử lý khi click ngoài dropdown
    document.body.addEventListener('click', function(event) {
        // Kiểm tra xem target của sự kiện có phải là dropdown toggle hay không
        var isDropdownToggle = dropdownToggle.contains(event.target);

        // Kiểm tra xem target của sự kiện có phải là dropdown menu hay không
        var isDropdownMenu = dropdownMenu.contains(event.target);

        // Nếu không phải là dropdown toggle hoặc dropdown menu, thêm lại class d-none cho dropdown menu
        if (!isDropdownToggle && !isDropdownMenu) {
            dropdownMenu.classList.add('d-none');
        }
    });
});