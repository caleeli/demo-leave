<template>
  <div class="dlv-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0 font-weight-bold">
        <i class="far fa-calendar-alt mr-2 text-primary" />
        Company holidays
      </h5>
      <span class="dlv-badge" style="background:#eef2ff;color:#4f46e5;">{{ holidays.length }} dates</span>
    </div>
    <ul class="list-unstyled mb-0 dlv-holiday-list">
      <li
        v-for="day in holidays"
        :key="day"
        class="d-flex justify-content-between py-2 border-bottom"
      >
        <span>{{ formatDate(day) }}</span>
        <span class="text-muted small">non-working</span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'LeaveHolidayCalendar',
  props: {
    holidays: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    formatDate(iso) {
      try {
        return new Date(`${iso}T12:00:00`).toLocaleDateString(undefined, {
          weekday: 'short',
          month: 'short',
          day: 'numeric',
          year: 'numeric',
        });
      } catch (e) {
        return iso;
      }
    },
  },
};
</script>

<style scoped>
.dlv-holiday-list li:last-child {
  border-bottom: none !important;
}
</style>
