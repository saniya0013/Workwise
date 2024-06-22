

import {onMounted, onUnmounted, Ref} from 'vue';

export default function useBeforeUnload(override: Ref<boolean>) {
  let registered = false;
  const triggerUnload = (event: Event) => {
    if (!override.value) {
      event.preventDefault();
      event.returnValue = true;
      return event;
    }
  };

  const registerUnloadEvent = () => {
    !registered && window.addEventListener('beforeunload', triggerUnload);
    registered = true;
  };

  onMounted(() => {
    window.addEventListener('mousemove', registerUnloadEvent);
  });

  onUnmounted(() => {
    window.removeEventListener('mousemove', registerUnloadEvent);
    window.removeEventListener('beforeunload', triggerUnload);
  });

  return {triggerUnload};
}
