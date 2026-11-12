import LeaveEmployeeDashboard from './LeaveEmployeeDashboard.vue';

export default {
  title: 'Projects/DemoLeave/EmployeeDashboard',
  component: LeaveEmployeeDashboard,
};

export const Default = () => ({
  components: { LeaveEmployeeDashboard },
  template: '<leave-employee-dashboard :value="data" />',
  data: () => ({
    data: {
      employeeName: 'Jordan Lee',
      requestStatus: 'draft',
      balances: { annual: 12.5, sick: 8, personal: 2 },
      holidayDates: ['2026-11-26', '2026-12-25'],
      requestHistory: [
        { at: '2026-01-10T12:00:00Z', action: 'approved', days: 2, type: 'annual', comment: 'Enjoy!' },
      ],
    },
  }),
});

export const PendingApproval = () => ({
  components: { LeaveEmployeeDashboard },
  template: '<leave-employee-dashboard :value="data" />',
  data: () => ({
    data: {
      employeeName: 'Jordan Lee',
      requestStatus: 'pending_approval',
      balances: { annual: 12.5, sick: 8, personal: 2 },
      holidayDates: [],
      requestHistory: [],
    },
  }),
});
