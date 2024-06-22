

import {urlFor} from '@/core/util/helper/url';

/**
 * @param path
 * @param params
 * @param query
 */
export const navigate = function (
  path: string,
  params: {[key: string]: string | number} = {},
  query: {[key: string]: string | number | boolean | string[]} = {},
): void {
  window.location.href = urlFor(path, params, query);
};

export const reloadPage = function (): void {
  window.location.reload();
};
