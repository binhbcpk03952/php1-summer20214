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