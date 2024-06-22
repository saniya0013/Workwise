
<template>
  <oxd-input-field
    type="select"
    label="Current OrangeHRM Version"
    :options="options"
  />
</template>

<script>
import {ref, onBeforeMount} from 'vue';
import {APIService} from '@/core/util/services/api.service';
export default {
  name: 'VersionDropdown',
  setup() {
    const options = ref([]);
    const http = new APIService(
      window.appGlobal.baseUrl,
      'upgrader/api/versions',
    );
    onBeforeMount(() => {
      http.getAll().then(({data}) => {
        options.value = data.map((item) => {
          return {
            id: item,
            label: item,
          };
        });
      });
    });
    return {
      options,
    };
  },
};
</script>
