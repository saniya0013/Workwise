
<template>
  <oxd-form
    class="orangehrm-installer-page"
    :loading="isLoading"
    @submit-valid="onSubmit"
  >
    <oxd-text tag="h5" class="orangehrm-installer-page-title">
      License Acceptance
    </oxd-text>
    <br />
    <oxd-text class="orangehrm-installer-page-content">
      Please review the license terms before installing OrangeHRM Starter.
    </oxd-text>
    <br />

    <oxd-form-row>
      <gnu-licence></gnu-licence>
    </oxd-form-row>
    <br />

    <oxd-text tag="p" class="orangehrm-installer-page-content">
      If you accept the terms of the agreement, select the first option below.
      You must accept the agreement to install OrangeHRM. Click <b>Next</b> to
      continue
    </oxd-text>

    <br />
    <oxd-form-row>
      <oxd-input-field
        v-model="userConsent"
        type="checkbox"
        option-label="I accept the terms in the License Agreement"
      />
    </oxd-form-row>

    <oxd-form-actions class="orangehrm-installer-page-action">
      <oxd-button display-type="ghost" label="Back" @click="onClickBack" />
      <oxd-button
        :disabled="!userConsent"
        class="orangehrm-left-space"
        display-type="secondary"
        label="Next"
        type="submit"
      />
    </oxd-form-actions>
  </oxd-form>
</template>

<script>
import {APIService} from '@/core/util/services/api.service';
import {navigate} from '@/core/util/helper/navigation.ts';
import GNULicence from '@/components/GNULicence.vue';

export default {
  name: 'LicenceAcceptanceScreen',
  components: {
    'gnu-licence': GNULicence,
  },
  setup() {
    const http = new APIService(
      window.appGlobal.baseUrl,
      'installer/api/license',
    );
    return {
      http,
    };
  },
  data() {
    return {
      isLoading: false,
      userConsent: false,
    };
  },
  methods: {
    onClickBack() {
      navigate('/welcome');
    },
    onSubmit() {
      navigate('/installer/database-config');
    },
  },
};
</script>
<style src="./installer-page.scss" lang="scss" scoped></style>
