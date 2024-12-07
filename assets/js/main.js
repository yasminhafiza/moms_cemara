document.addEventListener('DOMContentLoaded', () => {
    const navbarMenu = document.querySelector('.navbar-menu');
    const btnMenu = document.querySelector('#btn-menu');
    
    if (btnMenu) {
        btnMenu.addEventListener('click', () => {
            navbarMenu.classList.toggle('active');
        });
    }

    const btnUser = document.querySelector('#btn-user');
    const userDropdown = document.querySelector('.user');

    if (btnUser) {
        btnUser.addEventListener('click', function(e) {
            if (userDropdown) {
                userDropdown.classList.toggle('active');
            }
            e.preventDefault();
        });
    }

    $('.hero .owl-carousel').owlCarousel({
        autoplay: true,
        nav: true,
        loop: true,
        dots: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 1000, 
        items: 1,
        navText: [
            "<i class='fas fa-angle-left'></i>",
            "<i class='fas fa-angle-right'></i>"
        ],
        navContainer: "#owl-nav"
    });

    $('.detail-produk .owl-carousel').owlCarousel({
        autoplay: true,
        nav: true,
        loop: true,
        dots: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 1000, 
        items: 1,
        navText: [
            "<i class='fas fa-angle-left'></i>",
            "<i class='fas fa-angle-right'></i>"
        ],
        navContainer: "#owl-nav"
    });
});

// Pagination
function getPageList(totalPage, page, maxLength) {
    function range(start, end) {
        return Array.from(Array(end - start + 1), (_, i) => i + start);
    }

    var sideWidth = maxLength < 9 ? 1 : 2;
    var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
    var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

    if (totalPage <= maxLength) {
        return range(1, totalPage);
    }

    if (page <= maxLength - sideWidth - 1 - rightWidth) {
        return range(1, maxLength - sideWidth - 1).concat(0, range(totalPage - sideWidth + 1, totalPage));
    }

    if (page >= totalPage - sideWidth - 1 - rightWidth) {
        return range(1, sideWidth).concat(0, range(totalPage - sideWidth - 1 - rightWidth - leftWidth, totalPage));
    }

    return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth), 0, range(totalPage - sideWidth + 1, totalPage));
}

$(function() {
    var numberOfItems = $(".card-produk .card").length;
    var limitPerPage = 6; 
    var totalPage = Math.ceil(numberOfItems / limitPerPage);
    var paginationSize = 5;
    var currentPage = 1; // Inisialisasi halaman saat memuat pertama kali

    function showPage(whichPage) {
        if (whichPage < 1 || whichPage > totalPage) return false;
        currentPage = whichPage;

        $(".card-produk .card").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();
        $(".pagination li").slice(1, -1).remove();

        getPageList(totalPage, currentPage, paginationSize).forEach(item => {
            $("<li>").addClass("page-item").addClass(item ? "halaman" : "dots")
                .toggleClass("active", item === currentPage)
                .append($("<a>").addClass("page-link").attr({ href: "javascript:void(0)" }).text(item || "..."))
                .insertBefore(".page-item-next"); // Insert before next button
        });

        // Menangani kelas disabled untuk tombol Prev
        $(".page-item-prev").toggleClass("disabled", currentPage === 1);
        // Menangani kelas disabled untuk tombol Next
        $(".page-item-next").toggleClass("disabled", currentPage === totalPage);

        return true;
    }

    $(".pagination").append(
        $("<li>").addClass("page-item").addClass("page-item-prev")
            .append($("<a>").addClass("page-link").attr({ href: "javascript:void(0)" }).text("Prev"))
    );
    $(".pagination").append(
        $("<li>").addClass("page-item").addClass("page-item-next")
            .append($("<a>").addClass("page-link").attr({ href: "javascript:void(0)" }).text("Next"))
    );

    $(".card-produk").show();
    showPage(1); // Menampilkan halaman pertama saat memuat pertama kali

    // Handler untuk klik pada halaman di pagination
    $(document).on("click", ".pagination li.halaman:not(.active)", function() {
        return showPage(+$(this).text());
    });

    // Handler untuk klik pada tombol Next
    $(document).on("click", ".page-item-next", function() {
        return showPage(currentPage + 1);
    });

    // Handler untuk klik pada tombol Prev
    $(document).on("click", ".page-item-prev", function() {
        if (currentPage > 1) {
            return showPage(currentPage - 1);
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var btnProfile = document.getElementById('btn-profile');
    var btnLogout = document.getElementById('btn-logout');
    var btnLogin = document.getElementById('btn-login');
    var dropdownUser = document.getElementById('dropdown-user');
    var searchForm = document.querySelector('.search-form');
    var searchBox = document.getElementById('search-box');
    var btnSearch = document.getElementById('btn-search');

    if (btnProfile) {
        btnProfile.addEventListener('click', function() {
            dropdownUser.style.display = (dropdownUser.style.display === 'block') ? 'none' : 'block';
        });
    }

    if (btnLogout) {
        btnLogout.addEventListener('click', function() {
            alert('Anda telah logout.');
        });
    }

    if (btnLogin) {
        btnLogin.addEventListener('click', function() {});
    }

    window.addEventListener('click', function(event) {
        if (dropdownUser && !dropdownUser.contains(event.target) && event.target !== btnProfile) {
            dropdownUser.style.display = 'none';
        }
    });

    if (btnSearch) {
        btnSearch.addEventListener('click', function(e) {
            searchForm.classList.toggle('active');
            searchBox.focus();
            e.preventDefault();
        });
    }

    if (searchBox) {
        searchBox.addEventListener('blur', function() {
            searchForm.classList.remove('active');
        });
    }
});

