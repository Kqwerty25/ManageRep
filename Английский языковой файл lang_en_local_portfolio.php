<?php
/**
 * English strings for local_portfolio
 *
 * @package    local_portfolio
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Electronic Portfolio';
$string['portfolio'] = 'Portfolio';
$string['manageportfolio'] = 'Manage Portfolio';

// Form fields
$string['title'] = 'Title';
$string['category'] = 'Category';
$string['description'] = 'Description';
$string['status'] = 'Status';
$string['save'] = 'Save';
$string['cancel'] = 'Cancel';
$string['edit'] = 'Edit';
$string['delete'] = 'Delete';
$string['view'] = 'View';
$string['actions'] = 'Actions';
$string['created'] = 'Created';
$string['modified'] = 'Modified';

// Status options
$string['status_draft'] = 'Draft';
$string['status_published'] = 'Published';

// Page titles
$string['addachievement'] = 'Add Achievement';
$string['editachievement'] = 'Edit Achievement';
$string['myachievements'] = 'My Achievements';
$string['achievementadded'] = 'Achievement added successfully';
$string['achievementupdated'] = 'Achievement updated successfully';
$string['achievementdeleted'] = 'Achievement deleted successfully';

// Categories
$string['selectcategory'] = 'Select category';
$string['categoryname'] = 'Category name';
$string['addcategory'] = 'Add category';
$string['editcategory'] = 'Edit category';

// Messages
$string['noachievements'] = 'No achievements yet';
$string['noachievementsdesc'] = 'You haven\'t added any achievements to your portfolio yet. Start by adding your first achievement!';
$string['addfirstachievement'] = 'Add first achievement';
$string['confirmdelete'] = 'Are you sure you want to delete this achievement? This action cannot be undone.';
$string['confirmdeletecategory'] = 'Are you sure you want to delete this category? All achievements in this category will be moved to uncategorized.';

// Errors
$string['errortitleshort'] = 'Title must be at least 3 characters long';
$string['errorcategorynotfound'] = 'Selected category not found';
$string['errornotfound'] = 'Achievement not found';
$string['errornopermission'] = 'You don\'t have permission to perform this action';
$string['errordatabase'] = 'Database error occurred';
$string['errornotloggedin'] = 'You must be logged in to perform this action';

// Capabilities
$string['portfolio:manage'] = 'Manage personal portfolio';
$string['portfolio:view'] = 'View portfolio';
$string['portfolio:add'] = 'Add achievements to portfolio';
$string['portfolio:edit'] = 'Edit portfolio achievements';
$string['portfolio:delete'] = 'Delete portfolio achievements';

// Events
$string['evententrycreated'] = 'Portfolio entry created';
$string['evententryupdated'] = 'Portfolio entry updated';
$string['evententrydeleted'] = 'Portfolio entry deleted';
$string['evententryviewed'] = 'Portfolio entry viewed';

// Navigation
$string['portfolionav'] = 'Portfolio';
$string['myportfolio'] = 'My Portfolio';
$string['allportfolios'] = 'All Portfolios';

// Settings
$string['settingsheader'] = 'Portfolio Settings';
$string['enabled'] = 'Enable portfolio';
$string['enabled_desc'] = 'Enable the electronic portfolio functionality';
$string['maxfilesize'] = 'Maximum file size';
$string['maxfilesize_desc'] = 'Maximum size for uploaded files in portfolio (in MB)';
$string['allowedfiletypes'] = 'Allowed file types';
$string['allowedfiletypes_desc'] = 'Comma-separated list of allowed file extensions (e.g., pdf,doc,docx,jpg,png)';

// Pagination
$string['pagination'] = 'Pagination';
$string['previous'] = 'Previous';
$string['next'] = 'Next';
$string['first'] = 'First';
$string['last'] = 'Last';
$string['page'] = 'Page';
$string['of'] = 'of';

// Help texts
$string['title_help'] = 'Enter a descriptive title for your achievement (3-255 characters)';
$string['category_help'] = 'Select a category for your achievement. You can create new categories in the categories management section.';
$string['description_help'] = 'Provide detailed description of your achievement. You can use formatting tools and add images if needed.';
$string['status_help'] = 'Choose whether this achievement is published (visible to others) or draft (visible only to you).';

// Validation messages
$string['required'] = 'This field is required';
$string['maximumchars'] = 'Maximum {$a} characters';
$string['minimumchars'] = 'Minimum {$a} characters';

// Success messages
$string['successadd'] = 'Achievement added successfully';
$string['successupdate'] = 'Achievement updated successfully';
$string['successdelete'] = 'Achievement deleted successfully';
$string['successcategoryadd'] = 'Category added successfully';
$string['successcategoryupdate'] = 'Category updated successfully';
$string['successcategorydelete'] = 'Category deleted successfully';

// Email notifications
$string['emailnewachievement_subject'] = 'New achievement added to portfolio';
$string['emailnewachievement_body'] = 'Hello {$a->fullname},

You have successfully added a new achievement to your portfolio:

Title: {$a->title}
Category: {$a->category}
Status: {$a->status}

You can view your achievement here: {$a->viewurl}

Best regards,
Portfolio System';

// Reports
$string['reporttitle'] = 'Portfolio Report';
$string['totalachievements'] = 'Total achievements';
$string['publishedachievements'] = 'Published achievements';
$string['draftachievements'] = 'Draft achievements';
$string['achievementsbycategory'] = 'Achievements by category';
$string['recentachievements'] = 'Recent achievements';

// Export
$string['export'] = 'Export';
$string['exportpdf'] = 'Export to PDF';
$string['exportcsv'] = 'Export to CSV';
$string['exportall'] = 'Export all achievements';
$string['exportselected'] = 'Export selected achievements';

// Import
$string['import'] = 'Import';
$string['importfile'] = 'Import from file';
$string['importinstructions'] = 'Select a CSV file with achievements to import';

// Statistics
$string['statistics'] = 'Statistics';
$string['achievementscount'] = 'Achievements count';
$string['categoriescount'] = 'Categories count';
$string['lastupdate'] = 'Last update';
$string['averagerating'] = 'Average rating';

// Search
$string['search'] = 'Search achievements';
$string['searchplaceholder'] = 'Search by title or description...';
$string['searchresults'] = 'Search results';
$string['nomatches'] = 'No matches found';

// Filters
$string['filter'] = 'Filter';
$string['filterbycategory'] = 'Filter by category';
$string['filterbystatus'] = 'Filter by status';
$string['filterbydate'] = 'Filter by date';
$string['clearfilters'] = 'Clear filters';

// Sorting
$string['sort'] = 'Sort';
$string['sortbytitle'] = 'Sort by title';
$string['sortbydate'] = 'Sort by date';
$string['sortbycategory'] = 'Sort by category';
$string['sortasc'] = 'Ascending';
$string['sortdesc'] = 'Descending';