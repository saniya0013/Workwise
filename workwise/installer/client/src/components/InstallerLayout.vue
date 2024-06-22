
<template>
  <div class="orangehrm-installer">
    <div class="orangehrm-installer-sidebar">
      <installer-steps
        :steps="steps"
        :current-step="currentStep"
      ></installer-steps>
      <div class="orangehrm-installer-footer">
        <a
          v-show="currentStep === 0"
          target="_blank"
          class="orangehrm-installer-guide"
          href="https://starterhelp.orangehrm.com/hc/en-us/articles/5295915003666-OrangeHRM-Starter-Installation-Guide"
        >
          <oxd-icon
            type="svg"
            name="guide"
            class="orangehrm-installer-guide-icon"
          />
          Installation Guide
        </a>
        <br />
        <slot name="footer"></slot>
      </div>
    </div>
    <div class="orangehrm-installer-header">
      <img :src="brandingSrc" width="280" alt="orangehrm-branding" />
    </div>
    <div class="orangehrm-installer-content">
      <slot></slot>
    </div>
  </div>
</template>

<script>
import InstallerSteps from '@/components/InstallerSteps.vue';
import {OxdIcon} from '@ohrm/oxd';

export default {
  name: 'InstallerLayout',
  components: {
    'installer-steps': InstallerSteps,
    'oxd-icon': OxdIcon,
  },
  props: {
    steps: {
      type: Array,
      required: true,
    },
    currentStep: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      brandingSrc: `${window.appGlobal.publicPath}/client/public/ohrm_branding.png`,
    };
  },
};
</script>

<style src="./installer-layout.scss" lang="scss" scoped></style>
