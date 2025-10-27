<?php
require_once __DIR__ . '/../core/Database.php';

class Usuario
{
    // Ruta para almacenamiento simple cuando no hay DB configurada
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
            $stmt = $mysqli->prepare('SELECT * FROM usuarios WHERE email = ? LIMIT 1');
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

        // Fallback JSON si no hay DB
        self::ensureStorage();
        $all = json_decode(file_get_contents(self::$storage), true) ?: [];
        foreach ($all as $u) {
            if (isset($u['email']) && $u['email'] === $email) return $u;
        }
        return null;
    }

    public static function create($username, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $mysqli = self::getMysqli();
        if ($mysqli) {
            $stmt = $mysqli->prepare('INSERT INTO usuarios (username, email, password, created_at) VALUES (?, ?, ?, NOW())');
            if (!$stmt) {
                error_log("Error en prepare: " . $mysqli->error);
                return null;
            }
            $stmt->bind_param('sss', $username, $email, $hash);
            $stmt->execute();
            $id = $mysqli->insert_id;
            $stmt->close();
            return ['id' => $id, 'username' => $username, 'email' => $email, 'password' => $hash, 'created_at' => date('c')];
        }

        // Fallback JSON
        self::ensureStorage();
        $all = json_decode(file_get_contents(self::$storage), true) ?: [];
        $id = (count($all) ? intval(end($all)['id']) : 0) + 1;
        $user = ['id' => $id, 'username' => $username, 'email' => $email, 'password' => $hash, 'created_at' => date('c')];
        $all[] = $user;
        file_put_contents(self::$storage, json_encode($all, JSON_PRETTY_PRINT));
        return $user;
    }

    public static function verifyCredentials($email, $password)
    {
        $u = self::findByEmail($email);
        if (!$u) return false;
        if (password_verify($password, $u['password'])) return $u;
        return false;
    }

    // Helper opcional: migrar usuarios JSON a la tabla 'usuarios'
    public static function migrateToDb()
    {
        $mysqli = self::getMysqli();
        if (!$mysqli) return 0;

        self::ensureStorage();
        $all = json_decode(file_get_contents(self::$storage), true) ?: [];
        $count = 0;

        foreach ($all as $u) {
            // comprobar existencia por email
            $stmt = $mysqli->prepare('SELECT id FROM usuarios WHERE email = ?');
            if (!$stmt) continue;
            $stmt->bind_param('s', $u['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $stmt->close();
                continue;
            }
            $stmt->close();

            $stmt = $mysqli->prepare('INSERT INTO usuarios (username, email, password, created_at) VALUES (?, ?, ?, ?)');
            if (!$stmt) continue;
            $createdAt = isset($u['created_at']) ? $u['created_at'] : date('c');
            $stmt->bind_param('ssss', $u['username'], $u['email'], $u['password'], $createdAt);
            $stmt->execute();
            $stmt->close();
            $count++;
        }

        return $count;
    }
}

