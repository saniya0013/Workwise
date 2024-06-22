

import {createApp} from 'vue';
import Pages from '@/pages';
import Components from '@/components';
import '@ohrm/oxd/fonts.css';
import '@ohrm/oxd/icons.css';
import '@ohrm/oxd/style.css';
import './styles/global.scss';

const app = createApp({
  name: 'App',
  components: Pages,
});

app.use(Components);

app.mount('#app');
