<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Admin\WidgetModel;
use Exception;
use PDO;

class WidgetController extends Controller {
    private $model;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['admin_logged_in'])) {
            header("Location: " . BASE_URL . "/auth");
            exit;
        }
        $this->model = new WidgetModel($this->db);
    }

    public function index() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->syncWidgets();
        
        $res = $this->model->getAll();
        $all = $res->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title'             => __('Widget Manager'),
            'current_page'      => 'widget',
            'library'           => $all,
            'savedLayout'       => $this->model->getSavedLayout('homepage_layout'),
            'savedFooterLayout' => $this->model->getSavedLayout('footer_layout'),
            'error_message'     => $this->model->getErrorMessage()
        ];
        
        $this->view('widgets_manager', $data, 'admin');
    }

    private function syncWidgets() {
        $path = BASE_PATH . '/widgets/*.php';
        $res = $this->model->getAll();
        $dbWidgets = [];

        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $dbWidgets[] = $row['widget_type'];
        }

        foreach (glob($path) as $file) {
            $type = basename($file, '.php');

            if (!in_array($type, $dbWidgets)) {
                $content = file_get_contents($file);
                preg_match('/Widget Name:\s*(.*)$/mi', $content, $nameMatch);
                preg_match('/Widget Category:\s*(.*)$/mi', $content, $catMatch);
                preg_match('/Widget Description:\s*(.*)$/mi', $content, $descMatch);
                
                $name = isset($nameMatch[1]) ? trim($nameMatch[1]) : ucfirst($type);
                $category = isset($catMatch[1]) ? trim($catMatch[1]) : 'General';
                $description = isset($descMatch[1]) ? trim($descMatch[1]) : '';
                $config_raw = '';
                if (preg_match('/Widget Config:\s*(\{[\s\S]*?\})\s*\*/i', $content, $configMatch)) {
                    $config_raw = $configMatch[1];
                }

                if (method_exists($this->model, 'register')) {
                    $this->model->register($type, $name, $category, $description, $config_raw);
                }
            }
        }
    }

    public function getWidgetData() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $is_instance = isset($_GET['is_instance']) && 
                       ($_GET['is_instance'] === 'true' || $_GET['is_instance'] === '1' || $_GET['is_instance'] === 1);
        $widget_type = $_GET['widget_type'] ?? '';

        $res = $this->model->getWidgetContent($id, $is_instance);

        $config_template = [];
        if (!empty($widget_type)) {
            $file_path = BASE_PATH . '/widgets/' . $widget_type . '.php';
            if (file_exists($file_path)) {
                $file_content = file_get_contents($file_path);
                if (preg_match('/Config:\s*(\{.*?\})/s', $file_content, $matches)) {
                    $config_template = json_decode($matches[1], true);
                }
            }
        }

        if ($res) {
            echo json_encode([
                'success' => true, 
                'data' => $res,
                'config_template' => $config_template 
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => __('Data not found')]);
        }
        exit;
    }

    public function updateCustomWidget() {
        header('Content-Type: application/json');
        try {
            $id = intval($_POST['id']);
            $title = $_POST['title'] ?? 'Untitled';
            $new_values_json = $_POST['content'] ?? '{}';
            $widget_type = $_POST['widget_type'] ?? '';
            $is_instance = ($_POST['is_instance'] === 'true' || $_POST['is_instance'] === '1');
            $show_title = isset($_POST['show_title']) ? intval($_POST['show_title']) : 1;

            $master_data = $this->model->getMasterContentByType($widget_type);
            if (!$master_data) {
                $master_data = $this->model->getWidgetContent($id, false);
            }

            $master_content = $master_data['content'] ?? '{}';
            $decoded_schema = json_decode($master_content, true);
            $decoded_new_values = json_decode($new_values_json, true);

            $final_content = $new_values_json;

            if (is_array($decoded_schema) && is_array($decoded_new_values)) {
                $first_item = reset($decoded_schema);
                if (is_array($first_item) && isset($first_item['type'])) {
                    foreach ($decoded_schema as $key => $config) {
                        if (isset($decoded_new_values[$key])) {
                            $decoded_schema[$key]['default'] = $decoded_new_values[$key];
                        }
                    }
                    $final_content = json_encode($decoded_schema);
                }
            }

            if ($is_instance) {
                $this->model->updateInstance($id, $title, $final_content, $show_title);
                $new_id = $id;
            } else {
                $new_id = $this->model->createInstance($id, $title, $final_content, $show_title);
            }

            echo json_encode(['success' => true, 'new_id' => $new_id]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function saveRecursiveLayout() {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        try {
            $token = $_POST['csrf_token'] ?? '';
            if ($token !== $_SESSION['csrf_token']) throw new Exception(__('Invalid CSRF Token'));

            $layout = $_POST['layout'] ?? '[]';
            $target = $_POST['target'] ?? 'home';
            $setting_name = ($target === 'footer') ? 'footer_layout' : 'homepage_layout';

            $this->model->saveCompleteLayout($layout, $setting_name);
            
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function preview() {
        $layoutRaw = $_POST['layout_data'] ?? '[]';
        $data = [
            'title'  => __('Preview'),
            'layout' => json_decode($layoutRaw, true) ?: []
        ];
        $this->view('widgets_preview', $data, 'blank');
    }   

    public function deleteWidgetInstance() {
        header('Content-Type: application/json');
        try {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $is_instance = isset($_POST['is_instance']) && ($_POST['is_instance'] === 'true' || $_POST['is_instance'] === '1');

            if ($is_instance && $id > 0) {
                $this->model->deleteInstance($id);
                echo json_encode(['success' => true, 'message' => __('Instance deleted permanently')]);
            } else {
                echo json_encode(['success' => true, 'message' => __('Removed from layout')]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}