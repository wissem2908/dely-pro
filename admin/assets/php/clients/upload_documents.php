<?php
session_start();
include_once './../config.php';

header('Content-Type: application/json');

$userId = null;
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $userId = $_POST['id'];
} else {
    $userId = $_SESSION['user_id'];
}


try {
    $bdd = new PDO(
        "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // $userId = $_SESSION['user_id'];

    /* ===================== CONFIG ===================== */

    $allowedExt = ['pdf', 'jpg', 'jpeg', 'png'];
    $fields = ['piece_identite', 'extrait_naissance'];

    /* ===================== GET REFERENCE ===================== */

    $req = $bdd->prepare("SELECT reference FROM delypro_inscriptions WHERE id = ?");
    $req->execute([$userId]);
    $row = $req->fetch(PDO::FETCH_ASSOC);

    if (!$row || empty($row['reference'])) {
        throw new Exception("Référence introuvable");
    }

    $reference = $row['reference'];

    /* ===================== DIRECTORIES ===================== */
$referenceDir = "../../../../assets/uploads/files_uploads/" . $reference . "/";
   // $baseDir = __DIR__ . "/../../uploads/files_uploads/";
  //  $referenceDir = $baseDir . $reference . "/";

    if (!is_dir($referenceDir)) {
        mkdir($referenceDir, 0777, true);
    }

    /* ===================== UPLOAD LOOP ===================== */

    foreach ($fields as $field) {

        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            continue;
        }

        $extension = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowedExt)) {
            throw new Exception("Format non autorisé : $field");
        }

        /* ===== DELETE OLD FILE OF SAME TYPE ONLY ===== */

        $old = $bdd->prepare("
            SELECT filename, file_path
            FROM delypro_documents
            WHERE inscription_id = ?
              AND document_type = ?
            LIMIT 1
        ");
        $old->execute([$userId, $field]);
        $oldFile = $old->fetch(PDO::FETCH_ASSOC);

        if ($oldFile) {
            $oldPath = $oldFile['file_path'] . $oldFile['filename'];
            if (file_exists($oldPath)) {
                unlink($oldPath); // deletes ONLY this file
            }

            $bdd->prepare("
                DELETE FROM delypro_documents
                WHERE inscription_id = ?
                  AND document_type = ?
            ")->execute([$userId, $field]);
        }

        /* ===== CREATE NEW FILE ===== */

        $filename = strtoupper($field) . "_" . $userId . "_" . time() . "." . $extension;
        $destination = $referenceDir . $filename;

        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $destination)) {
            throw new Exception("Échec upload : $field");
        }

        /* ===== INSERT DB RECORD ===== */

        $insert = $bdd->prepare("
            INSERT INTO delypro_documents
            (inscription_id, reference, document_type, filename, file_path, file_extension, file_size)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $insert->execute([
            $userId,
            $reference,
            $field,
            $filename,
            $referenceDir,
            $extension,
            $_FILES[$field]['size']
        ]);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Fichiers téléchargés avec succès'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
