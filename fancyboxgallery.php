@extends('main.layouts.main')
@section('main-container')
    {{-- Hero Section --}}
    <section id="hero" class="hero section dark-background">
        <section class="banner">
            <div class="container"></div>
        </section>

        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
            </defs>
            <g class="wave1">
                <use xlink:href="#wave-path" x="50" y="3"></use>
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0"></use>
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="9"></use>
            </g>
        </svg>
    </section>

    {{-- Press Gallery Section --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" rel="stylesheet">

    <style>
        /* Container Styles */
        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Header and Search Styles */
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .search-container {
            max-width: 500px;
            margin: 0 auto 2rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* Gallery Grid Styles */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem 0;
        }

        .gallery-item {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .gallery-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .gallery-item:hover .gallery-image {
            filter: brightness(1.1);
        }

        .gallery-content {
            padding: 1.25rem;
        }

        .gallery-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .gallery-date {
            font-size: 0.9rem;
            color: #64748b;
        }

        /* Pagination Styles */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2rem 0;
            gap: 1rem;
        }

        .page-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .page-btn:hover:not(:disabled) {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-numbers {
            display: flex;
            gap: 0.5rem;
        }

        .page-number {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e2e8f0;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .page-number:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .page-number.active {
            background: #4a90e2;
            border-color: #4a90e2;
            color: white;
        }

        .no-results {
            text-align: center;
            grid-column: 1 / -1;
            padding: 3rem;
            font-size: 1.1rem;
            color: #64748b;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .gallery-image {
                height: 180px;
            }

            .page-number {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .search-input {
                font-size: 0.9rem;
                padding: 0.875rem 1.25rem;
            }

            .pagination-container {
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="gallery-container">
        <div class="page-header">
            <h1 class="page-title">Press Notes <span id="press-count"></span></h1>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search press articles..." id="searchInput">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
        </div>
        <div class="gallery-grid" id="pressGallery"></div>
        <div class="pagination-container">
            <button id="prevPage" class="page-btn">&laquo; Previous</button>
            <div id="pageNumbers" class="page-numbers"></div>
            <button id="nextPage" class="page-btn">Next &raquo;</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <script>
        $(document).ready(function() {
            // Global variables
            let allArticles = [];
            let filteredArticles = [];
            const $gallery = $('#pressGallery');
            const $searchInput = $('#searchInput');
            const $pressCount = $('#press-count');
            const articlesPerPage = 5;
            let currentPage = 1;

            // Fetch articles from the server
            $.ajax({
                url: 'press-articles',
                method: 'GET',
                success: function(data) {
                    allArticles = data;
                    filteredArticles = data;
                    $pressCount.text(`(Total: ${data.length})`);
                    updatePagination();
                    displayArticles();
                    initializeFancybox();
                },
                error: function(error) {
                    console.error('Error fetching press articles:', error);
                    $gallery.html('<div class="no-results">Error loading articles. Please try again later.</div>');
                }
            });

            // Search functionality with debounce
            let searchTimeout;
            $searchInput.on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = $(this).val().toLowerCase();
                    filteredArticles = allArticles.filter(article =>
                        article.name.toLowerCase().includes(searchTerm) ||
                        article.press_date.toLowerCase().includes(searchTerm)
                    );
                    currentPage = 1; // Reset to first page on search
                    updatePagination();
                    displayArticles();
                    initializeFancybox();
                }, 300);
            });

            // Pagination event handlers
            $('#prevPage').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    displayArticles();
                    updatePagination();
                    scrollToTop();
                }
            });

            $('#nextPage').on('click', function() {
                if (currentPage < getTotalPages()) {
                    currentPage++;
                    displayArticles();
                    updatePagination();
                    scrollToTop();
                }
            });

            // Display articles function
            function displayArticles() {
                const startIndex = (currentPage - 1) * articlesPerPage;
                const endIndex = startIndex + articlesPerPage;
                const currentArticles = filteredArticles.slice(startIndex, endIndex);

                if (currentArticles.length === 0) {
                    $gallery.html('<div class="no-results">No articles found</div>');
                    return;
                }

                const articlesHtml = currentArticles.map(article => `
                    <div class="gallery-item">
                        <a href="${article.imageurl}" data-fancybox="gallery">
                            <img class="gallery-image" src="${article.imageurl}" alt="${article.name}">
                        </a>
                        <div class="gallery-content">
                            <h3 class="gallery-title">${article.name}</h3>
                            <div class="gallery-date">${article.press_date}</div>
                        </div>
                    </div>
                `).join('');

                $gallery.html(articlesHtml);
            }

            // Update pagination controls
            function updatePagination() {
                const totalPages = getTotalPages();
                $('#prevPage').prop('disabled', currentPage === 1);
                $('#nextPage').prop('disabled', currentPage === totalPages);

                // Update page numbers
                const $pageNumbers = $('#pageNumbers');
                $pageNumbers.empty();

                // Determine which page numbers to show
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);

                // Adjust if we're near the end
                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                // Add page numbers
                for (let i = startPage; i <= endPage; i++) {
                    $pageNumbers.append(`
                        <div class="page-number ${i === currentPage ? 'active' : ''}" 
                             data-page="${i}">
                            ${i}
                        </div>
                    `);
                }

                // Add click handlers to page numbers
                $('.page-number').on('click', function() {
                    currentPage = parseInt($(this).data('page'));
                    displayArticles();
                    updatePagination();
                    scrollToTop();
                });
            }

            // Helper functions
            function getTotalPages() {
                return Math.ceil(filteredArticles.length / articlesPerPage);
            }

            function scrollToTop() {
                $('html, body').animate({
                    scrollTop: $gallery.offset().top - 100
                }, 500);
            }

            // Initialize Fancybox
            function initializeFancybox() {
                $("[data-fancybox]").fancybox({
                    buttons: [
                        "zoom",
                        "share",
                        "slideShow",
                        "fullScreen",
                        "download",
                        "thumbs",
                        "close"
                    ],
                    loop: true,
                    animationEffect: "zoom-in-out",
                    transitionEffect: "slide",
                    protect: true,
                    touch: {
                        vertical: true,
                        momentum: true
                    }
                });
            }
        });
    </script>
@endsection
