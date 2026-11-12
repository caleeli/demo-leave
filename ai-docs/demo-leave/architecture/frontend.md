# demo-leave frontend

Domain Vue inventory. **Catalog, build, publish, handlerVue rules:** [screen-builder.md](../../screen-builder.md).

Vue 2 + BootstrapVue. Catalog: `resources/js/designer/public-screen-components.json`.

## Components

| Story group | Root component | Children |
| --- | --- | --- |
| Employee dashboard | `LeaveEmployeeDashboard` | `LeaveBalanceCards`, `LeaveHolidayCalendar`, `LeaveHistoryTable` |
| Request | `LeaveRequestForm` | — |
| Manager | `LeaveManagerReview` | inline detail rows |
| Validation | `LeaveValidationNotice` | `LeaveHolidayCalendar` |
| Status | `LeaveStatusSummary` | `LeaveHistoryTable` |

Shared visual tokens: `resources/js/projects/demoLeave/shared/leaveTheme.css` (indigo gradient hero, soft cards, responsive grids).

## Screens

See [AGENTS.md](../AGENTS.md) for the full `pm:screenRef` → YAML → Vue table.

## Build

```bash
npm run prod
php artisan vendor:publish --tag=demo-leave --force
```
