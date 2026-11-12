<?php

namespace ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases;

/**
 * Applies manager approval or rejection to balances, status, and history.
 */
final class ApplyLeaveDecision
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function handle(array $data): array
    {
        $decision = (string) ($data['managerDecision'] ?? '');
        $history = $this->historyEntries($data);
        $timestamp = gmdate('Y-m-d\TH:i:s\Z');
        $requestedDays = (float) ($data['requestedDays'] ?? 0);
        $leaveType = (string) ($data['leaveType'] ?? 'annual');

        if ($decision === 'approve') {
            $balances = is_array($data['balances'] ?? null) ? $data['balances'] : [];
            $current = (float) ($balances[$leaveType] ?? 0);
            $balances[$leaveType] = max(0, $current - $requestedDays);
            $data['balances'] = $balances;
            $data['requestStatus'] = 'approved';
            $history[] = [
                'at' => $timestamp,
                'action' => 'approved',
                'days' => $requestedDays,
                'type' => $leaveType,
                'comment' => (string) ($data['managerComments'] ?? ''),
            ];
        } elseif ($decision === 'reject') {
            $data['requestStatus'] = 'rejected';
            $history[] = [
                'at' => $timestamp,
                'action' => 'rejected',
                'days' => $requestedDays,
                'type' => $leaveType,
                'comment' => (string) ($data['managerComments'] ?? ''),
            ];
        } else {
            $data['requestStatus'] = 'pending_decision';
            $errors = $data['validationErrors'] ?? [];
            if (!is_array($errors)) {
                $errors = [];
            }
            $errors[] = 'Manager decision is required.';
            $data['validationErrors'] = $errors;
        }

        $data['requestHistory'] = $history;
        $this->attachNotification($data, $decision, $timestamp);

        return $data;
    }

    /**
     * @param array<string, mixed> $data
     * @return list<array<string, mixed>>
     */
    private function historyEntries(array $data): array
    {
        $history = $data['requestHistory'] ?? [];
        if (!is_array($history)) {
            return [];
        }

        return $history;
    }

    /**
     * @param array<string, mixed> $data
     */
    private function attachNotification(array &$data, string $decision, string $timestamp): void
    {
        $employeeName = (string) ($data['employeeName'] ?? 'Employee');
        $statusLabel = $decision === 'approve' ? 'approved' : ($decision === 'reject' ? 'rejected' : 'updated');
        $range = sprintf('%s → %s', $data['startDate'] ?? '', $data['endDate'] ?? '');

        $data['notificationSubject'] = sprintf('Leave request %s', $statusLabel);
        $data['notificationBody'] = sprintf(
            "Hello %s,\n\nYour leave request (%s, %s days) was %s on %s.\n\nManager note: %s\n",
            $employeeName,
            $range,
            (string) ($data['requestedDays'] ?? ''),
            $statusLabel,
            $timestamp,
            (string) ($data['managerComments'] ?? '—')
        );
        $data['notifyEmail'] = (string) ($data['employeeEmail'] ?? 'admin@processmaker.com');
    }
}
