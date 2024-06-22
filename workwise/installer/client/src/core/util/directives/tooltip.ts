

import {Directive, DirectiveBinding, h, render} from 'vue';
import {OxdIcon} from '@ohrm/oxd';

const tooltipDirective: Directive = {
  beforeMount(el: HTMLElement, binding: DirectiveBinding<string>) {
    if (!el || el.children.length === 0) return;
    const {value} = binding;
    const node = h(OxdIcon, {
      name: 'info-circle-fill',
      title: value,
      style: {
        marginLeft: 'auto',
        cursor: 'pointer',
      },
    });
    render(node, el.children[0]);
  },
};
export default tooltipDirective;
