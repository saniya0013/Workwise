

import {APIService} from '@/core/util/services/api.service';
import {AxiosResponse} from 'axios';
import useUpgrader from './useUpgrader';
import useDiagnostics from './useDiagnostics';

export default function useInstaller(http: APIService) {
  const {versionGenerator} = useUpgrader(http);
  const {notifyInstallerStart} = useDiagnostics(http);

  const getVersionList = (
    excludeLatest = false,
  ): Promise<AxiosResponse<string[]>> => {
    return http.request({
      method: 'GET',
      url: 'installer/api/versions',
      params: {excludeLatest},
    });
  };

  const createDatabase = (): Promise<AxiosResponse[]> => {
    return Promise.all([
      notifyInstallerStart(),
      http.request({
        method: 'POST',
        url: '/installer/api/installation/database',
      }),
    ]);
  };

  const createDatabaseUser = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: 'installer/api/installation/database-user',
    });
  };

  const preMigrationCheck = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: 'installer/api/installation/pre-migration',
    });
  };

  const runMigrations = async (): Promise<void> => {
    const doMigration = (version: string): Promise<AxiosResponse> => {
      return http.request({
        method: 'POST',
        url: 'installer/api/installation/migration',
        data: {
          version,
        },
      });
    };

    const versionResponse = await getVersionList();
    const versions = ['0.0', ...versionResponse.data];
    const currentVersion = Array.isArray(versions) ? versions[0] : null;
    if (!currentVersion) throw new Error('version not detected');
    for (const nextVersion of versionGenerator(versions, currentVersion)) {
      await doMigration(nextVersion);
    }
  };

  const createInstance = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: 'installer/api/installation/instance',
    });
  };

  const createConfigFiles = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: 'installer/api/installation/config-file',
    });
  };

  const runCleanup = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: 'installer/api/clean-up-install',
    });
  };

  return {
    runCleanup,
    runMigrations,
    createInstance,
    createDatabase,
    createConfigFiles,
    createDatabaseUser,
    preMigrationCheck,
  };
}
