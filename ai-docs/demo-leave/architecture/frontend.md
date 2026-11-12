# demo-leave frontend

Vue 2 + BootstrapVue screen components registered in `resources/js/designer/public-screen-components.json`.

## Components

| Story group | Root component | Children |
| --- | --- | --- |
| Employee dashboard | `LeaveEmployeeDashboard` | `LeaveBalanceCards`, `LeaveHolidayCalendar`, `LeaveHistoryTable` |
| Request | `LeaveRequestForm` | — |
| Manager | `LeaveManagerReview` | inline detail rows |
| Validation | `LeaveValidationNotice` | `LeaveHolidayCalendar` |
| Status | `LeaveStatusSummary` | `LeaveHistoryTable` |

Shared visual tokens live in `resources/js/projects/demoLeave/shared/leaveTheme.css` (indigo gradient hero, soft cards, responsive grids).

## Screen Builder

Each FORM/DISPLAY YAML uses a single `VueComponentRenderTemplate` with `handlerVue` guarding `this.data` before defaults are applied.

## Build

```bash
npm install
npm run prod
php artisan vendor:publish --tag=demo-leave --force
```

When integrated with Screen Builder entrypoints, load `registerPublicScreenCatalog` from `resources/js/designer/public-screen-components.json`.
