<?php
/**
 * Форма для добавления/редактирования достижений в портфолио
 *
 * @package    local_portfolio
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

/**
 * Класс формы для работы с достижениями портфолио
 */
class portfolio_entry_form extends moodleform {

    /**
     * Определение формы
     */
    public function definition() {
        global $DB;

        $mform = $this->_form;
        $customdata = $this->_customdata;
        
        // Скрытое поле для ID записи (если редактирование)
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        
        // Заголовок достижения
        $mform->addElement('text', 'title', get_string('title', 'local_portfolio'), 
            array('size' => 50, 'maxlength' => 255));
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', get_string('required'), 'required', null, 'client');
        $mform->addRule('title', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('title', 'title', 'local_portfolio');
        
        // Категория достижения
        $categories = $this->get_categories();
        $mform->addElement('select', 'catid', get_string('category', 'local_portfolio'), $categories);
        $mform->setType('catid', PARAM_INT);
        $mform->addRule('catid', get_string('required'), 'required', null, 'client');
        $mform->addHelpButton('catid', 'category', 'local_portfolio');
        
        // Описание достижения
        $mform->addElement('editor', 'description', get_string('description', 'local_portfolio'), 
            array('rows' => 10));
        $mform->setType('description', PARAM_RAW);
        $mform->addRule('description', get_string('required'), 'required', null, 'client');
        $mform->addHelpButton('description', 'description', 'local_portfolio');
        
        // Статус достижения
        $statusoptions = array(
            0 => get_string('status_draft', 'local_portfolio'),
            1 => get_string('status_published', 'local_portfolio')
        );
        $mform->addElement('select', 'status', get_string('status', 'local_portfolio'), $statusoptions);
        $mform->setType('status', PARAM_INT);
        $mform->setDefault('status', 0);
        $mform->addHelpButton('status', 'status', 'local_portfolio');
        
        // Кнопки отправки формы
        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('save', 'local_portfolio'));
        $buttonarray[] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');
    }

    /**
     * Валидация данных формы
     *
     * @param array $data данные формы
     * @param array $files файлы
     * @return array ошибки валидации
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        
        // Проверка длины заголовка
        if (strlen(trim($data['title'])) < 3) {
            $errors['title'] = get_string('errortitleshort', 'local_portfolio');
        }
        
        // Проверка существования категории
        if (!empty($data['catid'])) {
            global $DB;
            if (!$DB->record_exists('local_portfolio_categories', array('id' => $data['catid']))) {
                $errors['catid'] = get_string('errorcategorynotfound', 'local_portfolio');
            }
        }
        
        return $errors;
    }

    /**
     * Получение списка категорий
     *
     * @return array массив категорий
     */
    private function get_categories() {
        global $DB, $USER;
        
        $categories = array(0 => get_string('selectcategory', 'local_portfolio'));
        
        // Получаем категории текущего пользователя
        $records = $DB->get_records('local_portfolio_categories', 
            array('userid' => $USER->id), 'name ASC');
        
        foreach ($records as $record) {
            $categories[$record->id] = format_string($record->name);
        }
        
        return $categories;
    }

    /**
     * Загрузка данных в форму
     *
     * @param stdClass $defaultvalues значения по умолчанию
     */
    public function set_data($defaultvalues) {
        // Обработка описания для редактора
        if (isset($defaultvalues->description)) {
            $defaultvalues->description = array(
                'text' => $defaultvalues->description,
                'format' => FORMAT_HTML
            );
        }
        
        parent::set_data($defaultvalues);
    }
}