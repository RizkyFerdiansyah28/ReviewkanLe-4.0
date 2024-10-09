<?php 
session_start();
include 'layout/header.php';

if(!isset($_SESSION["login"])){
    echo "<script>alert('anda belum login');
    document.location.href = 'login.php';
    </script>";
}

if (isset($_GET['user_id'])) {
    $user_id = (int)$_GET['user_id'];
} else {
    echo "<script>
            alert('ID user tidak ditemukan');
            document.location.href = 'index.php';
          </script>";
    exit;
}
$user = select("SELECT * FROM users WHERE user_id = $user_id")[0];

usort($data_review, function($a, $b) {
    return $b['rating'] <=> $a['rating'];
});

// Limiting to the top 3 reviews
$top_reviews = array_slice($data_review, 0, 3);
?>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0f2f5;
        }


        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
        }

        .profile-name {
            font-size: 1.8rem;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .profile-bio {
            color: #666;
            margin-bottom: 1rem;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1a1a1a;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .recent-reviews {
            margin-top: 2rem;
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .review-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .movie-poster {
            width: 100px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .review-content {
            flex: 1;
        }

        .movie-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .review-text {
            color: #444;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .review-meta {
            color: #666;
            font-size: 0.9rem;
        }

        .rating {
            color: #ffd700;
            font-weight: bold;
        }
    </style>


    <div class="container">
        <div class="profile-header">
            <img src="./foto/foto-profil/SCMamimi.png" alt="Foto Profil" class="profile-picture">
            <h1 class="profile-name"><?= $user['username']; ?></h1>
            <p class="profile-bio">Pencinta film dari Indonesia</p>
        </div>
        
        <div class="recent-reviews">
            <?php foreach ($top_reviews as $review) : ?>
            <h2>Review Terbaru</h2>
            <div class="review-item">
                <img src="./foto/foto-film/<?= $review['foto_film']; ?>" alt="Film Poster 1" class="movie-poster">
                <div class="review-content">
                    <h3 class="movie-title"><?= $review['judul_film']; ?></h3>
                    <p class="review-text"><?= $review['ulasan']; ?></p>
                    <p class="review-meta">Rating: <span class="rating"><?= $review['rating']; ?></span><br> <?= date('d F Y', strtotime($review['tanggal'])); ?></p>
                </div>
            </div>
            
            <?php  endforeach; ?>
        </div>
    </div>