

import {App} from 'vue';
import {
  OxdForm,
  OxdFormRow,
  OxdFormActions,
  OxdInputField,
  OxdInputGroup,
  OxdGrid,
  OxdGridItem,
  OxdText,
  OxdButton,
  OxdDivider,
} from '@ohrm/oxd';
import InstallerLayout from '@/components/InstallerLayout.vue';
import RequiredText from '@/components/RequiredText.vue';

export default {
  install: (app: App) => {
    app.component('RequiredText', RequiredText);
    app.component('OxdDivider', OxdDivider);
    app.component('OxdForm', OxdForm);
    app.component('OxdFormRow', OxdFormRow);
    app.component('OxdFormActions', OxdFormActions);
    app.component('OxdInputField', OxdInputField);
    app.component('OxdInputGroup', OxdInputGroup);
    app.component('OxdGrid', OxdGrid);
    app.component('OxdGridItem', OxdGridItem);
    app.component('InstallerLayout', InstallerLayout);
    app.component('OxdText', OxdText);
    app.component('OxdButton', OxdButton);
  },
};
