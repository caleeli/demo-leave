# demo-leave

BPMN-driven leave management for employees and managers.

## Architecture

- [database.md](./architecture/database.md) — request data keys (in-process balances; optional `dlv_*` tables later)
- [workflow.md](./architecture/workflow.md) — BPMN path, screens, scripts, gateways
- [frontend.md](./architecture/frontend.md) — Vue screens and Storybook ([screen-builder.md](../../screen-builder.md) for catalog/build)

## BPMN

| File | Process name | process_id |
| --- | --- | --- |
| [projects/demo-leave/bpmn/demo-leave-request.xml](../../projects/demo-leave/bpmn/demo-leave-request.xml) | `demo-leave-request` | `2` (pm4.local:8089) |

## Screens (`pm:screenRef` → YAML → Vue)

| Screen title | YAML | Vue root |
| --- | --- | --- |
| `demo-leave-employee-dashboard` | `projects/demo-leave/screens/demo-leave-employee-dashboard.yaml` | `resources/js/projects/demoLeave/employeeDashboard/LeaveEmployeeDashboard.vue` |
| `demo-leave-request` | `projects/demo-leave/screens/demo-leave-request.yaml` | `resources/js/projects/demoLeave/requestForm/LeaveRequestForm.vue` |
| `demo-leave-manager-review` | `projects/demo-leave/screens/demo-leave-manager-review.yaml` | `resources/js/projects/demoLeave/managerReview/LeaveManagerReview.vue` |
| `demo-leave-validation-notice` | `projects/demo-leave/screens/demo-leave-validation-notice.yaml` | `resources/js/projects/demoLeave/validationNotice/LeaveValidationNotice.vue` |
| `demo-leave-status` | `projects/demo-leave/screens/demo-leave-status.yaml` | `resources/js/projects/demoLeave/statusSummary/LeaveStatusSummary.vue` |

## Scripts (`pm:scriptRef` → PHP → use case)

| Script title | Wrapper | Use case |
| --- | --- | --- |
| `demo-leave-initialize-workspace` | `projects/demo-leave/scripts/demo-leave-initialize-workspace.php` | `InitializeLeaveWorkspace` |
| `demo-leave-validate-request` | `projects/demo-leave/scripts/demo-leave-validate-request.php` | `ValidateLeaveRequest` |
| `demo-leave-apply-decision` | `projects/demo-leave/scripts/demo-leave-apply-decision.php` | `ApplyLeaveDecision` |

## Table prefix

`dlv_` (reserved for future persistence; current demo stores balances on the request payload).
