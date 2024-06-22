
<template>
  <ul class="orangehrm-installer-steps">
    <li
      v-for="(step, index) in steps"
      :key="step"
      :class="{
        'orangehrm-installer-steps-item': true,
        '--active': currentStep === index,
      }"
    >
      <oxd-text
        tag="span"
        :class="{
          'orangehrm-installer-steps-count': true,
          '--success': currentStep > index,
        }"
      >
        <template v-if="currentStep <= index">{{ index + 1 }}</template>
        <oxd-icon v-else class="orangehrm-installer-steps-icon" name="check" />
      </oxd-text>

      <oxd-text tag="span" class="orangehrm-installer-steps-name">
        {{ step }}
      </oxd-text>
    </li>
  </ul>
</template>

<script>
import {OxdIcon} from '@ohrm/oxd';

export default {
  name: 'InstallerSteps',
  components: {
    'oxd-icon': OxdIcon,
  },
  props: {
    steps: {
      type: Array,
      default: () => [],
    },
    currentStep: {
      type: Number,
      default: 0,
    },
  },
};
</script>

<style src="./installer-steps.scss" lang="scss" scoped></style>
