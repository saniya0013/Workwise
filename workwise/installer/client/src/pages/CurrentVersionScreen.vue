
<template>
  <oxd-form
    class="orangehrm-installer-page"
    :loading="isLoading"
    @submit-valid="onSubmit"
  >
    <oxd-text tag="h5" class="orangehrm-installer-page-title">
      Current Version Details
    </oxd-text>
    <br />
    <oxd-text class="orangehrm-installer-page-content">
      Select your current OrangeHRM version here. You can find the version at
      the bottom of the OrangeHRM login page. OrangeHRM Upgrader only supports
      versions listed in the dropdown. Selecting a different version would lead
      to an upgrade failure and a database corruption.
    </oxd-text>
    <br />

    <oxd-form-row>
      <oxd-grid :cols="3" class="orangehrm-full-width-grid">
        <oxd-grid-item>
          <version-dropdown
            v-model="version"
            :rules="rules.version"
            required
          ></version-dropdown>
        </oxd-grid-item>
      </oxd-grid>
    </oxd-form-row>

    <oxd-text tag="p" class="orangehrm-installer-page-content">
      Click <b>Next</b> to commence upgrading your instance
    </oxd-text>

    <oxd-form-actions class="orangehrm-installer-page-action">
      <required-text />
      <oxd-button display-type="ghost" label="Back" @click="onClickBack" />
      <oxd-button
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
import {required} from '@/core/util/validation/rules';
import {navigate} from '@/core/util/helper/navigation.ts';
import VersionDropdown from '@/components/VersionDropdown.vue';

export default {
  name: 'CurrentVersionScreen',
  components: {
    'version-dropdown': VersionDropdown,
  },
  setup() {
    const http = new APIService(window.appGlobal.baseUrl, '');
    return {
      http,
    };
  },
  data() {
    return {
      isLoading: false,
      version: null,
      rules: {
        version: [required],
      },
    };
  },
  beforeMount() {
    this.isLoading = true;
    this.http
      .request({
        method: 'GET',
        url: '/upgrader/api/current-version',
      })
      .then((response) => {
        const {version} = response.data;
        if (version) {
          this.version = {
            id: version,
            label: version,
          };
        }
        this.isLoading = false;
      });
  },
  methods: {
    onClickBack() {
      navigate('/upgrader/system-check');
    },
    onSubmit() {
      this.isLoading = true;
      this.http
        .request({
          method: 'POST',
          url: '/upgrader/api/current-version',
          data: {
            currentVersion: this.version?.id,
          },
        })
        .then(() => {
          return this.http.request({
            method: 'POST',
            url: '/upgrader/api/send-data/upgrader-start',
          });
        })
        .then(() => {
          navigate('/upgrader/process');
        });
    },
  },
};
</script>
<style src="./installer-page.scss" lang="scss" scoped></style>
