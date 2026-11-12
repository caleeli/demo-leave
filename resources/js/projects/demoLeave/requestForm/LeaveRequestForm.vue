<template>
  <div class="dlv-shell">
    <div class="dlv-hero mb-3">
      <h3 class="font-weight-bold mb-1">
        New leave request
      </h3>
      <p class="mb-0">
        Choose dates that avoid weekends and company holidays. Half-day requests count as 0.5 days.
      </p>
    </div>

    <div v-if="local.validationErrors && local.validationErrors.length" class="alert alert-danger dlv-card">
      <strong>Please fix the following:</strong>
      <ul class="mb-0 mt-2">
        <li v-for="(err, idx) in local.validationErrors" :key="idx">
          {{ err }}
        </li>
      </ul>
    </div>

    <div class="dlv-card">
      <div class="form-group">
        <label class="font-weight-bold">
          <i class="fas fa-tag mr-1 text-primary" />
          Leave type
        </label>
        <b-form-select v-model="local.leaveType" :options="typeOptions" />
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="font-weight-bold">Start date</label>
            <b-form-input v-model="local.startDate" type="date" />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="font-weight-bold">End date</label>
            <b-form-input v-model="local.endDate" type="date" />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Reason</label>
        <b-form-textarea
          v-model="local.reason"
          rows="3"
          max-rows="6"
          placeholder="Optional context for your manager"
        />
      </div>
      <b-form-checkbox v-model="local.halfDay" switch>
        Half-day on start date
      </b-form-checkbox>
    </div>

    <div class="dlv-card mt-3 d-flex flex-wrap justify-content-between align-items-center">
      <div>
        <div class="text-muted small">Estimated business days</div>
        <div class="h4 mb-0">{{ local.requestedDays || '—' }}</div>
      </div>
      <div class="text-right">
        <div class="text-muted small">Remaining {{ local.leaveType || 'annual' }}</div>
        <div class="h5 mb-0">{{ balanceRemaining }} days</div>
      </div>
    </div>
  </div>
</template>

<script>
import '../shared/leaveTheme.css';

const seed = () => ({
  leaveType: 'annual',
  startDate: '',
  endDate: '',
  reason: '',
  halfDay: false,
  validationErrors: [],
  balances: { annual: 15, sick: 10, personal: 3 },
  requestedDays: 0,
});

export default {
  name: 'LeaveRequestForm',
  props: {
    value: { type: Object, default: () => ({}) },
    submit: { type: Function, default: null },
  },
  data() {
    return {
      local: { ...seed(), ...(this.value || {}) },
      typeOptions: [
        { value: 'annual', text: 'Annual leave' },
        { value: 'sick', text: 'Sick leave' },
        { value: 'personal', text: 'Personal leave' },
      ],
    };
  },
  computed: {
    balanceRemaining() {
      const type = this.local.leaveType || 'annual';
      const balances = this.local.balances || {};
      return Number(balances[type] ?? 0).toFixed(1);
    },
  },
  watch: {
    value: {
      deep: true,
      handler(next) {
        this.local = { ...seed(), ...(next || {}) };
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
