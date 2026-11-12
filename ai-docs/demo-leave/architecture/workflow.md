# Leave request workflow

## Roles

| Role | BPMN lane | Tasks |
| --- | --- | --- |
| Employee | Employee | Dashboard, submit request, validation notice, status summary |
| Manager | Manager | Approval, automated apply + email |

Assign the **process manager** in ProcessMaker to the user who acts as manager (`pm:assignment="process_manager"` on manager approval).

## Flow

1. **Start** → script `demo-leave-initialize-workspace` (default balances, holidays, history).
2. **Employee dashboard** (FORM) — balances, holiday list, history.
3. **Submit leave request** (FORM) — type, dates, reason, half-day flag.
4. **Validate request** (script) — business days, holidays, balance check → `validationPassed`.
5. **Exclusive gateway** — if false, **validation notice** (DISPLAY) and loop to dashboard; if true, manager path.
6. **Manager approval** (FORM) — `managerDecision` approve/reject + comments.
7. **Apply decision** (script) — update balances, `requestStatus`, history, notification fields.
8. **Send Email** — employee notification (`notificationSubject`, `notificationBody`, `notifyEmail`).
9. **Status summary** (DISPLAY) → **End**.

## Request data (primary keys)

| Key | Purpose |
| --- | --- |
| `balances` | `{ annual, sick, personal }` floats |
| `holidayDates` | ISO date strings |
| `leaveType`, `startDate`, `endDate`, `reason`, `halfDay` | Request form |
| `requestedDays` | Business days after validation |
| `validationPassed`, `validationErrors` | Gateway + UI |
| `managerDecision`, `managerComments` | Manager task |
| `requestStatus`, `requestHistory` | Tracking |
| `notificationSubject`, `notificationBody`, `notifyEmail` | Email task |

## Publish order

1. `upsert-script-php` (three scripts)
2. `upsert-screen-yaml` (five screens)
3. `upsert-process-bpmn` (`demo-leave-request.xml`)
4. Rebuild php-nayra executor if scripts use new `src/Projects` classes
5. Record `process_id` / screen / script ids in this file after deploy

## Instance IDs (pm4.local:8089)

| Asset | Title | ID |
| --- | --- | --- |
| Process | `demo-leave-request` | 2 |
| Script | `demo-leave-validate-request` | 2 |
| Script | `demo-leave-initialize-workspace` | 3 |
| Script | `demo-leave-apply-decision` | 4 |
| Screen | `demo-leave-employee-dashboard` | 7 |
| Screen | `demo-leave-request` | 8 |
| Screen | `demo-leave-manager-review` | 9 |
| Screen | `demo-leave-validation-notice` | 10 |
| Screen | `demo-leave-status` | 11 |
