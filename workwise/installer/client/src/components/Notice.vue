
<template>
  <oxd-sheet type="gray-lighten-2">
    <oxd-text tag="p" class="notice-title">{{ title }}</oxd-text>
    <div>
      <slot></slot>
    </div>
  </oxd-sheet>
</template>

<script>
import {OxdSheet, OxdText} from '@ohrm/oxd';

export default {
  components: {
    'oxd-sheet': OxdSheet,
    'oxd-text': OxdText,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped>
.notice-title {
  font-size: 14px;
  font-weight: 700;
  margin-bottom: 0.5rem;
  text-transform: uppercase;
}
</style>
