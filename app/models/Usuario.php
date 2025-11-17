<?php
require_once __DIR__ . '/../core/Database.php';

class Usuario
{
    private static $storage = __DIR__ . '/../data/users.json';

    private static function ensureStorage()
    {
        $dir = dirname(self::$storage);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        if (!file_exists(self::$storage)) file_put_contents(self::$storage, json_encode([]));
    }

    private static function getMysqli()
    {
        return Database::getConnection();
    }

    public static function findByEmail($email)
    {
        $mysqli = self::getMysqli();
        if ($mysqli) {
            $stmt = $mysqli->prepare("
                SELECT u.*, r.nombre AS rol_nombre
                FROM usuarios u
                LEFT JOIN roles r ON u.rol_id = r.id
                WHERE u.email = ?
                LIMIT 1
            ");

            if (!$stmt) {
                error_log("Error en prepare: " . $mysqli->error);
                return null;
            }

            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row) return $row;
            return null;
        }

        // Fallback JSON
        self::ensureStorage();
        $all = json_decode(file_get_contents(self::$storage), true) ?: [];
        foreach ($all as $u) {
            if (isset($u['email']) && $u['email'] === $email) {
                if (!isset($u['rol_id'])) $u['rol_id'] = 2;
                $u['rol_nombre'] = ($u['rol_id'] == 1 ? 'admin' : 'usuario');
                return $u;
            }
        }
        return null;
    }

    public static function create($username, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $mysqli = self::getMysqli();
        $rol_id = 2;

        if ($mysqli) {
            $stmt = $mysqli->prepare("
                INSERT INTO usuarios (username, email, password, rol_id, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");

            if (!$stmt) {
                error_log("Error en prepare: " . $mysqli->error);
                return null;
            }

            $stmt->bind_param('sssi', $username, $email, $hash, $rol_id);
            $stmt->execute();
            $id = $mysqli->insert_id;
            $stmt->close();

            return [
                'id' => $id,
                'username' => $username,
                'email' => $email,
                'password' => $hash,
                'rol_id' => $rol_id,
                'rol_nombre' => 'usuario',
                'created_at' => date('c')
            ];
        }

        self::ensureStorage();
        $all = json_decode(file_get_contents(self::$storage), true) ?: [];
        $id = (count($all) ? intval(end($all)['id']) : 0) + 1;

        $user = [
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'password' => $hash,
            'rol_id' => $rol_id,
            'rol_nombre' => 'usuario',
            'created_at' => date('c')
        ];

        $all[] = $user;
        file_put_contents(self::$storage, json_encode($all, JSON_PRETTY_PRINT));
        return $user;
    }

    public static function verifyCredentials($email, $password)
{
    $conn = Database::getConnection();

    if (!$conn) return false;

    // Buscar usuario por email
    $stmt = $conn->prepare("SELECT u.*, r.nombre AS rol_nombre 
                            FROM usuarios u 
                            INNER JOIN roles r ON u.rol_id = r.id
                            WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verificar contraseña con password_verify
        if (password_verify($password, $usuario['password'])) {
            return $usuario;
        }
    }

    return false;
}


    public static function migrateToDb()
    {
        $mysqli = self::getMysqli();
        if (!$mysqli) return 0;

        self::ensureStorage();
        $all = json_decode(file_get_contents(self::$storage), true) ?: [];
        $count = 0;

        foreach ($all as $u) {
            $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
            if (!$stmt) continue;

            $stmt->bind_param('s', $u['email']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();
                continue;
            }
            $stmt->close();

            $rol_id = isset($u['rol_id']) ? intval($u['rol_id']) : 2;
            $createdAt = isset($u['created_at']) ? $u['created_at'] : date('c');

            $stmt = $mysqli->prepare("
                INSERT INTO usuarios (username, email, password, rol_id, created_at)
                VALUES (?, ?, ?, ?, ?)
            ");
            if (!$stmt) continue;

            $stmt->bind_param('sssis', $u['username'], $u['email'], $u['password'], $rol_id, $createdAt);
            $stmt->execute();
            $stmt->close();
            $count++;
        }

        return $count;
    }
}

