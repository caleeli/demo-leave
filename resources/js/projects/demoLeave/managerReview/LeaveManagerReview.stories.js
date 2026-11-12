import LeaveManagerReview from './LeaveManagerReview.vue';

export default {
  title: 'Projects/DemoLeave/ManagerReview',
  component: LeaveManagerReview,
};

export const PendingDecision = () => ({
  components: { LeaveManagerReview },
  template: '<leave-manager-review :value="data" />',
  data: () => ({
    data: {
      employeeName: 'Jordan Lee',
      leaveType: 'annual',
      startDate: '2026-06-01',
      endDate: '2026-06-05',
      requestedDays: 4,
      reason: 'Family trip',
      managerDecision: '',
      managerComments: '',
    },
  }),
});
