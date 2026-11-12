<template>
  <div class="dlv-shell">
    <div class="dlv-hero mb-3">
      <h3 class="font-weight-bold mb-1">
        Manager review
      </h3>
      <p class="mb-0">
        Review the employee request, check balances, and approve or reject with a short note.
      </p>
    </div>

    <motion-detail :local="local" class="mb-3" />

    <div class="dlv-card">
      <label class="font-weight-bold d-block mb-2">Decision</label>
      <b-form-radio-group
        v-model="local.managerDecision"
        :options="decisionOptions"
        buttons
        button-variant="outline-primary"
        class="mb-3"
      />
      <b-form-textarea
        v-model="local.managerComments"
        rows="3"
        placeholder="Optional message to the employee"
      />
    </div>
  </div>
</template>

<script>
import '../shared/leaveTheme.css';

const MotionDetail = {
  name: 'MotionDetail',
  props: { local: Object },
  template: `
    <div class="dlv-card">
      <motion-row label="Employee" :value="local.employeeName" />
      <motion-row label="Type" :value="local.leaveType" />
      <motion-row label="Dates" :value="dateRange" />
      <motion-row label="Business days" :value="local.requestedDays" />
      <motion-row label="Reason" :value="local.reason || '—'" />
    </div>
  `,
  components: {
    MotionRow: {
      props: { label: String, value: [String, Number] },
      template: `
        <div class="d-flex justify-content-between py-2 border-bottom">
          <span class="text-muted">{{ label }}</span>
          <span class="font-weight-bold text-capitalize">{{ value }}</span>
        </div>
      `,
    },
  },
  computed: {
    dateRange() {
      if (!this.local.startDate) return '—';
      return this.local.endDate
        ? `${this.local.startDate} → ${this.local.endDate}`
        : this.local.startDate;
    },
  },
};

export default {
  name: 'LeaveManagerReview',
  components: { MotionDetail },
  props: {
    value: { type: Object, default: () => ({}) },
    submit: { type: Function, default: null },
  },
  data() {
    return {
      local: {
        managerDecision: '',
        managerComments: '',
        ...(this.value || {}),
      },
      decisionOptions: [
        { text: 'Approve', value: 'approve' },
        { text: 'Reject', value: 'reject' },
      ],
    };
  },
  watch: {
    value: {
      deep: true,
      handler(next) {
        this.local = { managerDecision: '', managerComments: '', ...(next || {}) };
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
