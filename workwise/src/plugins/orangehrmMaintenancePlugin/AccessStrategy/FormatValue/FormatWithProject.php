<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software: you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with OrangeHRM.
 * If not, see <https://www.gnu.org/licenses/>.
 */

namespace OrangeHRM\Maintenance\AccessStrategy\FormatValue;

use OrangeHRM\Entity\Project;
use OrangeHRM\Maintenance\FormatValueStrategy\ValueFormatter;
use OrangeHRM\Time\Traits\Service\ProjectServiceTrait;

class FormatWithProject implements ValueFormatter
{
    use ProjectServiceTrait;

    /**
     * @param $entityValue
     * @return null|string
     */
    public function getFormattedValue($entityValue): ?string
    {
        $project = $this->getProjectService()->getProjectDao()->getProjectById($entityValue);
        if ($project instanceof Project) {
            return $project->getName();
        }
        return null;
    }
}
