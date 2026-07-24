<?php
include "includes/header.php";
include "includes/navbar.php";
require_once "config/db.php";

$featuredQuery = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC LIMIT 1");
$featured = mysqli_fetch_assoc($featuredQuery);

$newsQuery = mysqli_query($conn, "SELECT * FROM news ORDER BY created_at DESC LIMIT 1, 9");
?>


<section class="news-banner d-flex align-items-center">
    <div class="container text-center py-5">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3">
            Rotary Club of Isolo Metro
        </span>
        <h1 class="display-3 fw-extrabold text-white mb-3">Latest News & Stories</h1>
        <p class="lead text-white-50 mx-auto max-w-600">
            Discover how we are creating lasting impact through service, community empowerment, and local leadership.
        </p>
    </div>
</section>

<?php if ($featured): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h6 class="text-warning fw-bold text-uppercase">Top Highlight</h6>
            <h2 class="fw-bold">Featured Story</h2>
        </div>

        <div class="card border-0 shadow-lg overflow-hidden rounded-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-7">
                    <img src="assets/images/news/<?php echo htmlspecialchars($featured['image']); ?>" 
                         class="img-fluid w-100 featured-news-img" 
                         alt="<?php echo htmlspecialchars($featured['title']); ?>">
                </div>
                <div class="col-lg-5 p-4 p-md-5">
                    <div class="d-flex align-items-center gap-3 mb-3 text-muted small">
                        <span><i class="far fa-calendar-alt text-warning me-1"></i> <?php echo date("M d, Y", strtotime($featured['created_at'])); ?></span>
                        <span>&bull;</span>
                        <span><i class="far fa-user text-warning me-1"></i> <?php echo htmlspecialchars($featured['author']); ?></span>
                    </div>

                    <h2 class="fw-bold text-navy mb-3 display-6">
                        <?php echo htmlspecialchars($featured['title']); ?>
                    </h2>

                    <p class="text-secondary line-clamp-3 mb-4">
                        <?php echo substr(strip_tags($featured['content']), 0, 220); ?>...
                    </p>

                    <a href="news-details.php?id=<?php echo $featured['id']; ?>" class="btn btn-warning rounded-pill px-4 py-2 fw-semibold">
                        Read Full Story <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-5">
    <div class="container py-4">
        <div class="section-title text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase">Stay Informed</h6>
            <h2 class="fw-bold">Recent Updates</h2>
        </div>

        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($newsQuery)): ?>
                <div class="col-lg-4 col-md-6">
                    <article class="card h-100 border-0 shadow-sm news-card rounded-4">
                        <div class="news-img-wrapper">
                            <img src="assets/images/news/<?php echo htmlspecialchars($row['image']); ?>" 
                                 class="card-img-top news-img" 
                                 alt="<?php echo htmlspecialchars($row['title']); ?>">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                <span><i class="far fa-calendar-alt me-1"></i> <?php echo date("M d, Y", strtotime($row['created_at'])); ?></span>
                                <span>&bull;</span>
                                <span><i class="far fa-user me-1"></i> <?php echo htmlspecialchars($row['author']); ?></span>
                            </div>

                            <h4 class="card-title fw-bold text-navy h5 my-2">
                                <a href="news-details.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-navy">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                            </h4>

                            <p class="card-text text-secondary small line-clamp-3 mb-4">
                                <?php echo substr(strip_tags($row['content']), 0, 140); ?>...
                            </p>

                            <div class="mt-auto">
                                <a href="news-details.php?id=<?php echo $row['id']; ?>" class="text-primary fw-bold text-decoration-none read-more-link">
                                    Read Article <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="newsletter-section py-5 position-relative">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white">
                <i class="fas fa-paper-plane fa-3x mb-3 text-warning"></i>
                <h2 class="fw-bold mb-2">Stay Updated</h2>
                <p class="text-white-50 mb-4 max-w-600 mx-auto">
                    Subscribe to receive monthly updates on Rotary Club of Isolo Metro projects, events, and community initiatives.
                </p>

                <form class="row g-2 justify-content-center">
                    <div class="col-md-7">
                        <input type="email" class="form-control form-control-lg border-0 shadow-none px-4 rounded-pill" placeholder="Enter your email address" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning btn-lg w-100 rounded-pill fw-bold">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>