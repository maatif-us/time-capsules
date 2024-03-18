<template>
  <el-popconfirm
    :confirm-button-text="confirmLabel"
    :cancel-button-text="cancelLabel"
    :icon="InfoFilled"
    icon-color="#626AEF"
    :title="title"
    @confirm="confirmEvent"
  >
    <template #reference>
      <el-button size="small" type="danger" :icon="Delete">Delete</el-button>
    </template>
  </el-popconfirm>
</template>

<script>
export default {
  name: 'confirmBtn',
  props: {
    item: Object,
    title: String,
    confirmLabel: String,
    cancelLabel: String,
  },
  methods: {
    confirmEvent() {
      this.$emit("is:connfirmed", this.item);
    },
  },
};
</script>
