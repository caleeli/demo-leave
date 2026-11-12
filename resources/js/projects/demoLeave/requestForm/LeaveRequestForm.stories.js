import LeaveRequestForm from './LeaveRequestForm.vue';

export default {
  title: 'Projects/DemoLeave/RequestForm',
  component: LeaveRequestForm,
};

export const Empty = () => ({
  components: { LeaveRequestForm },
  template: '<leave-request-form :value="data" />',
  data: () => ({ data: { balances: { annual: 15, sick: 10, personal: 3 } } }),
});

export const WithValidationErrors = () => ({
  components: { LeaveRequestForm },
  template: '<leave-request-form :value="data" />',
  data: () => ({
    data: {
      leaveType: 'personal',
      startDate: '2026-03-02',
      endDate: '2026-03-06',
      validationErrors: ['Insufficient personal balance (5.0 days requested, 1.0 remaining).'],
      balances: { annual: 15, sick: 10, personal: 1 },
    },
  }),
});
