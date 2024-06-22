
<template>
  <oxd-form
    class="orangehrm-installer-page"
    :loading="isLoading"
    @submit-valid="onSubmit"
  >
    <oxd-text tag="h5" class="orangehrm-installer-page-title">
      Instance Creation
    </oxd-text>
    <br />
    <oxd-text tag="p" class="orangehrm-installer-page-content">
      Fill in your organization details here. Details entered in this section
      will be captured to create your OrangeHRM Instance
    </oxd-text>
    <br />
    <oxd-grid :cols="2" class="orangehrm-full-width-grid">
      <oxd-grid-item>
        <oxd-input-field
          v-model="instance.organizationName"
          label="Organization Name"
          required
          :rules="rules.organizationName"
        />
      </oxd-grid-item>
      <oxd-grid-item class="--offset-row-2">
        <oxd-input-field
          v-model="instance.countryCode"
          label="Country"
          required
          type="select"
          :options="countryList"
          :rules="rules.countryCode"
        />
      </oxd-grid-item>
      <oxd-grid-item class="--offset-row-3">
        <oxd-input-field
          v-model="instance.langCode"
          label="Language"
          type="select"
          :options="languageList"
        />
      </oxd-grid-item>
      <oxd-grid-item class="--offset-row-4">
        <oxd-input-field
          v-model="instance.timezone"
          label="Timezone"
          type="select"
          :options="timezoneList"
        />
      </oxd-grid-item>
    </oxd-grid>

    <oxd-form-actions class="orangehrm-installer-page-action">
      <required-text />
      <oxd-button
        display-type="ghost"
        label="Back"
        type="button"
        @click="navigateUrl"
      />
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
import {
  required,
  shouldNotExceedCharLength,
} from '@/core/util/validation/rules';
import {navigate} from '@/core/util/helper/navigation';

export default {
  name: 'InstanceCreation',
  setup() {
    const http = new APIService(
      window.appGlobal.baseUrl,
      '/installer/api/instance',
    );
    return {
      http,
    };
  },
  data() {
    return {
      isLoading: false,
      instance: {
        organizationName: null,
        countryCode: null,
        langCode: null,
        timezone: null,
      },
      countryList: [],
      languageList: [],
      timezoneList: [],
      rules: {
        organizationName: [required, shouldNotExceedCharLength(100)],
        countryCode: [required],
      },
    };
  },
  beforeMount() {
    this.isLoading = true;
    this.http
      .request({
        method: 'GET',
        url: 'installer/api/countries',
      })
      .then((response) => {
        const {data} = response.data;
        data.sort((a, b) => (a.label > b.label ? 1 : -1));
        this.countryList = data;
        return this.http.request({
          method: 'GET',
          url: 'installer/api/languages',
        });
      })
      .then((response) => {
        const {data} = response.data;
        this.languageList = data;
        return this.http.request({
          method: 'GET',
          url: 'installer/api/timezones',
        });
      })
      .then((response) => {
        const {data} = response.data;
        this.timezoneList = data;
        return this.http.getAll();
      })
      .then((response) => {
        const {data} = response.data;
        this.instance = {...this.instance, ...data};
        this.isLoading = false;
      });
  },
  methods: {
    onSubmit() {
      this.http
        .create({
          organizationName: this.instance.organizationName,
          countryCode: this.instance.countryCode.id,
          langCode: this.instance.langCode?.id,
          timezone: this.instance.timezone?.id,
        })
        .then(() => {
          navigate('/installer/admin-user-creation');
        });
    },
    navigateUrl() {
      navigate('/installer/system-check');
    },
  },
};
</script>

<style src="./installer-page.scss" lang="scss" scoped></style>
