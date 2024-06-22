
<template>
  <oxd-form :loading="isLoading">
    <div class="orangehrm-installer-page">
      <oxd-text tag="h5" class="orangehrm-installer-page-title">
        System Check
      </oxd-text>
      <br />
      <oxd-text class="orangehrm-installer-page-content">
        In order for your OrangeHRM installation to function properly, please
        ensure that all of the system check items listed below are green. If any
        are red, please take the necessary steps to fix them.
      </oxd-text>
      <br />
      <flex-table
        v-for="item in items"
        :key="item.category"
        :items="item.checks"
        :title-name="item.category"
      ></flex-table>
      <oxd-form-actions class="orangehrm-installer-page-action">
        <oxd-button display-type="ghost" label="Back" @click="navigateUrl" />
        <oxd-button
          class="orangehrm-left-space"
          display-type="ghost"
          label="Re-Check"
          type="submit"
          @click="reCheck"
        />
        <oxd-button
          class="orangehrm-left-space"
          display-type="secondary"
          :disabled="isInterrupted"
          label="Next"
          @click="goToScreen()"
        />
      </oxd-form-actions>
    </div>
  </oxd-form>
</template>
<script>
import {APIService} from '@/core/util/services/api.service';
import FlexTable from '@/components/FlexTable.vue';
import {navigate} from '@/core/util/helper/navigation.ts';
export default {
  name: 'SystemCheckScreen',
  components: {
    'flex-table': FlexTable,
  },
  props: {
    installer: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const http = new APIService(
      window.appGlobal.baseUrl,
      `${props.installer ? 'installer' : 'upgrader'}/api/system-check`,
    );
    return {
      http,
    };
  },
  data() {
    return {
      items: [],
      isLoading: false,
      isInterrupted: true,
    };
  },
  beforeMount() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.isLoading = true;
      this.http
        .getAll()
        .then((response) => {
          const {data, meta} = response.data;
          this.items = data;
          this.isInterrupted = meta.isInterrupted;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    navigateUrl() {
      navigate(
        this.installer
          ? '/installer/database-config'
          : '/upgrader/database-config',
      );
    },
    goToScreen() {
      navigate(
        this.installer
          ? '/installer/instance-creation'
          : '/upgrader/current-version',
      );
    },
    reCheck() {
      this.fetchData();
    },
  },
};
</script>
<style src="./installer-page.scss" lang="scss" scoped></style>
