
<template>
  <div class="orangehrm-installer-page">
    <oxd-text tag="h5" class="orangehrm-installer-page-title">
      Installation Complete
    </oxd-text>
    <br />
    <oxd-text tag="p" class="orangehrm-installer-page-content">
      OrangeHRM Starter Version {{ productversion }} has been successfully
      installed.
    </oxd-text>
    <br />
    <br />
    <oxd-button
      class="orangehrm-installer-complete-button"
      display-type="secondary"
      label="Launch OrangeHRM"
      @click="launch"
    />
  </div>
</template>

<script>
import {navigate} from '@/core/util/helper/navigation.ts';
export default {
  name: 'InstallerCompleteScreen',
  props: {
    productversion: {
      type: String,
      required: true,
    },
  },
  methods: {
    launch() {
      navigate('/');
    },
  },
};
</script>

<style src="./installer-page.scss" lang="scss" scoped></style>
<style lang="scss" scoped>
.orangehrm-installer-complete-button {
  margin-right: auto;
}
</style>
