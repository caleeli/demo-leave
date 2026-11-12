<template>
  <div class="dlv-shell">
    <div class="alert alert-warning dlv-card">
      <h4 class="alert-heading font-weight-bold">
        Validation issues found
      </h4>
      <p class="mb-2">
        Update your request and submit again. Weekends and listed holidays are excluded automatically.
      </p>
      <ul class="mb-0">
        <li v-for="(item, index) in local.validationErrors" :key="index">
          {{ item }}
        </li>
      </ul>
    </div>
    <leave-holiday-calendar :holidays="local.holidayDates" />
  </div>
</template>

<script>
import LeaveHolidayCalendar from '../components/LeaveHolidayCalendar.vue';
import '../shared/leaveTheme.css';

export default {
  name: 'LeaveValidationNotice',
  components: { LeaveHolidayCalendar },
  props: {
    value: { type: Object, default: () => ({}) },
  },
  data() {
    return { local: { validationErrors: [], holidayDates: [], ...(this.value || {}) } };
  },
  watch: {
    value: {
      deep: true,
      handler(next) {
        this.local = { validationErrors: [], holidayDates: [], ...(next || {}) };
      },
    },
  },
};
</script>
