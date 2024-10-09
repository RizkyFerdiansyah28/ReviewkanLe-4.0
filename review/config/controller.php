<?php 

    //menampilkaan data dari DB
    function select($query)
    {
        // Panggil Database
        global $db;

        $result = mysqli_query($db, $query);
        $rows = [];

        while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
        }

        return $rows;
    }

    //menambahkan review
    function create_review($post)
    {
        global $db;

        $judul  = $post['judul'];
        $genre  = $post['genre'];
        $ulasan = $post['ulasan'];
        $rating = $post['rating'];
        $foto_film = upload_fotoFilm();
        
        //cek foto
        if (!$foto_film){
            return false;
        }
        //query tambah data
        $query = "INSERT INTO review_film VALUES(null, '$judul', CURRENT_TIMESTAMP(),'$genre', '$ulasan', '$rating', '$foto_film')";

        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }

    //mengubah review
    function update_review($post)
    {
        global $db;

        $id_review = $post['id_review'];
        $judul  = $post['judul'];
        $genre  = $post['genre'];
        $ulasan = $post['ulasan'];
        $rating = $post['rating'];
        $foto_film_lama = $post['foto_film_lama'];

        //cek foto
        if ($_FILES['foto_film']['error'] == 4){
            $foto_film = $foto_film_lama;
        } else {
            $foto_film = upload_fotoFilm();
        }

        //query ubah data
        $query = "UPDATE review_film SET judul_film = '$judul', genre = '$genre', ulasan ='$ulasan', rating ='$rating', foto_film = '$foto_film' WHERE id_review = $id_review";

        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }

     //upload foto
     function upload_fotoFilm()
     {
         $nama_FotoFilm = $_FILES['foto_film']['name'];
         $ukuran_FotoFilm = $_FILES['foto_film']['size'];
         $error = $_FILES['foto_film']['error'];
         $tmpName = $_FILES['foto_film']['tmp_name'];
 
         //cek file yang diupload
         $extensifileValid = ['jpg', 'jpeg', 'png'];
         $extensifile= explode('.', $nama_FotoFilm);
         $extensifile= strtolower(end($extensifile));
 
         if (!in_array($extensifile, $extensifileValid)){
             //pesan gagal
 
             echo "<script>
                     alert('Format File Salah');
                     document.location.href = 'tambah-review.php';
             </script>";
             die();
         }
 
         //mengubah nama file menjadi nama baru
         $namaFileBaru   = uniqid();
         $namaFileBaru  .= '.';
         $namaFileBaru  .= $extensifile;
 
         //pindah ke folder foto
         move_uploaded_file($tmpName, 'foto/foto-film/'. $namaFileBaru);
         return ($namaFileBaru);
                 
     }
    

    //menghapus review
    function delete_review($id_review){
        global $db;

        //query hapus
        $query = "DELETE FROM review_film WHERE id_review = $id_review";

        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }


function register_user($post)
{
    global $db;

    // Sanitasi input untuk menghindari SQL Injection
    $username = mysqli_real_escape_string($db, $post['username']);
    $password = mysqli_real_escape_string($db, $post['password']);
    $email    = mysqli_real_escape_string($db, $post['email']);

    // Cek apakah email sudah ada
    $check_user = mysqli_query($db, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_fetch_assoc($check_user)) {
        return 0; // Email sudah terdaftar
    }

    // Hash password sebelum disimpan
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk menambahkan user baru
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hashed')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}


?>