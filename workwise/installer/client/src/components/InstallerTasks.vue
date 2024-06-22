
<template>
  <div class="orangehrm-installer-task">
    <div
      v-for="task in tasks"
      :key="task"
      class="orangehrm-installer-task-item"
    >
      <oxd-text
        tag="p"
        :class="{
          'orangehrm-installer-task-item-name': true,
          '--active': task.state === 1,
          '--error': task.state === 3,
        }"
      >
        {{ task.name }}
      </oxd-text>
      <div class="orangehrm-installer-task-item-progress">
        <oxd-loading-spinner v-if="task.state === 1" :with-container="false" />
        <div
          v-else-if="task.state === 2"
          class="orangehrm-installer-task-icon --done"
        >
          <oxd-icon name="check" />
        </div>
        <div
          v-else-if="task.state === 3"
          class="orangehrm-installer-task-icon --error"
        >
          <oxd-icon name="exclamation" />
        </div>
        <div v-else class="orangehrm-installer-task-icon --pending">
          <oxd-icon name="dash" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {OxdIcon, OxdSpinner} from '@ohrm/oxd';

export default {
  name: 'InstallerTasks',
  components: {
    'oxd-icon': OxdIcon,
    'oxd-loading-spinner': OxdSpinner,
  },
  props: {
    tasks: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style lang="scss" scoped>
.orangehrm-installer-task {
  &-item {
    width: 70%;
    max-width: 320px;
    display: flex;
    padding: 0.5rem 0;
    justify-content: space-between;
    align-items: center;
  }
  &-item-name {
    font-size: 16px;
    &.--active {
      font-weight: 700;
    }
    &.--error {
      font-weight: 700;
      color: $oxd-feedback-danger-color;
    }
  }
  &-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    text-align: center;
    line-height: 20px;
    font-size: 16px;
    &.--done {
      background-color: $oxd-secondary-four-color;
    }
    &.--pending {
      background-color: $oxd-interface-gray-darken-1-color;
    }
    &.--error {
      background-color: $oxd-feedback-danger-color;
    }
  }
}
::v-deep(.oxd-loading-spinner) {
  width: 10px;
  height: 10px;
}
::v-deep(.oxd-icon) {
  color: $oxd-white-color;
}
</style>
