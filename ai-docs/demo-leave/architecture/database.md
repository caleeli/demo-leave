# demo-leave data

## In-request (default)

Balances, holidays, and history are carried on the **request payload** so the demo runs without extra tables:

- `balances.annual | sick | personal`
- `holidayDates[]`
- `requestHistory[]` — `{ at, action, days, type, comment }`

## Future tables (`dlv_*`)

| Table | Purpose |
| --- | --- |
| `dlv_leave_balances` | Per-user balances synced from HR |
| `dlv_holidays` | Company calendar |
| `dlv_leave_requests` | Audit log outside completed requests |

Not migrated in the initial demo; scripts use in-memory defaults via `InitializeLeaveWorkspace` and `ValidateLeaveRequest`.
