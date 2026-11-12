# Processmaker Demo Leave

BPMN-driven leave management: employee dashboard, request submission, manager approval, balance tracking, holiday calendar, notifications, and status history. Versioned assets live under `projects/demo-leave/` (BPMN, screens, scripts) with Vue components in `resources/js/projects/demoLeave/`.

See [ai-docs/demo-leave/AGENTS.md](ai-docs/demo-leave/AGENTS.md) for architecture and deploy order.

## Development
If you need to create a new ProcessMaker package run the following commands:

```
git clone https://github.com/ProcessMaker/demo-leave.git
cd demo-leave
php rename-project.php demo-leave
composer install
npm install
npm run dev
```

## Installation
* Use `composer require processmaker/demo-leave` to install the package.
* Use `php artisan demo-leave:install` to install generate the dependencies.

## Navigation and testing
* Navigate to administration tab in your ProcessMaker 4
* Select `Skeleton Package` from the administrative sidebar

## Uninstall
* Use `php artisan demo-leave:uninstall` to uninstall the package
* Use `composer remove processmaker/demo-leave` to remove the package completely
