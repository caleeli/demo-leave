<template>
  <div class="dlv-balance-grid">
    <motion-card
      v-for="card in cards"
      :key="card.key"
      :label="card.label"
      :value="card.value"
      :accent="card.accent"
      :icon="card.icon"
    />
  </div>
</template>

<script>
const MotionCard = {
  name: 'MotionCard',
  props: {
    label: String,
    value: [Number, String],
    accent: String,
    icon: String,
  },
  template: `
    <div class="dlv-card dlv-balance-card" :style="{ borderTop: '4px solid ' + accent }">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <div class="text-muted small">{{ label }}</div>
          <div class="h3 mb-0 font-weight-bold">{{ value }}</div>
          <div class="text-muted small">days remaining</div>
        </div>
        <span class="dlv-badge" :style="{ background: accent + '22', color: accent }">
          <i :class="icon"></i>
        </span>
      </div>
    </div>
  `,
};

export default {
  name: 'LeaveBalanceCards',
  components: { MotionCard },
  props: {
    balances: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    cards() {
      const palette = {
        annual: { label: 'Annual leave', accent: '#4f46e5', icon: 'fas fa-umbrella-beach' },
        sick: { label: 'Sick leave', accent: '#059669', icon: 'fas fa-notes-medical' },
        personal: { label: 'Personal leave', accent: '#d97706', icon: 'fas fa-user-clock' },
      };
      return Object.keys(palette).map((key) => ({
        key,
        ...palette[key],
        value: Number(this.balances[key] ?? 0).toFixed(1),
      }));
    },
  },
};
</script>

<style scoped>
.dlv-balance-grid {
  display: grid;
  gap: 1rem;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
}
</style>
