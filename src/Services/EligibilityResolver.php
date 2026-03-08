<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

use Seat\SharkordConnector\Data\EligibilityDecision;
use Seat\SharkordConnector\Models\SharkordConnectorSetting;

final class EligibilityResolver
{
    public function evaluate(array $userContext): EligibilityDecision
    {
        $settings = SharkordConnectorSetting::query()->firstOrFail();
        $groups = $userContext['groups'] ?? [];

        if (count(array_intersect($groups, $settings->deny_groups_json ?? [])) > 0) {
            return new EligibilityDecision('ineligible', ['deny_group_match']);
        }

        if (in_array((int) ($userContext['alliance_id'] ?? 0), $settings->allowed_alliance_ids_json ?? [], true)) {
            return new EligibilityDecision('eligible');
        }

        if (in_array((int) ($userContext['corp_id'] ?? 0), $settings->allowed_corp_ids_json ?? [], true)) {
            return new EligibilityDecision('eligible');
        }

        if (count(array_intersect($groups, $settings->allowed_guest_groups_json ?? [])) > 0) {
            return new EligibilityDecision('eligible_restricted', ['guest_group_match']);
        }

        return new EligibilityDecision('ineligible', ['no_eligibility_match']);
    }
}
