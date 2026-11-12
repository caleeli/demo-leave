<template>
  <div class="dlv-shell">
    <div class="dlv-hero">
      <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
          <p class="mb-1 opacity-75">Welcome back</p>
          <h2 class="mb-0 font-weight-bold">
            {{ local.employeeName || 'Employee' }}
          </h2>
          <p class="mb-0 mt-2">
            Track balances, plan around holidays, and monitor request status in one place.
          </p>
        </div>
        <span class="dlv-badge mt-2 mt-md-0" :style="statusStyle">
          {{ statusLabel }}
        </span>
      </div>
    </div>

    <leave-balance-cards :balances="local.balances" class="mb-3" />

    <div class="row">
      <div class="col-lg-7 mb-3">
        <leave-history-table :history="local.requestHistory" />
      </div>
      <div class="col-lg-5 mb-3">
        <leave-holiday-calendar :holidays="local.holidayDates" />
      </div>
    </div>

    <p class="text-muted small mb-0">
      Continue to the next task to compose a new leave request. Your balances update automatically after manager approval.
    </p>
  </div>
</template>

<script>
import LeaveBalanceCards from '../components/LeaveBalanceCards.vue';
import LeaveHolidayCalendar from '../components/LeaveHolidayCalendar.vue';
import LeaveHistoryTable from '../components/LeaveHistoryTable.vue';
import '../shared/leaveTheme.css';

const defaults = () => ({
  employeeName: '',
  requestStatus: 'draft',
  balances: { annual: 15, sick: 10, personal: 3 },
  holidayDates: [],
  requestHistory: [],
});

export default {
  name: 'LeaveEmployeeDashboard',
  components: {
    LeaveBalanceCards,
    LeaveHolidayCalendar,
    LeaveHistoryTable,
  },
  props: {
    value: {
      type: Object,
      default: () => ({}),
    },
    submit: {
      type: Function,
      default: null,
    },
  },
  data() {
    return {
      local: { ...defaults(), ...(this.value || {}) },
    };
  },
  computed: {
    statusLabel() {
      const map = {
        draft: 'Draft',
        pending_approval: 'Awaiting manager',
        approved: 'Approved',
        rejected: 'Rejected',
        validation_failed: 'Needs correction',
      };
      return map[this.local.requestStatus] || 'In progress';
    },
    statusStyle() {
      const colorMap = {
        approved: '#059669',
        rejected: '#dc2626',
        pending_approval: '#d97706',
        validation_failed: '#dc2626',
      };
      const color = colorMap[this.local.requestStatus] || '#4f46e5';
      return { background: `${color}22`, color };
    },
  },
  watch: {
    value: {
      deep: true,
      handler(next) {
        this.local = { ...defaults(), ...(next || {}) };
      },
    },
    local: {
      deep: true,
      handler(next) {
        this.$emit('input', next);
      },
    },
  },
};
</script>
