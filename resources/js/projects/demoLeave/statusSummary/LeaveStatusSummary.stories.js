import LeaveStatusSummary from './LeaveStatusSummary.vue';

export default {
  title: 'Projects/DemoLeave/StatusSummary',
  component: LeaveStatusSummary,
};

export const Approved = () => ({
  components: { LeaveStatusSummary },
  template: '<leave-status-summary :value="data" />',
  data: () => ({
    data: {
      requestStatus: 'approved',
      leaveType: 'annual',
      startDate: '2026-06-01',
      endDate: '2026-06-05',
      requestedDays: 4,
      requestHistory: [
        { at: '2026-05-20T10:00:00Z', action: 'approved', days: 4, type: 'annual', comment: 'Approved' },
      ],
    },
  }),
});

export const Rejected = () => ({
  components: { LeaveStatusSummary },
  template: '<leave-status-summary :value="data" />',
  data: () => ({
    data: {
      requestStatus: 'rejected',
      leaveType: 'sick',
      startDate: '2026-07-01',
      endDate: '2026-07-02',
      requestedDays: 2,
      requestHistory: [],
    },
  }),
});
