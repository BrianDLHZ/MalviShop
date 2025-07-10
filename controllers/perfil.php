<?php
// malvishop/controllers/perfil.php

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . $baseUrl . '/login');
    exit();
}

$usuario_id = $_SESSION['user_id'];
$errors = [];
$success_message = '';

//  Si se envía el formulario para actualizar 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si se apreto el botón "guardar datos"
    if (isset($_POST['update_personal_data'])) {
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $codigo_postal = trim($_POST['codigo_postal'] ?? '');
        $descripcion_fachada = trim($_POST['descripcion_fachada'] ?? '');

        if (empty($errors)) {
            $db->query(
                "UPDATE usuarios SET telefono = :telefono, direccion = :direccion, codigo_postal = :cp, descripcion_fachada = :fachada WHERE id = :id",
                [
                    'telefono' => $telefono,
                    'direccion' => $direccion,
                    'cp' => $codigo_postal,
                    'fachada' => $descripcion_fachada,
                    'id' => $usuario_id
                ]
            );
            $success_message = '¡Tus datos personales han sido actualizados!';
        }
    }

    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
            $user_data = $db->query("SELECT password FROM usuarios WHERE id = :id", ['id' => $usuario_id])->fetch();

            if (!$user_data || !password_verify($current_password, $user_data['password'])) {
                $errors['password'] = 'La contraseña actual es incorrecta.';
            } elseif (strlen($new_password) < 8) {
                $errors['password'] = 'La nueva contraseña debe tener al menos 8 caracteres.';
            } elseif ($new_password !== $confirm_password) {
                $errors['password'] = 'La nueva contraseña y su confirmación no coinciden.';
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $db->query("UPDATE usuarios SET password = :password WHERE id = :id", [
                    'password' => $hashed_password,
                    'id' => $usuario_id
                ]);
                $success_message = '¡Tu contraseña ha sido cambiada con éxito!';
            }
        } else {
            $errors['password'] = 'Debes completar todos los campos para cambiar la contraseña.';
        }
    }

    if (isset($_POST['delete_photo'])) {
        $foto_actual = $db->query("SELECT foto_perfil FROM usuarios WHERE id = :id", ['id' => $usuario_id])->fetchColumn();

        if ($foto_actual && $foto_actual !== 'default.png') {
            $foto_path = BASE_PATH . '/public/images/users/' . $foto_actual;

            if (file_exists($foto_path)) {
                unlink($foto_path);
            }

            $db->query("UPDATE usuarios SET foto_perfil = NULL WHERE id = :id", ['id' => $usuario_id]);
            $_SESSION['user_foto'] = null;

            $success_message = 'Tu foto de perfil fue eliminada correctamente.';
        } else {
            
        }
    }

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['foto_perfil'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowed_types)) {
            $errors['foto'] = 'Formato de imagen no válido. Solo se permite JPG, PNG o GIF.';
        } elseif ($file['size'] > $max_size) {
            $errors['foto'] = 'La imagen es demasiado grande. El máximo es 5MB.';
        } else {
            $old_photo = $db->query("SELECT foto_perfil FROM usuarios WHERE id = :id", ['id' => $usuario_id])->fetchColumn();

            $filename = 'user_' . $usuario_id . '_' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $target_path = BASE_PATH . '/public/images/users/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $target_path)) {
                $db->query("UPDATE usuarios SET foto_perfil = :foto WHERE id = :id", [
                    'foto' => $filename,
                    'id' => $usuario_id
                ]);

                if ($old_photo && $old_photo !== 'default.png' && file_exists(BASE_PATH . '/public/images/users/' . $old_photo)) {
                    unlink(BASE_PATH . '/public/images/users/' . $old_photo);
                }

                $_SESSION['user_foto'] = $filename;
                $success_message = '¡Foto de perfil actualizada con éxito!';
            } else {
                $errors['foto'] = 'Ocurrió un error al subir tu imagen.';
            }
        }
    }
}

// Obtener datos del usuario actual
$usuario = $db->query("SELECT * FROM usuarios WHERE id = :id", ['id' => $usuario_id])->fetch();

require BASE_PATH . '/views/perfil.php';
