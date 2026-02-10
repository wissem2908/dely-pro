<?php
session_start();
header('Content-Type: application/json');

require_once '../config.php'; // adapte si besoin

try {

    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Sécurité : admin uniquement
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode([
            'response' => false,
            'message'  => 'Accès refusé'
        ]);
        exit;
    }

    // Vérification des champs obligatoires
    if (empty($_POST['title']) || empty($_POST['description'])) {
        echo json_encode([
            'response' => false,
            'message'  => 'Champs obligatoires manquants'
        ]);
        exit;
    }

    // Image obligatoire
    if (!isset($_FILES['document']) || $_FILES['document']['error'] === UPLOAD_ERR_NO_FILE) {
        echo json_encode([
            'response' => false,
            'message'  => 'Le document est obligatoire'
        ]);
        exit;
    }
    $title       = trim($_POST['title']);
    $description = $_POST['description'];
    $date        = date('Y-m-d'); // date du jour

    $imageName   = null;

/*********************************************  generate slug  ********************************************************** */
//     function generateSlug($text) {
//     // Convert accents → ASCII
//     $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

//     // Lowercase
//     $text = strtolower($text);

//     // Replace non letters/numbers with -
//     $text = preg_replace('/[^a-z0-9]+/i', '-', $text);

//     // Trim -
//     $text = trim($text, '-');

//     return $text ?: 'news';
// }



// function makeUniqueSlug($bdd, $slug) {
//     $baseSlug = $slug;
//     $i = 1;

//     while (true) {
//         $stmt = $bdd->prepare("SELECT COUNT(*) FROM news WHERE slug = ?");
//         $stmt->execute([$slug]);

//         if ($stmt->fetchColumn() == 0) {
//             return $slug;
//         }

//         $slug = $baseSlug . '-' . $i;
//         $i++;
//     }
// }

// Generate slug
// $slug = generateSlug($title);
// $slug = makeUniqueSlug($bdd, $slug);
/***************************************************************************************************************************** */





    // Gestion upload image
    if (!empty($_FILES['document']['name'])) {

        $uploadDir = '../../uploads/appels_offres/'; // adapte le chemin
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmp  = $_FILES['document']['tmp_name'];
        $fileSize = $_FILES['document']['size'];
        $fileExt  = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION));

        $allowedExt = ['jpg', 'jpeg', 'png', 'webp','pdf','doc','docx'];

        if (!in_array($fileExt, $allowedExt)) {
            echo json_encode([
                'response' => false,
                'message'  => 'Format document non autorisé'
            ]);
            exit;
        }

            // if ($fileSize > 5 * 1024 * 1024) { // 5MB
            //     echo json_encode([
            //         'response' => false,
            //         'message'  => 'Document trop volumineux'
            //     ]);
            //     exit;
            // }

        // Nom unique
        $imageName = uniqid('offers_', true) . '.' . $fileExt;
        $destination = $uploadDir . $imageName;

        if (!move_uploaded_file($fileTmp, $destination)) {
            echo json_encode([
                'response' => false,
                'message'  => 'Erreur upload image'
            ]);
            exit;
        }
    }

    // Insertion en base
    $sql = "INSERT INTO `appels_offres`(`title`, `description`, `file_path`) VALUES
             (:title,  :description, :image)";

    $stmt = $bdd->prepare($sql);

    $stmt->execute([
        ':title'       => $title,
       
        ':description' => $description,
        ':image'       => $imageName,
       
    ]);

    echo json_encode([
        'response' => true,
        'message'  => 'Appel d\'offres ajouté avec succès'
    ]);
} catch (Exception $e) {

    if (isset($bdd) && $bdd->inTransaction()) {
        $bdd->rollBack();
    }

    http_response_code(500);

    echo json_encode([
        'response' => false,
        'message'  => 'exception',
        'error'    => $e->getMessage()
    ]);
}
