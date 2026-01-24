<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Helpers\ToaStr;
use App\Models\Admin\UserModel;
use PDO;

class UserController extends Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/auth");
            exit;
        }
        $this->model = new UserModel($this->db);
    }

    public function index() {
        $data = [
            'title' => __('Manage User'),
            'users' => $this->model->getAllUsers()->fetchAll(PDO::FETCH_ASSOC)
        ];
        $this->view('users', $data, 'admin');
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = (int)$this->input('user_id', 0);
            
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['image/jpeg', 'image/png', 'image/webp'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowed)) {
                    ToaStr::set('error', __('Invalid photo format. Use JPG, PNG or WEBP.'));
                    header("Location: " . BASE_URL . "/admin/user");
                    exit;
                }
            }

            $data = [
                'id_user'      => $userId,
                'username'     => $this->input('username'),
                'role'         => $this->input('role'),
                'nama'         => $this->input('nama_lengkap'),
                'current_foto' => $this->input('current_foto')
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }

            if ($this->model->save($data, $_FILES['foto'] ?? null)) {
                ToaStr::set('success', $userId > 0 ? __('User updated successfully') : __('User created successfully'));
            } else {
                ToaStr::set('error', __('Failed to save user data'));
            }

            header("Location: " . BASE_URL . "/admin/user");
            exit;
        }
    }

    public function delete($id) {
        $id = (int)$id;
        if ($id === (int)$_SESSION['admin_id']) {
            ToaStr::set('warning', __('You cannot delete your own account'));
        } else {
            if ($this->model->delete($id)) {
                ToaStr::set('error', __('User has been deleted'));
            }
        }
        header("Location: " . BASE_URL . "/admin/user");
        exit;
    }
}