
import {APIService} from '@/core/util/services/api.service';
import {AxiosResponse} from 'axios';

export default function useUpgrader(http: APIService) {
  const getVersionList = (
    excludeLatest = true,
  ): Promise<AxiosResponse<string[]>> => {
    return http.request({
      method: 'GET',
      url: 'upgrader/api/versions',
      params: {excludeLatest},
    });
  };

  const getCurrentVersion = (): Promise<
    AxiosResponse<{version: string} | null>
  > => {
    return http.request({
      method: 'GET',
      url: 'upgrader/api/current-version',
    });
  };

  const createConfigFiles = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: 'upgrader/api/config-file',
    });
  };

  const migrateToVersion = (fromVersion: string | null, toVersion: string) => {
    let payload;
    if (fromVersion) {
      payload = {
        fromVersion,
        toVersion,
      };
    } else {
      payload = {
        version: toVersion,
      };
    }
    return http.request({
      method: 'POST',
      url: 'upgrader/api/migration',
      data: payload,
    });
  };

  function* versionGenerator(
    versions: string[],
    currentVersion: string | null,
  ) {
    let index = versions.findIndex((_version) => _version === currentVersion);
    if (index === -1) return null;
    while (versions[index + 1]) {
      yield versions[index + 1];
      index++;
    }
  }

  const runAllMigrations = async () => {
    let versions = [];
    let currentVersion = null;
    const getVersions = Promise.all([
      getVersionList(false),
      getCurrentVersion(),
    ]);
    const [versionResponse, currentVersionResponse] = await getVersions;
    versions = [...versionResponse.data];
    currentVersion = currentVersionResponse.data?.version;
    if (!currentVersion) throw new Error('version not detected');
    for (const nextVersion of versionGenerator(versions, currentVersion)) {
      await migrateToVersion(null, nextVersion);
    }
  };

  const preMigrationCheck = (): Promise<AxiosResponse> => {
    return http.request({
      method: 'POST',
      url: 'upgrader/api/installation/pre-migration',
    });
  };

  return {
    getVersionList,
    getCurrentVersion,
    migrateToVersion,
    runAllMigrations,
    createConfigFiles,
    versionGenerator,
    preMigrationCheck,
  };
}
