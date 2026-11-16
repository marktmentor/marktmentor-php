<?php

namespace MarktMentor\Types;

use MarktMentor\Core\Json\JsonSerializableType;
use MarktMentor\Core\Json\JsonProperty;

class Usage extends JsonSerializableType
{
    /**
     * @var UsageOrganization $organization
     */
    #[JsonProperty('organization')]
    public UsageOrganization $organization;

    /**
     * oauth for a portal or app connection, key for an API key.
     *
     * * `oauth` - oauth
     * * `key` - key
     *
     * @var value-of<UsageCredential> $credential
     */
    #[JsonProperty('credential')]
    public string $credential;

    /**
     * bundle: requests count toward the API bundle. unmetered: a grant without a request limit. free: the free monthly allowance. none: research requests are not available.
     *
     * * `bundle` - bundle
     * * `unmetered` - unmetered
     * * `free` - free
     * * `none` - none
     *
     * @var value-of<UsagePlan> $plan
     */
    #[JsonProperty('plan')]
    public string $plan;

    /**
     * @var ?BundleUsage $bundle
     */
    #[JsonProperty('bundle')]
    public ?BundleUsage $bundle;

    /**
     * @var ?FreeTierUsage $freeTier The free monthly allowance of the organization, shared by its API keys and portal connections. Absent when the plan does not allow it.
     */
    #[JsonProperty('freeTier')]
    public ?FreeTierUsage $freeTier;

    /**
     * @param array{
     *   organization: UsageOrganization,
     *   credential: value-of<UsageCredential>,
     *   plan: value-of<UsagePlan>,
     *   bundle?: ?BundleUsage,
     *   freeTier?: ?FreeTierUsage,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->organization = $values['organization'];
        $this->credential = $values['credential'];
        $this->plan = $values['plan'];
        $this->bundle = $values['bundle'] ?? null;
        $this->freeTier = $values['freeTier'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
