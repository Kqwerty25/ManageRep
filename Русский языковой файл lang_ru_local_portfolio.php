<?php
/**
 * Русские строки для local_portfolio
 *
 * @package    local_portfolio
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Электронное портфолио';
$string['portfolio'] = 'Портфолио';
$string['manageportfolio'] = 'Управление портфолио';

// Поля формы
$string['title'] = 'Заголовок';
$string['category'] = 'Категория';
$string['description'] = 'Описание';
$string['status'] = 'Статус';
$string['save'] = 'Сохранить';
$string['cancel'] = 'Отмена';
$string['edit'] = 'Редактировать';
$string['delete'] = 'Удалить';
$string['view'] = 'Просмотреть';
$string['actions'] = 'Действия';
$string['created'] = 'Создано';
$string['modified'] = 'Изменено';

// Опции статуса
$string['status_draft'] = 'Черновик';
$string['status_published'] = 'Опубликовано';

// Заголовки страниц
$string['addachievement'] = 'Добавить достижение';
$string['editachievement'] = 'Редактировать достижение';
$string['myachievements'] = 'Мои достижения';
$string['achievementadded'] = 'Достижение успешно добавлено';
$string['achievementupdated'] = 'Достижение успешно обновлено';
$string['achievementdeleted'] = 'Достижение успешно удалено';

// Категории
$string['selectcategory'] = 'Выберите категорию';
$string['categoryname'] = 'Название категории';
$string['addcategory'] = 'Добавить категорию';
$string['editcategory'] = 'Редактировать категорию';

// Сообщения
$string['noachievements'] = 'Пока нет достижений';
$string['noachievementsdesc'] = 'Вы еще не добавили ни одного достижения в свое портфолио. Начните с добавления первого достижения!';
$string['addfirstachievement'] = 'Добавить первое достижение';
$string['confirmdelete'] = 'Вы уверены, что хотите удалить это достижение? Это действие нельзя отменить.';
$string['confirmdeletecategory'] = 'Вы уверены, что хотите удалить эту категорию? Все достижения в этой категории будут перемещены в "Без категории".';

// Ошибки
$string['errortitleshort'] = 'Заголовок должен содержать не менее 3 символов';
$string['errorcategorynotfound'] = 'Выбранная категория не найдена';
$string['errornotfound'] = 'Достижение не найдено';
$string['errornopermission'] = 'У вас нет прав для выполнения этого действия';
$string['errordatabase'] = 'Произошла ошибка базы данных';
$string['errornotloggedin'] = 'Вы должны быть авторизованы для выполнения этого действия';

// Права доступа
$string['portfolio:manage'] = 'Управление личным портфолио';
$string['portfolio:view'] = 'Просмотр портфолио';
$string['portfolio:add'] = 'Добавление достижений в портфолио';
$string['portfolio:edit'] = 'Редактирование достижений портфолио';
$string['portfolio:delete'] = 'Удаление достижений портфолио';

// События
$string['evententrycreated'] = 'Запись портфолио создана';
$string['evententryupdated'] = 'Запись портфолио обновлена';
$string['evententrydeleted'] = 'Запись портфолио удалена';
$string['evententryviewed'] = 'Запись портфолио просмотрена';

// Навигация
$string['portfolionav'] = 'Портфолио';
$string['myportfolio'] = 'Мое портфолио';
$string['allportfolios'] = 'Все портфолио';

// Настройки
$string['settingsheader'] = 'Настройки портфолио';
$string['enabled'] = 'Включить портфолио';
$string['enabled_desc'] = 'Включить функционал электронного портфолио';
$string['maxfilesize'] = 'Максимальный размер файла';
$string['maxfilesize_desc'] = 'Максимальный размер загружаемых файлов в портфолио (в МБ)';
$string['allowedfiletypes'] = 'Разрешенные типы файлов';
$string['allowedfiletypes_desc'] = 'Список разрешенных расширений файлов через запятую (например, pdf,doc,docx,jpg,png)';

// Пагинация
$string['pagination'] = 'Пагинация';
$string['previous'] = 'Предыдущая';
$string['next'] = 'Следующая';
$string['first'] = 'Первая';
$string['last'] = 'Последняя';
$string['page'] = 'Страница';
$string['of'] = 'из';

// Подсказки
$string['title_help'] = 'Введите описательный заголовок для вашего достижения (3-255 символов)';
$string['category_help'] = 'Выберите категорию для вашего достижения. Вы можете создавать новые категории в разделе управления категориями.';
$string['description_help'] = 'Предоставьте подробное описание вашего достижения. Вы можете использовать инструменты форматирования и добавлять изображения при необходимости.';
$string['status_help'] = 'Выберите, опубликовано ли это достижение (видно другим) или находится в черновике (видно только вам).';

// Сообщения валидации
$string['required'] = 'Это поле обязательно для заполнения';
$string['maximumchars'] = 'Максимум {$a} символов';
$string['minimumchars'] = 'Минимум {$a} символов';

// Сообщения об успехе
$string['successadd'] = 'Достижение успешно добавлено';
$string['successupdate'] = 'Достижение успешно обновлено';
$string['successdelete'] = 'Достижение успешно удалено';
$string['successcategoryadd'] = 'Категория успешно добавлена';
$string['successcategoryupdate'] = 'Категория успешно обновлена';
$string['successcategorydelete'] = 'Категория успешно удалена';

// Уведомления по email
$string['emailnewachievement_subject'] = 'Новое достижение добавлено в портфолио';
$string['emailnewachievement_body'] = 'Здравствуйте, {$a->fullname},

Вы успешно добавили новое достижение в свое портфолио:

Заголовок: {$a->title}
Категория: {$a->category}
Статус: {$a->status}

Вы можете просмотреть свое достижение здесь: {$a->viewurl}

С уважением,
Система портфолио';

// Отчеты
$string['reporttitle'] = 'Отчет по портфолио';
$string['totalachievements'] = 'Всего достижений';
$string['publishedachievements'] = 'Опубликованных достижений';
$string['draftachievements'] = 'Черновиков достижений';
$string['achievementsbycategory'] = 'Достижения по категориям';
$string['recentachievements'] = 'Последние достижения';

// Экспорт
$string['export'] = 'Экспорт';
$string['exportpdf'] = 'Экспорт в PDF';
$string['exportcsv'] = 'Экспорт в CSV';
$string['exportall'] = 'Экспортировать все достижения';
$string['exportselected'] = 'Экспортировать выбранные достижения';

// Импорт
$string['import'] = 'Импорт';
$string['importfile'] = 'Импорт из файла';
$string['importinstructions'] = 'Выберите CSV файл с достижениями для импорта';

// Статистика
$string['statistics'] = 'Статистика';
$string['achievementscount'] = 'Количество достижений';
$string['categoriescount'] = 'Количество категорий';
$string['lastupdate'] = 'Последнее обновление';
$string['averagerating'] = 'Средний рейтинг';

// Поиск
$string['search'] = 'Поиск достижений';
$string['searchplaceholder'] = 'Поиск по заголовку или описанию...';
$string['searchresults'] = 'Результаты поиска';
$string['nomatches'] = 'Совпадений не найдено';

// Фильтры
$string['filter'] = 'Фильтр';
$string['filterbycategory'] = 'Фильтр по категории';
$string['filterbystatus'] = 'Фильтр по статусу';
$string['filterbydate'] = 'Фильтр по дате';
$string['clearfilters'] = 'Очистить фильтры';

// Сортировка
$string['sort'] = 'Сортировка';
$string['sortbytitle'] = 'Сортировать по заголовку';
$string['sortbydate'] = 'Сортировать по дате';
$string['sortbycategory'] = 'Сортировать по категории';
$string['sortasc'] = 'По возрастанию';
$string['sortdesc'] = 'По убыванию';