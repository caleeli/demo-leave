<template>
  <div class="dlv-card">
    <h5 class="font-weight-bold mb-3">
      <i class="fas fa-history mr-2 text-primary" />
      Request history
    </h5>
    <div v-if="!entries.length" class="text-muted text-center py-4">
      No leave activity yet. Submit your first request to see it here.
    </div>
    <b-table
      v-else
      small
      hover
      responsive
      :items="entries"
      :fields="fields"
    />
  </div>
</template>

<script>
export default {
  name: 'LeaveHistoryTable',
  props: {
    history: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      fields: [
        { key: 'at', label: 'When' },
        { key: 'type', label: 'Type' },
        { key: 'days', label: 'Days' },
        { key: 'action', label: 'Status' },
        { key: 'comment', label: 'Note' },
      ],
    };
  },
  computed: {
    entries() {
      return [...this.history].reverse().map((row) => ({
        ...row,
        action: this.statusBadge(row.action),
      }));
    },
  },
  methods: {
    statusBadge(action) {
      const map = {
        approved: 'Approved',
        rejected: 'Rejected',
        submitted: 'Submitted',
      };
      return map[action] || action;
    },
  },
};
</script>
