

<template>
  <oxd-text tag="p" class="orangehrm-form-hint"> * Required </oxd-text>
</template>

<script>
export default {
  name: 'RequiredText',
};
</script>

<style lang="scss" scoped>
.orangehrm-form-hint {
  margin-right: auto;
  font-weight: 600;
  font-size: 0.75rem;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}
</style>
