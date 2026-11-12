<template>
  <div class="dlv-shell text-center">
    <div class="dlv-hero mb-3">
      <h3 class="font-weight-bold mb-1">
        Request complete
      </h3>
      <p class="mb-0">
        Your leave workflow finished. Details are below and an email confirmation was sent when configured.
      </p>
    </div>

    <motion-status :local="local" />

    <leave-history-table :history="local.requestHistory" class="mt-3 text-left" />
  </div>
</template>

<script>
import LeaveHistoryTable from '../components/LeaveHistoryTable.vue';
import '../shared/leaveTheme.css';

const MotionStatus = {
  name: 'MotionStatus',
  props: { local: Object },
  computed: {
    icon() {
      return this.local.requestStatus === 'approved' ? 'fas fa-check-circle' : 'fas fa-times-circle';
    },
    color() {
      return this.local.requestStatus === 'approved' ? '#059669' : '#dc2626';
    },
    headline() {
      const map = {
        approved: 'Approved',
        rejected: 'Rejected',
        pending_approval: 'Pending',
      };
      return map[this.local.requestStatus] || 'Updated';
    },
  },
  template: `
    <div class="dlv-card py-4">
      <i :class="icon" :style="{ color, fontSize: '3rem' }"></i>
      <h2 class="font-weight-bold mt-3 mb-1">{{ headline }}</h2>
      <p class="text-muted mb-0">
        {{ local.requestedDays }} day(s) • {{ local.leaveType }} • {{ local.startDate }} → {{ local.endDate }}
      </p>
    </div>
  `,
};

export default {
  name: 'LeaveStatusSummary',
  components: { LeaveHistoryTable, MotionStatus },
  props: {
    value: { type: Object, default: () => ({}) },
  },
  data() {
    return { local: { ...(this.value || {}) } };
  },
  watch: {
    value: {
      deep: true,
      handler(next) {
        this.local = { ...(next || {}) };
      },
    },
  },
};
</script>
