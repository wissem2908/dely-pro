<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.all.min.js"></script>

<style>
    #news-description img {
        max-width: 100%;
        height: auto;
    }

    #news-description {
        line-height: 1.8;
        font-size: 16px;
    }

    /* Sidebar container */
    .sidebar-news {
        max-height: 600px;
        /* max height */
        overflow-y: auto;
        /* scroll if too many items */
    }

    /* Scrollbar styling (optional) */
    .sidebar-news::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-news::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    /* News item styling */
    .news-item {
        transition: background 0.2s;
        padding: 5px;
        border-radius: 5px;
            background: #e9ecef;
    padding: 15px;
    }

    .news-item:hover {
        background-color: #e9f2ff;
    }

    .news-title {
        font-size: 14px;
        line-height: 1.3;
    }

    /* Optional: truncate long titles */
    .news-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<div class="container-fluid" style="max-width:1200px;">
    <div class="row">

        <!-- LEFT: NEWS DETAIL -->
        <div class="col-lg-8">
            <div id="news-detail">

                <h1 id="news-title" class="mb-3"></h1>

                <p class="text-muted mb-3">
                    <i class="far fa-calendar-alt me-2"></i>
                    <span id="news-date"></span>
                </p>

                <img id="news-image" class="img-fluid rounded mb-4" src="" alt="">

                <div id="news-description"></div>

            </div>
        </div>

        <!-- RIGHT: OTHER NEWS -->
        <div class="col-lg-4">
            <div class="bg-light rounded p-4 sidebar-news">
                <h5 class="mb-4">Autres actualités</h5>
                <div id="other-news" class="other-news-list"></div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script>
    function getSlugFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('slug');
    }


    $(document).ready(function() {

        const slug = getSlugFromUrl();

        if (!slug) {
            Swal.fire("Erreur", "Actualité introuvable", "error");
            return;
        }

        $.ajax({
            url: 'admin/assets/php/news/get_news_detail.php',
            type: 'GET',
            data: {
                slug: slug
            },
            dataType: 'json',
            success: function(news) {

                $('#news-title').text(news.title);
                $('#news-date').text(news.date_fr);
                $('#news-image').attr('src', 'admin/assets/uploads/news_images/' + news.image);
                $('#news-description').html(news.description);

                loadOtherNews(slug);

            },
            error: function() {
                Swal.fire("Erreur", "Impossible de charger l'actualité", "error");
            }
        });


        function loadOtherNews(currentSlug) {

            $.ajax({
                url: 'admin/assets/php/news/get_other_news.php',
                type: 'GET',
                data: {
                    slug: currentSlug
                },
                dataType: 'json',
                success: function(data) {

                    let html = '';
                    data.forEach(item => {
                        html += `
                          <a href="news_details.php?slug=${item.slug}" class="fw-semibold text-dark d-block news-title">
    <div class="d-flex align-items-start mb-3 news-item">
        <div class="flex-shrink-0">
            <img src="admin/assets/uploads/news_images/${item.image}" 
                 class="rounded" style="width:70px; height:55px; object-fit:cover;">
        </div>
        <div class="flex-grow-1 ms-2">
          
                ${item.title}
           
            <span class="text-muted small">${item.date_fr}</span>
        </div>
    </div> </a>`;
                    });
                    $('#other-news').html(html);

                }
            });

        }

    });
</script>