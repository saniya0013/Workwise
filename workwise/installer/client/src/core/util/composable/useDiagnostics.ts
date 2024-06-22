

import {APIService} from '@/core/util/services/api.service';
import {AxiosResponse} from 'axios';

export default function useDiagnostics(http: APIService) {
  const notifyInstallerStart = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: '/installer/api/send-data/installer-start',
    });
  };

  const notifyUpgraderStart = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: '/installer/api/send-data/upgrader-start',
    });
  };

  return {
    notifyUpgraderStart,
    notifyInstallerStart,
  };
}
